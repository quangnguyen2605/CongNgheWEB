<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-book"></i> 
                    Quản lý bài học - <?= htmlspecialchars($course['title']) ?>
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=create&course_id=<?= $course['id'] ?>" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm bài học mới
                </a>
            </div>

            <!-- Course Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Tổng số bài học:</strong> <?= count($lessons) ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Trạng thái:</strong> 
                            <span class="badge bg-<?= count($lessons) > 0 ? 'success' : 'warning' ?>">
                                <?= count($lessons) > 0 ? 'Đã có nội dung' : 'Chưa có nội dung' ?>
                            </span>
                        </div>
                        <div class="col-md-6">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-info" role="progressbar" 
                                     style="width: 100%" 
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    Khóa học: <?= htmlspecialchars($course['title']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lessons List -->
            <?php if (!empty($lessons)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>STT</th>
                                <th>Tên bài học</th>
                                <th>Nội dung</th>
                                <th>Video</th>
                                <th>Thứ tự</th>
                                <th>Tài liệu</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary"><?= $index + 1 ?></span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($lesson['title']) ?></strong>
                                    </td>
                                    <td>
                                        <?php 
                                        $content = strip_tags($lesson['content']);
                                        $preview = mb_substr($content, 0, 100);
                                        echo htmlspecialchars($preview) . (mb_strlen($content) > 100 ? '...' : '');
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
                                        <span class="badge bg-info"><?= $lesson['order'] ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-file"></i> Tài liệu
                                        </span>
                                        <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manageMaterials&lesson_id=<?= $lesson['id'] ?>" 
                                           class="btn btn-sm btn-outline-info ms-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=edit&id=<?= $lesson['id'] ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manageMaterials&lesson_id=<?= $lesson['id'] ?>" 
                                               class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-file"></i> Tài liệu
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=delete&id=<?= $lesson['id'] ?>&course_id=<?= $course['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Bạn có chắc muốn xóa bài học này? Toàn bộ tài liệu liên quan sẽ bị xóa.')">
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
                    <h4>Chưa có bài học nào</h4>
                    <p>Bắt đầu bằng cách thêm bài học đầu tiên cho khóa học của bạn.</p>
                    <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=create&course_id=<?= $course['id'] ?>" 
                       class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Thêm bài học đầu tiên
                    </a>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="mt-4">
                <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=myCourses" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại khóa học của tôi
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $course['id'] ?>" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-eye"></i> Xem khóa học
                </a>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=viewStudents&course_id=<?= $course['id'] ?>" 
                   class="btn btn-outline-info">
                    <i class="fas fa-users"></i> Xem học viên
                </a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
