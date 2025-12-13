<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.php?controller=Admin&action=allEnrollments">Quản lý đăng ký</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Thêm học viên: <?= htmlspecialchars($course['title'] ?? '') ?>
                            </li>
                        </ol>
                    </nav>
                    <h2>
                        <i class="fas fa-user-plus"></i> 
                        Thêm học viên vào khóa học
                    </h2>
                    <p class="text-muted"><?= htmlspecialchars($course['title'] ?? '') ?></p>
                </div>
                <a href="index.php?controller=Admin&action=courseEnrollments&id=<?= $course['id'] ?>" 
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <!-- Course Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">Thông tin khóa học</h5>
                            <p><strong>Giảng viên:</strong> <?= htmlspecialchars($course['instructor_name'] ?? 'N/A') ?></p>
                            <p><strong>Danh mục:</strong> <?= htmlspecialchars($course['category_name'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Thống kê</h5>
                            <p><strong>Số học viên hiện tại:</strong> 
                                <?php
                                $enrollmentModel = new Enrollment();
                                $currentCount = $enrollmentModel->getEnrolledCount($course['id']);
                                echo $currentCount;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Student Form -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($students)): ?>
                        <form method="POST" action="index.php?controller=Admin&action=addStudentToCourse">
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            <input type="hidden" name="redirect" value="index.php?controller=Admin&action=courseEnrollments&id=<?= $course['id'] ?>">
                            
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Chọn học viên</label>
                                <select class="form-select" id="student_id" name="student_id" required>
                                    <option value="">-- Chọn học viên --</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['id'] ?>">
                                            <?= htmlspecialchars($student['fullname']) ?> 
                                            (<?= htmlspecialchars($student['username']) ?> - <?= htmlspecialchars($student['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm học viên
                                </button>
                                <a href="index.php?controller=Admin&action=courseEnrollments&id=<?= $course['id'] ?>" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Không có học viên nào có thể thêm</strong>
                            <p class="mb-0 mt-2">Tất cả học viên đã đăng ký khóa học này.</p>
                        </div>
                        <div class="mt-3">
                            <a href="index.php?controller=Admin&action=courseEnrollments&id=<?= $course['id'] ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
