<?php 
$pageTitle = 'Quên mật khẩu';
require __DIR__ . '/../layouts/header.php'; 

// Xử lý quên mật khẩu
$error = '';
$success = '';
$step = 1; // 1: nhập email, 2: xác nhận code, 3: đặt mật khẩu mới

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . '/../../config/Database.php';
    require_once __DIR__ . '/../../models/User.php';
    
    $userModel = new User();
    
    if (isset($_POST['submit_email'])) {
        // Bước 1: Gửi email
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email)) {
            $error = 'Vui lòng nhập email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        } else {
            $user = $userModel->findByEmailOrUsername($email);
            if ($user) {
                // Tạo reset code (6 ký tự số)
                $resetCode = sprintf('%06d', mt_rand(0, 999999));
                $resetExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Lưu reset code vào session (trong thực tế nên lưu vào database)
                $_SESSION['reset_code'] = $resetCode;
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_expiry'] = $resetExpiry;
                $_SESSION['reset_user_id'] = $user['id'];
                
                // Trong thực tế, gửi email ở đây
                // mail($email, "Reset Password Code", "Mã xác nhận của bạn là: $resetCode");
                
                $success = "Mã xác nhận đã được gửi đến email $email. Mã có hiệu lực trong 1 giờ.";
                $step = 2;
            } else {
                $error = 'Email không tồn tại trong hệ thống';
            }
        }
    } elseif (isset($_POST['submit_code'])) {
        // Bước 2: Xác nhận code
        $code = trim($_POST['reset_code'] ?? '');
        
        if (empty($code)) {
            $error = 'Vui lòng nhập mã xác nhận';
        } elseif ($code !== $_SESSION['reset_code']) {
            $error = 'Mã xác nhận không đúng';
        } elseif (strtotime($_SESSION['reset_expiry']) < time()) {
            $error = 'Mã xác nhận đã hết hạn. Vui lòng thử lại.';
            unset($_SESSION['reset_code'], $_SESSION['reset_email'], $_SESSION['reset_expiry']);
            $step = 1;
        } else {
            $step = 3;
        }
    } elseif (isset($_POST['submit_password'])) {
        // Bước 3: Đặt mật khẩu mới
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($newPassword) || empty($confirmPassword)) {
            $error = 'Vui lòng nhập đầy đủ mật khẩu';
        } elseif (strlen($newPassword) < 6) {
            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'Mật khẩu xác nhận không khớp';
        } else {
            // Cập nhật mật khẩu
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $userModel->update($_SESSION['reset_user_id'], ['password' => $hash]);
            
            if ($updated) {
                // Xóa session reset
                unset($_SESSION['reset_code'], $_SESSION['reset_email'], $_SESSION['reset_expiry'], $_SESSION['reset_user_id']);
                $success = 'Đổi mật khẩu thành công! <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login" style="color: #16a34a;">Nhấn vào đây để đăng nhập</a>';
                $step = 4; // Hoàn thành
            } else {
                $error = 'Không thể cập nhật mật khẩu. Vui lòng thử lại.';
            }
        }
    }
}
?>

<style>
.forgot-password-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.forgot-password-form {
    background: white;
    padding: 2.5rem;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 450px;
}

.forgot-password-form h2 {
    color: #1a202c;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-align: center;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.forgot-password-form .subtitle {
    color: #2d3748;
    text-align: center;
    margin-bottom: 2rem;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5;
}

.step-indicator {
    display: flex;
    justify-content: center;
    margin-bottom: 2rem;
}

.step {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #f7fafc;
    color: #2d3748;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    position: relative;
    border: 2px solid #e2e8f0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.step.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.step.completed {
    background: #16a34a;
    color: white;
    border-color: #16a34a;
    box-shadow: 0 4px 8px rgba(22, 163, 74, 0.3);
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 30px;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 2px;
    background: #e2e8f0;
}

