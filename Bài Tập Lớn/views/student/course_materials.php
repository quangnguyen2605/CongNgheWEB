<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-folder"></i> Tài liệu khóa học
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Enrollment&action=progress&course_id=<?= $course['id'] ?>" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Quay lại tiến độ
                </a>
            </div>

            <!-- Course Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                    <p class="text-muted mb-0">
                        <i class="fas fa-user"></i> <?= htmlspecialchars($course['instructor_name']) ?> | 
                        <i class="fas fa-clock"></i> <?= (int)$course['duration_weeks'] ?> tuần
                    </p>
                </div>
            </div>

            <!-- Course-level Materials -->
            <?php if (!empty($courseMaterials)): ?>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-book"></i> Tài liệu khóa học
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($courseMaterials as $material): ?>
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                <div class="me-3">
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
                                                    <i class="fas <?= $iconClass ?> fa-2x <?= $iconColor ?>"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1"><?= htmlspecialchars($material['filename']) ?></h6>
                                                    <?php if ($material['description']): ?>
                                                        <p class="card-text small text-muted"><?= htmlspecialchars($material['description']) ?></p>
                                                    <?php endif; ?>
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($material['uploaded_at'])) ?>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Xem
                                                </a>
                                                <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                   download class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-download"></i> Tải về
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Lesson Materials -->
            <?php if (!empty($lessonMaterials)): ?>
                <?php foreach ($lessonMaterials as $lessonId => $materials): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-book-open"></i> 
                                <?= htmlspecialchars($materials['lesson_title']) ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($materials['files'] as $material): ?>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="me-3">
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
                                                        <i class="fas <?= $iconClass ?> fa-2x <?= $iconColor ?>"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="card-title mb-1"><?= htmlspecialchars($material['filename']) ?></h6>
                                                        <?php if ($material['description']): ?>
                                                            <p class="card-text small text-muted"><?= htmlspecialchars($material['description']) ?></p>
                                                        <?php endif; ?>
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($material['uploaded_at'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </a>
                                                    <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                       download class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Tải về
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- No Materials Message -->
            <?php if (empty($courseMaterials) && empty($lessonMaterials)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>Chưa có tài liệu nào</h4>
                    <p>Giảng viên chưa tải lên tài liệu cho khóa học này.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
