<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Quản lý Đơn ứng tuyển</h1>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Điện thoại</th>
                                    <th>Chuyên môn</th>
                                    <th>Kinh nghiệm</th>
                                    <th>Ngày ứng tuyển</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $applicationModel = new Application();
                                $userModel = new User();
                                $applications = $applicationModel->getAll();
                                $stt = 1;
                                foreach ($applications as $app):
                                    $existingUser = $userModel->findByEmail($app['email']);
                                ?>
                                    <tr>
                                        <td><?php echo $stt++; ?></td>
                                        <td><?php echo htmlspecialchars($app['fullname']); ?></td>
                                        <td><?php echo htmlspecialchars($app['email']); ?></td>
                                        <td><?php echo htmlspecialchars($app['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($app['specialization']); ?></td>
                                        <td><?php echo htmlspecialchars($app['experience']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($app['created_at'])); ?></td>
                                        <td>
                                            <?php if ($app['status'] === 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Đang xét duyệt</span>
                                            <?php elseif ($app['status'] === 'approved'): ?>
                                                <span class="badge bg-success">Đã duyệt</span>
                                                <?php if ($existingUser && $existingUser['role'] == 1): ?>
                                                    <br><small class="text-success">Đã tạo tài khoản GV</small>
                                                <?php endif; ?>
                                            <?php elseif ($app['status'] === 'rejected'): ?>
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <?php if ($app['status'] === 'pending'): ?>
                                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=approveApplication&id=<?php echo $app['id']; ?>" 
                                                       class="btn btn-sm btn-success" 
                                                       onclick="return confirm('Tạo tài khoản giảng viên và duyệt đơn này?')">Duyệt</a>
                                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=rejectApplication&id=<?php echo $app['id']; ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('Từ chối đơn ứng tuyển này?')">Từ chối</a>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($app['cv_file'])): ?>
                                                    <a href="/onlinecourse/onlinecourse/uploads/cv/<?php echo htmlspecialchars($app['cv_file']); ?>" 
                                                       class="btn btn-sm btn-primary" target="_blank">Xem CV</a>
                                                <?php endif; ?>
                                                
                                                <?php if ($existingUser): ?>
                                                    <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=editUser&id=<?php echo $existingUser['id']; ?>" 
                                                       class="btn btn-sm btn-info">Xem user</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                                <?php if (empty($applications)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="alert alert-info">
                                                Chưa có đơn ứng tuyển nào.
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    background-color: #f8f9fa;
    border-top: none;
}

.badge {
    padding: 0.5rem 0.75rem;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
