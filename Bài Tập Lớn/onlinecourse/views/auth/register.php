<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pageTitle = 'Đăng ký';

// Xử lý đăng ký
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Load các class cần thiết
        require_once __DIR__ . '/../../config/Database.php';
        require_once __DIR__ . '/../../models/User.php';
        
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        // Validation
        if ($password !== $confirm) {
            $error = 'Mật khẩu nhập lại không khớp';
        } elseif (empty($username) || empty($email) || empty($fullname) || empty($password)) {
            $error = 'Vui lòng nhập đầy đủ thông tin';
        } elseif (strlen($username) < 3) {
            $error = 'Username phải có ít nhất 3 ký tự';
        } elseif (strlen($password) < 8) {
            $error = 'Mật khẩu phải có ít nhất 8 ký tự';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
            $error = 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email không hợp lệ';
        } else {
            // Kiểm tra user đã tồn tại chưa
            $userModel = new User();
            $existing = $userModel->findByEmailOrUsername($email);
            
            if ($existing) {
                $error = 'Email hoặc username đã được sử dụng';
            } else {
                // Tạo user mới
                $hash = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
                $created = $userModel->create([
                    'username' => $username,
                    'email' => $email,
                    'fullname' => $fullname,
                    'password' => $hash,
                    'role' => 0, // Học viên
                ]);
                
                if ($created) {
                    $success = 'Đăng ký thành công! <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login" style="color: #16a34a;">Nhấn vào đây để đăng nhập</a>';
                    // Clear form
                    $_POST = [];
                } else {
                    $error = 'Không thể tạo tài khoản. Vui lòng thử lại.';
                }
            }
        }
    } catch (Exception $e) {
        $error = 'Lỗi hệ thống: ' . $e->getMessage();
    }
}

require __DIR__ . '/../layouts/header.php'; 
?>

<style>
.auth-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.auth-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    width: 100%;
    max-width: 500px;
    position: relative;
}

.auth-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 12px 12px 0 0;
}

.auth-form h2 {
    color: #2d3748;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
}

.auth-form .form-group {
    margin-bottom: 1.5rem;
}

