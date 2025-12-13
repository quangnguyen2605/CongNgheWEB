<?php 
require __DIR__ . '/../layouts/header.php';
$webRoot = dirname(dirname($_SERVER['PHP_SELF']));

// Get user info from database
require_once __DIR__ . '/../../models/User.php';
$userModel = new User();
$user = $userModel->findById($_SESSION['user_id']);
$studentName = $user ? ($user['full_name'] ?? $user['username'] ?? 'HocVien') : 'HocVien';

// Debug - kiểm tra payment data
if (!isset($payment) || empty($payment)) {
    echo '<div class="alert alert-danger">Lỗi: Không tìm thấy thông tin thanh toán!</div>';
    require __DIR__ . '/../layouts/footer.php';
    exit;
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-university text-danger"></i> 
                        Thanh toán qua MB Bank
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5>Thông tin thanh toán</h5>
                        <p class="text-muted">Vui lòng chuyển khoản theo thông tin bên dưới</p>
                    </div>

                    <div class="payment-info mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <h6>Thông tin người nhận</h6>
                                    <p class="mb-1"><strong>Người thụ hưởng:</strong> NGUYEN VAN QUANG</p>
                                    <p class="mb-1"><strong>Số tài khoản:</strong> 00526122005</p>
                                    <p class="mb-1"><strong>Ngân hàng:</strong> MB Bank</p>
                                    <p class="mb-0"><strong>Số tiền:</strong> <?= number_format($payment['amount'], 0, ',', '.') ?> VNĐ</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <h6>Quét mã QR</h6>
                                    <div class="qr-code-image mb-3">
                                        <img src="https://sf-static.upanhlaylink.com/img/image_20251208d0c7a75cd8a75b823abdeed597d16411.jpg" 
                                             alt="QR Code MB Bank - NGUYEN VAN QUANG" 
                                             class="img-fluid"
                                             style="max-width: 200px; border: 2px solid #e74c3c; border-radius: 8px;"
                                             onerror="this.src='https://api.vietqr.io/image/970436-00526122005.jpg?accountName=NGUYEN%20VAN%20QUANG&amount=<?= urlencode($payment['amount']) ?>&addInfo=<?= urlencode($studentName . ' - ' . $payment['course_title']) ?>'; this.onerror=null;">
                                    </div>
                                    <p class="text-muted small">Sử dụng app MB Bank để quét mã</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Lưu ý:</strong>
                        <ol class="mb-0 mt-2">
                            <li>Sau khi chuyển khoản thành công, hệ thống sẽ tự động xác nhận trong vài phút</li>
                            <li>Vui lòng giữ lại biên lai chuyển khoản để đối chiếu khi cần</li>
                            <li>Thông tin sẽ được điền tự động trên app MB Bank khi quét QR:</li>
                        </ol>
                        
                        <div class="bg-light p-3 rounded mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Người thụ hưởng:</strong> NGUYEN VAN QUANG</p>
                                    <p class="mb-1"><strong>Số tài khoản:</strong> 00526122005</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Số tiền:</strong> <?= number_format($payment['amount'], 0, ',', '.') ?> VNĐ</p>
                                    <p class="mb-1"><strong>Nội dung CK:</strong> <?= htmlspecialchars($studentName) ?> - <?= htmlspecialchars($payment['course_title']) ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <ol class="mb-0" start="4">
                            <li>Kiểm tra lại thông tin và xác nhận chuyển khoản</li>
                        </ol>
                    </div>

                    <div class="supported-payments text-center mb-4">
                        <small class="text-muted">Hỗ trợ thanh toán:</small>
                        <div class="mt-2">
                            <span class="badge bg-danger me-1">MB Bank</span>
                            <span class="badge bg-primary me-1">VIETQR</span>
                            <span class="badge bg-success me-1">Napas 247</span>
                            <span class="badge bg-info me-1">+50 ngân hàng khác</span>
                            <div class="mt-2">
                                <span class="text-success"><i class="fas fa-check-circle"></i> Hỗ trợ mọi app ngân hàng</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="index.php?controller=Payment&action=checkout&course_id=<?= $payment['course_id'] ?>" 
                           class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <a href="index.php?controller=Student&action=myCourses" 
                           class="btn btn-success">
                            <i class="fas fa-check"></i> Đã thanh toán
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-info {
    border: 2px solid #e9ecef;
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    border-radius: 8px;
    padding: 20px;
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

.alert-info {
    background-color: #fff5f5;
    border-color: #e74c3c;
    color: #c0392b;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
