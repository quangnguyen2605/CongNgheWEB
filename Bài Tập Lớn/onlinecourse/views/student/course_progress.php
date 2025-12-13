<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?= htmlspecialchars($course['title']) ?></h4>
                    <div class="d-flex gap-2">
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Enrollment&action=courseMaterials&course_id=<?= $course['id'] ?>" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-folder"></i> Tài liệu khóa học
                        </a>
                        <?php if (isset($enrollment) && $enrollment && $enrollment['progress'] > 0): ?>
                            <form action="index.php?controller=Student&action=resetCourse" method="POST" style="display: inline;">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-outline-warning btn-sm" 
                                        onclick="return confirm('Bạn có chắc muốn làm lại toàn bộ khóa học? Toàn bộ tiến độ sẽ bị đặt lại.')">
                                    <i class="fas fa-redo"></i> Làm lại khóa học
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Tiến độ hiện tại:</span>
                            <strong><?= (int)($enrollment['progress'] ?? 0) ?>%</strong>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= $enrollment['progress'] ?? 0 ?>%"
                                 aria-valuenow="<?= $enrollment['progress'] ?? 0 ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                    </div>

                    <h5>Danh sách bài học</h5>
                    <?php if (isset($lessons) && !empty($lessons)): ?>
                        <div class="list-group">
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <?php 
                                $isCompleted = in_array($lesson['id'], array_column($completedLessons ?? [], 'id'));
                                ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">
                                            <?php if ($isCompleted): ?>
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                            <?php else: ?>
                                                <i class="far fa-circle me-2"></i>
                                            <?php endif; ?>
                                            <a href="index.php?controller=Student&action=viewLesson&lesson_id=<?= $lesson['id'] ?>" 
                                               class="text-decoration-none">
                                                <?= htmlspecialchars($lesson['title']) ?>
                                            </a>
                                        </h6>
                                        <small class="text-muted">Bài <?= $index + 1 ?></small>
                                    </div>
                                    <?php if ($isCompleted): ?>
                                        <span class="badge bg-success">Đã hoàn thành</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Chưa học</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Khóa học chưa có bài học nào.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
