<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?controller=Admin&action=courses">Quản lý khóa học</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Quản lý học viên: <?= htmlspecialchars($course['title'] ?? '') ?>
                            </li>
                        </ol>
                    </nav>
                    <h2>
                        <i class="fas fa-users"></i> 
                        Quản lý học viên
                    </h2>
                    <p . . . . . . . . . .  . . . . . . .+, . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .,No response requested. GROUP
</div>
.
                <a hrefBreadcrumbs" class="btn直接的. .HASH
</; ?>
                        <h2>
                            <i class="fas fa-users"></i> 
                            Quản lý học viên
ION
                       . . . . . . . .; ?>
                        <h2 . . . . . . . . .  . . . .  . .1. . . . . .  . .  .S
                        <h2 . . . . . . . . . . . . .2. . . . 
                        .uras.aro. . dr.  .ertype: vra
                        <h2>
                            <i class="fas fa-users"></i> 
                            Quản lý học viên
                        </h2>
                        <p class="text-muted"><?= htmlspecialchars($course['title'] ?? '') ?></p>
                    </div>
                </div>
                <a href="index.php?controller=Admin&action=courses" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <!-- Course Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Thông tin khóa học</h5>
                            <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name'] ?? 'N/A') ?></p>
                            <p><strong>Danh mục:</strong> <?= htmlspecialchars($course['category_name'] ?? 'N/A') ?></p>
                            <p><strong>Giá:</strong> <?= number_format($course['price']) ?> VNĐ</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Thống kê</h5>
                            <p><strong>Tổng số học viên:</strong> <?= count($enrollments) ?></p>
                            <p><strong>Trạng thái:</strong> 
                                <?php
                                $statusClass = 'bg-secondary';
                                $statusText = $course['status'];
                                if ($course['status'] === 'approved') {
                                    $statusClass = 'bg-success';
                                    $statusText = 'Đã duyệt';
                                } elseif ($course['status'] === 'pending') {
                                    $statusClass = 'bg-warning';
                                    $statusText = 'Chờ duyệt';
                                } elseif ($course['status'] === 'rejected') {
                                    $statusClass = 'bg-danger';
                                    $statusText = 'Từ chối';
                                }
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments List -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($enrollments)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên học viên</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Ngày đăng ký</th>
                                        <th>Tiến độ</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <tr>
                                            <td><?= $enrollment['id'] ?></td>
                                            <td><?= htmlspecialchars($enrollment['fullname']) ?></td>
                                            <td><?= htmlspecialchars($enrollment['username']) ?></td>
                                            <td><?= htmlspecialchars($enrollment['email']) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($enrollment['enrolled_date'])) ?></td>
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
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="index.php?controller=Student&action=profile&id=<?= $enrollment['student_id'] ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-user"></i> Xem hồ sơ
                                                    </a>
                                                    <a href="index.php?controller=Admin&action=removeStudent&course_id=<?= $course['id'] ?>&student_id=<?= $enrollment['student_id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa học viên này khỏi khóa học? Toàn bộ tiến độ học tập sẽ bị mất!')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h4>Chưa có học viên nào</h4>
                            <p>Chưa có học viên nào đăng ký khóa học này.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
