<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pageTitle = 'Thông tin cá nhân';

// Load header trước để có session
require __DIR__ . '/../layouts/header.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=login');
    exit;
} 

// Load models
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/User.php';

$userModel = new User();
$user = $userModel->findById($_SESSION['user_id']);

// Xử lý upload avatar
$avatarError = '';
$avatarSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_avatar'])) {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        $fileType = $_FILES['avatar']['type'];
        $fileSize = $_FILES['avatar']['size'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $avatarError = 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WebP)';
        } elseif ($fileSize > $maxSize) {
            $avatarError = 'Kích thước file không quá 5MB';
        } else {
            // Tạo tên file unique
            $fileName = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $uploadPath = __DIR__ . '/../../uploads/avatars/' . $fileName;
            
            // Tạo thư mục nếu chưa có
            if (!is_dir(__DIR__ . '/../../uploads/avatars/')) {
                mkdir(__DIR__ . '/../../uploads/avatars/', 0777, true);
            }
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
                // Cập nhật database
                $avatarPath = '/onlinecourse/onlinecourse/uploads/avatars/' . $fileName;
                $userModel->updateAvatar($_SESSION['user_id'], $avatarPath);
                $avatarSuccess = 'Cập nhật ảnh đại diện thành công!';
                
                // Load lại user data
                $user = $userModel->findById($_SESSION['user_id']);
            } else {
                $avatarError = 'Không thể upload file. Vui lòng thử lại.';
            }
        }
    } else {
        $avatarError = 'Vui lòng chọn file ảnh';
    }
}

// Xử lý đổi mật khẩu
$passwordError = '';
$passwordSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $passwordError = 'Vui lòng nhập đầy đủ thông tin';
    } elseif (strlen($newPassword) < 6) {
        $passwordError = 'Mật khẩu mới phải có ít nhất 6 ký tự';
    } elseif ($newPassword !== $confirmPassword) {
        $passwordError = 'Mật khẩu xác nhận không khớp';
    } else {
        // Kiểm tra mật khẩu hiện tại
        if (password_verify($currentPassword, $user['password'])) {
            // Cập nhật mật khẩu mới
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $updated = $userModel->update($user['id'], ['password' => $newHash]);
            
            if ($updated) {
                $passwordSuccess = 'Đổi mật khẩu thành công!';
                // Cập nhật lại user data
                $user = $userModel->findById($_SESSION['user_id']);
            } else {
                $passwordError = 'Không thể cập nhật mật khẩu. Vui lòng thử lại.';
            }
        } else {
            $passwordError = 'Mật khẩu hiện tại không đúng';
        }
    }
}

// Xử lý cập nhật thông tin cá nhân
$profileError = '';
$profileSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    // Debug logging
    error_log("Profile update attempt - POST data: " . print_r($_POST, true));
    
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    error_log("Processed data - fullname: '$fullname', email: '$email'");
    
    if (empty($fullname) || empty($email)) {
        $profileError = 'Vui lòng nhập đầy đủ họ tên và email';
        error_log("Validation error: empty fields");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $profileError = 'Email không hợp lệ';
        error_log("Validation error: invalid email");
    } else {
        // Kiểm tra email đã tồn tại chưa (nếu thay đổi)
        if ($email !== $user['email']) {
            $existing = $userModel->findByEmailOrUsername($email);
            if ($existing && $existing['id'] !== $user['id']) {
                $profileError = 'Email đã được sử dụng bởi tài khoản khác';
                error_log("Validation error: email already exists");
            }
        }
        
        if (!$profileError) {
            error_log("Attempting to update user ID: " . $user['id']);
            $updated = $userModel->update($user['id'], [
                'fullname' => $fullname,
                'email' => $email
            ]);
            
            error_log("Update result: " . ($updated ? 'SUCCESS' : 'FAILED'));
            
            if ($updated) {
                $profileSuccess = 'Cập nhật thông tin thành công!';
                // Cập nhật lại session và user data
                $_SESSION['user_name'] = $fullname;
                $_SESSION['user_email'] = $email;
                $user = $userModel->findById($_SESSION['user_id']);
                error_log("Session updated and user data refreshed");
            } else {
                $profileError = 'Không thể cập nhật thông tin. Vui lòng thử lại.';
                error_log("Update failed in database");
            }
        }
    }
}
?>

<style>
.profile-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    text-align: center;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 2.5rem;
    color: #667eea;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.profile-role {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.profile-email {
    font-size: 0.9rem;
    opacity: 0.8;
}

.profile-tabs {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    overflow: hidden;
}

.tab-buttons {
    display: flex;
    border-bottom: 1px solid #e2e8f0;
}

.tab-button {
    flex: 1;
    padding: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
    color: #64748b;
    transition: all 0.3s ease;
}

.tab-button.active {
    color: #667eea;
    background: #f8fafc;
    border-bottom: 3px solid #667eea;
}

