<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-folder"></i> Danh mục khóa học
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=createCategory" 
                   class="btn btn-primary">
                    <i class="fas fa-plus"></i> Thêm danh mục
                </a>
            </div>
            
            <?php if (empty($categories)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Chưa có danh mục nào.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $c): ?>
                                <tr>
                                    <td><?= $c['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($c['name']) ?></strong>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars(substr($c['description'] ?? '', 0, 100)) ?>
                                        <?php if (strlen($c['description'] ?? '') > 100): ?>
                                            <span class="text-muted">...</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($c['created_at'])) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=editCategory&id=<?= $c['id'] ?>" 
                                               class="btn btn-outline-primary">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=deleteCategory&id=<?= $c['id'] ?>" 
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Xóa danh mục này? Tất cả khóa học trong danh mục sẽ bị ảnh hưởng.')">
                                                <i class="fas fa-trash"></i> Xóa
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
