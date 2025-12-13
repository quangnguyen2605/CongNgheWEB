<?php 
$pageTitle = 'Đăng nhập';
require __DIR__ . '/../layouts/header.php'; 
?>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.login-container {
    min-height: 100vh;
    background: var(--primary-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    overflow: hidden;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
}

.login-form {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    width: 100%;
    max-width: 450px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    z-index: 2;
}

.login-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--secondary-gradient);
    border-radius: 20px 20px 0 0;
}

.login-form h2 {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 2rem;
    text-align: center;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    color: #4a5568;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-group input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
}

.form-group input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.btn-login {
    width: 100%;
    padding: 1rem;
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 1rem;
}

.btn-login:hover {
    background: #5a67d8;
}

.alert {
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.alert.error {
    background-color: #fee;
    color: #c53030;
    border: 1px solid #fc8181;
}

.form-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e2e8f0;
}

.form-footer p {
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 1rem;
    font-weight: 500;
}

.form-footer a {
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

.form-footer a:hover {
    color: #3182ce;
    text-decoration: underline;
    background: rgba(66, 153, 225, 0.2);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
}

.remember-me {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.remember-me input[type="checkbox"] {
    width: auto;
    margin-right: 0.5rem;
}

.remember-me label {
    font-size: 0.95rem;
    color: #4a5568;
    font-weight: 500;
}

.forgot-password {
    font-size: 0.95rem;
    color: #4299e1;
    text-decoration: none;
    margin-left: auto;
    transition: all 0.3s ease;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    background: rgba(66, 153, 225, 0.1);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.forgot-password:hover {
    color: #3182ce;
    text-decoration: underline;
    background: rgba(66, 153, 225, 0.2);
    transform: translateY(-1px);
}

.social-login {
    margin-top: 2rem;
}

.social-divider {
    text-align: center;
    margin: 2rem 0;
    position: relative;
}

.social-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
    z-index: 1;
}

.divider-text {
    position: relative;
    z-index: 2;
    background: rgba(255, 255, 255, 0.95);
    padding: 0.5rem 1.5rem;
    border-radius: 20px;
    color: #4a5568;
    font-weight: 600;
    font-size: 0.95rem;
    display: inline-block;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.divider-text i {
    color: #667eea;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.6; 
        transform: scale(1.1);
    }
}

.social-buttons {
    display: flex;
    gap: 1rem;
}

.social-btn {
    flex: 1;
    padding: 0.875rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    background: white;
    color: #1a202c;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.social-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.social-btn.google:hover {
    border-color: #ea4335;
    color: #ea4335;
}

.social-btn.facebook:hover {
    border-color: #1877f2;
    color: #1877f2;
}

.social-btn i {
    font-size: 1.1rem;
}
</style>

 hop>

<div class="login-container">
    <div class="login-form">
        <h2>Đăng nhập</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success']) && $_GET['success'] === 'registered'): ?>
            <div class="alert success">
                <i class="fas fa-check-circle"></i> Đăng ký thành công! Vui lòng đăng nhập.
            </div>
        <?php endif; ?>
        
        <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       placeholder="Nhập email">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Nhập mật khẩu">
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Ghi nhớ đăng nhập</label>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=forgot_password" class="forgot-password">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn-login">Đăng nhập</button>
        </form>

        <div class="social-login">
            <div class="social-divider">
                <span class="divider-text">
                    <i class="fas fa-sparkles me-2"></i>
                    Hoặc tiếp tục với
                    <i class="fas fa-sparkles ms-2"></i>
                </span>
            </div>
            <div class="social-buttons">
                <button type="button" class="social-btn google" onclick="socialLogin('google')">
                    <i class="fab fa-google"></i>
                    Google
                </button>
                <button type="button" class="social-btn facebook" onclick="socialLogin('facebook')">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </button>
            </div>
        </div>

        <div class="form-footer">
            <p>Chưa có tài khoản?</p>
            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=register">Đăng ký ngay</a>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    
    if (!email) {
        e.preventDefault();
        alert('Vui lòng nhập email');
        return;
    }
    
    if (password.length < 6) {
        e.preventDefault();
        alert('Mật khẩu phải có ít nhất 6 ký tự');
        return;
    }
});

function socialLogin(provider) {
    // Hiển thị loading
    const btn = event.target;
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang chuyển hướng...';
    
    // Chuyển đến form đăng nhập bằng social link
    window.location.href = '/onlinecourse/onlinecourse/index.php?controller=Auth&action=socialLinkLogin&provider=' + provider;
}

// Thêm hiệu ứng khi click vào social buttons
document.querySelectorAll('.social-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Thêm hiệu ứng loading
        this.style.opacity = '0.7';
        this.style.cursor = 'not-allowed';
        
        setTimeout(() => {
            this.style.opacity = '1';
            this.style.cursor = 'pointer';
        }, 1000);
    });
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
