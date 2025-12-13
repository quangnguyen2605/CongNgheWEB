<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - OnlineCourse</title>
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
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Câu hỏi thường gặp (FAQ)</h1>
            <p class="lead">Tìm câu trả lời cho các câu hỏi phổ biến nhất</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="accordion" id="faqAccordion">
                            <!-- Account Questions -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Làm thế nào để đăng ký tài khoản?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Để đăng ký tài khoản, bạn:</p>
                                        <ol>
                                            <li>Nhấn nút "Đăng ký" ở góc trên phải</li>
                                            <li>Điền email, mật khẩu và thông tin cá nhân</li>
                                            <li>Nhấn "Đăng ký"</li>
                                            <li>Kiểm tra email để kích hoạt tài khoản</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Tôi quên mật khẩu phải làm sao?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Bạn có thể khôi phục mật khẩu bằng cách:</p>
                                        <ol>
                                            <li>Nhấn "Quên mật khẩu" ở trang đăng nhập</li>
                                            <li>Nhập email đã đăng ký</li>
                                            <li>Kiểm tra email để nhận link reset</li>
                                            <li>Tạo mật khẩu mới</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Course Questions -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Khóa học có thời hạn bao lâu?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Tùy theo loại khóa học:</p>
                                        <ul>
                                            <li>Khóa học miễn phí: Trọn đời</li>
                                            <li>Khóa học có phí: Trọn đời</li>
                                            <li>Khóa học đặc biệt: Theo gói đăng ký</li>
                                        </ul>
                                        <p>Bạn có thể xem lại video bất cứ lúc nào sau khi đăng ký.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                        Tôi có thể tải video về không?
                                    </button>
                                </h2>
                                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Hiện tại chúng tôi chưa hỗ trợ tải video về máy tính. Tuy nhiên:</p>
                                        <ul>
                                            <li>Bạn có thể xem online bất cứ lúc nào</li>
                                            <li>App di động hỗ trợ tải offline</li>
                                            <li>Có thể xem lại không giới hạn lần</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Questions -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                        Các phương thức thanh toán nào được chấp nhận?
                                    </button>
                                </h2>
                                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <p>Chúng tôi chấp nhận:</p>
                                        <ul>
                                            <li>Thẻ tín dụng/ghi nợ (Visa, Mastercard)</li>
                                            <li>Chuyển khoản ngân hàng</li>
                                            <li>Ví điện tử (Momo, ZaloPay)</li>
                                            <li>Thanh toán khi nhận hàng (COD)</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Still have questions -->
                <div class="card shadow mt-4">
                    <div class="card-body p-4 text-center">
                        <h3 class="h5 mb-3">Vẫn còn câu hỏi?</h3>
                        <p class="mb-4">Nếu bạn không tìm thấy câu trả lời, hãy liên hệ với chúng tôi</p>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=contact" class="btn btn-primary me-2">
                            <i class="fas fa-envelope me-2"></i>Liên hệ
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=support" class="btn btn-outline-primary">
                            <i class="fas fa-headset me-2"></i>Hỗ trợ
                        </a>
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
