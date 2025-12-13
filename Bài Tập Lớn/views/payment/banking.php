<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">
                    <i class="fas fa-university text-primary"></i> 
                    Thanh toán qua ngân hàng
                </h4>
            </div>
            <div class="card-body">
                <!-- Payment Info -->
                <div class="mb-4">
                    <h6>Thông tin thanh toán</h6>
                    <div class="bg-light p-3 rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Khóa học:</span>
                                    <span><?php echo htmlspecialchars($payment['course_title']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Số tiền:</span>
                                    <span class="fw-bold text-danger"><?php echo number_format($payment['amount'], 0, ',', '.'); ?> VNĐ</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Mã đơn hàng:</span>
                                    <span class="fw-bold">#<?php echo $payment['id']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Người thanh toán:</span>
                                    <span><?php echo htmlspecialchars($payment['student_name']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="alert alert-success">
                    <h5 class="alert-heading">MBBank</h5>
                    <div class="mb-2">
                        <strong>Chủ tài khoản:</strong> NGUYEN VAN QUANG
                    </div>
                    <div class="mb-2">
                        <strong>Số tài khoản:</strong> 
                        <span class="fw-bold text-primary">00526122005</span>
                    </div>
                    <div class="mb-2">
                        <strong>Số tiền:</strong> 
                        <span class="fw-bold text-danger"><?php echo number_format($payment['amount'], 0, ',', '.'); ?> VNĐ</span>
                    </div>
                    <div>
                        <strong>Nội dung chuyển khoản:</strong>
                        <div class="bg-white p-2 border rounded mt-1">
                            <code><?php echo htmlspecialchars($payment['student_name'] . ' - ' . $payment['course_title']); ?></code>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="text-center mb-4">
                    <h6>Quét mã QR để thanh toán</h6>
                    <div class="bg-light p-3 rounded d-inline-block">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=MBBANK|00526122005|NGUYEN VAN QUANG|<?php echo $payment['amount']; ?>|<?php echo urlencode($payment['student_name'] . ' - ' . $payment['course_title']); ?>" 
                             alt="QR Code MBBank" class="img-fluid">
                    </div>
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

<?php require __DIR__ . '/../layouts/footer.php'; ?>