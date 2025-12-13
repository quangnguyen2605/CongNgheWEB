<?php 
// Kiểm tra xem người dùng đã có đơn ứng tuyển nào chưa
$applicationModel = new Application();
$userApplications = [];
if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) {
    // Lấy đơn ứng tuyển của người dùng hiện tại
    $userApplications = $applicationModel->getApplicationsByEmail($_SESSION['user_email']);
}
?>

<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="mb-4">Tuyển dụng Giảng viên</h1>
            <p class="lead mb-5">Hãy gia nhập đội ngũ giảng viên của chúng tôi và chia sẻ kiến thức với cộng đồng!</p>
            
            <?php if (!empty($userApplications)): ?>
                <div class="alert alert-info mb-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Trạng thái đơn ứng tuyển của bạn:</h5>
                    <?php foreach ($userApplications as $app): ?>
                        <div class="mt-2">
                            <strong>Ngày gửi:</strong> <?php echo date('d/m/Y H:i', strtotime($app['created_at'])); ?><br>
                            <strong>Trạng thái:</strong> 
                            <?php if ($app['status'] === 'pending'): ?>
                                <span class="badge bg-warning text-dark">Đang xét duyệt</span>
                            <?php elseif ($app['status'] === 'approved'): ?>
                                <span class="badge bg-success">Đã được duyệt</span>
                            <?php elseif ($app['status'] === 'rejected'): ?>
                                <span class="badge bg-danger">Đã bị từ chối</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php 
                // Nếu có đơn đang chờ duyệt, không cho phép gửi đơn mới
                $hasPending = false;
                foreach ($userApplications as $app) {
                    if ($app['status'] === 'pending') {
                        $hasPending = true;
                        break;
                    }
                }
                
                if ($hasPending):
                ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        Bạn đang có đơn ứng tuyển đang được xét duyệt. Vui lòng chờ kết quả trước khi gửi đơn mới.
                    </div>
                <?php else: ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Bạn có thể gửi đơn ứng tuyển mới.
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php if (empty($userApplications) || !$hasPending): ?>
            <div class="card shadow">
                <div class="card-body p-4">
                    <form method="POST" action="/onlinecourse/onlinecourse/index.php?controller=Page&action=submitApplication" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fullname" class="form-label">Họ và tên *</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" 
                                       value="<?php echo htmlspecialchars($_SESSION['user_fullname'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>" required readonly>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="specialization" class="form-label">Chuyên môn *</label>
                                <select class="form-select" id="specialization" name="specialization" required>
                                    <option value="">Chọn chuyên môn</option>
                                    <option value="web">Lập trình Web</option>
                                    <option value="mobile">Lập trình di động</option>
                                    <option value="data">Khoa học dữ liệu</option>
                                    <option value="ai">Trí tuệ nhân tạo</option>
                                    <option value="backend">Backend Development</option>
                                    <option value="frontend">Frontend Development</option>
                                    <option value="devops">DevOps</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="experience" class="form-label">Kinh nghiệm làm việc *</label>
                            <select class="form-select" id="experience" name="experience" required>
                                <option value="">Chọn kinh nghiệm</option>
                                <option value="0-1">Dưới 1 năm</option>
                                <option value="1-3">1-3 năm</option>
                                <option value="3-5">3-5 năm</option>
                                <option value="5+">Trên 5 năm</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="education" class="form-label">Học vấn *</label>
                            <input type="text" class="form-control" id="education" name="education" placeholder="Ví dụ: Đại học Bách khoa Hà Nội" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Giới thiệu bản thân *</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" required placeholder="Giới thiệu ngắn gọn về bản thân, kinh nghiệm và lý do muốn trở thành giảng viên..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cv" class="form-label">CV/Resume *</label>
                            <input type="file" class="form-control" id="cv" name="cv" accept=".pdf,.doc,.docx" required>
                            <div class="form-text">Chấp nhận file PDF, DOC, DOCX (tối đa 5MB)</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="portfolio" class="form-label">Link portfolio (nếu có)</label>
                            <input type="url" class="form-control" id="portfolio" name="portfolio" placeholder="https://github.com/username">
                        </div>
                        
                        <div class="mb-3">
                            <label for="courses" class="form-label">Các khóa học có thể giảng dạy</label>
                            <input type="text" class="form-control" id="courses" name="courses" placeholder="Ví dụ: HTML/CSS, JavaScript, ReactJS, Node.js">
                        </div>
                        
                        <div class="mb-3">
                            <label for="availability" class="form-label">Thời gian có thể giảng dạy *</label>
                            <select class="form-select" id="availability" name="availability" required>
                                <option value="">Chọn thời gian</option>
                                <option value="fulltime">Toàn thời gian</option>
                                <option value="parttime">Bán thời gian</option>
                                <option value="weekend">Cuối tuần</option>
                                <option value="flexible">Linh hoạt</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="salary" class="form-label">Mức lương mong muốn</label>
                            <input type="text" class="form-control" id="salary" name="salary" placeholder="Ví dụ: 15-20 triệu/tháng">
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agreement" name="agreement" required>
                                <label class="form-check-label" for="agreement">
                                    Tôi đồng ý với <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=terms">Điều khoản dịch vụ</a> và <a href="/onlinecourse/onlinecourse/index.php?controller=Page&action=privacy">Chính sách bảo mật</a>
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">Nhập lại</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Gửi đơn ứng tuyển
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}
</style>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
