<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - OnlineCourse' : 'OnlineCourse - Học lập trình trực tuyến' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/onlinecourse/onlinecourse/">
                <i class="fas fa-graduation-cap"></i> OnlineCourse
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/onlinecourse/onlinecourse/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/onlinecourse/onlinecourse/index.php?controller=Course&action=index">Khóa học</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <?php $role = (int)($_SESSION['user_role'] ?? 0); ?>
                        
                        <?php if ($role === 0): ?>
                            <a href="index.php?controller=Enrollment&action=myCourses" class="btn btn-outline-primary me-2">
                                <i class="fas fa-book"></i> Khóa học của tôi
                            </a>
                        <?php elseif ($role === 1): ?>
                            <a href="index.php?controller=Instructor&action=dashboard" class="btn btn-outline-primary me-2">
                                <i class="fas fa-chalkboard-teacher"></i> Giảng viên
                            </a>
                        <?php elseif ($role === 2): ?>
                            <a href="index.php?controller=Admin&action=dashboard" class="btn btn-outline-primary me-2">
                                <i class="fas fa-cog"></i> Quản trị
                            </a>
                        <?php endif; ?>
                        
                        <div class="dropdown">
                            <a class="btn btn-link text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> 
                                <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?controller=Auth&action=profile"><i class="fas fa-user"></i> Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="index.php?controller=Auth&action=profile#password-tab"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?controller=Auth&action=logout">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login" class="btn btn-outline-primary me-2">Đăng nhập</a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=register" class="btn btn-primary">Đăng ký</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php require __DIR__ . '/flash_messages.php'; ?>
    </div>
    
<main class="site-main container py-4">
