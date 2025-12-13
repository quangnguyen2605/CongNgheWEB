<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid mt-4">
    <h1 class="h3 mb-4">Admin Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng người dùng</h5>
                    <h2 class="card-text"><?= (int)$totalUsers ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Tổng khóa học</h5>
                    <h2 class="card-text"><?= (int)$totalCourses ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Lượt đăng ký</h5>
                    <h2 class="card-text"><?= (int)$totalEnrollments ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Khóa học chờ duyệt</h5>
                    <h2 class="card-text"><?= (int)$pendingCourses ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- User Stats by Role -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Học viên</h5>
                    <h3 class="text-primary"><?= (int)$students ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Giảng viên</h5>
                    <h3 class="text-success"><?= (int)$instructors ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quản trị viên</h5>
                    <h3 class="text-warning"><?= (int)$admins ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <h4>Thao tác nhanh</h4>
            <div class="btn-group" role="group">
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=users" class="btn btn-outline-primary">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=courses" class="btn btn-outline-danger">
                    <i class="fas fa-graduation-cap"></i> Quản lý khóa học
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=allEnrollments" class="btn btn-outline-info">
                    <i class="fas fa-user-graduate"></i> Quản lý đăng ký
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=manageApplications" class="btn btn-outline-success">
                    <i class="fas fa-user-tie"></i> Quản lý đơn ứng tuyển
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=categories" class="btn btn-outline-success">
                    <i class="fas fa-folder"></i> Quản lý danh mục
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=courseApproval" class="btn btn-outline-warning">
                    <i class="fas fa-check-circle"></i> Duyệt khóa học
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=statistics" class="btn btn-outline-info">
                    <i class="fas fa-chart-bar"></i> Thống kê hệ thống
                </a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
