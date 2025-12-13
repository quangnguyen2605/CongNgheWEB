<?php require __DIR__ . '/../../layouts/header.php'; ?>
<h2>Học viên đăng ký - <?= htmlspecialchars($course['title']) ?></h2>
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Trạng thái</th>
        <th>Tiến độ</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($students as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['fullname']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['status']) ?></td>
            <td><?= (int)$s['progress_percentage'] ?>%</td>
            <td>
                <a href="index.php?controller=Instructor&action=studentDetail&course_id=<?= $course['id'] ?>&student_id=<?= $s['student_id'] ?>" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> Xem chi tiết
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php require __DIR__ . '/../../layouts/footer.php'; ?>
