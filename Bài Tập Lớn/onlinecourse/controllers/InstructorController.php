<?php
class InstructorController
{
    private function requireInstructor()
    {
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 1) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireInstructor();
        $instructorId = (int)$_SESSION['user_id'];
        
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        
        // Get instructor's courses
        $courses = $courseModel->getByInstructor($instructorId);
        
        // Get total students
        $totalStudents = 0;
        $totalRevenue = 0;
        foreach ($courses as $course) {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare('SELECT COUNT(*) as count FROM enrollments WHERE course_id = :course_id');
            $stmt->execute([':course_id' => $course['id']]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalStudents += $result['count'];
            $totalRevenue += $result['count'] * $course['price'];
        }
        
        // Get recent enrollments
        $recentEnrollments = [];
        if (!empty($courses)) {
            $courseIds = array_column($courses, 'id');
            $placeholders = str_repeat('?,', count($courseIds) - 1) . '?';
            $sql = "SELECT e.*, c.title as course_title, u.fullname, u.email 
                    FROM enrollments e 
                    JOIN courses c ON e.course_id = c.id 
                    JOIN users u ON e.student_id = u.id 
                    WHERE e.course_id IN ($placeholders) 
                    ORDER BY e.enrolled_date DESC LIMIT 10";
            $stmt = $db->prepare($sql);
            $stmt->execute($courseIds);
            $recentEnrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        $pageTitle = 'Dashboard Giảng viên';
        require __DIR__ . '/../views/instructor/dashboard.php';
    }

    public function myCourses()
    {
        $this->requireInstructor();
        $instructorId = (int)$_SESSION['user_id'];
        
        $courseModel = new Course();
        $courses = $courseModel->getByInstructor($instructorId);
        
        $pageTitle = 'Quản lý khóa học';
        require __DIR__ . '/../views/instructor/course/manage.php';
    }

    public function createCourse()
    {
        $this->requireInstructor();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel = new Course();
            
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'instructor_id' => (int)$_SESSION['user_id'],
                'category_id' => (int)($_POST['category_id'] ?? 0),
                'price' => (float)($_POST['price'] ?? 0),
                'duration_weeks' => (int)($_POST['duration_weeks'] ?? 4),
                'level' => $_POST['level'] ?? 'beginner',
                'image' => $_POST['image'] ?? '',
            ];
            
            if ($courseModel->create($data)) {
                $_SESSION['success'] = 'Tạo khóa học thành công! Khóa học đang chờ duyệt.';
                header('Location: index.php?controller=Instructor&action=myCourses');
                exit;
            } else {
                $error = 'Không thể tạo khóa học. Vui lòng thử lại.';
            }
        }
        
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        
        $pageTitle = 'Tạo khóa học mới';
        require __DIR__ . '/../views/instructor/course/create.php';
    }

    public function editCourse()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        // Check if course belongs to this instructor
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'description' => $_POST['description'] ?? '',
                'category_id' => (int)($_POST['category_id'] ?? 0),
                'price' => (float)($_POST['price'] ?? 0),
                'duration_weeks' => (int)($_POST['duration_weeks'] ?? 4),
                'level' => $_POST['level'] ?? 'beginner',
                'image' => $_POST['image'] ?? '',
            ];
            
            if ($courseModel->update($courseId, $data)) {
                $_SESSION['success'] = 'Cập nhật khóa học thành công!';
                header('Location: index.php?controller=Instructor&action=myCourses');
                exit;
            } else {
                $error = 'Không thể cập nhật khóa học. Vui lòng thử lại.';
            }
        }
        
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        
        $pageTitle = 'Chỉnh sửa khóa học';
        require __DIR__ . '/../views/instructor/course/edit.php';
    }

    public function deleteCourse()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($courseId > 0) {
            $courseModel = new Course();
            $course = $courseModel->findById($courseId);
            
            // Check if course belongs to this instructor
            if ($course && $course['instructor_id'] == (int)$_SESSION['user_id']) {
                $courseModel->delete($courseId);
                $_SESSION['success'] = 'Xóa khóa học thành công!';
            } else {
                $_SESSION['error'] = 'Bạn không có quyền xóa khóa học này!';
            }
        }
        
        header('Location: index.php?controller=Instructor&action=myCourses');
        exit;
    }

    public function manageLessons()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền quản lý khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        
        $pageTitle = 'Quản lý bài học - ' . $course['title'];
        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    public function createLesson()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền thêm bài học cho khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel = new Lesson();
            
            // Get next order number
            $lessons = $lessonModel->getByCourse($courseId);
            $nextOrder = count($lessons) + 1;
            
            $data = [
                'course_id' => $courseId,
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'video_url' => $_POST['video_url'] ?? '',
                'order' => (int)($_POST['order'] ?? $nextOrder),
            ];
            
            if ($lessonModel->create($data)) {
                $_SESSION['success'] = 'Tạo bài học thành công!';
                header("Location: index.php?controller=Instructor&action=manageLessons&course_id=$courseId");
                exit;
            } else {
                $error = 'Không thể tạo bài học. Vui lòng thử lại.';
            }
        }
        
        $pageTitle = 'Tạo bài học mới';
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    public function editLesson()
    {
        $this->requireInstructor();
        $lessonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($lessonId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($lessonId);
        
        if (!$lesson) {
            $_SESSION['error'] = 'Bài học không tồn tại!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($lesson['course_id']);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa bài học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'video_url' => $_POST['video_url'] ?? '',
                'order' => (int)($_POST['order'] ?? 1),
            ];
            
            if ($lessonModel->update($lessonId, $data)) {
                $_SESSION['success'] = 'Cập nhật bài học thành công!';
                header("Location: index.php?controller=Instructor&action=manageLessons&course_id={$lesson['course_id']}");
                exit;
            } else {
                $error = 'Không thể cập nhật bài học. Vui lòng thử lại.';
            }
        }
        
        $pageTitle = 'Chỉnh sửa bài học';
        require __DIR__ . '/../views/instructor/lessons/edit.php';
    }

    public function deleteLesson()
    {
        $this->requireInstructor();
        $lessonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($lessonId > 0) {
            $lessonModel = new Lesson();
            $lesson = $lessonModel->findById($lessonId);
            
            if ($lesson) {
                // Check if course belongs to this instructor
                $courseModel = new Course();
                $course = $courseModel->findById($lesson['course_id']);
                
                if ($course && $course['instructor_id'] == (int)$_SESSION['user_id']) {
                    $lessonModel->delete($lessonId);
                    $_SESSION['success'] = 'Xóa bài học thành công!';
                } else {
                    $_SESSION['error'] = 'Bạn không có quyền xóa bài học này!';
                }
            }
        }
        
        header('Location: index.php?controller=Instructor&action=myCourses');
        exit;
    }

    public function uploadMaterials()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền tải tài liệu cho khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle file upload
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/materials/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['file']['name']);
                $filePath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                    $materialModel = new Material();
                    $data = [
                        'course_id' => $courseId,
                        'lesson_id' => !empty($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : null,
                        'title' => $_POST['title'] ?? $fileName,
                        'file_path' => 'uploads/materials/' . $fileName,
                        'file_type' => $_FILES['file']['type'],
                        'file_size' => $_FILES['file']['size'],
                        'description' => $_POST['description'] ?? '',
                    ];
                    
                    if ($materialModel->create($data)) {
                        $_SESSION['success'] = 'Tải tài liệu thành công!';
                    } else {
                        $_SESSION['error'] = 'Không thể lưu thông tin tài liệu!';
                    }
                } else {
                    $_SESSION['error'] = 'Không thể tải file lên!';
                }
            } else {
                $_SESSION['error'] = 'Vui lòng chọn file để tải lên!';
            }
            
            header("Location: index.php?controller=Instructor&action=uploadMaterials&course_id=$courseId");
            exit;
        }
        
        $pageTitle = 'Tải tài liệu học tập';
        require __DIR__ . '/../views/instructor/materials/upload.php';
    }

    public function viewStudents()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền xem danh sách học viên của khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Get enrolled students with progress
        $db = Database::getInstance()->getConnection();
        $sql = 'SELECT e.*, u.fullname, u.email, 
                (SELECT COUNT(*) FROM completed_lessons cl 
                 JOIN lessons l ON cl.lesson_id = l.id 
                 WHERE l.course_id = :course_id AND cl.student_id = e.student_id) as completed_lessons,
                (SELECT COUNT(*) FROM lessons WHERE course_id = :course_id) as total_lessons
                FROM enrollments e 
                JOIN users u ON e.student_id = u.id 
                WHERE e.course_id = :course_id
                ORDER BY e.enrolled_date DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate progress percentage for each student
        foreach ($students as &$student) {
            $totalLessons = (int)$student['total_lessons'];
            $completedLessons = (int)$student['completed_lessons'];
            $student['progress_percentage'] = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100, 1) : 0;
        }
        
        $pageTitle = 'Học viên đăng ký - ' . $course['title'];
        require __DIR__ . '/../views/instructor/students/list.php';
    }

    public function studentProgress()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;
        
        if ($courseId === 0 || $studentId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền xem tiến độ học viên của khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Get student info
        $userModel = new User();
        $student = $userModel->findById($studentId);
        
        if (!$student) {
            $_SESSION['error'] = 'Học viên không tồn tại!';
            header('Location: index.php?controller=Instructor&action=viewStudents&course_id=$courseId');
            exit;
        }
        
        // Get lessons and progress
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        $completedLessons = $lessonModel->getCompletedByStudent($courseId, $studentId);
        
        // Mark completed lessons
        $completedLessonIds = array_column($completedLessons, 'id');
        foreach ($lessons as &$lesson) {
            $lesson['is_completed'] = in_array($lesson['id'], $completedLessonIds);
        }
        
        // Calculate overall progress
        $totalLessons = count($lessons);
        $completedCount = count($completedLessons);
        $progress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 1) : 0;
        
        $pageTitle = 'Tiến độ học tập - ' . $student['fullname'];
        require __DIR__ . '/../views/instructor/students/progress.php';
    }

    public function studentDetail()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = isset($_GET['student_id']) ? (int)$_GET['student_id'] : 0;
        
        if ($courseId === 0 || $studentId === 0) {
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->findById($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền xem thông tin học viên của khóa học này!';
            header('Location: index.php?controller=Instructor&action=myCourses');
            exit;
        }
        
        // Get student info
        $userModel = new User();
        $student = $userModel->findById($studentId);
        
        if (!$student) {
            $_SESSION['error'] = 'Học viên không tồn tại!';
            header('Location: index.php?controller=Instructor&action=viewStudents&course_id=' . $courseId);
            exit;
        }
        
        // Verify student is enrolled in course
        $enrollmentModel = new Enrollment();
        if (!$enrollmentModel->isEnrolled($studentId, $courseId)) {
            $_SESSION['error'] = 'Học viên này chưa đăng ký khóa học!';
            header('Location: index.php?controller=Instructor&action=viewStudents&course_id=' . $courseId);
            exit;
        }
        
        // Get lessons and completion status
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        $completedLessons = $lessonModel->getCompletedByStudent($courseId, $studentId);
        
        // Get materials
        $materialModel = new Material();
        $materials = $materialModel->getByCourse($courseId);
        
        // Get enrollment info
        $enrollment = $enrollmentModel->getOne($courseId, $studentId);
        
        $pageTitle = 'Chi tiết tiến độ - ' . htmlspecialchars($student['fullname']) . ' - ' . htmlspecialchars($course['title']);
        require __DIR__ . '/../views/instructor/students/detail.php';
    }

    public function manageCourses()
    {
        $this->requireInstructor();
        $instructorId = (int)$_SESSION['user_id'];
        
        // Get instructor's courses with statistics
        $db = Database::getInstance()->getConnection();
        $sql = 'SELECT c.*, 
                (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id) as student_count,
                (SELECT COUNT(*) FROM lessons l WHERE l.course_id = c.id) as lesson_count,
                (SELECT COUNT(*) FROM materials m JOIN lessons l ON m.lesson_id = l.id WHERE l.course_id = c.id) as material_count
                FROM courses c 
                WHERE c.instructor_id = :instructor_id
                ORDER BY c.created_at DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([':instructor_id' => $instructorId]);
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Separate courses by status
        $pendingCourses = array_filter($courses, function($course) {
            return $course['status'] === 'pending';
        });
        $approvedCourses = array_filter($courses, function($course) {
            return $course['status'] === 'approved';
        });
        $rejectedCourses = array_filter($courses, function($course) {
            return $course['status'] === 'rejected';
        });
        
        $pageTitle = 'Quản lý khóa học của tôi';
        require __DIR__ . '/../views/instructor/course/manage.php';
    }

    public function uploadCourseMaterials()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Instructor&action=manageCourses');
            exit;
        }
        
        // Check if course belongs to this instructor
        $courseModel = new Course();
        $course = $courseModel->getCourseWithInstructor($courseId);
        
        if (!$course || $course['instructor_id'] != (int)$_SESSION['user_id']) {
            $_SESSION['error'] = 'Bạn không có quyền quản lý tài liệu của khóa học này!';
            header('Location: index.php?controller=Instructor&action=manageCourses');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $materialType = $_POST['material_type'] ?? '';
            $lessonId = isset($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : 0;
            $description = $_POST['description'] ?? '';
            
            if (isset($_FILES['materials']) && !empty($_FILES['materials']['name'][0])) {
                $uploadDir = 'assets/uploads/materials/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $materialModel = new Material();
                $uploadedCount = 0;
                
                foreach ($_FILES['materials']['name'] as $key => $name) {
                    if ($_FILES['materials']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = time() . '_' . basename($name);
                        $targetPath = $uploadDir . $fileName;
                        
                        if (move_uploaded_file($_FILES['materials']['tmp_name'][$key], $targetPath)) {
                            $materialData = [
                                'course_id' => $courseId,
                                'lesson_id' => ($materialType === 'lesson' && $lessonId > 0) ? $lessonId : null,
                                'filename' => $name,
                                'file_path' => $targetPath,
                                'file_type' => pathinfo($name, PATHINFO_EXTENSION),
                                'description' => $description
                            ];
                            
                            $materialModel->create($materialData);
                            $uploadedCount++;
                        }
                    }
                }
                
                if ($uploadedCount > 0) {
                    $_SESSION['success'] = "Đã tải lên thành công {$uploadedCount} tài liệu!";
                } else {
                    $_SESSION['error'] = 'Không thể tải lên tài liệu';
                }
            } else {
                $_SESSION['error'] = 'Vui lòng chọn file để tải lên';
            }
            
            header('Location: index.php?controller=Instructor&action=uploadCourseMaterials&course_id=' . $courseId);
            exit;
        }
        
        // Get lessons for this course
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        
        // Get existing materials
        $materialModel = new Material();
        $materials = $materialModel->getByCourse($courseId);
        
        $pageTitle = 'Tải tài liệu - ' . htmlspecialchars($course['title']);
        require __DIR__ . '/../views/instructor/course/upload_materials.php';
    }
}
