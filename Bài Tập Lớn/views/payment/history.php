<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-history"></i> 
                        Lịch sử thanh toán
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($payments)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Bạn chưa có giao dịch thanh toán nào</h5>
                            <p class="text-muted">Hãy khám phá và đăng ký các khóa học tuyệt vời của chúng tôi!</p>
                            <a href="index.php?controller=Student&action=browseCourses" class="btn btn-primary">
                                <i class="fas fa-search"></i> Khám phá khóa học
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Payment Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="bg-light p-3 rounded text-center">
                                    <h5 class="text-primary"><?php echo count($payments); ?></h5>
                                    <p class="mb-0 text-muted">Tổng giao dịch</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-success p-3 rounded text-center">
                                    <h5 class="text-success">
                                        <?php 
                                        $completed = array_filter($payments, function($p) { return $p['status'] === 'completed'; });
                                        echo count($completed); 
                                        ?>
                                    </h5>
                                    <p class="mb-0 text-muted">Thành công</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-warning p-3 rounded text-center">
                                    <h5 class="text-warning">
                                        <?php 
                                        $pending = array_filter($payments, function($p) { return $p['status'] === 'pending'; });
                                        echo count($pending); 
                                        ?>
                                    </h5>
                                    <p class="mb-0 text-muted">Đang chờ</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment List -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khóa học</th>
                                        <th>Số tiền</th>
                                        <th>Phương thức</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <td>
                                                <span class="fw-bold">#<?php echo $payment['id']; ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong><?php echo htmlspecialchars($payment['course_title']); ?></strong>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-danger">
                                                    <?php echo number_format($payment['amount'], 0, ',', '.'); ?> VNĐ
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $methodIcons = [
                                                    'zalopay' => 'fas fa-mobile-alt text-primary',
                                                    'banking' => 'fas fa-university text-success'
                                                ];
                                                $methodNames = [
                                                    'zalopay' => 'ZaloPay',
                                                    'banking' => 'Ngân hàng'
                                                ];
                                                $icon = $methodIcons[$payment['payment_method']] ?? 'fas fa-money-bill';
                                                $name = $methodNames[$payment['payment_method']] ?? 'Khác';
                                                ?>
                                                <i class="<?php echo $icon; ?>"></i> 
                                                <?php echo $name; ?>
                                            </td>
                                            <td>
                                                <?php if ($payment['status'] === 'completed'): ?>
                                                    <span class="badge bg-success">Hoàn thành</span>
                                                <?php elseif ($payment['status'] === 'pending'): ?>
                                                    <span class="badge bg-warning">Đang chờ</span>
                                                <?php elseif ($payment['status'] === 'failed'): ?>
                                                    <span class="badge bg-danger">Thất bại</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Khác</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y H:i', strtotime($payment['created_at'])); ?>
                                            </td>
                                            <td>
                                                <?php if ($payment['status'] === 'pending'): ?>
                                                    <a href="index.php?controller=Payment&action=checkout&course_id=<?php echo $payment['course_id']; ?>" 
                                                       class="btn btn-sm btn-primary">
                                                        <i class="fas fa-redo"></i> Tiếp tục
                                                    </a>
                                                <?php elseif ($payment['status'] === 'completed'): ?>
                                                    <a href="index.php?controller=Student&action=courseProgress&course_id=<?php echo $payment['course_id']; ?>" 
                                                       class="btn btn-sm btn-success">
                                                        <i class="fas fa-play"></i> Học ngay
                                                    </a>
                                                <?php else: ?>
                                                    <a href="index.php?controller=Payment&action=checkout&course_id=<?php echo $payment['course_id']; ?>" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-redo"></i> Thử lại
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Back Button -->
                        <div class="mt-4">
                            <a href="index.php?controller=Student&action=dashboard" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại dashboard
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header {
    background: linear-gradient(135deg, #17a2b8, #6c757d);
    color: white;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.badge {
    font-size: 0.8em;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
