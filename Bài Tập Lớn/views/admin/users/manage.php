<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-users"></i> Quản lý người dùng
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=createUser" 
                   class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Thêm người dùng
                </a>
            </div>
            
            <?php if (empty($users)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Chưa có người dùng nào.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($u['username']) ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($u['fullname']) ?></td>
                                    <td><?= htmlspecialchars($u['email']) ?></td>
                                    <td>
                                        <?php
                                        $roleLabels = [
                                            0 => '<span class="badge bg-primary">Học viên</span>',
                                            1 => '<span class="badge bg-success">Giảng viên</span>',
                                            2 => '<span class="badge bg-danger">Quản trị viên</span>'
                                        ];
                                        echo $roleLabels[(int)$u['role']] ?? '<span class="badge bg-secondary">Unknown</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $status = isset($u['status']) ? (int)$u['status'] : 1;
                                        if ($status == 1) {
                                            echo '<span class="badge bg-success">Hoạt động</span>';
                                        } else {
                                            echo '<span class="badge bg-secondary">Vô hiệu</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($u['created_at'])) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=toggleUserStatus&id=<?= $u['id'] ?>" 
                                               class="btn btn-<?= (isset($u['status']) && (int)$u['status'] == 1) ? 'outline-warning' : 'outline-success' ?>"
                                               onclick="return confirm('Bạn muốn <?= (isset($u['status']) && (int)$u['status'] == 1) ? 'vô hiệu hóa' : 'kích hoạt' ?> người dùng này?')"
                                               title="<?= (isset($u['status']) && (int)$u['status'] == 1) ? 'Vô hiệu hóa' : 'Kích hoạt' ?> người dùng">
                                                <i class="fas fa-power-off"></i>
                                            </a>
                                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=deleteUser&id=<?= $u['id'] ?>" 
                                               class="btn btn-outline-danger"
                                               onclick="return confirm('Xóa người dùng này? Hành động này không thể hoàn lại.')"
                                               title="Xóa người dùng">
                                                <i class="fas fa-trash"></i>
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
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