.auth-form label {
    display: block;
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.auth-form input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.auth-form input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.auth-form .btn {
    width: 100%;
    padding: 0.875rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.auth-form .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.auth-form .alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.auth-form .alert.error {
    background-color: #fee;
    color: #c53030;
    border: 1px solid #fc8181;
}

.auth-form .alert.success {
    background-color: #f0fdf4;
    color: #16a34a;
    border: 1px solid #86efac;
}

.alert.success i {
    margin-right: 0.5rem;
}

.auth-form .form-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e2e8f0;
}

.auth-form .form-footer p {
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 1rem;
    font-weight: 500;
}

.auth-form .form-footer a {
    color: #4299e1;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    background: rgba(66, 153, 225, 0.1);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: inline-block;
    margin-top: 0.5rem;
}

.auth-form .form-footer a:hover {
    color: #3182ce;
    text-decoration: underline;
    background: rgba(66, 153, 225, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
}

.auth-form .social-login {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e2e8f0;
}

.auth-form .social-login h3 {
    text-align: center;
    color: #2d3748;
    font-size: 1rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.auth-form .social-buttons {
    display: flex;
    gap: 1rem;
}

.auth-form .social-btn {
    flex: 1;
    padding: 0.875rem;
    border: 2px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    color: #1a202c;
    font-weight: 600;
    font-size: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.auth-form .social-btn:hover {
    border-color: #667eea;
    background: #f8fafc;
}

.auth-form .social-btn i {
    font-size: 1.2rem;
}

.auth-form .social-btn.google {
    color: #ea4335;
}

.auth-form .social-btn.facebook {
    color: #1877f2;
}

.auth-form .social-btn.github {
    color: #333;
}

.terms-conditions {
    margin-bottom: 1rem;
}

.terms-conditions label {
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #64748b;
}

.terms-conditions input[type="checkbox"] {
    width: auto;
    margin-top: 0.25rem;
}

.password-strength {
    margin-top: 0.5rem;
    font-size: 0.8rem;
}

.password-strength .weak {
    color: #e53e3e;
}

.password-strength .medium {
    color: #dd6b20;
}

.password-strength .strong {
    color: #38a169;
}

@media (max-width: 480px) {
    .auth-form {
        padding: 2rem;
        margin: 1rem;
    }
    
    .auth-form h2 {
        font-size: 1.5rem;
    }
}
</style>

<div class="auth-container">
    <div class="auth-form">
        <h2>Đăng ký</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert error">
                <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=register" id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       placeholder="Nhập username">
            </div>

            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" required 
                       value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>"
                       placeholder="Nhập họ và tên đầy đủ">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="Nhập email của bạn">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Nhập mật khẩu (ít nhất 8 ký tự, 1 hoa, 1 thường, 1 số)" minlength="8">
                <div class="password-strength" id="passwordStrength"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" required 
                       placeholder="Nhập lại mật khẩu">
            </div>

            <div class="terms-conditions">
                <label>
                    <input type="checkbox" name="terms" required>
                    Tôi đồng ý với <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms" style="color: #667eea;">Điều khoản dịch vụ</a> và <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=privacy" style="color: #667eea;">Chính sách bảo mật</a>
                </label>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-user-plus"></i> Đăng ký
            </button>
        </form>

        <div class="social-login">
            <h3>Hoặc đăng ký với</h3>
            <div class="social-buttons">
                <button class="social-btn google" onclick="socialRegister('google')">
                    <i class="fab fa-google"></i> Google
                </button>
                <button class="social-btn facebook" onclick="socialRegister('facebook')">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
            </div>
        </div>

        <div class="form-footer">
            <p>Đã có tài khoản?</p>
            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login">Đăng nhập ngay</a>
        </div>
    </div>
</div>

<script>
function socialRegister(provider) {
    // Hiển thị loading
    const btn = event.target;
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
    
    // Chuyển hướng đến OAuth endpoint
    if (provider === 'google') {
        window.location.href = '/onlinecourse/onlinecourse/index.php?controller=Auth&action=googleOAuth';
    } else if (provider === 'facebook') {
        window.location.href = '/onlinecourse/onlinecourse/index.php?controller=Auth&action=facebookOAuth';
    } else if (provider === 'github') {
        window.location.href = '/onlinecourse/onlinecourse/index.php?controller=Auth&action=githubOAuth';
    } else {
        // Fallback
        alert(`Đăng ký với ${provider} - Chức năng đang được phát triển!`);
        btn.style.opacity = '1';
        btn.style.cursor = 'pointer';
        btn.innerHTML = `<i class="fab fa-${provider}"></i> ${provider.charAt(0).toUpperCase() + provider.slice(1)}`;
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    const strengthDiv = document.getElementById('passwordStrength');
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    let strengthText = '';
    let strengthClass = '';
    
    if (strength <= 2) {
        strengthText = 'Yếu';
        strengthClass = 'weak';
    } else if (strength <= 3) {
        strengthText = 'Trung bình';
        strengthClass = 'medium';
    } else {
        strengthText = 'Mạnh';
        strengthClass = 'strong';
    }
    
    strengthDiv.innerHTML = `<span class="${strengthClass}">Độ mạnh mật khẩu: ${strengthText}</span>`;
}

// Add form validation
document.getElementById('password').addEventListener('input', function() {
    checkPasswordStrength(this.value);
});

document.getElementById('registerForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const fullname = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const terms = document.querySelector('input[name="terms"]').checked;
    
    if (!username || !fullname || !email || !password || !confirmPassword) {
        e.preventDefault();
        alert('Vui lòng nhập đầy đủ thông tin');
        return;
    }
    
    if (username.length < 3) {
        e.preventDefault();
        alert('Username phải có ít nhất 3 ký tự');
        return;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Mật khẩu phải có ít nhất 6 ký tự');
        return;
    }
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu nhập lại không khớp');
        return;
    }
    
    if (!terms) {
        e.preventDefault();
        alert('Vui lòng đồng ý với điều khoản dịch vụ');
        return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        alert('Email không hợp lệ');
        return;
    }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
