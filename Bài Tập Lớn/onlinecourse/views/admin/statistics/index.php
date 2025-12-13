<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-chart-bar"></i> Thống kê hệ thống
            </h2>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['totalUsers']) ?></h4>
                            <p class="mb-0">Tổng người dùng</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['totalCourses']) ?></h4>
                            <p class="mb-0">Tổng khóa học</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['totalEnrollments']) ?></h4>
                            <p class="mb-0">Tổng đăng ký</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-plus fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['pendingCourses']) ?></h4>
                            <p class="mb-0">Chờ duyệt</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['totalRevenue'], 0) ?> VNĐ</h4>
                            <p class="mb-0">Tổng doanh thu</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['todayRevenue'], 0) ?> VNĐ</h4>
                            <p class="mb-0">Doanh thu hôm nay</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0"><?= number_format($stats['monthRevenue'], 0) ?> VNĐ</h4>
                            <p class="mb-0">Doanh thu tháng này</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Activity -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Hoạt động hôm nay
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="text-primary" style="font-size: 2rem;">
                                    <?= $stats['todayUsers'] ?>
                                </div>
                                <small class="text-muted">Người dùng mới</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="text-success" style="font-size: 2rem;">
                                    <?= $stats['todayEnrollments'] ?>
                                </div>
                                <small class="text-muted">Đăng ký mới</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="text-info" style="font-size: 2rem;">
                                    <?= $stats['todayCourses'] ?>
                                </div>
                                <small class="text-muted">Khóa học mới</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3">
                                <div class="text-warning" style="font-size: 2rem;">
                                    <?= number_format($stats['todayRevenue'], 0) ?> VNĐ
                                </div>
                                <small class="text-muted">Doanh thu hôm nay</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie"></i> Phân bổ người dùng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="text-primary" style="font-size: 2rem;">
                                    <?= number_format($stats['students']) ?>
                                </div>
                                <small class="text-muted">Học viên</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php $studentPercent = $stats['totalUsers'] > 0 ? ($stats['students'] / $stats['totalUsers']) * 100 : 0; ?>
                                <div class="progress-bar bg-primary" style="width: <?= $studentPercent ?>%"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="text-success" style="font-size: 2rem;">
                                    <?= number_format($stats['instructors']) ?>
                                </div>
                                <small class="text-muted">Giảng viên</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php $instructorPercent = $stats['totalUsers'] > 0 ? ($stats['instructors'] / $stats['totalUsers']) * 100 : 0; ?>
                                <div class="progress-bar bg-success" style="width: <?= $instructorPercent ?>%"></div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <div class="text-danger" style="font-size: 2rem;">
                                    <?= number_format($stats['admins']) ?>
                                </div>
                                <small class="text-muted">Quản trị viên</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php $adminPercent = $stats['totalUsers'] > 0 ? ($stats['admins'] / $stats['totalUsers']) * 100 : 0; ?>
                                <div class="progress-bar bg-danger" style="width: <?= $adminPercent ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i> Thống kê khóa học
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="text-success" style="font-size: 2rem;">
                                    <?= number_format($stats['approvedCourses']) ?>
                                </div>
                                <small class="text-muted">Đã duyệt</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php $approvedPercent = $stats['totalCourses'] > 0 ? ($stats['approvedCourses'] / $stats['totalCourses']) * 100 : 0; ?>
                                <div class="progress-bar bg-success" style="width: <?= $approvedPercent ?>%"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <div class="text-warning" style="font-size: 2rem;">
                                    <?= number_format($stats['pendingCourses']) ?>
                                </div>
                                <small class="text-muted">Chờ duyệt</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <?php $pendingPercent = $stats['totalCourses'] > 0 ? ($stats['pendingCourses'] / $stats['totalCourses']) * 100 : 0; ?>
                                <div class="progress-bar bg-warning" style="width: <?= $pendingPercent ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus"></i> Đăng ký gần đây
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['recentEnrollments'])): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Chưa có đăng ký nào.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($stats['recentEnrollments'] as $enrollment): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($enrollment['fullname']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($enrollment['title']) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($enrollment['enrolled_date'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-book"></i> Khóa học mới
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['recentCourses'])): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Chưa có khóa học nào.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($stats['recentCourses'] as $course): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($course['title']) ?></div>
                                            <small class="text-muted">by <?= htmlspecialchars($course['instructor_name']) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($course['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-trophy"></i> Top khóa học
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['topCourses'])): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Chưa có dữ liệu.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($stats['topCourses'] as $index => $course): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-primary me-2"><?= $index + 1 ?></span>
                                                <div>
                                                    <div class="fw-semibold"><?= htmlspecialchars($course['title']) ?></div>
                                                    <small class="text-muted"><?= $course['enrollment_count'] ?> học viên</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="text-success fw-bold">
                                                <?= number_format($course['revenue'], 0) ?> VNĐ
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus"></i> Đăng ký gần đây
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['recentEnrollments'])): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Chưa có đăng ký nào.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($stats['recentEnrollments'] as $enrollment): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($enrollment['fullname']) ?></div>
                                            <small class="text-muted"><?= htmlspecialchars($enrollment['title']) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($enrollment['enrolled_date'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-book"></i> Khóa học mới
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($stats['recentCourses'])): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <p>Chưa có khóa học nào.</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($stats['recentCourses'] as $course): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold"><?= htmlspecialchars($course['title']) ?></div>
                                            <small class="text-muted">by <?= htmlspecialchars($course['instructor_name']) ?></small>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">
                                                <?= date('d/m/Y H:i', strtotime($course['created_at'])) ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
