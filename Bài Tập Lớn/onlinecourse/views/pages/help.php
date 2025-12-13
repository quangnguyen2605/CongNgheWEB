<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trợ giúp - OnlineCourse</title>
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
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=faq">FAQ</a>
                <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms">Điều khoản</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Trợ giúp</h1>
            <p class="lead">Hướng dẫn sử dụng các tính năng của OnlineCourse</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3">Hướng dẫn nhanh</h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                                    <h6>Đăng ký tài khoản</h6>
                                    <p class="small">Tạo tài khoản miễn phí trong 2 phút</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fas fa-search fa-3x text-success mb-3"></i>
                                    <h6>Tìm khóa học</h6>
                                    <p class="small">Duyệt qua danh mục khóa học</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center">
                                    <i class="fas fa-play fa-3x text-warning mb-3"></i>
                                    <h6>Bắt đầu học</h6>
                                    <p class="small">Xem video và làm bài tập</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3">Hướng dẫn chi tiết</h3>
                        <div class="accordion" id="helpAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#help1">
                                        Cách đăng ký tài khoản
                                    </button>
                                </h2>
                                <div id="help1" class="accordion-collapse collapse show" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Nhấn nút "Đăng ký" ở góc trên phải</li>
                                            <li>Điền thông tin: email, mật khẩu, họ tên</li>
                                            <li>Nhấn "Đăng ký"</li>
                                            <li>Kiểm tra email để kích hoạt tài khoản</li>
                                            <li>Đăng nhập và bắt đầu học</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#help2">
                                        Cách đăng ký khóa học
                                    </button>
                                </h2>
                                <div id="help2" class="accordion-collapse collapse" data-bs-parent="#helpAccordion">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Tìm khóa học bạn quan tâm</li>
                                            <li>Nhấn vào khóa học để xem chi tiết</li>
                                            <li>Nhấn "Đăng ký ngay"</li>
                                            <li>Chọn phương thức thanh toán</li>
                                            <li>Hoàn tất thanh toán</li>
                                            <li>Bắt đầu học ngay lập tức</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 mb-4">
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
                
                <div class="col-lg-2 mb-4">
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
