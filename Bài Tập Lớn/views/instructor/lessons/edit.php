<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-edit"></i> Chỉnh sửa bài học
                </h2>
            </div>

            <!-- Form -->
            <div class="card">
                <div class="card-body">
                    <form method="post" action="index.php?controller=Lesson&action=update">
                        <input type="hidden" name="id" value="<?= $lesson['id'] ?>">
                        <input type="hidden" name="course_id" value="<?= $lesson['course_id'] ?>">

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading"></i> Tiêu đề bài học <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?= htmlspecialchars($lesson['title']) ?>" required
                                   placeholder="Nhập tiêu đề bài học">
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">
                                <i class="fas fa-file-alt"></i> Nội dung bài học
                            </label>
                            <textarea class="form-control" id="content" name="content" rows="8"
                                      placeholder="Nhập nội dung chi tiết của bài học..."><?= htmlspecialchars($lesson['content']) ?></textarea>
                            <small class="form-text text-muted">
                                Bạn có thể sử dụng HTML để định dạng nội dung. Hỗ trợ các thẻ: p, strong, em, ul, ol, li, h1-h6, etc.
                            </small>
                        </div>

                        <!-- Video URL -->
                        <div class="mb-3">
                            <label for="video_url" class="form-label fw-bold">
                                <i class="fas fa-video"></i> Video URL (tùy chọn)
                            </label>
                            <input type="url" class="form-control" id="video_url" name="video_url"
                                   value="<?= htmlspecialchars($lesson['video_url']) ?>"
                                   placeholder="https://www.youtube.com/watch?v=...">
                            <?php if ($lesson['video_url']): ?>
                                <div class="mt-2">
                                    <a href="<?= htmlspecialchars($lesson['video_url']) ?>" target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Xem video hiện tại
                                    </a>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Nhập link video từ YouTube, Vimeo hoặc các nền tảng khác.
                            </small>
                        </div>

                        <!-- Order -->
                        <div class="mb-3">
                            <label for="order" class="form-label fw-bold">
                                <i class="fas fa-sort"></i> Thứ tự
                            </label>
                            <input type="number" class="form-control" id="order" name="order" 
                                   value="<?= (int)$lesson['order'] ?>" min="0" max="100">
                            <small class="form-text text-muted">
                                Thứ tự hiển thị của bài học trong khóa học (0 = đầu tiên).
                            </small>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật bài học
                            </button>
                            <a href="index.php?controller=Lesson&action=manage&course_id=<?= $lesson['course_id'] ?>" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Lesson Info Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i> Thông tin bài học
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="mb-2">
                            <strong>ID:</strong> <?= $lesson['id'] ?>
                        </div>
                        <div class="mb-2">
                            <strong>Số thứ tự:</strong> <?= (int)$lesson['order'] ?>
                        </div>
                        <div class="mb-2">
                            <strong>Ngày tạo:</strong> 
                            <?= date('d/m/Y H:i', strtotime($lesson['created_at'])) ?>
                        </div>
                        <?php if ($lesson['updated_at'] && $lesson['updated_at'] != $lesson['created_at']): ?>
                            <div class="mb-2">
                                <strong>Cập nhật cuối:</strong> 
                                <?= date('d/m/Y H:i', strtotime($lesson['updated_at'])) ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-2">
                            <strong>Trạng thái video:</strong> 
                            <span class="badge bg-<?= $lesson['video_url'] ? 'success' : 'secondary' ?>">
                                <?= $lesson['video_url'] ? 'Có video' : 'Không có video' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt"></i> Hành động nhanh
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manageMaterials&lesson_id=<?= $lesson['id'] ?>" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fas fa-file"></i> Quản lý tài liệu
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manage&course_id=<?= $lesson['course_id'] ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list"></i> Danh sách bài học
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=manageCourses" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Khóa học của tôi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card mt-3">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Vùng nguy hiểm
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Hành động này không thể hoàn lại. Hãy chắc chắn bạn muốn thực hiện.
                    </p>
                    <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=delete&id=<?= $lesson['id'] ?>&course_id=<?= $lesson['course_id'] ?>" 
                       class="btn btn-danger btn-sm w-100"
                       onclick="return confirm('Bạn có chắc muốn xóa bài học này? Toàn bộ tài liệu liên quan sẽ bị xóa.')">
                        <i class="fas fa-trash"></i> Xóa bài học
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
