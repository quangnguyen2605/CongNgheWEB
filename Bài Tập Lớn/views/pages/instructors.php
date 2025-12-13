<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đội ngũ giảng viên - OnlineCourse</title>
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
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=contact">Liên hệ</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=support">Hỗ trợ</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=help">Trợ giúp</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=faq">FAQ</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms">Điều khoản</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Đội ngũ giảng viên</h1>
            <p class="lead">Gặp gỡ đội ngũ giảng viên chuyên môn cao và giàu kinh nghiệm của chúng tôi</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php 
                    $userModel = new User();
                    $instructors = $userModel->getInstructors();
                    if (!empty($instructors)): ?>
                        <?php foreach ($instructors as $instructor): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <?php if (!empty($instructor['avatar'])): ?>
                                            <img src="/onlinecourse/onlinecourse/uploads/avatars/<?php echo htmlspecialchars($instructor['avatar']); ?>" 
                                                 alt="<?php echo htmlspecialchars($instructor['fullname']); ?>" 
                                                 class="rounded-circle mb-3" width="120" height="120">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3" 
                                                 style="width: 120px; height: 120px; margin: 0 auto;">
                                                <i class="fas fa-user-tie fa-3x"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <h5 class="card-title"><?php echo htmlspecialchars($instructor['fullname']); ?></h5>
                                        
                                        <?php if (!empty($instructor['specialization'])): ?>
                                            <p class="text-muted small mb-2"><?php echo htmlspecialchars($instructor['specialization']); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($instructor['bio'])): ?>
                                            <p class="card-text small"><?php echo htmlspecialchars($instructor['bio']); ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($instructor['email'])): ?>
                                            <p class="mb-0">
                                                <a href="mailto:<?php echo htmlspecialchars($instructor['email']); ?>" class="text-primary">
                                                    <i class="fas fa-envelope"></i> Liên hệ
                                                </a>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                Đang cập nhật đội ngũ giảng viên...
                            </div>
                        </div>
                    <?php endif; ?>
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
