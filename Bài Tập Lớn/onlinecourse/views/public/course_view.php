<?php 
require __DIR__ . '/../layouts/header.php';
$webRoot = dirname(dirname($_SERVER['PHP_SELF']));
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Course Header -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><?= htmlspecialchars($course['title']) ?></h2>
                    <p class="mb-0 mt-2">Giảng viên: <?= htmlspecialchars($course['instructor_name']) ?></p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-muted"><?= htmlspecialchars($course['description'] ?? 'Không có mô tả') ?></p>
                            <div class="d-flex gap-3 mb-3">
                                <span><i class="fas fa-clock"></i> <?= $course['duration'] ?? 'Không xác định' ?></span>
                                <span><i class="fas fa-signal"></i> <?= htmlspecialchars($course['level'] ?? 'Cơ bản') ?></span>
                                <span><i class="fas fa-users"></i> <?= $enrolledCount ?> học viên</span>
                            </div>
                            <h4 class="text-danger"><?= number_format($course['price'] ?? 0, 0, ',', '.') ?> VNĐ</h4>
                        </div>
                        <div class="col-md-4 text-center">
                            <?php if (!empty($course['image'])): ?>
                                <img src="<?= htmlspecialchars($course['image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($course['title']) ?>">
                            <?php else: ?>
                                <div class="bg-light p-5 rounded">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Course Content -->
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Nội dung khóa học</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($lessons)): ?>
                        <?php foreach ($lessons as $index => $lesson): ?>
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="me-3">
                                    <span class="badge bg-primary"><?= $index + 1 ?></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($lesson['title']) ?></h6>
                                    <p class="text-muted mb-0 small"><?= htmlspecialchars($lesson['description'] ?? '') ?></p>
                                </div>
                                <div>
                                    <i class="fas fa-lock text-muted"></i>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Khóa học chưa có nội dung</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <p class="mb-3">Đăng ký ngay để học khóa học này!</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="index.php?controller=Auth&action=login" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="index.php?controller=Auth&action=register" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Share Section -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chia sẻ khóa học</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="<?= "http://$_SERVER[HTTP_HOST]$webRoot/index.php?controller=Public&action=viewCourse&course_id=$course[id]" ?>" readonly id="shareLink">
                        <button class="btn btn-outline-secondary" onclick="copyShareLink()">
                            <i class="fas fa-copy"></i> Sao chép
                        </button>
                    </div>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary" onclick="shareFacebook()">
                            <i class="fab fa-facebook"></i> Facebook
                        </button>
                        <button class="btn btn-success" onclick="shareZalo()">
                            <i class="fab fa-zalo"></i> Zalo
                        </button>
                        <button class="btn btn-info" onclick="shareMessenger()">
                            <i class="fab fa-facebook-messenger"></i> Messenger
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyShareLink() {
    const shareLink = document.getElementById('shareLink');
    shareLink.select();
    document.execCommand('copy');
    alert('Đã sao chép link!');
}

function shareFacebook() {
    const url = encodeURIComponent(document.getElementById('shareLink').value);
    const text = encodeURIComponent('<?= htmlspecialchars($course['title']) ?> - Khóa học chất lượng cao');
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`, '_blank');
}

function shareZalo() {
    const url = encodeURIComponent(document.getElementById('shareLink').value);
    const text = encodeURIComponent('<?= htmlspecialchars($course['title']) ?> - Khóa học chất lượng cao');
    window.open(`https://zalo.me/share?text=${text}&url=${url}`, '_blank');
}

function shareMessenger() {
    const url = encodeURIComponent(document.getElementById('shareLink').value);
    const text = encodeURIComponent('<?= htmlspecialchars($course['title']) ?> - Khóa học chất lượng cao');
    window.open(`https://www.facebook.com/dialog/send?app_id=123456789&link=${url}&redirect_uri=${url}`, '_blank');
}
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
