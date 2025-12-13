<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-graduation-cap"></i> 
                    Quản lý khóa học
                </h2>
                <div class="btn-group">
                    <a href="index.php?controller=Admin&action=pendingCourses" 
                       class="btn btn-warning">
                        <i class="fas fa-clock"></i> Khóa học chờ duyệt
                    </a>
                </div>
            </div>

            <!-- Courses List -->
            <div class="card">
                <div class="card-body">
                    <?php 
                    if (!isset($courses)) {
                        echo '<div class="alert alert-danger">Lỗi: Biến $courses không tồn tại. Vui lòng kiểm tra AdminController.</div>';
                    } elseif (empty($courses)) {
                        echo '<div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h4>Chưa có khóa học nào</h4>
                            <p>Chưa có khóa học nào trong hệ thống.</p>
                        </div>';
                    } else { ?>
                        <div class="alert alert-success">Tìm thấy <?= count($courses) ?> khóa học</div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên khóa học</th>
                                        <th>Giảng viên</th>
                                        <th>Danh mục</th>
                                        <th>Giá</th>
                                        <th>Trạng thái</th>
                                        <th>Học viên</th>
                                        <th>Ngày tạo</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= $course['id'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($course['image']): ?>
                                                        <img src="<?= htmlspecialchars($course['image']) ?>" 
                                                             alt="<?= htmlspecialchars($course['title']) ?>"
                                                             class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                                    <?php else: ?>
                                                        <div class="me-2 bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                             style="width: 40px; height: 40px; border-radius: 4px;">
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?= htmlspecialchars($course['title']) ?></strong>
                                                        <?php if ($course['description']): ?>
                                                            <br><small class="text-muted"><?= htmlspecialchars(substr($course['description'], 0, 50)) ?>...</small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($course['instructor_name'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars($course['category_name'] ?? 'N/A') ?></td>
                                            <td><?= number_format($course['price']) ?> VNĐ</td>
                                            <td>
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
                                                <span class="badge <?= $statusClass ?>">
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $enrollmentModel = new Enrollment();
                                                $enrolledCount = $enrollmentModel->getEnrolledCount($course['id']);
                                                echo $enrolledCount;
                                                ?>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($course['created_at'])) ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $course['id'] ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </a>
                                                    <a href="index.php?controller=Admin&action=courseEnrollments&id=<?= $course['id'] ?>" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-users"></i> Học viên
                                                    </a>
                                                    <?php if ($course['status'] === 'pending'): ?>
                                                        <a href="index.php?controller=Admin&action=approveCourse&id=<?= $course['id'] ?>" 
                                                           class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-check"></i> Duyệt
                                                        </a>
                                                        <a href="index.php?controller=Admin&action=rejectCourse&id=<?= $course['id'] ?>" 
                                                           class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-times"></i> Từ chối
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="index.php?controller=Admin&action=deleteCourse&id=<?= $course['id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa khóa học này? Toàn bộ học viên đã đăng ký sẽ bị mất dữ liệu tiến độ học tập!')">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>