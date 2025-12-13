<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - OnlineCourse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .hero-section {
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/onlinecourse/onlinecourse/">
                <i class="fas fa-graduation-cap text-primary"></i> OnlineCourse
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/onlinecourse/onlinecourse/">Trang chủ</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=support">Hỗ trợ</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Liên hệ</h1>
            <p class="lead">Chúng tôi luôn lắng nghe ý kiến của bạn</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-5">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                                <h5>Địa chỉ</h5>
                                <p class="mb-0">số 1 Thái Hà<br>Đống Đa, Hà Nội</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-phone fa-3x text-success mb-3"></i>
                                <h5>Điện thoại</h5>
                                <p class="mb-0">0342381276<br>8:00 - 22:00 hàng ngày</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-envelope fa-3x text-info mb-3"></i>
                                <h5>Email</h5>
                                <p class="mb-0">quangnguyenvan2k5@gmail.com<br>Phản hồi trong 24h</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-4">Gửi tin nhắn cho chúng tôi</h3>
                        <form method="POST" action="/onlinecourse/onlinecourse/index.php?controller=Page&action=submitContact">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Họ và tên *</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chủ đề *</label>
                                <select class="form-select" name="subject" required>
                                    <option value="">Chọn chủ đề</option>
                                    <option value="general">Tư vấn chung</option>
                                    <option value="technical">Hỗ trợ kỹ thuật</option>
                                    <option value="payment">Thanh toán</option>
                                    <option value="course">Nội dung khóa học</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung *</label>
                                <textarea class="form-control" name="message" rows="5" required placeholder="Nhập nội dung tin nhắn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-graduation-cap"></i> OnlineCourse
                    </h5>
                    <p class="text-white">
                        Nền tảng học lập trình trực tuyến hàng đầu với các khóa học chất lượng cao 
                        và chuyên đề bài bản.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="https://www.facebook.com/quang.nguyen.490818/" class="text-light" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/wang_uen/" class="text-light" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@weng_nguyn" class="text-light" target="_blank"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 mb-4">
                    <h6 class="fw-bold mb-3">Khóa học</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Lập trình Web</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Lập trình Mobile</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Data Science</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Machine Learning</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 mb-4">
                    <h6 class="fw-bold mb-3">Hỗ trợ</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=support" class="text-white text-decoration-none">Hỗ trợ</a></li>
                        <li class="mb-2"><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=help" class="text-white text-decoration-none">Trợ giúp</a></li>
                        <li class="mb-2"><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=contact" class="text-white text-decoration-none">Liên hệ</a></li>
                        <li class="mb-2"><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=faq" class="text-white text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms" class="text-white text-decoration-none">Điều khoản</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3">Đăng ký nhận tin</h6>
                    <p class="text-white">Nhận thông tin về các khóa học mới và ưu đãi đặc biệt</p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Email của bạn">
                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                    </form>
                </div>
            </div>
            
            <hr class="bg-white my-4">
            
            <div class="text-center">
                <p class="mb-0">&copy; 2025 OnlineCourse. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
