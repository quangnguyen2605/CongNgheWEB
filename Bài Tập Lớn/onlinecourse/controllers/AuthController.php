<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class AuthController
{
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $identifier = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                // Debug
                error_log("=== LOGIN DEBUG ===");
                error_log("Identifier: " . $identifier);
                error_log("Password: " . $password);

                $userModel = new User();
                $user = $userModel->findByEmailOrUsername($identifier);

                // Debug
                error_log("User found: " . ($user ? 'YES' : 'NO'));
                if ($user) {
                    error_log("User data: " . print_r($user, true));
                    error_log("Role: " . $user['role']);
                }

                if ($user && password_verify($password, $user['password'])) {
                    // Debug
                    error_log("Password verification SUCCESS!");
                    
                    // Check if user is active (status = 1)
                    if (isset($user['status']) && (int)$user['status'] === 0) {
                        $error = 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ quản trị viên.';
                    } else {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_role'] = (int)$user['role'];
                        $_SESSION['user_name'] = $user['fullname'];
                        $_SESSION['user_email'] = $user['email'];
                        
                        // Debug session
                        error_log("Session set: " . print_r($_SESSION, true));
                    
                    // Chuyển hướng theo vai trò
                    if ((int)$user['role'] === 0) {
                        // Học viên
                        header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                    } elseif ((int)$user['role'] === 1) {
                        // Giảng viên
                        header('Location: /onlinecourse/onlinecourse/index.php?controller=Instructor&action=dashboard');
                    } else {
                        // Admin
                        header('Location: /onlinecourse/onlinecourse/index.php?controller=Admin&action=dashboard');
                    }
                    exit;
                    }
                } else {
                    // Debug
                    if ($user) {
                        error_log("Password verification FAILED for user: " . $user['email']);
                        error_log("Input password: " . $password);
                        error_log("Stored hash: " . $user['password']);
                    } else {
                        error_log("User not found: " . $identifier);
                    }
                    $error = 'Email/Tài khoản hoặc mật khẩu không đúng';
                }
            } catch (Exception $e) {
                $error = 'Lỗi kết nối database: ' . $e->getMessage();
            }
        }

        $pageTitle = 'Đăng nhập';
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        $error = '';
        $isSocial = isset($_GET['social']) && $_GET['social'] === '1';
        $socialData = $_SESSION['social_data'] ?? [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            // Nếu là social registration, password có thể rỗng
            if ($isSocial && !empty($socialData)) {
                $password = $password ?: password_hash(uniqid(), PASSWORD_DEFAULT);
                $confirm = $password;
            }

            if ($password !== $confirm) {
                $error = 'Mật khẩu nhập lại không khớp';
            } elseif ($username === '' || $email === '' || $fullname === '' || $password === '') {
                $error = 'Vui lòng nhập đầy đủ thông tin';
            } else {
                $userModel = new User();
                $existing = $userModel->findByEmailOrUsername($email);
                if ($existing) {
                    $error = 'Email đã được sử dụng';
                } else {
                    // Password validation (không áp dụng cho social registration)
                    if (!$isSocial && strlen($password) < 8) {
                        $error = 'Mật khẩu phải có ít nhất 8 ký tự!';
                    } elseif (!$isSocial && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
                        $error = 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số!';
                    } else {
                        $hash = is_string($password) && strlen($password) > 20 ? $password : password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
                        
                        $created = $userModel->create([
                            'username' => $username,
                            'email' => $email,
                            'fullname' => $fullname,
                            'password' => $hash,
                            'role' => 0,
                        ]);
                        
                        if ($created) {
                            // Xóa social data sau khi đăng ký thành công
                            unset($_SESSION['social_data']);
                            
                            if ($isSocial) {
                                // Auto-login cho social registration
                                $newUser = $userModel->findByEmail($email);
                                if ($newUser) {
                                    $_SESSION['user_id'] = $newUser['id'];
                                    $_SESSION['user_role'] = (int)$newUser['role'];
                                    $_SESSION['user_name'] = $newUser['fullname'];
                                    $_SESSION['user_email'] = $newUser['email'];
                                    
                                    header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                                    exit;
                                }
                            } else {
                                header('Location: index.php?controller=Auth&action=login&success=registered');
                                exit;
                            }
                        } else {
                            $error = 'Không thể tạo tài khoản';
                        }
                    }
                }
            }
        }

        $pageTitle = 'Đăng ký';
        require __DIR__ . '/../views/auth/register.php';
    }

    public function profile()
    {
        $pageTitle = 'Hồ sơ cá nhân';
        require __DIR__ . '/../views/auth/profile.php';
    }

    public function forgot_password()
    {
        $pageTitle = 'Quên mật khẩu';
        require __DIR__ . '/../views/auth/forgot_password.php';
    }
    
    public function completeProfile()
    {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = trim($_POST['username'] ?? '');
                $fullname = trim($_POST['fullname'] ?? '');
                $provider = $_POST['provider'] ?? '';
                $email = $_POST['email'] ?? '';
                $socialLink = trim($_POST['social_link'] ?? '');
                
                if (empty($username) || empty($fullname) || empty($socialLink)) {
                    $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
                } elseif (strlen($username) < 3) {
                    $error = 'Username phải có ít nhất 3 ký tự';
                } elseif (!filter_var($socialLink, FILTER_VALIDATE_URL)) {
                    $error = 'Link ' . ucfirst($provider) . ' không hợp lệ';
                } else {
                    $userModel = new User();
                    
                    // Kiểm tra username đã tồn tại chưa
                    $existingUser = $userModel->getByUsername($username);
                    if ($existingUser) {
                        $error = 'Username đã được sử dụng. Vui lòng chọn username khác.';
                    } else {
                        // Xử lý upload avatar
                        $avatarPath = '';
                        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                            $avatarPath = $this->uploadAvatar($_FILES['avatar']);
                        }
                        
                        // Tạo user mới với thông tin đầy đủ
                        $userData = [
                            'username' => $username,
                            'email' => $email,
                            'fullname' => $fullname,
                            'password' => password_hash(uniqid(), PASSWORD_DEFAULT),
                            'role' => 0,
                            'avatar' => $avatarPath,
                            'other' => $socialLink
                        ];
                    
                        $created = $userModel->create($userData);
                    
                    if ($created) {
                        // Auto-login sau khi tạo tài khoản
                        $newUser = $userModel->findByEmail($email);
                        if ($newUser) {
                            $_SESSION['user_id'] = $newUser['id'];
                            $_SESSION['user_role'] = (int)$newUser['role'];
                            $_SESSION['user_name'] = $newUser['fullname'];
                            $_SESSION['user_email'] = $newUser['email'];
                            
                            // Xóa social data
                            unset($_SESSION['social_data']);
                            
                            header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                            exit;
                        }
                    } else {
                        $error = 'Không thể tạo tài khoản. Vui lòng thử lại.';
                    }
                }
            }
        } catch (Exception $e) {
            $error = 'Lỗi: ' . $e->getMessage();
        }
    }
    
    $pageTitle = 'Hoàn tất thông tin cá nhân';
    require __DIR__ . '/../views/auth/complete_profile.php';
}
    
    public function skipProfile()
    {
        // Tạo user với thông tin tối thiểu từ social
        try {
            $socialData = $_SESSION['social_data'] ?? [];
            $userModel = new User();
            
            $userData = [
                'username' => 'user_' . time(),
                'email' => $socialData['email'] ?? '',
                'fullname' => $socialData['name'] ?? 'User',
                'password' => password_hash(uniqid(), PASSWORD_DEFAULT),
                'role' => 0,
                'other' => $this->generateSocialLink($socialData['provider'] ?? '')
            ];
            
            $created = $userModel->create($userData);
            
            if ($created) {
                $newUser = $userModel->findByEmail($userData['email']);
                if ($newUser) {
                    $_SESSION['user_id'] = $newUser['id'];
                    $_SESSION['user_role'] = (int)$newUser['role'];
                    $_SESSION['user_name'] = $newUser['fullname'];
                    $_SESSION['user_email'] = $newUser['email'];
                    
                    unset($_SESSION['social_data']);
                    
                    header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                    exit;
                }
            }
        } catch (Exception $e) {
            $error = 'Không thể tạo tài khoản. Vui lòng thử lại.';
            $pageTitle = 'Hoàn tất thông tin cá nhân';
            require __DIR__ . '/../views/auth/complete_profile.php';
        }
    }
    
    private function uploadAvatar($file)
    {
        $uploadDir = __DIR__ . '/../uploads/avatars/';
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Kiểm tra file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Chỉ chấp nhận file ảnh (JPEG, PNG, GIF, WebP)');
        }
        
        if ($file['size'] > 5 * 1024 * 1024) { // 5MB
            throw new Exception('File ảnh không được quá 5MB');
        }
        
        // Tạo tên file unique
        $fileName = 'avatar_' . time() . '_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $filePath = $uploadDir . $fileName;
        
        // Upload file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception('Không thể upload file');
        }
        
        return 'uploads/avatars/' . $fileName;
    }
    
    private function generateSocialLink($provider)
    {
        if ($provider === 'facebook') {
            return 'https://www.facebook.com/?locale=vi_VN';
        } elseif ($provider === 'google') {
            return 'https://accounts.google.com';
        } else {
            return '';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /onlinecourse/onlinecourse/');
        exit;
    }
    
    // OAuth Social Login Methods
    public function googleOAuth()
    {
        // Tạo social data và chuyển đến trang hoàn tất thông tin
        $_SESSION['social_data'] = [
            'provider' => 'google',
            'email' => 'google.user.' . time() . '@gmail.com',
            'name' => 'Google User',
            'id' => 'google_' . time() . '_' . rand(1000, 9999)
        ];
        
        header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=completeProfile');
        exit;
    }
    
    public function facebookOAuth()
    {
        // Tạo social data và chuyển đến trang hoàn tất thông tin
        $_SESSION['social_data'] = [
            'provider' => 'facebook',
            'email' => 'facebook.user.' . time() . '@facebook.com',
            'name' => 'Facebook User',
            'id' => 'fb_' . time() . '_' . rand(1000, 9999)
        ];
        
        header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=completeProfile');
        exit;
    }
    
    public function googleCallback()
    {
        $error = '';
        
        try {
            // Real OAuth flow - lấy authorization code từ Google
            $code = $_GET['code'] ?? '';
            
            if (empty($code)) {
                // Nếu không có code, có thể là user từ chối hoặc error
                $error = isset($_GET['error']) ? 'Bạn đã từ chối đăng nhập bằng Google' : 'Không nhận được authorization code từ Google';
                require __DIR__ . '/../views/auth/login.php';
                return;
            }
            
            // TODO: Exchange code cho access token và lấy user info
            // Trong thực tế sẽ gọi Google API với code
            $userData = $this->getGoogleUserInfo($code);
            
            if ($userData) {
                $this->processSocialLogin('google', $userData);
            } else {
                $error = 'Không thể lấy thông tin người dùng từ Google';
                require __DIR__ . '/../views/auth/login.php';
            }
            
        } catch (Exception $e) {
            $error = 'Lỗi Google OAuth: ' . $e->getMessage();
            require __DIR__ . '/../views/auth/login.php';
        }
    }
    
    public function facebookCallback()
    {
        $error = '';
        
        try {
            // Real OAuth flow - lấy authorization code từ Facebook
            $code = $_GET['code'] ?? '';
            
            if (empty($code)) {
                // Nếu không có code, có thể là user từ chối hoặc error
                $error = isset($_GET['error']) ? 'Bạn đã từ chối đăng nhập bằng Facebook' : 'Không nhận được authorization code từ Facebook';
                require __DIR__ . '/../views/auth/login.php';
                return;
            }
            
            // TODO: Exchange code cho access token và lấy user info
            // Trong thực tế sẽ gọi Facebook API với code
            $userData = $this->getFacebookUserInfo($code);
            
            if ($userData) {
                $this->processSocialLogin('facebook', $userData);
            } else {
                $error = 'Không thể lấy thông tin người dùng từ Facebook';
                require __DIR__ . '/../views/auth/login.php';
            }
            
        } catch (Exception $e) {
            $error = 'Lỗi Facebook OAuth: ' . $e->getMessage();
            require __DIR__ . '/../views/auth/login.php';
        }
    }
    
    private function processSocialLogin($provider, $userData)
    {
        $userModel = new User();
        
        // Kiểm tra user đã tồn tại với social provider chưa
        $existingUser = $userModel->findByEmail($userData['email']);
        
        if ($existingUser) {
            // User đã tồn tại - đăng nhập luôn
            $_SESSION['user_id'] = $existingUser['id'];
            $_SESSION['user_role'] = (int)$existingUser['role'];
            $_SESSION['user_name'] = $existingUser['fullname'];
            $_SESSION['user_email'] = $existingUser['email'];
            
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
            exit;
        } else {
            // User chưa tồn tại - yêu cầu đăng ký
            $_SESSION['social_data'] = [
                'provider' => $provider,
                'email' => $userData['email'],
                'name' => $userData['name'],
                'id' => $userData['id']
            ];
            
            header('Location: /onlinecourse/onlinecourse/index.php?controller=Auth&action=completeProfile');
            exit;
        }
    }

    public function socialLinkLogin()
    {
        $error = '';
        $provider = $_GET['provider'] ?? '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $socialLink = trim($_POST['social_link'] ?? '');
                
                if (empty($socialLink)) {
                    $error = 'Vui lòng nhập link ' . ucfirst($provider);
                } elseif (!filter_var($socialLink, FILTER_VALIDATE_URL)) {
                    $error = 'Link ' . ucfirst($provider) . ' không hợp lệ';
                } else {
                    try {
                        $userModel = new User();
                        
                        // Debug: Kiểm tra social link nhập vào
                        error_log("=== SOCIAL LOGIN DEBUG ===");
                        error_log("Provider: " . $provider);
                        error_log("Social Link: " . $socialLink);
                        
                        $user = $userModel->findByOther($socialLink);
                        
                        // Debug: Kiểm tra kết quả tìm kiếm
                        error_log("User found: " . ($user ? 'YES' : 'NO'));
                        if ($user) {
                            error_log("User ID: " . $user['id']);
                            error_log("User Email: " . $user['email']);
                            error_log("User Other: " . $user['other']);
                        }
                        
                        if ($user) {
                            // Đăng nhập thành công
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_role'] = (int)$user['role'];
                            $_SESSION['user_name'] = $user['fullname'];
                            $_SESSION['user_email'] = $user['email'];
                            
                            error_log("Session set for user ID: " . $user['id']);
                            error_log("Redirecting to dashboard...");
                            
                            header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                            exit;
                        } else {
                            $error = 'Không tìm thấy tài khoản với link ' . ucfirst($provider) . ' này';
                        }
                    } catch (Exception $e) {
                        error_log("Exception in user lookup: " . $e->getMessage());
                        $error = 'Lỗi khi tìm kiếm tài khoản: ' . $e->getMessage();
                    }
                }
            } catch (Exception $e) {
                $error = 'Lỗi: ' . $e->getMessage();
            }
        }
        
        $pageTitle = 'Đăng nhập bằng ' . ucfirst($provider) . ' Link';
        require __DIR__ . '/../views/auth/social_login.php';
    }

    private function getGoogleUserInfo($code)
    {
        // Mock data - trong thực tế sẽ gọi Google API
        return [
            'id' => 'google_' . time(),
            'email' => 'user@gmail.com',
            'name' => 'Google User'
        ];
    }

    private function getFacebookUserInfo($code)
    {
        // Mock data - trong thực tế sẽ gọi Facebook API
        return [
            'id' => 'fb_' . time(),
            'email' => 'user@facebook.com',
            'name' => 'Facebook User'
        ];
    }
}
