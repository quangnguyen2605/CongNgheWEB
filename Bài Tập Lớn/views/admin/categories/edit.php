<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-edit"></i> Sửa danh mục
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=categories" 
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <?php if (!$category): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> Danh mục không tồn tại.
                        </div>
                    <?php else: ?>
                        <form method="POST" action="/onlinecourse/onlinecourse/index.php?controller=Admin&action=updateCategory">
                            <input type="hidden" name="id" value="<?= $category['id'] ?>">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="<?= htmlspecialchars($category['name']) ?>"
                                       placeholder="Nhập tên danh mục">
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                          placeholder="Nhập mô tả cho danh mục"><?= htmlspecialchars($category['description'] ?? '') ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ngày tạo</label>
                                <input type="text" class="form-control" readonly
                                       value="<?= date('d/m/Y H:i', strtotime($category['created_at'])) ?>">
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật danh mục
                                </button>
                                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=categories" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
