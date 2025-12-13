<?php require __DIR__ . '/../../layouts/header.php'; ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <div class="d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2"></i>
                    <h4 class="mb-0">Tạo khóa học mới</h4>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="post" action="index.php?controller=Course&action=store" enctype="multipart/form-data" id="courseForm">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="mb-4">
                                <h6 class="text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Thông tin cơ bản</h6>
                                 
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-semibold">Tiêu đề khóa học <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="title" name="title" required 
                                           placeholder="Nhập tiêu đề khóa học hấp dẫn...">
                                    <div class="form-text">Tiêu đề nên ngắn gọn, rõ ràng và thu hút học viên</div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label fw-semibold">Mô tả chi tiết</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" 
                                              placeholder="Mô tả nội dung, mục tiêu và đối tượng của khóa học..."></textarea>
                                    <div class="form-text">Cung cấp thông tin chi tiết để giúp học viên hiểu rõ về khóa học</div>
                                </div>
                            </div>

                            <!-- Course Details -->
                            <div class="mb-4">
                                <h6 class="text-primary mb-3"><i class="fas fa-cog me-2"></i>Chi tiết khóa học</h6>
                                 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">-- Chọn danh mục --</option>
                                                <?php foreach ($categories as $cat): ?>
                                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="level" class="form-label fw-semibold">Cấp độ</label>
                                            <select class="form-select" id="level" name="level">
                                                <option value="Beginner">Beginner (Cơ bản)</option>
                                                <option value="Intermediate">Intermediate (Trung cấp)</option>
                                                <option value="Advanced">Advanced (Nâng cao)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label fw-semibold">Giá khóa học (VNĐ)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                                <input type="number" class="form-control" id="price" name="price" 
                                                       step="1000" min="0" value="0" placeholder="0">
                                            </div>
                                            <div class="form-text">Để 0 nếu khóa học miễn phí</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="duration_weeks" class="form-label fw-semibold">Thời lượng (tuần)</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                                <input type="number" class="form-control" id="duration_weeks" name="duration_weeks" 
                                                       min="1" value="4" placeholder="4">
                                                <span class="input-group-text">tuần</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Course Image -->
                            <div class="mb-4">
                                <h6 class="text-primary mb-3"><i class="fas fa-image me-2"></i>Hình ảnh khóa học</h6>
                                 
                                <div class="text-center">
                                    <div id="imagePreview" class="mb-3">
                                        <div class="border-2 border-dashed border-secondary rounded p-4 bg-light">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                            <p class="text-muted small mb-0">Chưa có hình ảnh</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="image" class="btn btn-outline-primary w-100">
                                            <i class="fas fa-upload me-2"></i>Chọn hình ảnh
                                        </label>
                                        <input type="file" class="d-none" id="image" name="image" accept="image/*">
                                    </div>
                                    
                                    <div class="form-text text-start">
                                        <p class="mb-1"><i class="fas fa-check-circle text-success"></i> Định dạng: JPG, PNG, GIF</p>
                                        <p class="mb-1"><i class="fas fa-check-circle text-success"></i> Kích thước tối đa: 5MB</p>
                                        <p class="mb-0"><i class="fas fa-info-circle text-info"></i> Kích thước đề xuất: 800x450px</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Tips -->
                            <div class="alert alert-info">
                                <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Mẹo nhanh</h6>
                                <ul class="mb-0 small">
                                    <li>Tiêu đề hấp dẫn tăng 40% lượt đăng ký</li>
                                    <li>Mô tả chi tiết giúp học viên đưa ra quyết định</li>
                                    <li>Hình ảnh chất lượng cao tạo ấn tượng tốt</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <a href="index.php?controller=Course&action=myCourses" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                        <div>
                            <button type="reset" class="btn btn-outline-danger me-2">
                                <i class="fas fa-redo me-2"></i>Làm lại
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Tạo khóa học
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
}

.border-dashed {
    border-style: dashed !important;
}

#imagePreview img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>

<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="img-fluid rounded shadow-sm">
                <p class="text-muted small mt-2 mb-0">${file.name}</p>
            `;
        }
        reader.readAsDataURL(file);
    }
});

// Form validation
document.getElementById('courseForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const categoryId = document.getElementById('category_id').value;
    
    if (!title) {
        alert('Vui lòng nhập tiêu đề khóa học');
        e.preventDefault();
        return false;
    }
    
    if (!categoryId) {
        alert('Vui lòng chọn danh mục khóa học');
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
