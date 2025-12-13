<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-upload"></i> Tải tài liệu khóa học
                </h2>
            </div>

            <!-- Course Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                    <p class="text-muted"><?= htmlspecialchars($course['description']) ?></p>
                    <div class="row">
                        <div class="col-md-4">
                            <small><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name']) ?></small>
                        </div>
                        <div class="col-md-4">
                            <small><strong>Học viên:</strong> <?= (int)($course['student_count'] ?? 0) ?></small>
                        </div>
                        <div class="col-md-4">
                            <small><strong>Bài học:</strong> <?= (int)($course['lesson_count'] ?? 0) ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cloud-upload-alt"></i> Tải tài liệu mới
                    </h5>
                </div>
                <div class="card-body">
                    <form method="post" action="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=uploadCourseMaterials&course_id=<?= $course['id'] ?>" 
                          enctype="multipart/form-data">
                        
                        <!-- Material Type Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                <i class="fas fa-tag"></i> Loại tài liệu
                            </label>
                            <select class="form-select" name="material_type" required>
                                <option value="">-- Chọn loại tài liệu --</option>
                                <option value="course">Tài liệu khóa học (cho tất cả học viên)</option>
                                <option value="lesson">Tài liệu bài học cụ thể</option>
                            </select>
                        </div>

                        <!-- Lesson Selection (shown when lesson material selected) -->
                        <div class="mb-3" id="lessonSelection" style="display: none;">
                            <label class="form-label fw-bold">
                                <i class="fas fa-book"></i> Chọn bài học
                            </label>
                            <select class="form-select" name="lesson_id" id="lessonSelect">
                                <option value="">-- Chọn bài học --</option>
                                <?php foreach ($lessons as $lesson): ?>
                                    <option value="<?= $lesson['id'] ?>">
                                        <?= htmlspecialchars($lesson['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="materials" class="form-label fw-bold">
                                <i class="fas fa-file"></i> Chọn file tài liệu <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="materials" name="materials[]" multiple
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                            <small class="form-text text-muted">
                                Hỗ trợ nhiều file cùng lúc. Định dạng: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG, GIF, MP4, AVI, MOV.
                                Kích thước tối đa: 50MB per file.
                            </small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-comment"></i> Mô tả (tùy chọn)
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="3"
                                      placeholder="Mô tả về tài liệu này..."></textarea>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Tải lên
                            </button>
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=manageCourses" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Current Materials -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-folder"></i> Tài liệu hiện tại
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($materials)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <?php
                                                $iconClass = 'fa-file';
                                                $iconColor = 'text-secondary';
                                                $fileType = strtolower($material['file_type']);
                                                
                                                if (in_array($fileType, ['pdf'])) {
                                                    $iconClass = 'fa-file-pdf';
                                                    $iconColor = 'text-danger';
                                                } elseif (in_array($fileType, ['doc', 'docx'])) {
                                                    $iconClass = 'fa-file-word';
                                                    $iconColor = 'text-primary';
                                                } elseif (in_array($fileType, ['xls', 'xlsx'])) {
                                                    $iconClass = 'fa-file-excel';
                                                    $iconColor = 'text-success';
                                                } elseif (in_array($fileType, ['ppt', 'pptx'])) {
                                                    $iconClass = 'fa-file-powerpoint';
                                                    $iconColor = 'text-warning';
                                                } elseif (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                                    $iconClass = 'fa-file-image';
                                                    $iconColor = 'text-info';
                                                } elseif (in_array($fileType, ['mp4', 'avi', 'mov'])) {
                                                    $iconClass = 'fa-file-video';
                                                    $iconColor = 'text-dark';
                                                }
                                                ?>
                                                <i class="fas <?= $iconClass ?> <?= $iconColor ?>"></i>
                                            </div>
                                            <div>
                                                <small class="fw-bold"><?= htmlspecialchars($material['filename']) ?></small>
                                                <?php if ($material['description']): ?>
                                                    <br>
                                                    <small class="text-muted"><?= htmlspecialchars(substr($material['description'], 0, 50)) ?>...</small>
                                                <?php endif; ?>
                                                <br>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y H:i', strtotime($material['uploaded_at'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-<?= $material['lesson_id'] ? 'success' : 'primary' ?>">
                                            <?= $material['lesson_id'] ? 'Bài học' : 'Khóa học' ?>
                                        </span>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                               target="_blank" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                               download class="btn btn-outline-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted small mb-0">Chưa có tài liệu nào</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb"></i> Mẹo tải tài liệu
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Tài liệu khóa học sẽ hiển thị cho tất cả học viên</li>
                        <li>Tài liệu bài học chỉ hiển thị trong bài học cụ thể</li>
                        <li>Có thể tải nhiều file cùng lúc</li>
                        <li>Sử dụng tên file rõ ràng, dễ hiểu</li>
                        <li>Kiểm tra kỹ nội dung trước khi tải lên</li>
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt"></i> Hành động nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manage&course_id=<?= $course['id'] ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-book"></i> Quản lý bài học
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=viewStudents&course_id=<?= $course['id'] ?>" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-users"></i> Xem học viên
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $course['id'] ?>" 
                           class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-eye"></i> Xem khóa học
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const materialType = document.querySelector('select[name="material_type"]');
    const lessonSelection = document.getElementById('lessonSelection');
    const lessonSelect = document.getElementById('lessonSelect');
    
    materialType.addEventListener('change', function() {
        if (this.value === 'lesson') {
            lessonSelection.style.display = 'block';
            lessonSelect.required = true;
        } else {
            lessonSelection.style.display = 'none';
            lessonSelect.required = false;
            lessonSelect.value = '';
        }
    });
});
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
