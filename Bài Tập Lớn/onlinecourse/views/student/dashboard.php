<?php require __DIR__ . '/../layouts/header.php'; ?>
<div class="student-dashboard">
    <h2>Dashboard học viên</h2>
    <p>Chào mừng bạn trở lại hệ thống khóa học online.</p>
    <ul>
        <li><a href="index.php?controller=Student&action=myCourses">Khóa học của tôi</a></li>
        <li><a href="index.php?controller=Payment&action=paymentHistory">Lịch sử thanh toán</a></li>
        <li><a href="index.php?controller=Student&action=browseCourses">Khám phá khóa học</a></li>
    </ul>
</div>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
