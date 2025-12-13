<?php
session_start();

// Lấy course_id từ URL
$courseId = $_GET['course_id'] ?? 0;
if (!$courseId) {
    header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=myCourses');
    exit;
}

// Load models
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Review.php';
require_once __DIR__ . '/../../models/Enrollment.php';

$courseModel = new Course();
$reviewModel = new Review();
$enrollmentModel = new Enrollment();

// Lấy thông tin khóa học
$course = $courseModel->findById($courseId);
if (!$course || $course['status'] != 'approved') {
    $_SESSION['error'] = 'Khóa học không tồn tại hoặc chưa được duyệt';
    header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=myCourses');
    exit;
}

// Kiểm tra user đã đăng ký khóa học chưa (chỉ nếu user đã đăng nhập)
$enrollment = null;
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0) {
    $enrollment = $enrollmentModel->findByUserAndCourse($_SESSION['user_id'], $courseId);
    
    // Debug thêm
    error_log("DEBUG - User ID: " . $_SESSION['user_id'] . ", Course ID: " . $courseId);
    error_log("DEBUG - Enrollment result: " . ($enrollment ? "FOUND" : "NOT FOUND"));
}

// Lấy đánh giá hiện tại của user (nếu đã đăng nhập)
$userReview = null;
if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0) {
    $userReview = $reviewModel->getUserReview($_SESSION['user_id'], $courseId);
}

// Xử lý submit đánh giá
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
        $error = 'Bạn cần đăng nhập để đánh giá khóa học.';
    } 
    // Kiểm tra đã đăng ký chưa
    elseif (!$enrollment) {
        $error = 'Bạn cần đăng ký khóa học trước khi đánh giá.';
    } else {
        $rating = $_POST['rating'] ?? 0;
        $comment = $_POST['comment'] ?? '';
        
        if ($rating >= 1 && $rating <= 5) {
            if ($reviewModel->create($_SESSION['user_id'], $courseId, $rating, $comment)) {
                $success = 'Đánh giá của bạn đã được gửi thành công!';
                $userReview = $reviewModel->getUserReview($_SESSION['user_id'], $courseId);
            } else {
                $error = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
        } else {
            $error = 'Vui lòng chọn xếp hạng từ 1 đến 5 sao.';
        }
    }
}

$pageTitle = 'Đánh giá khóa học - ' . htmlspecialchars($course['title']);
require __DIR__ . '/../layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Course Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Student&action=myCourses" 
                           class="btn btn-outline-secondary me-3">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <h4 class="mb-0"><?= htmlspecialchars($course['title']) ?></h4>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name'] ?? 'Chưa cập nhật') ?></p>
                            <p class="mb-1"><strong>Thời lượng:</strong> <?= (int)$course['duration_weeks'] ?> tuần</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Cấp độ:</strong> <?= htmlspecialchars($course['level']) ?></p>
                            <p class="mb-1"><strong>Tiến độ:</strong> <?= $enrollment ? (int)$enrollment['progress'] . '%' : 'Chưa đăng ký' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <?php if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-user-lock fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Bạn cần đăng nhập để đánh giá khóa học</h5>
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Auth&action=login" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        </div>
                    <?php elseif (!$enrollment): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-lock fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Bạn cần đăng ký khóa học trước khi đánh giá</h5>
                            
                            <!-- Debug Info -->
                            <div class="alert alert-warning">
                                <small>
                                    <strong>Debug Info:</strong><br>
                                    User ID: <?= isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not logged in' ?><br>
                                    User Role: <?= isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'Not set' ?><br>
                                    Course ID: <?= $courseId ?><br>
                                    Enrollment Found: <?= $enrollment ? 'YES' : 'NO' ?>
                                    <?php if ($enrollment): ?>
                                        <br>Enrollment Data: <pre><?= print_r($enrollment, true) ?></pre>
                                    <?php endif; ?>
                                </small>
                            </div>
                            
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $courseId ?>" class="btn btn-primary">
                                <i class="fas fa-info-circle"></i> Xem chi tiết khóa học
                            </a>
                        </div>
                    <?php else: ?>
                        <h5 class="card-title mb-4">
                            <i class="fas fa-star text-warning"></i> 
                            <?= $userReview ? 'Cập nhật đánh giá' : 'Viết đánh giá của bạn' ?>
                        </h5>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> <?= $success ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?= $error ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Xếp hạng *</label>
                                <select class="form-select form-select-lg" name="rating" required>
                                    <option value="">-- Chọn xếp hạng --</option>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($userReview['rating'] ?? 0) == $i ? 'selected' : '' ?>>
                                            <?= $i ?> sao
                                            <?php if ($i == 1): ?> - Rất tệ<?php elseif ($i == 2): ?> - Tệ<?php elseif ($i == 3): ?> - Trung bình<?php elseif ($i == 4): ?> - Tốt<?php elseif ($i == 5): ?> - Rất tốt<?php endif; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="comment" class="form-label fw-bold">Bình luận</label>
                                <textarea class="form-control" id="comment" name="comment" rows="5" 
                                          placeholder="Chia sẻ trải nghiệm của bạn về khóa học này. Nội dung nào bạn thấy hữu ích nhất? Giảng viên có nhiệt tình không?..."><?= htmlspecialchars($userReview['comment'] ?? '') ?></textarea>
                                <small class="text-muted">Hãy chia sẻ chi tiết để giúp các học viên khác có lựa chọn tốt hơn.</small>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" name="submit_review" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> 
                                    <?= $userReview ? 'Cập nhật đánh giá' : 'Gửi đánh giá' ?>
                                </button>
                                
                                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $courseId ?>#reviews" 
                                   class="btn btn-outline-secondary">
                                    <i class="fas fa-eye"></i> Xem đánh giá khác
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 12px;
}

.form-select-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

textarea.form-control {
    resize: vertical;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.text-warning {
    color: #ffc107 !important;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
