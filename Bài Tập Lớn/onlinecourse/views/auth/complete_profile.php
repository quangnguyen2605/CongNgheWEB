<?php
require_once __DIR__ . '/../layouts/header.php';

$provider = $_SESSION['social_data']['provider'] ?? 'facebook';
$email = $_SESSION['social_data']['email'] ?? '';
$name = $_SESSION['social_data']['name'] ?? '';
?>

<style>
.complete-profile-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.complete-profile-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    width: 100%;
    max-width: 600px;
    position: relative;
}

.complete-profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 12px 12px 0 0;
}

.profile-header {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-header i {
    font-size: 3rem;
    color: #1877f2;
    margin-bottom: 1rem;
}

.profile-header h2 {
    color: #2d3748;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.profile-header p {
    color: #718096;
    font-size: 0.95rem;
}

.social-info {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
}

.social-info h4 {
    color: #4a5568;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.social-info p {
    color: #2d3748;
    font-size: 0.95rem;
    margin: 0.25rem 0;
}

.avatar-upload {
    text-align: center;
    margin-bottom: 2rem;
}

.avatar-preview {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: #f8fafc;
    border: 3px solid #e2e8f0;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-preview i {
    font-size: 3rem;
    color: #cbd5e0;
}

.avatar-upload-btn {
    background: #667eea;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.avatar-upload-btn:hover {
    background: #5a67d8;
    transform: translateY(-1px);
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

.form-group input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-complete {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-complete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-skip {
    width: 100%;
    padding: 0.75rem;
    background: transparent;
    color: #718096;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 1rem;
}

.btn-skip:hover {
    background: #f8fafc;
    border-color: #cbd5e0;
}

.error-message {
    background: #fee;
    color: #c53030;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid #fc8181;
}

.success-message {
    background: #f0fdf4;
    color: #16a34a;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid #86efac;
}
</style>

<div class="complete-profile-container">
    <div class="complete-profile-card">
        <div class="profile-header">
            <i class="fab fa-<?= $provider ?>"></i>
            <h2>Hoàn tất thông tin cá nhân</h2>
            <p>Vui lòng cung cấp thêm thông tin để hoàn tất đăng ký bằng <?= ucfirst($provider) ?></p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" enctype="multipart/form-data" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=completeProfile">
            <div class="avatar-upload">
                <div class="avatar-preview" id="avatarPreview">
                    <i class="fas fa-user"></i>
                </div>
                <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                <button type="button" class="avatar-upload-btn" onclick="document.getElementById('avatar').click()">
                    <i class="fas fa-camera me-2"></i>Chọn Avatar
                </button>
            </div>
            
            <div class="form-group">
                <label for="username">Username *</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Nhập username (dùng để đăng nhập)"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="fullname">Họ và tên *</label>
                <input type="text" id="fullname" name="fullname" required 
                       placeholder="Nhập họ và tên đầy đủ"
                       value="<?= htmlspecialchars($name) ?>">
            </div>
            
            <div class="form-group">
                <label for="social_link">Link <?= ucfirst($provider) ?> *</label>
                <input type="url" id="social_link" name="social_link" required 
                       placeholder="Nhập link <?= ucfirst($provider) ?> của bạn"
                       value="<?= htmlspecialchars($_POST['social_link'] ?? '') ?>">
                <small style="color: #718096; font-size: 0.85rem; margin-top: 0.25rem; display: block;">
                    Ví dụ: https://facebook.com/yourprofile hoặc https://plus.google.com/yourprofile
                </small>
            </div>
            
            <input type="hidden" name="provider" value="<?= $provider ?>">
            <input type="hidden" name="email" value="<?= $email ?>">
            
            <button type="submit" class="btn-complete">
                <i class="fas fa-check"></i>
                Hoàn tất đăng ký
            </button>
        </form>
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
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar">`;
        };
        reader.readAsDataURL(file);
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const fullname = document.getElementById('fullname').value.trim();
    const socialLink = document.getElementById('social_link').value.trim();
    
    if (!username || !fullname || !socialLink) {
        e.preventDefault();
        alert('Vui lòng nhập đầy đủ thông tin bắt buộc');
        return;
    }
    
    if (username.length < 3) {
        e.preventDefault();
        alert('Username phải có ít nhất 3 ký tự');
        return;
    }
    
    // Kiểm tra URL hợp lệ
    try {
        new URL(socialLink);
    } catch {
        e.preventDefault();
        alert('Link social không hợp lệ');
        return;
    }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
