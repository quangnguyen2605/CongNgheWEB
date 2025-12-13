<?php
class AdminController
{
    private function requireAdmin()
    {
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 2) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();
        $db = Database::getInstance()->getConnection();

        $totalUsers = (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
        $totalCourses = (int)$db->query('SELECT COUNT(*) FROM courses')->fetchColumn();
        $totalEnrollments = (int)$db->query('SELECT COUNT(*) FROM enrollments')->fetchColumn();

        // Users by role
        $students = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 0')->fetchColumn();
        $instructors = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 1')->fetchColumn();
        $admins = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 2')->fetchColumn();
        
        // Courses by status
        $pendingCourses = (int)$db->query('SELECT COUNT(*) FROM courses WHERE status = "pending"')->fetchColumn();

        $pageTitle = 'Admin Dashboard';
        require __DIR__ . '/../views/admin/dashboard.php';
    }

    // Quản lý người dùng (xem danh sách)
    public function users()
    {
        $this->requireAdmin();
        $userModel = new User();
        $users = $userModel->getAll();
        $pageTitle = 'Quản lý người dùng';
        require __DIR__ . '/../views/admin/users/manage.php';
    }

    public function createUser()
    {
        $this->requireAdmin();
        $pageTitle = 'Thêm người dùng mới';
        require __DIR__ . '/../views/admin/users/create.php';
    }

