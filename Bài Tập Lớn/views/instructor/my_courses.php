<?php require __DIR__ . '/../layouts/instructor_header.php'; ?>
<div class="instructor-my-courses">
    <h2>Khóa học của tôi</h2>
    <a class="btn btn-primary" href="/onlinecourse/onlinecourse/index.php?controller=Course&action=create">+ Tạo khóa học mới</a>
    <div class="course-list">
        <?php foreach ($courses as $c): ?>
            <div class="course-card">
                <h3><?= htmlspecialchars($c['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($c['description'], 0, 100))) ?>...</p>
                <p>Thời lượng: <?= (int)$c['duration_weeks'] ?> tuần</p>
                <div class="course-actions">
                    <a class="btn btn-outline-primary" href="/onlinecourse/onlinecourse/index.php?controller=Course&action=edit&id=<?= $c['id'] ?>">Sửa khóa học</a>
                    <a class="btn btn-outline-success" href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manage&course_id=<?= $c['id'] ?>">Quản lý bài học</a>
                    <a class="btn btn-outline-info" href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=viewStudents&course_id=<?= $c['id'] ?>">Xem học viên</a>
                    <a class="btn btn-outline-danger" href="/onlinecourse/onlinecourse/index.php?controller=Course&action=delete&id=<?= $c['id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa khóa học này?');">Xóa khóa học</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