.tab-content {
    padding: 2rem;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-secondary:hover {
    background: #cbd5e0;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert.error {
    background-color: #fee;
    color: #c53030;
    border: 1px solid #fc8181;
}

.alert.success {
    background-color: #f0fdf4;
    color: #16a34a;
    border: 1px solid #86efac;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.info-item {
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.info-label {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.info-value {
    font-weight: 600;
    color: #2d3748;
}

@media (max-width: 768px) {
    .profile-container {
        margin: 1rem auto;
    }
    
    .tab-buttons {
        flex-direction: column;
    }
    
    .tab-button {
        border-bottom: 1px solid #e2e8f0;
    }
    
    .tab-button.active {
        border-bottom: 3px solid #667eea;
    }
}
</style>

<div class="profile-container">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="profile-avatar">
            <?php if (!empty($user['avatar'])): ?>
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="avatar-img">
            <?php else: ?>
                <i class="fas fa-user"></i>
            <?php endif; ?>
        </div>
        <h1 class="profile-name"><?= htmlspecialchars($user['fullname']) ?></h1>
        <div class="profile-role">
            <?php
            $roles = [0 => 'Học viên', 1 => 'Giảng viên', 2 => 'Admin'];
            echo $roles[$user['role']] ?? 'Unknown';
            ?>
        </div>
        <div class="profile-email"><?= htmlspecialchars($user['email']) ?></div>
        
        <!-- Upload Avatar Button -->
        <button type="button" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#avatarModal">
            <i class="fas fa-camera"></i> Đổi ảnh đại diện
        </button>
    </div>

    <!-- Profile Tabs -->
    <div class="profile-tabs">
        <div class="tab-buttons">
            <button class="tab-button active" onclick="switchTab('info')">Thông tin cá nhân</button>
            <button class="tab-button" onclick="switchTab('password')">Đổi mật khẩu</button>
        </div>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Info Tab -->
            <div id="info-tab" class="tab-pane active">
                <?php if (!empty($profileError)): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($profileError) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($profileSuccess)): ?>
                    <div class="alert success">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($profileSuccess) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <input type="hidden" name="update_profile" value="1">
                    
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Username</div>
                            <div class="info-value"><?= htmlspecialchars($user['username']) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Vai trò</div>
                            <div class="info-value"><?= $roles[$user['role']] ?? 'Unknown' ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Ngày tạo</div>
                            <div class="info-value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Họ và tên</label>
                        <input type="text" id="fullname" name="fullname" required
                               value="<?= htmlspecialchars($user['fullname']) ?>"
                               placeholder="Nhập họ và tên đầy đủ">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required
                               value="<?= htmlspecialchars($user['email']) ?>"
                               placeholder="Nhập email của bạn">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật thông tin
                    </button>
                </form>
            </div>

            <!-- Password Tab -->
            <div id="password-tab" class="tab-pane">
                <?php if (!empty($passwordError)): ?>
                    <div class="alert error">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($passwordError) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($passwordSuccess)): ?>
                    <div class="alert success">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($passwordSuccess) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="">
                    <input type="hidden" name="change_password" value="1">
                    
                    <div class="form-group">
                        <label for="current_password">Mật khẩu hiện tại</label>
                        <input type="password" id="current_password" name="current_password" required
                               placeholder="Nhập mật khẩu hiện tại của bạn">
                    </div>

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

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Đổi mật khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tabName) {
    // Hide all tabs
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Password strength checker
document.getElementById('new_password')?.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;
    
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^a-zA-Z0-9]/.test(password)) strength++;
    
    // You can add password strength indicator here if needed
});

// Form validation
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const passwordForm = document.querySelector('form[name="change_password"]');
        
        if (passwordForm && this.querySelector('[name="change_password"]')) {
            const currentPassword = document.getElementById('current_password').value;
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (!currentPassword || !newPassword || !confirmPassword) {
                e.preventDefault();
                alert('Vui lòng nhập đầy đủ thông tin mật khẩu');
                return;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Mật khẩu mới phải có ít nhất 6 ký tự');
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

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Đổi ảnh đại diện</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <?php if ($avatarError): ?>
                        <div class="alert alert-danger"><?= $avatarError ?></div>
                    <?php endif; ?>
                    
                    <?php if ($avatarSuccess): ?>
                        <div class="alert alert-success"><?= $avatarSuccess ?></div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Chọn ảnh đại diện</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
                        <div class="form-text">Chấp nhận file JPG, PNG, GIF, WebP. Tối đa 5MB</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="avatar-preview mb-3" id="avatarPreview">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Current avatar" class="img-fluid rounded-circle" style="max-width: 150px;">
                            <?php else: ?>
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; margin: 0 auto;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" name="upload_avatar" class="btn btn-primary">Cập nhật ảnh</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Avatar preview
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('avatarPreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="img-fluid rounded-circle" style="max-width: 150px;">`;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
