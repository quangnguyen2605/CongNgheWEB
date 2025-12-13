<?php
class PageController {
    public function about() {
        $pageTitle = 'Giới thiệu - OnlineCourse';
        require __DIR__ . '/../views/pages/about.php';
    }
    
    public function instructors() {
        $userModel = new User();
        $instructors = $userModel->getInstructors();
        $pageTitle = 'Đội ngũ giảng viên - OnlineCourse';
        require __DIR__ . '/../views/pages/instructors.php';
    }
    
    public function terms() {
        $pageTitle = 'Điều khoản dịch vụ - OnlineCourse';
        require __DIR__ . '/../views/pages/terms.php';
    }
    
    public function privacy() {
        $pageTitle = 'Chính sách bảo mật - OnlineCourse';
        require __DIR__ . '/../views/pages/privacy.php';
    }
    
    public function support() {
        $pageTitle = 'Hỗ trợ - OnlineCourse';
        require __DIR__ . '/../views/pages/support.php';
    }
    
    public function help() {
        $pageTitle = 'Trợ giúp - OnlineCourse';
        require __DIR__ . '/../views/pages/help.php';
    }
    
    public function contact() {
        $pageTitle = 'Liên hệ - OnlineCourse';
        require __DIR__ . '/../views/pages/contact.php';
    }
    
    public function submitContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process contact form
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Basic validation
            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            } else {
                // Here you would typically save to database or send email
                // For now, we'll just show success message
                $_SESSION['success'] = 'Liên hệ thành công! Chúng tôi sẽ phản hồi cho bạn sớm nhất.';
            }
            
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Page&action=contact');
            exit;
        }
    }
    
    public function submitSupport() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and process support form
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';
            
            // Basic validation
            if (empty($name) || empty($email) || empty($message)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            } else {
                // Here you would typically save to database or send email
                // For now, we'll just show success message
                $_SESSION['success'] = 'Gửi yêu cầu hỗ trợ thành công! Chúng tôi sẽ phản hồi cho bạn sớm nhất.';
            }
            
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Page&action=support');
            exit;
        }
    }
    
    public function faq() {
        $pageTitle = 'FAQ - OnlineCourse';
        require __DIR__ . '/../views/pages/faq.php';
    }
    
    public function careers() {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (empty($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để ứng tuyển giảng viên!';
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=login');
            exit;
        }
        
        $pageTitle = 'Tuyển dụng - OnlineCourse';
        require __DIR__ . '/../views/pages/careers.php';
    }
    
    public function submitApplication() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý form ứng tuyển
            $data = [
                'fullname' => $_POST['fullname'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'specialization' => $_POST['specialization'] ?? '',
                'experience' => $_POST['experience'] ?? '',
                'education' => $_POST['education'] ?? '',
                'bio' => $_POST['bio'] ?? '',
                'courses' => $_POST['courses'] ?? '',
                'availability' => $_POST['availability'] ?? '',
                'salary' => $_POST['salary'] ?? '',
                'portfolio' => $_POST['portfolio'] ?? '',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            // Xử lý upload CV
            if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
                $cvFile = $_FILES['cv'];
                $uploadDir = __DIR__ . '/../uploads/cv/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($cvFile['name']);
                $targetPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($cvFile['tmp_name'], $targetPath)) {
                    $data['cv_file'] = $fileName;
                }
            }
            
            // Lưu vào database
            $applicationModel = new Application();
            if ($applicationModel->create($data)) {
                $_SESSION['success'] = 'Đơn ứng tuyển đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn sớm.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            }
            
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Page&action=careers');
            exit;
        }
    }
    
    public function manageApplications() {
        // Chỉ admin được truy cập
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 2) {
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=login');
            exit;
        }
        
        $pageTitle = 'Quản lý Đơn ứng tuyển';
        require __DIR__ . '/../views/pages/manage_applications.php';
    }
    
    public function approveApplication() {
        // Chỉ admin được truy cập
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 2) {
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=login');
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $applicationModel = new Application();
        $userModel = new User();
        
        // Lấy thông tin đơn ứng tuyển
        $application = $applicationModel->findById($id);
        
        if ($application && $application['status'] === 'pending') {
            // Kiểm tra xem email đã tồn tại chưa
            $existingUser = $userModel->findByEmail($application['email']);
            
            if (!$existingUser) {
                // Tạo tài khoản giảng viên mới
                $userData = [
                    'username' => explode('@', $application['email'])[0] . time(),
                    'email' => $application['email'],
                    'password' => password_hash('default123', PASSWORD_DEFAULT), // Mật khẩu mặc định
                    'fullname' => $application['fullname'],
                    'role' => 1, // Giảng viên
                    'bio' => $application['bio'],
                    'phone' => $application['phone'],
                    'specialization' => $application['specialization'],
                    'experience' => $application['experience'],
                    'education' => $application['education']
                ];
                
                if ($userModel->create($userData)) {
                    // Lấy ID user vừa tạo
                    $newUserId = $this->db->lastInsertId();
                    
                    // Upload CV vào thư mục avatar nếu có
                    if (!empty($application['cv_file'])) {
                        $cvSource = __DIR__ . '/../uploads/cv/' . $application['cv_file'];
                        $avatarTarget = __DIR__ . '/../uploads/avatars/' . $application['cv_file'];
                        
                        if (file_exists($cvSource)) {
                            if (!is_dir(__DIR__ . '/../uploads/avatars/')) {
                                mkdir(__DIR__ . '/../uploads/avatars/', 0755, true);
                            }
                            copy($cvSource, $avatarTarget);
                            
                            // Cập nhật avatar cho user
                            $userModel->updateAvatar($newUserId, $application['cv_file']);
                        }
                    }
                    
                    // Cập nhật trạng thái đơn
                    $applicationModel->updateStatus($id, 'approved');
                    
                    // Gửi email thông báo (nếu có)
                    $_SESSION['success'] = 'Đã duyệt đơn và tạo tài khoản giảng viên thành công! Mật khẩu mặc định: default123';
                } else {
                    $_SESSION['error'] = 'Không thể tạo tài khoản giảng viên.';
                }
            } else {
                // Email đã tồn tại, chỉ cập nhật role thành giảng viên
                if ($existingUser['role'] != 1) {
                    $userModel->update($existingUser['id'], ['role' => 1]);
                    $applicationModel->updateStatus($id, 'approved');
                    $_SESSION['success'] = 'Đã duyệt đơn và nâng cấp tài khoản thành giảng viên!';
                } else {
                    $_SESSION['error'] = 'Tài khoản này đã là giảng viên.';
                }
            }
        } else {
            $_SESSION['error'] = 'Đơn ứng tuyển không hợp lệ hoặc đã được xử lý.';
        }
        
        header('Location: /onlinecourse/onlinecourse/index.php?controller=Page&action=manageApplications');
        exit;
    }
    
    public function rejectApplication() {
        // Chỉ admin được truy cập
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 2) {
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=login');
            exit;
        }
        
        $id = $_GET['id'] ?? 0;
        $applicationModel = new Application();
        
        if ($applicationModel->updateStatus($id, 'rejected')) {
            $_SESSION['success'] = 'Đã từ chối đơn ứng tuyển!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra.';
        }
        
        header('Location: /onlinecourse/onlinecourse/index.php?controller=Page&action=manageApplications');
        exit;
    }
}