.step.completed:not(:last-child)::after {
    background: #16a34a;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #1a202c;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-group input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8fafc;
    color: #1a202c;
    font-weight: 500;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group input::placeholder {
    color: #718096;
    font-weight: 400;
}

.btn-reset {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.back-link {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.back-link a {
    color: #667eea;
    text-decoration: none;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.back-link a:hover {
    color: #5a67d8;
    text-decoration: underline;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.alert.error {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #991b1b;
    border: 2px solid #fca5a5;
}

.alert.success {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    color: #166534;
    border: 2px solid #86efac;
}

.alert.info {
    background: linear-gradient(135deg, #e0f2fe, #bae6fd);
    color: #075985;
    border: 2px solid #7dd3fc;
}

.alert i {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

.code-display {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border: 3px solid #667eea;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    margin: 1.5rem 0;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
}

.code-display .code {
    font-size: 2rem;
    font-weight: 800;
    color: #1a202c;
    letter-spacing: 0.3rem;
    font-family: 'Courier New', monospace;
    background: white;
    padding: 1rem;
    border-radius: 8px;
    margin: 0.5rem 0;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.code-display .note {
    font-size: 0.9rem;
    color: #2d3748;
    margin-top: 1rem;
    font-weight: 500;
}

@media (max-width: 480px) {
    .forgot-password-form {
        padding: 2rem;
        margin: 1rem;
    }
    
    .forgot-password-form h2 {
        font-size: 1.5rem;
    }
}
</style>

<div class="forgot-password-container">
    <div class="forgot-password-form">
        <h2>Quên mật khẩu</h2>
        
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step <?= $step >= 1 ? 'active' : '' ?> <?= $step > 1 ? 'completed' : '' ?>">1</div>
            <div class="step <?= $step >= 2 ? 'active' : '' ?> <?= $step > 2 ? 'completed' : '' ?>">2</div>
            <div class="step <?= $step >= 3 ? 'active' : '' ?> <?= $step > 3 ? 'completed' : '' ?>">3</div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i> <?= $success ?>
            </div>
        <?php endif; ?>

        <?php if ($step === 1): ?>
            <p class="subtitle">Nhập email của bạn để nhận mã xác nhận đặt lại mật khẩu</p>
            
            <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=forgot_password">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           placeholder="Nhập email đã đăng ký">
                </div>

                <button type="submit" name="submit_email" class="btn-reset">
                    <i class="fas fa-paper-plane"></i> Gửi mã xác nhận
                </button>
            </form>

        <?php elseif ($step === 2): ?>
            <p class="subtitle">Nhập mã xác nhận đã được gửi đến email của bạn</p>
            
            <!-- Demo: Hiển thị mã (trong thực tế sẽ gửi qua email) -->
            <div class="code-display">
                <div class="note">Mã xác nhận của bạn (demo):</div>
                <div class="code"><?= $_SESSION['reset_code'] ?? '' ?></div>
                <div class="note">Mã có hiệu lực đến: <?= date('H:i', strtotime($_SESSION['reset_expiry'])) ?></div>
            </div>
            
            <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=forgot_password">
                <div class="form-group">
                    <label for="reset_code">Mã xác nhận</label>
                    <input type="text" id="reset_code" name="reset_code" required 
                           placeholder="Nhập 6 ký tự mã xác nhận"
                           maxlength="6" style="letter-spacing: 0.2rem; text-align: center; font-family: monospace;">
                </div>

                <button type="submit" name="submit_code" class="btn-reset">
                    <i class="fas fa-check"></i> Xác nhận mã
                </button>
            </form>

        <?php elseif ($step === 3): ?>
            <p class="subtitle">Đặt mật khẩu mới cho tài khoản của bạn</p>
            
            <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=forgot_password">
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" id="new_password" name="new_password" required 
                           placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           placeholder="Nhập lại mật khẩu mới">
                </div>

                <button type="submit" name="submit_password" class="btn-reset">
                    <i class="fas fa-key"></i> Đặt mật khẩu mới
                </button>
            </form>

        <?php elseif ($step === 4): ?>
            <div class="alert info">
                <i class="fas fa-info-circle"></i> 
                Mật khẩu của bạn đã được đổi thành công. Bạn có thể đăng nhập bằng mật khẩu mới.
            </div>
        <?php endif; ?>

        <div class="back-link">
            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login">
                <i class="fas fa-arrow-left"></i> Quay lại trang đăng nhập
            </a>
        </div>
    </div>
</div>

<script>
// Auto-focus inputs
document.addEventListener('DOMContentLoaded', function() {
    const firstInput = document.querySelector('input:not([type="hidden"])');
    if (firstInput) {
        firstInput.focus();
    }
    
    // Format code input
    const codeInput = document.getElementById('reset_code');
    if (codeInput) {
        codeInput.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase().replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                document.querySelector('button[type="submit"]').focus();
            }
        });
    }
    
    // Password strength indicator
    const newPasswordInput = document.getElementById('new_password');
    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            // You can add password strength indicator here if needed
        });
    }
});

// Form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const passwordForm = document.querySelector('form[name="submit_password"]');
        
        if (passwordForm && this.querySelector('[name="submit_password"]')) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải có ít nhất 6 ký tự');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không khớp');
                return;
            }
        }
    });
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
