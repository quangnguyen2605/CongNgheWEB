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
                        <a href="index.php?controller=Lesson&action=manage&course_id=<?= $lesson['course_id'] ?>">
                            Quản lý bài học
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Tài liệu: <?= htmlspecialchars($lesson['title']) ?>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-file"></i> 
                    Quản lý tài liệu - <?= htmlspecialchars($lesson['title']) ?>
                </h2>
                <a href="index.php?controller=Lesson&action=uploadMaterial&lesson_id=<?= $lesson['id'] ?>" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm tài liệu
                </a>
            </div>

            <!-- Materials List -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($materials)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tên file</th>
                                        <th>Loại file</th>
                                        <th>Kích thước</th>
                                        <th>Ngày tải lên</th>
                                        <th>Hành động</th>
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
                                                    <?= strtoupper($material['file_type']) ?>
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
                                                <?= date('d/m/Y H:i', strtotime($material['uploaded_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                       target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Xem
                                                    </a>
                                                    <a href="<?= htmlspecialchars($material['file_path']) ?>" 
                                                       download class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-download"></i> Tải
                                                    </a>
                                                    <a href="index.php?controller=Lesson&action=deleteMaterial&id=<?= $material['id'] ?>&lesson_id=<?= $lesson['id'] ?>" 
                                                       class="btn btn-sm btn-outline-danger"
                                                       onclick="return confirm('Bạn có chắc muốn xóa tài liệu này?')">
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
                            <i class="fas fa-info-circle"></i> 
                            Chưa có tài liệu nào cho bài học này.
                            <br>
                            <a href="index.php?controller=Lesson&action=uploadMaterial&lesson_id=<?= $lesson['id'] ?>" 
                               class="btn btn-primary mt-2">
                                <i class="fas fa-plus"></i> Thêm tài liệu đầu tiên
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-3">
                <a href="index.php?controller=Lesson&action=manage&course_id=<?= $lesson['course_id'] ?>" 
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại quản lý bài học
                </a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
