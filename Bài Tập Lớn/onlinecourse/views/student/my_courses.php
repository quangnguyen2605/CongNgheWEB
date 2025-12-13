<?php 
require_once __DIR__ . '/../../models/Review.php';
$reviewModel = new Review();
?>
<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="my-courses">
    <h2>Khóa học của tôi</h2>
    <div class="course-list">
        <?php if (isset($courses) && !empty($courses)): ?>
            <?php foreach ($courses as $c): ?>
                <?php 
                $userReview = $reviewModel->getUserReview($_SESSION['user_id'], $c['course_id']);
                $avgRating = $reviewModel->getAverageRating($c['course_id']);
                ?>
                <div class="course-card">
                    <h3><?= htmlspecialchars($c['title']) ?></h3>
                    <p>Trạng thái: <?= htmlspecialchars($c['status']) ?></p>
                    <p>Tiến độ: <?= (int)$c['progress'] ?>%</p>
                    
                    <?php if ($avgRating['avg_rating'] > 0): ?>
                        <p class="mb-2">
                            <i class="fas fa-star text-warning"></i> 
                            Đánh giá trung bình: <?= round($avgRating['avg_rating'], 1) ?> 
                            <small class="text-muted">(<?= $avgRating['total_reviews'] ?> đánh giá)</small>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ($userReview): ?>
                        <div class="alert alert-success py-2 mb-2">
                            <small><i class="fas fa-check-circle"></i> Bạn đã đánh giá: 
                                <span class="text-warning">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $userReview['rating'] ? '' : 'text-muted' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                            </small>
                        </div>
                    <?php endif; ?>
                    
                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-primary" href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $c['course_id'] ?>">
                            <i class="fas fa-info-circle"></i> Xem chi tiết
                        </a>
                        
                        <a class="btn btn-outline-primary" href="/onlinecourse/onlinecourse/index.php?controller=Enrollment&action=progress&course_id=<?= $c['course_id'] ?>">Xem tiến độ</a>
                        
                        <?php 
                        // Get first lesson of this course
                        $lessonModel = new Lesson();
                        $firstLesson = $lessonModel->getByCourse($c['course_id']);
                        if (!empty($firstLesson)):
                            $firstLessonId = $firstLesson[0]['id'];
                        ?>
                            <a class="btn btn-success" href="/onlinecourse/onlinecourse/index.php?controller=Student&action=viewLesson&lesson_id=<?= $firstLessonId ?>">
                                <i class="fas fa-play"></i> Học bài học
                            </a>
                        <?php endif; ?>
                        
                        <a class="btn <?= $userReview ? 'btn-secondary' : 'btn-warning' ?>" 
                           href="/onlinecourse/onlinecourse/views/courses/review.php?course_id=<?= $c['course_id'] ?>">
                            <i class="fas fa-star"></i> 
                            <?= $userReview ? 'Xem đánh giá' : 'Viết đánh giá' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Bạn chưa đăng ký khóa học nào.
                <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=index" class="btn btn-primary ms-2">Xem khóa học</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.course-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.course-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.course-card h3 {
    color: #333;
    margin-bottom: 1rem;
}

.course-card .btn {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.text-warning {
    color: #ffc107 !important;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
