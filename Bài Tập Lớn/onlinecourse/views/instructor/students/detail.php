<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php?controller=Instructor&action=myCourses">Khóa học của tôi</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="index.php?controller=Instructor&action=viewStudents&course_id=<?= $course['id'] ?>">
                            <?= htmlspecialchars($course['title']) ?>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Chi tiết học viên: <?= htmlspecialchars($student['fullname']) ?>
                    </li>
                </ol>
            </nav>

            <!-- Student Info Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Thông tin học viên
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> <?= htmlspecialchars($student['fullname']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                            <p><strong>Ngày đăng ký:</strong> <?= date('d/m/Y', strtotime($enrollment['enrolled_date'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-<?= $enrollment['status'] == 'active' ? 'success' : 'warning' ?>">
                                    <?= htmlspecialchars($enrollment['status']) ?>
                                </span>
                            </p>
                            <p><strong>Tiến độ tổng thể:</strong> 
                                <span class="badge bg-info"><?= (int)($enrollment['progress'] ?? 0) ?>%</span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-3">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= $enrollment['progress'] ?? 0 ?>%"
                                 aria-valuenow="<?= $enrollment['progress'] ?? 0 ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                                <?= (int)($enrollment['progress'] ?? 0) ?>%
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lessons Progress -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book"></i> Tiến độ bài học
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($lessons)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên bài học</th>
                                        <th>Nội dung</th>
                                        <th>Video</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày hoàn thành</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lessons as $index => $lesson): ?>
                                        <?php 
                                        $isCompleted = in_array($lesson['id'], array_column($completedLessons ?? [], 'id'));
                                        $completedLesson = null;
                                        if ($isCompleted) {
                                            foreach ($completedLessons as $cl) {
                                                if ($cl['id'] == $lesson['id']) {
                                                    $completedLesson = $cl;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <tr class="<?= $isCompleted ? 'table-success' : '' ?>">
                                            <td><?= $index + 1 ?></td>
                                            <td>
                                                <strong><?= htmlspecialchars($lesson['title']) ?></strong>
                                            </td>
                                            <td>
                                                <?php 
                                                $content = strip_tags($lesson['content']);
                                                echo htmlspecialchars(mb_substr($content, 0, 100)) . (mb_strlen($content) > 100 ? '...' : '');
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($lesson['video_url']): ?>
                                                    <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-video"></i> Xem
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">Không có</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($isCompleted): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Đã hoàn thành
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-clock"></i> Chưa học
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($completedLesson && $completedLesson['completed_at']): ?>
                                                    <?= date('d/m/Y H:i', strtotime($completedLesson['completed_at'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Summary -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <h4 class="text-primary"><?= count($lessons) ?></h4>
                                        <p class="mb-0">Tổng số bài học</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <h4 class="text-success"><?= count($completedLessons) ?></h4>
                                        <p class="mb-0">Đã hoàn thành</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <h4 class="text-warning"><?= count($lessons) - count($completedLessons) ?></h4>
                                        <p class="mb-0">Còn lại</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Khóa học chưa có bài học nào.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Course Materials -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-file"></i> Tài liệu khóa học
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($materials)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên tài liệu</th>
                                        <th>Loại file</th>
                                        <th>Kích thước</th>
                                        <th>Tải về</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td>
                                                <i class="fas fa-file-alt me-2"></i>
                                                <?= htmlspecialchars($material['filename']) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">
                                                    <?= strtoupper(pathinfo($material['filename'], PATHINFO_EXTENSION)) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                if (file_exists($material['file_path'])) {
                                                    $size = filesize($material['file_path']);
                                                    echo number_format($size / 1024, 2) . ' KB';
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                   class="btn btn-sm btn-primary" target="_blank">
                                                    <i class="fas fa-download"></i> Tải về
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Khóa học chưa có tài liệu nào.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4">
                <a href="index.php?controller=Instructor&action=viewStudents&course_id=<?= $course['id'] ?>" 
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách học viên
                </a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
