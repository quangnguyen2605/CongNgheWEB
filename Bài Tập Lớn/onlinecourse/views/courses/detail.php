<?php 
$pageTitle = $course['title'];
require_once __DIR__ . '/../../models/Review.php';
$reviewModel = new Review();
require __DIR__ . '/../layouts/header.php'; 
?>

<div class="container py-4">
    <!-- Course Header -->
    <div class="course-detail">
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="badge bg-info"><?= htmlspecialchars($course['level']) ?></span>
                        <span class="badge bg-secondary"><?= htmlspecialchars($course['category_name'] ?? 'Programming') ?></span>
                        <span class="badge bg-success">Đã được duyệt</span>
                    </div>
                    
                    <h1 class="fw-bold mb-3"><?= htmlspecialchars($course['title']) ?></h1>
                    
                    <div class="course-meta mb-4">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span><?= htmlspecialchars($course['instructor_name'] ?? 'Giảng viên') ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span><?= (int)$course['duration_weeks'] ?> tuần</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span><?= number_format($course['enrolled_count'] ?? 0) ?> học viên</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-star text-warning"></i>
                            <span>4.8 (234 đánh giá)</span>
                        </div>
                    </div>
                    
                    <div class="price-section mb-4">
                        <h3 class="text-primary fw-bold"><?= number_format($course['price'], 0) ?> VNĐ</h3>
                        <p class="text-muted">Trọn đời • Học mọi lúc mọi nơi • Chứng nhận hoàn thành</p>
                    </div>
                    
                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0): ?>
                        <?php if ($isEnrolled): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> Bạn đã đăng ký khóa học này
                                <a href="index.php?controller=Enrollment&action=progress&course_id=<?= $course['id'] ?>" class="btn btn-sm btn-primary ms-2">
                                    Tiếp tục học
                                </a>
                            </div>
                        <?php else: ?>
                            <form action="index.php?controller=Student&action=enroll" method="POST" style="display: inline;">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <input type="hidden" name="redirect" value="index.php?controller=Course&action=detail&id=<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-user-plus"></i> Đăng ký ngay
                                </button>
                            </form>
                        <?php endif; ?>
                    <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 1): ?>
                        <?php if ($course['instructor_id'] == $_SESSION['user_id']): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-user-tie"></i> Bạn là giảng viên của khóa học này
                                <div class="mt-2">
                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=manageCourses" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-cog"></i> Quản lý khóa học
                                    </a>
                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=edit&id=<?= $course['id'] ?>" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i> Sửa khóa học
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="index.php?controller=Auth&action=login" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập để đăng ký
                        </a>
                    <?php endif; ?>
                </div>
                
                <!-- Course Description -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-3">Mô tả khóa học</h3>
                    <div class="text-muted">
                        <?= nl2br(htmlspecialchars($course['description'])) ?>
                    </div>
                </div>
                
                <!-- Course Content -->
                <div class="mb-5">
                    <h3 class="fw-bold mb-3">Nội dung khóa học</h3>
                    <div class="accordion" id="courseContent">
                        <?php if (!empty($lessons)): ?>
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?= $index ?>">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#lesson<?= $index ?>" aria-expanded="true">
                                            <i class="fas fa-play-circle me-2"></i>
                                            Bài <?= $index + 1 ?>: <?= htmlspecialchars($lesson['title']) ?>
                                        </button>
                                    </h2>
                                    <div id="lesson<?= $index ?>" class="accordion-collapse collapse show" 
                                         aria-labelledby="heading<?= $index ?>" data-bs-parent="#courseContent">
                                        <div class="accordion-body">
                                            <p><?= nl2br(htmlspecialchars($lesson['content'])) ?></p>
                                            <?php if ($lesson['video_url']): ?>
                                                <a href="<?= htmlspecialchars($lesson['video_url']) ?>" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="fas fa-video"></i> Xem video
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Nội dung khóa học đang được cập nhật...</p>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <!-- Course Image Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <?php if ($course['image']): ?>
                            <img src="<?= htmlspecialchars($course['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>" style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Course Info Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0 && !$isEnrolled): ?>
                                <form action="index.php?controller=Student&action=enroll" method="POST">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <input type="hidden" name="redirect" value="index.php?controller=Course&action=detail&id=<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="fas fa-user-plus"></i> Đăng ký khóa học
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Instructor Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3">Giảng viên</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($course['instructor_name'] ?? 'Giảng viên') ?></h6>
                                    <small class="text-muted">Chuyên gia lập trình</small>
                                </div>
                            </div>
                            <p class="text-muted small">
                                Giảng viên có kinh nghiệm 5+ năm trong ngành lập trình web và mobile.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div id="reviews" class="container py-5">
        <div class="row">
            <div class="col-12">
                <h3 class="fw-bold mb-4">Đánh giá khóa học</h3>
                
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0 && $isEnrolled): ?>
                    <!-- Review Form -->
                    <div id="review-form" class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Viết đánh giá của bạn</h5>
                            
                            <?php
                            require_once __DIR__ . '/../../models/Review.php';
                            $reviewModel = new Review();
                            $userReview = $reviewModel->getUserReview($_SESSION['user_id'], $course['id']);
                            
                            // Xử lý submit đánh giá
                            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
                                $rating = $_POST['rating'] ?? 0;
                                $comment = $_POST['comment'] ?? '';
                                
                                if ($rating >= 1 && $rating <= 5) {
                                    if ($reviewModel->create($_SESSION['user_id'], $course['id'], $rating, $comment)) {
                                        echo '<div class="alert alert-success">Đánh giá của bạn đã được gửi thành công!</div>';
                                        $userReview = $reviewModel->getUserReview($_SESSION['user_id'], $course['id']);
                                    } else {
                                        echo '<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại.</div>';
                                    }
                                }
                            }
                            ?>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Xếp hạng *</label>
                                    <select class="form-select" name="rating" required>
                                        <option value="">-- Chọn xếp hạng --</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>" <?= ($userReview['rating'] ?? 0) == $i ? 'selected' : '' ?>>
                                                <?= $i ?> sao
                                                <?php if ($i == 1): ?> - Rất tệ<?php elseif ($i == 2): ?> - Tệ<?php elseif ($i == 3): ?> - Trung bình<?php elseif ($i == 4): ?> - Tốt<?php elseif ($i == 5): ?> - Rất tốt<?php endif; ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Bình luận</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" 
                                              placeholder="Chia sẻ trải nghiệm của bạn về khóa học này..."><?= htmlspecialchars($userReview['comment'] ?? '') ?></textarea>
                                </div>
                                
                                <button type="submit" name="submit_review" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Gửi đánh giá
                                </button>
                            </form>
                        </div>
                    </div>
                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_role'] == 0 && !$isEnrolled): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Bạn cần đăng ký khóa học để có thể đánh giá.
                    </div>
                <?php endif; ?>
                
                <!-- Reviews List -->
                <div class="reviews-list">
                    <?php
                    $reviews = $reviewModel->getCourseReviews($course['id'], 10);
                    
                    if (empty($reviews)): ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comment-slash fa-3x mb-3"></i>
                            <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá khóa học này!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                             style="width: 50px; height: 50px; min-width: 50px;">
                                            <?php if (!empty($review['avatar'])): ?>
                                                <img src="<?= htmlspecialchars($review['avatar']) ?>" alt="Avatar" class="rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php else: ?>
                                                <i class="fas fa-user"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($review['fullname']) ?></h6>
                                                    <small class="text-muted">
                                                        <?= date('d/m/Y', strtotime($review['created_at'])) ?>
                                                    </small>
                                                </div>
                                                <div class="text-warning">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="fas fa-star <?= $i <= $review['rating'] ? '' : 'text-muted' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <?php if (!empty($review['comment'])): ?>
                                                <p class="mb-0"><?= htmlspecialchars($review['comment']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reviews-list .card {
    transition: transform 0.2s;
}

.reviews-list .card:hover {
    transform: translateY(-2px);
}

/* Smooth scroll */
html {
    scroll-behavior: smooth;
}
</style>

<script>
// Scroll to reviews section if hash exists or show_review parameter or localStorage
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const showReview = urlParams.get('show_review');
    const courseIdFromStorage = localStorage.getItem('scrollToReview');
    
    // Clear localStorage sau khi đọc
    if (courseIdFromStorage) {
        localStorage.removeItem('scrollToReview');
    }
    
    if (window.location.hash === '#reviews' || showReview === 'true' || courseIdFromStorage) {
        setTimeout(function() {
            const reviewsSection = document.getElementById('reviews');
            const reviewForm = document.getElementById('review-form');
            
            if (reviewForm) {
                // Focus on review form first
                reviewForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Highlight the form briefly
                reviewForm.style.border = '2px solid #ffc107';
                reviewForm.style.boxShadow = '0 0 15px rgba(255, 193, 7, 0.3)';
                setTimeout(function() {
                    reviewForm.style.border = '';
                    reviewForm.style.boxShadow = '';
                }, 2000);
                
                // Focus on the rating select
                const ratingSelect = document.querySelector('select[name="rating"]');
                if (ratingSelect) {
                    ratingSelect.focus();
                }
            } else if (reviewsSection) {
                reviewsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 800);
    }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
