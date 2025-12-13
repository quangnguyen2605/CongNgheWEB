<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<style>
.social-login-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.social-login-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    width: 100%;
    max-width: 500px;
    position: relative;
}

.social-login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 12px 12px 0 0;
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.login-header i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.login-header h2 {
    color: #2d3748;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.login-header p {
    color: #718096;
    font-size: 0.95rem;
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

.btn-login {
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

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.back-link {
    text-align: center;
    margin-top: 1.5rem;
}

.back-link a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.back-link a:hover {
    color: #5a67d8;
    text-decoration: underline;
}

.error-message {
    background: #fee;
    color: #c53030;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid #fc8181;
}

.help-text {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
}

.help-text h4 {
    color: #4a5568;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.help-text p {
    color: #718096;
    font-size: 0.85rem;
    margin: 0.25rem 0;
}
</style>

<div class="social-login-container">
    <div class="social-login-card">
        <div class="login-header">
            <i class="fab fa-<?= $provider === 'google' ? 'google' : 'facebook' ?>"></i>
            <h2>Đăng nhập bằng <?= ucfirst($provider) ?> Link</h2>
            <p>Nhập link <?= ucfirst($provider) ?> của bạn để đăng nhập</p>
        </div>
        
        <div class="help-text">
            <h4><i class="fas fa-info-circle me-2"></i>Hướng dẫn</h4>
            <p>Nhập chính xác link social bạn đã đăng ký:</p>
            <p>• Facebook: https://facebook.com/yourprofile</p>
            <p>• Google: https://plus.google.com/yourprofile</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=socialLinkLogin&provider=<?= $provider ?>">
            <div class="form-group">
                <label for="social_link">Link <?= ucfirst($provider) ?> *</label>
                <input type="url" id="social_link" name="social_link" required 
                       placeholder="https://<?= $provider === 'google' ? 'plus.google.com' : 'facebook.com' ?>/yourprofile"
                       value="<?= htmlspecialchars($_POST['social_link'] ?? '') ?>">
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Đăng nhập
            </button>
        </form>
        
        <div class="back-link">
            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login">
                <i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập thường
            </a>
        </div>
    </div>
</div>

<script>
// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const socialLink = document.getElementById('social_link').value.trim();
    
    if (!socialLink) {
        e.preventDefault();
        alert('Vui lòng nhập link <?= ucfirst($provider) ?>');
        return;
    }
    
    // Kiểm tra URL hợp lệ
    try {
        new URL(socialLink);
    } catch {
        e.preventDefault();
        alert('Link <?= ucfirst($provider) ?> không hợp lệ');
        return;
    }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
