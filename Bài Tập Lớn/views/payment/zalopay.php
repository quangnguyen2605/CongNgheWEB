<?php 
require __DIR__ . '/../layouts/header.php';
$webRoot = dirname(dirname($_SERVER['PHP_SELF']));

// Get user info from database
require_once __DIR__ . '/../../models/User.php';
$userModel = new User();
$user = $userModel->findById($_SESSION['user_id']);
$studentName = $user ? ($user['full_name'] ?? $user['username'] ?? 'HocVien') : 'HocVien';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-wallet text-primary"></i> 
                        Thanh toán qua ZaloPay
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Payment Info -->
                    <div class="mb-4 payment-info">
                        <h6>Thông tin thanh toán</h6>
                        <div class="bg-light p-3 rounded">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Khóa học:</span>
                                <span><?php echo htmlspecialchars($payment['course_title']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Số tiền:</span>
                                <span class="fw-bold text-danger"><?php echo number_format($payment['amount'], 0, ',', '.'); ?> VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Mã đơn hàng:</span>
                                <span class="fw-bold">#<?php echo $payment['id']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="text-center mb-4">
                        <div class="qr-code-container bg-light p-4 rounded">
                            <div class="qr-code-image mb-3">
                                <img src="https://sf-static.upanhlaylink.com/img/image_20251208ddd3445030d292d8099eb225663c79a0.jpg" 
                                     alt="QR Code ZaloPay" 
                                     class="img-fluid"
                                     style="max-width: 250px; border: 2px solid #007bff; border-radius: 8px;"
                                     onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=ZALOPAY-<?= urlencode($studentName . '-' . $payment['course_title'] . '-' . $payment['id']) ?>'; this.onerror=null;">
                            </div>
                            <h6 class="mb-2">ZaloPay</h6>
                            <p class="text-muted mb-1">Số điện thoại: 0987654321</p>
                            <p class="text-muted mb-2">Quét mã QR bằng ứng dụng ZaloPay để thanh toán</p>
                            <div class="supported-payments">
                                <small class="text-muted">Hỗ trợ thanh toán:</small>
                                <div class="mt-2">
                                    <span class="badge bg-primary me-1">ZaloPay</span>
                                    <span class="badge bg-success me-1">Ví điện tử</span>
                                    <span class="badge bg-info me-1">QR Code</span>
                                    <div class="mt-2">
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Hỗ trợ mọi app ngân hàng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Hướng dẫn thanh toán:</h6>
                        <ol class="mb-0">
                            <li>Mở ứng dụng ZaloPay trên điện thoại</li>
                            <li>Chọn "Quét mã" và quét mã QR ở trên</li>
                            <li>Thông tin sẽ được điền tự động trên app ZaloPay:</li>
                        </ol>
                        
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Họ tên:</strong> <?= htmlspecialchars($studentName) ?></p>
                                    <p class="mb-1"><strong>Khóa học:</strong> <?= htmlspecialchars($payment['course_title']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Mã đơn:</strong> #<?= $payment['id'] ?></p>
                                    <p class="mb-1"><strong>Số tiền:</strong> <?= number_format($payment['amount'], 0, ',', '.') ?> VNĐ</p>
                                </div>
                            </div>
                        </div>
                        
                        <ol class="mb-0" start="4">
                            <li>Kiểm tra lại thông tin và xác nhận thanh toán</li>
                        </ol>
                    </div>

                    <!-- Payment Status -->
                    <div id="payment-status" class="text-center mb-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang chờ thanh toán...</span>
                        </div>
                        <p class="mt-2 text-muted">Đang chờ bạn thanh toán...</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="index.php?controller=Payment&action=paymentSuccess&payment_id=<?php echo $payment['id']; ?>" 
                           class="btn btn-success flex-fill">
                            <i class="fas fa-check"></i> Đã thanh toán xong
                        </a>
                        <a href="index.php?controller=Payment&action=paymentFailed&payment_id=<?php echo $payment['id']; ?>" 
                           class="btn btn-outline-secondary flex-fill">
                            <i class="fas fa-times"></i> Hủy thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-check payment status (simulate)
setTimeout(function() {
    // In real implementation, this would poll the payment gateway
    const statusDiv = document.getElementById('payment-status');
    statusDiv.innerHTML = `
        <div class="alert alert-warning">
            <i class="fas fa-clock"></i> 
            Nếu bạn đã thanh toán, vui lòng nhấn nút "Đã thanh toán xong"
        </div>
    `;
}, 10000);
</script>

<style>
.qr-code-container {
    border: 2px solid #e9ecef;
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
}

.qr-code-image img {
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.15);
    transition: transform 0.3s ease;
}

.qr-code-image img:hover {
    transform: scale(1.05);
}

.supported-payments .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.card-header {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
}

.payment-info .bg-light {
    background-color: #f8f9fa !important;
    border-left: 4px solid #e74c3c;
}

.alert-info {
    background-color: #fff5f5;
    border-color: #e74c3c;
    color: #c0392b;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
