<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-plus"></i> Thêm bài học mới
                </h2>
            </div>

            <!-- Form -->
            <div class="card">
                <div class="card-body">
                    <form method="post" action="index.php?controller=Lesson&action=store" enctype="multipart/form-data">
                        <input type="hidden" name="course_id" value="<?= (int)($_GET['course_id'] ?? 0) ?>">

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading"></i> Tiêu đề bài học <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="title" name="title" required
                                   placeholder="Nhập tiêu đề bài học">
                        </div>

                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">
                                <i class="fas fa-file-alt"></i> Nội dung bài học
                            </label>
                            <textarea class="form-control" id="content" name="content" rows="8"
                                      placeholder="Nhập nội dung chi tiết của bài học..."></textarea>
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
                                   placeholder="https://www.youtube.com/watch?v=...">
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
                                   value="0" min="0" max="100">
                            <small class="form-text text-muted">
                                Thứ tự hiển thị của bài học trong khóa học (0 = đầu tiên).
                            </small>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu bài học
                            </button>
                            <a href="index.php?controller=Lesson&action=manage&course_id=<?= (int)($_GET['course_id'] ?? 0) ?>" 
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
            <!-- Tips Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb"></i> Mẹo tạo bài học
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="small">
                        <li class="mb-2">Sử dụng tiêu đề rõ ràng, mô tả nội dung chính</li>
                        <li class="mb-2">Thêm nội dung chi tiết để học viên dễ theo dõi</li>
                        <li class="mb-2">Video giúp tăng tương tác và hiểu biết</li>
                        <li class="mb-2">Sắp xếp thứ tự logic cho bài học</li>
                        <li class="mb-2">Sau khi tạo, bạn có thể thêm tài liệu bổ sung</li>
                    </ul>
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
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Lesson&action=manage&course_id=<?= (int)($_GET['course_id'] ?? 0) ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list"></i> Quản lý bài học
                        </a>
                        <a href="/onlinecourse/onlinecourse/index.php?controller=Instructor&action=manageCourses" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Khóa học của tôi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
