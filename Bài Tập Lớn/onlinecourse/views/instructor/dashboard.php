<?php require __DIR__ . '/../layouts/instructor_header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">Dashboard Giảng viên</h1>
            <p class="text-muted">Chào mừng trở lại, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Khóa học</h5>
                    <h2 class="card-text"><?= count($courses ?? []) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Học viên</h5>
                    <h2 class="card-text"><?= $totalStudents ?? 0 ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Doanh thu</h5>
                    <h2 class="card-text"><?= number_format($totalRevenue ?? 0, 0, ',', '.') ?>đ</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Đánh giá</h5>
                    <h2 class="card-text">4.8★</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thao tác nhanh</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=create" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Tạo khóa học mới
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=manageCourses" class="btn btn-success btn-block">
                                <i class="fas fa-book"></i> Quản lý khóa học
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Enrollments -->
    <?php if (!empty($recentEnrollments)): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Học viên đăng ký gần đây</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Học viên</th>
                                    <th>Khóa học</th>
                                    <th>Ngày đăng ký</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentEnrollments as $enrollment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($enrollment['fullname']) ?></td>
                                    <td><?= htmlspecialchars($enrollment['course_title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($enrollment['enrolled_date'])) ?></td>
                                    <td><span class="badge badge-success">Đang học</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
