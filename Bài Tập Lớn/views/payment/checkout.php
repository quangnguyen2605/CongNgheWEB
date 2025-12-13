<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Thanh toán khóa học</h4>
                </div>
                <div class="card-body">
                    <!-- Course Information -->
                    <div class="mb-4">
                        <h5>Thông tin khóa học</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (!empty($course['image'])): ?>
                                    <img src="<?php echo htmlspecialchars($course['image']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($course['title']); ?>">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/300x200?text=Khóa+học" class="img-fluid rounded" alt="Khóa học">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <h6><?php echo htmlspecialchars($course['title']); ?></h6>
                                <p class="text-muted"><?php echo htmlspecialchars($course['description'] ?? ''); ?></p>
                                <p><strong>Giảng viên:</strong> <?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></p>
                                <p><strong>Thời lượng:</strong> <?php echo htmlspecialchars($course['duration_weeks'] ?? 'N/A'); ?> tuần</p>
                                <p><strong>Trình độ:</strong> <?php echo htmlspecialchars($course['level'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="mb-4">
                        <h5>Chọn phương thức thanh toán</h5>
                        <form action="index.php?controller=Payment&action=processPayment" method="POST">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <input type="hidden" name="amount" value="<?php echo $course['price'] ?? 0; ?>">
                            
                            <div class="payment-methods">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="zalopay" value="zalopay" checked>
                                    <label class="form-check-label" for="zalopay">
                                        <i class="fas fa-wallet text-primary"></i> ZaloPay
                                        <span class="text-muted d-block">Thanh toán qua ví điện tử ZaloPay</span>
                                    </label>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="mbbank" value="mbbank">
                                    <label class="form-check-label" for="mbbank">
                                        <i class="fas fa-university text-danger"></i> MB Bank
                                        <span class="text-muted d-block">Thanh toán qua ngân hàng MB Bank (VIETQR)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Price Summary -->
                            <div class="price-summary mt-4 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between">
                                    <span>Giá khóa học:</span>
                                    <span><?php echo number_format($course['price'] ?? 0, 0, ',', '.'); ?> VNĐ</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Tổng cộng:</span>
                                    <span class="text-danger"><?php echo number_format($course['price'] ?? 0, 0, ',', '.'); ?> VNĐ</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-lock"></i> Tiến hành thanh toán
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Security Notice -->
                    <div class="alert alert-info">
                        <i class="fas fa-shield-alt"></i> 
                        <strong>Bảo mật thanh toán:</strong> Thông tin thanh toán của bạn được mã hóa và bảo vệ tuyệt đối.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.payment-methods .form-check {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-methods .form-check:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.payment-methods .form-check-input:checked + .form-check-label {
    color: #007bff;
}

.payment-methods i {
    margin-right: 10px;
    color: #007bff;
}

.price-summary {
    border: 1px solid #dee2e6;
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