    public function storeUser()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            
            // Password validation
            if (strlen($password) < 8) {
                $_SESSION['error'] = 'Mật khẩu phải có ít nhất 8 ký tự!';
                header('Location: index.php?controller=Admin&action=createUser');
                exit;
            }
            
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
                $_SESSION['error'] = 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số!';
                header('Location: index.php?controller=Admin&action=createUser');
                exit;
            }
            
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]),
                'fullname' => $_POST['fullname'] ?? '',
                'role' => (int)($_POST['role'] ?? 0),
                'phone' => $_POST['phone'] ?? '',
                'bio' => $_POST['bio'] ?? ''
            ];
            
            $userModel = new User();
            
            // Check if username or email already exists
            if ($userModel->getByUsername($data['username'])) {
                $_SESSION['error'] = 'Tên đăng nhập đã tồn tại!';
                header('Location: index.php?controller=Admin&action=createUser');
                exit;
            }
            
            if ($userModel->getByEmail($data['email'])) {
                $_SESSION['error'] = 'Email đã tồn tại!';
                header('Location: index.php?controller=Admin&action=createUser');
                exit;
            }
            
            if ($userModel->create($data)) {
                $_SESSION['success'] = 'Tạo người dùng thành công! Mật khẩu đã được mã hóa bằng Argon2ID.';
                header('Location: index.php?controller=Admin&action=users');
                exit;
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                header('Location: index.php?controller=Admin&action=createUser');
                exit;
            }
        }
    }

    public function toggleUserStatus()
    {
        $this->requireAdmin();
        $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($userId > 0) {
            $userModel = new User();
            $user = $userModel->findById($userId);
            
            if ($user) {
                // Toggle status: 1 -> 0, 0 -> 1
                $newStatus = ($user['status'] == 1) ? 0 : 1;
                
                if ($userModel->update($userId, ['status' => $newStatus])) {
                    $statusText = ($newStatus == 1) ? 'kích hoạt' : 'vô hiệu hóa';
                    $_SESSION['success'] = "Đã $statusText người dùng '{$user['fullname']}' thành công!";
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại!';
                }
            } else {
                $_SESSION['error'] = 'Người dùng không tồn tại!';
            }
        }
        
        header('Location: index.php?controller=Admin&action=users');
        exit;
    }

    public function deleteUser()
    {
        $this->requireAdmin();
        $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($userId > 0) {
            $userModel = new User();
            $userModel->delete($userId);
            $_SESSION['success'] = 'Xóa người dùng thành công';
        }
        
        header('Location: index.php?controller=Admin&action=users');
        exit;
    }

    // Quản lý danh mục khóa học
    public function categories()
    {
        $this->requireAdmin();
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        $pageTitle = 'Danh mục khóa học';
        require __DIR__ . '/../views/admin/categories/list.php';
    }

    public function createCategory()
    {
        $this->requireAdmin();
        $pageTitle = 'Thêm danh mục';
        require __DIR__ . '/../views/admin/categories/create.php';
    }

    public function storeCategory()
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryModel = new Category();
            $categoryModel->create([
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
            ]);
        }
        header('Location: index.php?controller=Admin&action=categories');
        exit;
    }

    public function editCategory()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $categoryModel = new Category();
        $category = $categoryModel->findById($id);
        $pageTitle = 'Sửa danh mục';
        require __DIR__ . '/../views/admin/categories/edit.php';
    }

    public function updateCategory()
    {
        $this->requireAdmin();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0) {
            $categoryModel = new Category();
            $categoryModel->update($id, [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
            ]);
        }
        header('Location: index.php?controller=Admin&action=categories');
        exit;
    }

    public function deleteCategory()
    {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $categoryModel = new Category();
            $categoryModel->delete($id);
        }
        header('Location: index.php?controller=Admin&action=categories');
        exit;
    }

    // Quản lý khóa học
    public function courses()
    {
        $this->requireAdmin();
        
        try {
            // Get courses with instructor and category info
            $db = Database::getInstance()->getConnection();
            $sql = 'SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                    FROM courses c 
                    LEFT JOIN users u ON c.instructor_id = u.id 
                    LEFT JOIN categories cat ON c.category_id = cat.id 
                    ORDER BY c.created_at DESC';
            $stmt = $db->query($sql);
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug: Log the results
            error_log("Courses query executed. Results: " . count($courses) . " courses found");
            
        } catch (Exception $e) {
            error_log("Error in courses method: " . $e->getMessage());
            $courses = [];
        }
        
        $pageTitle = 'Quản lý khóa học';
        require __DIR__ . '/../views/admin/courses/manage.php';
    }

    public function deleteCourse()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId > 0) {
            $courseModel = new Course();
            
            // Check if course exists
            $course = $courseModel->findById($courseId);
            if ($course) {
                // Delete related enrollments first
                $enrollmentModel = new Enrollment();
                $enrollmentModel->deleteByCourse($courseId);
                
                // Delete the course
                if ($courseModel->delete($courseId)) {
                    $_SESSION['success'] = 'Xóa khóa học thành công!';
                } else {
                    $_SESSION['error'] = 'Xóa khóa học thất bại!';
                }
            } else {
                $_SESSION['error'] = 'Khóa học không tồn tại!';
            }
        }
        
        header('Location: index.php?controller=Admin&action=courses');
        exit;
    }

    public function allEnrollments()
    {
        $this->requireAdmin();
        $db = Database::getInstance()->getConnection();
        
        // Get all enrollments with course and student info
        $sql = 'SELECT e.*, c.title as course_title, u.fullname as student_name, u.email as student_email,
                u.username as student_username, cat.name as category_name, ins.fullname as instructor_name
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id
                JOIN users u ON e.student_id = u.id
                LEFT JOIN categories cat ON c.category_id = cat.id
                LEFT JOIN users ins ON c.instructor_id = ins.id
                ORDER BY e.enrolled_date DESC';
        $stmt = $db->query($sql);
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $pageTitle = 'Quản lý đăng ký khóa học';
        require __DIR__ . '/../views/admin/enrollments/manage.php';
    }

    public function addStudentToCourse()
    {
        $this->requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = (int)($_POST['course_id'] ?? 0);
            $studentId = (int)($_POST['student_id'] ?? 0);
            
            if ($courseId > 0 && $studentId > 0) {
                $enrollmentModel = new Enrollment();
                
                // Check if already enrolled
                if ($enrollmentModel->isEnrolled($studentId, $courseId)) {
                    $_SESSION['error'] = 'Học viên đã đăng ký khóa học này!';
                } else {
                    // Add enrollment
                    if ($enrollmentModel->enroll($courseId, $studentId)) {
                        $_SESSION['success'] = 'Thêm học viên vào khóa học thành công!';
                    } else {
                        $_SESSION['error'] = 'Thêm học viên thất bại!';
                    }
                }
            }
        }
        
        $redirect = $_POST['redirect'] ?? 'index.php?controller=Admin&action=allEnrollments';
        header("Location: $redirect");
        exit;
    }

    public function addStudentForm()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId > 0) {
            $db = Database::getInstance()->getConnection();
            
            // Get course info
            $sql = 'SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                    FROM courses c 
                    LEFT JOIN users u ON c.instructor_id = u.id 
                    LEFT JOIN categories cat ON c.category_id = cat.id 
                    WHERE c.id = :course_id';
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get students not enrolled in this course
            $sql = 'SELECT u.id, u.username, u.fullname, u.email 
                    FROM users u 
                    WHERE u.role = 0 
                    AND u.id NOT IN (
                        SELECT e.student_id FROM enrollments e WHERE e.course_id = :course_id
                    )
                    ORDER BY u.fullname';
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $pageTitle = 'Thêm học viên - ' . ($course['title'] ?? '');
            require __DIR__ . '/../views/admin/enrollments/add_student.php';
        } else {
            $_SESSION['error'] = 'ID khóa học không hợp lệ!';
            header('Location: index.php?controller=Admin&action=allEnrollments');
            exit;
        }
    }

    public function courseEnrollments()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId > 0) {
            $db = Database::getInstance()->getConnection();
            
            // Get course info
            $sql = 'SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                    FROM courses c 
                    LEFT JOIN users u ON c.instructor_id = u.id 
                    LEFT JOIN categories cat ON c.category_id = cat.id 
                    WHERE c.id = :course_id';
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Get enrolled students
            $sql = 'SELECT e.*, u.username, u.fullname, u.email 
                    FROM enrollments e 
                    JOIN users u ON e.student_id = u.id 
                    WHERE e.course_id = :course_id 
                    ORDER BY e.enrolled_date DESC';
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $pageTitle = 'Quản lý học viên - ' . ($course['title'] ?? 'Khóa học');
            require __DIR__ . '/../views/admin/courses/enrollments.php';
        } else {
            $_SESSION['error'] = 'ID khóa học không hợp lệ!';
            header('Location: index.php?controller=Admin&action=courses');
            exit;
        }
    }

    public function removeStudent()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;
        
        if ($courseId > 0 && $studentId > 0) {
            $db = Database::getInstance()->getConnection();
            
            // Delete completed lessons first
            $sql = 'DELETE FROM completed_lessons WHERE course_id = :course_id AND student_id = :student_id';
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId, ':student_id' => $studentId]);
            
            // Delete enrollment
            $sql = 'DELETE FROM enrollments WHERE course_id = :course_id AND student_id = :student_id';
            $stmt = $db->prepare($sql);
            if ($stmt->execute([':course_id' => $courseId, ':student_id' => $studentId])) {
                $_SESSION['success'] = 'Xóa học viên khỏi khóa học thành công!';
            } else {
                $_SESSION['error'] = 'Xóa học viên thất bại!';
            }
        }
        
        header('Location: index.php?controller=Admin&action=courseEnrollments&id=' . $courseId);
        exit;
    }

    // Quản lý duyệt khóa học
    public function courseApproval()
    {
        // Alias for pendingCourses - redirect to the correct method
        $this->pendingCourses();
    }

    public function pendingCourses()
    {
        $this->requireAdmin();
        $courseModel = new Course();
        $courses = $courseModel->getPendingApproval();
        $pageTitle = 'Khóa học chờ duyệt';
        require __DIR__ . '/../views/admin/courses/pending.php';
    }

    public function approveCourse()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId > 0) {
            $courseModel = new Course();
            $courseModel->updateStatus($courseId, 'approved');
            $_SESSION['success'] = 'Duyệt khóa học thành công';
        }
        
        header('Location: index.php?controller=Admin&action=pendingCourses');
        exit;
    }

    public function rejectCourse()
    {
        $this->requireAdmin();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId > 0) {
            $courseModel = new Course();
            $courseModel->updateStatus($courseId, 'rejected');
            $_SESSION['success'] = 'Từ chối khóa học thành công';
        }
        
        header('Location: index.php?controller=Admin&action=pendingCourses');
        exit;
    }

    // Thống kê chi tiết
    public function statistics()
    {
        $this->requireAdmin();
        $db = Database::getInstance()->getConnection();

        // Basic stats
        $totalUsers = (int)$db->query('SELECT COUNT(*) FROM users')->fetchColumn();
        $totalCourses = (int)$db->query('SELECT COUNT(*) FROM courses')->fetchColumn();
        $totalEnrollments = (int)$db->query('SELECT COUNT(*) FROM enrollments')->fetchColumn();
        
        // Users by role
        $students = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 0')->fetchColumn();
        $instructors = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 1')->fetchColumn();
        $admins = (int)$db->query('SELECT COUNT(*) FROM users WHERE role = 2')->fetchColumn();
        
        // Courses by status
        $approvedCourses = (int)$db->query('SELECT COUNT(*) FROM courses WHERE status = "approved"')->fetchColumn();
        $pendingCourses = (int)$db->query('SELECT COUNT(*) FROM courses WHERE status = "pending"')->fetchColumn();
        
        // Revenue statistics
        $totalRevenue = (float)$db->query('SELECT SUM(c.price) FROM enrollments e JOIN courses c ON e.course_id = c.id')->fetchColumn() ?: 0;
        $todayRevenue = (float)$db->query('SELECT SUM(c.price) FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE DATE(e.enrolled_date) = CURDATE()')->fetchColumn() ?: 0;
        $monthRevenue = (float)$db->query('SELECT SUM(c.price) FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE MONTH(e.enrolled_date) = MONTH(CURDATE()) AND YEAR(e.enrolled_date) = YEAR(CURDATE())')->fetchColumn() ?: 0;
        
        // Daily statistics
        $todayUsers = (int)$db->query('SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()')->fetchColumn();
        $todayEnrollments = (int)$db->query('SELECT COUNT(*) FROM enrollments WHERE DATE(enrolled_date) = CURDATE()')->fetchColumn();
        $todayCourses = (int)$db->query('SELECT COUNT(*) FROM courses WHERE DATE(created_at) = CURDATE()')->fetchColumn();
        
        // Last 7 days statistics
        $weekEnrollments = $db->query('SELECT DATE(e.enrolled_date) as date, COUNT(*) as count FROM enrollments e WHERE e.enrolled_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(e.enrolled_date) ORDER BY date')->fetchAll(PDO::FETCH_ASSOC);
        $weekRevenue = $db->query('SELECT DATE(e.enrolled_date) as date, SUM(c.price) as revenue FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.enrolled_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(e.enrolled_date) ORDER BY date')->fetchAll(PDO::FETCH_ASSOC);
        
        // Recent activity
        $recentEnrollments = $db->query('SELECT e.*, u.fullname, c.title FROM enrollments e 
                                        JOIN users u ON e.student_id = u.id 
                                        JOIN courses c ON e.course_id = c.id 
                                        ORDER BY e.enrolled_date DESC LIMIT 10')
                                        ->fetchAll(PDO::FETCH_ASSOC);
        
        $recentCourses = $db->query('SELECT c.*, u.fullname as instructor_name FROM courses c 
                                     JOIN users u ON c.instructor_id = u.id 
                                     ORDER BY c.created_at DESC LIMIT 10')
                                     ->fetchAll(PDO::FETCH_ASSOC);

        // Top courses by enrollment
        $topCourses = $db->query('SELECT c.title, COUNT(e.id) as enrollment_count, SUM(c.price) as revenue FROM courses c 
                                 LEFT JOIN enrollments e ON c.id = e.course_id 
                                 WHERE c.status = "approved" 
                                 GROUP BY c.id, c.title 
                                 ORDER BY enrollment_count DESC 
                                 LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);

        $stats = [
            'totalUsers' => $totalUsers,
            'totalCourses' => $totalCourses,
            'totalEnrollments' => $totalEnrollments,
            'students' => $students,
            'instructors' => $instructors,
            'admins' => $admins,
            'approvedCourses' => $approvedCourses,
            'pendingCourses' => $pendingCourses,
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'todayUsers' => $todayUsers,
            'todayEnrollments' => $todayEnrollments,
            'todayCourses' => $todayCourses,
            'weekEnrollments' => $weekEnrollments,
            'weekRevenue' => $weekRevenue,
            'recentEnrollments' => $recentEnrollments,
            'recentCourses' => $recentCourses,
            'topCourses' => $topCourses
        ];

        $pageTitle = 'Thống kê hệ thống';
        require __DIR__ . '/../views/admin/statistics/index.php';
    }
}
