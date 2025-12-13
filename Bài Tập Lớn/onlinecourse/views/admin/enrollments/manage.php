<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-user-graduate"></i> 
                    Quản lý đăng ký khóa học
                </h2>
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
                                        <th>Học viên</th>
                                        <th>Email</th>
                                        <th>Khóa học</th>
                                        <th>Giảng viên</th>
                                        <th>Danh mục</th>
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
                                            <td>
                                                <div>
                                                    <strong><?= htmlspecialchars($enrollment['student_name']) ?></strong>
                                                    <br><small class="text-muted">@<?= htmlspecialchars($enrollment['student_username']) ?></small>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($enrollment['student_email']) ?></td>
                                            <td>
                                                <div>
                                                    <strong><?= htmlspecialchars($enrollment['course_title']) ?></strong>
                                                    <br><small class="text-muted"><?= htmlspecialchars($enrollment['category_name'] ?? 'N/A') ?></small>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($enrollment['instructor_name'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($enrollment['category_name'] ?? 'N/A') ?></td>
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
                                                    <a href="index.php?controller=Admin&action=courseEnrollments&id=<?= $enrollment['course_id'] ?>" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-users"></i> Xem lớp
                                                    </a>
                                                    <a href="index.php?controller=Student&action=profile&id=<?= $enrollment['student_id'] ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-user"></i> Hồ sơ
                                                    </a>
                                                    <a href="index.php?controller=Admin&action=removeStudent&course_id=<?= $enrollment['course_id'] ?>&student_id=<?= $enrollment['student_id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa học viên này khỏi khóa học? Toàn bộ tiến độ học tập sẽ bị mất!')">
                                                        <i class="fas fa-user-minus"></i> Thôi học
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
                            <h4>Chưa có đăng ký nào</h4>
                            <p>Chưa có học viên nào đăng ký khóa học.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
