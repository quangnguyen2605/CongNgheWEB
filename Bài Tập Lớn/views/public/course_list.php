<?php 
require __DIR__ . '/../layouts/header.php';
$webRoot = dirname(dirname($_SERVER['PHP_SELF']));
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Danh sách khóa học</h2>
            
            <?php if (!empty($courses)): ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <?php if (!empty($course['image'])): ?>
                                    <img src="<?= htmlspecialchars($course['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                                    <p class="card-text text-muted"><?= htmlspecialchars(substr($course['description'] ?? 'Không có mô tả', 0, 100)) ?>...</p>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <i class="fas fa-user"></i> <?= htmlspecialchars($course['instructor_name']) ?>
                                            </small>
                                            <small class="text-muted">
                                                <i class="fas fa-clock"></i> <?= $course['duration'] ?? 'N/A' ?>
                                            </small>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-danger fw-bold"><?= number_format($course['price'] ?? 0, 0, ',', '.') ?> VNĐ</span>
                                            <a href="index.php?controller=Public&action=viewCourse&course_id=<?= $course['id'] ?>" class="btn btn-primary btn-sm">
                                                Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chưa có khóa học nào.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
