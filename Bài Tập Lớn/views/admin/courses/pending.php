<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-clock"></i> Khóa học chờ duyệt
            </h2>
            
            <?php if (empty($courses)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Không có khóa học nào chờ duyệt.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Khóa học</th>
                                <th>Giảng viên</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($course['image']): ?>
                                                <img src="<?= htmlspecialchars($course['image']) ?>" 
                                                     alt="<?= htmlspecialchars($course['title']) ?>" 
                                                     class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?= htmlspecialchars($course['title']) ?></h6>
                                                <small class="text-muted"><?= substr(htmlspecialchars($course['description']), 0, 100) ?>...</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($course['instructor_name']) ?></td>
                                    <td><?= htmlspecialchars($course['category_name']) ?></td>
                                    <td><?= number_format($course['price']) ?> VNĐ</td>
                                    <td><?= date('d/m/Y', strtotime($course['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Course&action=detail&id=<?= $course['id'] ?>" 
                                               target="_blank" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i> Xem
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=approveCourse&id=<?= $course['id'] ?>" 
                                               class="btn btn-success"
                                               onclick="return confirm('Duyệt khóa học này?')">
                                                <i class="fas fa-check"></i> Duyệt
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=rejectCourse&id=<?= $course['id'] ?>" 
                                               class="btn btn-danger"
                                               onclick="return confirm('Từ chối khóa học này?')">
                                                <i class="fas fa-times"></i> Từ chối
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
