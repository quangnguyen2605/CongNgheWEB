<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-upload"></i> Tải tài liệu cho bài học
                </h2>
            </div>

            <!-- Upload Form -->
            <div class="card">
                <div class="card-body">
                    <form method="post" action="index.php?controller=Lesson&action=uploadMaterial&lesson_id=<?= (int)($_GET['lesson_id'] ?? 0) ?>" 
                          enctype="multipart/form-data">
                        
                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="material" class="form-label fw-bold">
                                <i class="fas fa-file"></i> Chọn file tài liệu <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="material" name="material" required
                                   accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                            <small class="form-text text-muted">
                                Hỗ trợ các định dạng: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, JPG, PNG, GIF, MP4, AVI, MOV.
                                Kích thước tối đa: 50MB.
                            </small>
                        </div>

                        <!-- Supported Formats -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle"></i> Các định dạng được hỗ trợ:
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tài liệu:</strong>
                                    <ul class="small mb-0">
                                        <li>PDF - Tài liệu PDF</li>
                                        <li>DOC/DOCX - Tài liệu Word</li>
                                        <li>XLS/XLSX - Bảng tính Excel</li>
                                        <li>PPT/PPTX - Trình chiếu PowerPoint</li>
                                        <li>TXT - Tài liệu văn bản</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <strong>Media:</strong>
                                    <ul class="small mb-0">
                                        <li>JPG/JPEG - Hình ảnh</li>
                                        <li>PNG - Hình ảnh</li>
                                        <li>GIF - Hình ảnh động</li>
                                        <li>MP4/AVI/MOV - Video</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Tải lên
                            </button>
                            <a href="index.php?controller=Lesson&action=manageMaterials&lesson_id=<?= (int)($_GET['lesson_id'] ?? 0) ?>" 
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
                        <i class="fas fa-lightbulb"></i> Mẹo tải tài liệu
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="small">
                        <li class="mb-2">Sử dụng tên file rõ ràng, dễ hiểu</li>
                        <li class="mb-2">Nén file lớn trước khi tải lên</li>
                        <li class="mb-2">Kiểm tra kỹ nội dung trước khi chia sẻ</li>
                        <li class="mb-2">Sử dụng PDF cho tài liệu văn bản tốt nhất</li>
                        <li class="mb-2">Video nên có độ phân giải hợp lý</li>
                        <li class="mb-2">Đảm bảo không có virus hoặc phần mềm độc hại</li>
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
                        <a href="index.php?controller=Lesson&action=manageMaterials&lesson_id=<?= (int)($_GET['lesson_id'] ?? 0) ?>" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list"></i> Danh sách tài liệu
                        </a>
                        <a href="index.php?controller=Lesson&action=manage&course_id=<?= $lesson['course_id'] ?? (int)($_GET['course_id'] ?? 0) ?>" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quản lý bài học
                        </a>
                    </div>
                </div>
            </div>

            <!-- File Size Info -->
            <div class="card mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle"></i> Lưu ý
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small mb-0">
                        <strong>Giới hạn kích thước:</strong> 50MB per file<br>
                        <strong>Lưu trữ:</strong> File được lưu trữ an toàn<br>
                        <strong>Xóa:</strong> Có thể xóa và thay thế bất cứ lúc nào
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
