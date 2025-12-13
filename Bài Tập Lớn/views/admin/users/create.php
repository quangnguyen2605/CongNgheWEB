<?php require __DIR__ . '/../../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    <i class="fas fa-user-plus"></i> Thêm người dùng mới
                </h2>
                <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=users" 
                   class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/onlinecourse/onlinecourse/index.php?controller=Admin&action=storeUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên đăng nhập <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username" required
                                           placeholder="Nhập tên đăng nhập">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           placeholder="Nhập email">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                           placeholder="Nhập mật khẩu" minlength="8">
                                    <div class="form-text">
                                        <small class="text-muted">
                                            Mật khẩu phải có ít nhất 8 ký tự, bao gồm: 1 chữ hoa, 1 chữ thường, 1 số
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" required
                                           placeholder="Nhập họ và tên">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">-- Chọn vai trò --</option>
                                        <option value="0">Học viên</option>
                                        <option value="1">Giảng viên</option>
                                        <option value="2">Quản trị viên</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                           placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Giới thiệu</label>
                            <textarea class="form-control" id="bio" name="bio" rows="3"
                                      placeholder="Nhập giới thiệu ngắn về người dùng"></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Lưu ý:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>Học viên:</strong> Có thể đăng ký và học các khóa học</li>
                                <li><strong>Giảng viên:</strong> Có thể tạo và quản lý khóa học của mình</li>
                                <li><strong>Quản trị viên:</strong> Có toàn quyền quản lý hệ thống</li>
                            </ul>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Tạo người dùng
                            </button>
                            <a href="/onlinecourse/onlinecourse/index.php?controller=Admin&action=users" 
                               class="btn btn-secondary">
                                <i class="fas fa-times"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
