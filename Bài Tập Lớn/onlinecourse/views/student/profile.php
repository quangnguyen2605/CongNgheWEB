<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <?php if ($isOwnProfile): ?>
                                <li class="breadcrumb-item">
                                    <a href="index.php?controller=Student&action=dashboard">Dashboard</a>
                                </li>
                            <?php else: ?>
                                <li class="breadcrumb-item">
                                    <a href="index.php?controller=Admin&action=allEnrollments">Quản lý đăng ký</a>
                                </li>
                            <?php endif; ?>
                            <li class="breadcrumb-item active">
                                <?= $isOwnProfile ? 'Hồ sơ của tôi' : 'Hồ sơ học viên' ?>
                            </li>
                        </ol>
                    </nav>
                    <h2>
                        <i class="fas fa-user"></i> 
                        <?= $isOwnProfile ? 'Hồ sơ của tôi' : 'Hồ sơ học viên: ' . $student['fullname'] ?>
                    </h2>
                </div>
                <?php if ($isOwnProfile): ?>
                    <a href="index.php?controller=Student&action=dashboard" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                    </a>
                <?php else: ?>
                    <a href="index.php?controller=Admin&action=allEnrollments" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                <?php endif; ?>
            </div>

            <!-- Student Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 120px; height: 120px; font-size: 48px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <h4 class="mt-3"><?= htmlspecialchars($student['fullname']) ?></h4>
                            <p class="text-muted">@<?= htmlspecialchars($student['username']) ?></p>
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title">Thông tin cá nhân</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Họ và tên:</strong> <?= htmlspecialchars($student['fullname']) ?></p>
                                    <p><strong>Username:</strong> <?= htmlspecialchars($student['username']) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Ngày tham gia:</strong> <?= date('d/m/Y', strtotime($student['created_at'])) ?></p>
                                    <p><strong>Vai trò:</strong> <span class="badge bg-info">Học viên</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tổng khóa học</h5>
                            <h2 class="card-text"><?= $totalCourses ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Đã hoàn thành</h5>
                            <h2 class="card-text"><?= $completedCourses ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h5 class="card-title">Tiến độ trung bình</h5>
                            <h2 class="card-text"><?= $avgProgress ?>%</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-graduation-cap"></i> 
                        Khóa học đã đăng ký
                    </h5>
                    <?php if (!empty($enrollments)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Khóa học</th>
                                        <th>Giảng viên</th>
                                        <th>Danh mục</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Tiến độ</th>
                                        <th>Trạng thái</th>
                                        <?php if ($isOwnProfile): ?>
                                            <th>Hành động</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?= htmlspecialchars($enrollment['title']) ?></strong>
                                                    <?php if ($enrollment['description']): ?>
                                                        <br><small class="text-muted"><?= htmlspecialchars(substr($enrollment['description'], 0, 50)) ?>...</small>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($enrollment['instructor_name'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($enrollment['category_name'] ?? 'N/A') ?></td>
                                            <td><?= date('d/m/Y', strtotime($enrollment['enrolled_date'])) ?></td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?= $enrollment['progress'] ?>%"
                                                         aria-valuenow="<?= $enrollment['progress'] ?>" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                        <?= $enrollment['progress'] ?>%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $enrollment['status'] === 'active' ? 'success' : 'secondary' ?>">
                                                    <?= $enrollment['status'] === 'active' ? 'Đang học' : 'Không hoạt động' ?>
                                                </span>
                                            </td>
                                            <?php if ($isOwnProfile): ?>
                                                <td>
                                                    <a href="index.php?controller=Student&action=courseProgress&course_id=<?= $enrollment['course_id'] ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-chart-line"></i> Xem tiến độ
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h4>Chưa đăng ký khóa học nào</h4>
                            <p>Bạn chưa đăng ký khóa học nào.</p>
                            <?php if ($isOwnProfile): ?>
                                <a href="index.php?controller=Student&action=browseCourses" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Khám phá khóa học
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
