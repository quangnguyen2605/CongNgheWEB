<?php
class StudentController
{
    private function requireStudent()
    {
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 0) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }
    
    private function requireAdmin()
    {
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 2) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function dashboard()
    {
        $this->requireStudent();
        $studentId = (int)$_SESSION['user_id'];
        
        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        
        // Get enrolled courses
        $enrolledCourses = $enrollmentModel->getByStudent($studentId);
        
        // Get total progress
        $totalCourses = count($enrolledCourses);
        $avgProgress = 0;
        if ($totalCourses > 0) {
            $totalProgress = array_sum(array_column($enrolledCourses, 'progress'));
            $avgProgress = round($totalProgress / $totalCourses, 1);
        }
        
        // Get recent courses for browsing
        $recentCourses = array_slice($courseModel->searchApproved('', null), 0, 6);
        
        $pageTitle = 'Dashboard Học viên';
        require __DIR__ . '/../views/student/dashboard.php';
    }

    public function myCourses()
    {
        $this->requireStudent();
        $studentId = (int)$_SESSION['user_id'];
        
        $enrollmentModel = new Enrollment();
        $courses = $enrollmentModel->getByStudent($studentId);
        
        $pageTitle = 'Khóa học của tôi';
        require __DIR__ . '/../views/student/my_courses.php';
    }

    public function enroll()
    {
        $this->requireStudent();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = (int)($_POST['course_id'] ?? 0);
            $studentId = (int)$_SESSION['user_id'];
            
            if ($courseId > 0) {
                $enrollmentModel = new Enrollment();
                
                // Check if already enrolled
                if ($enrollmentModel->isEnrolled($studentId, $courseId)) {
                    $_SESSION['error'] = 'Bạn đã đăng ký khóa học này rồi!';
                } else {
                    // For production with payment flow
                    header("Location: index.php?controller=Payment&action=checkout&course_id=$courseId");
                    exit;
                    
                    // For testing: Direct enrollment without payment
                    // Comment this out for production with real payment
                    // if ($enrollmentModel->enroll($courseId, $studentId)) {
                    //     $_SESSION['success'] = 'Đăng ký khóa học thành công!';
                    // } else {
                    //     $_SESSION['error'] = 'Đăng ký khóa học thất bại!';
                    // }
                }
            }
        }
        
        // Redirect back to course detail or my courses
        $redirect = $_POST['redirect'] ?? 'index.php?controller=Student&action=myCourses';
        header("Location: $redirect");
        exit;
    }

    public function courseProgress()
    {
        $this->requireStudent();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        // Verify student is enrolled
        $enrollmentModel = new Enrollment();
        if (!$enrollmentModel->isEnrolled($studentId, $courseId)) {
            $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này!';
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        $courseModel = new Course();
        $lessonModel = new Lesson();
        
        $course = $courseModel->getCourseWithInstructor($courseId);
        $lessons = $lessonModel->getByCourse($courseId);
        $completedLessons = $lessonModel->getCompletedByStudent($courseId, $studentId);
        
        // Calculate progress
        $totalLessons = count($lessons);
        $completedCount = count($completedLessons);
        $progress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 1) : 0;
        
        // Update enrollment progress
        $enrollmentModel->updateProgress($courseId, $studentId, $progress);
        
        // Get enrollment info for display
        $enrollment = $enrollmentModel->getOne($courseId, $studentId);
        
        $pageTitle = 'Tiến độ học tập - ' . ($course['title'] ?? '');
        require __DIR__ . '/../views/student/course_progress.php';
    }

    public function viewLesson()
    {
        $this->requireStudent();
        $lessonId = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];
        
        if ($lessonId === 0) {
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        $lessonModel = new Lesson();
        $materialModel = new Material();
        $courseModel = new Course();
        
        $lesson = $lessonModel->findById($lessonId);
        if (!$lesson) {
            $_SESSION['error'] = 'Bài học không tồn tại!';
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        // Verify student is enrolled in the course
        $enrollmentModel = new Enrollment();
        if (!$enrollmentModel->isEnrolled($studentId, $lesson['course_id'])) {
            $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này!';
            header('Location: index.php?controller=Student&action=myCourses');
            exit;
        }
        
        // Get course info
        $course = $courseModel->getCourseWithInstructor($lesson['course_id']);
        
        // Get materials for this lesson
        $materials = $materialModel->getByLesson($lessonId);
        
        // Get all lessons for navigation
        $allLessons = $lessonModel->getByCourse($lesson['course_id']);
        
        // Check if lesson is completed
        $isCompleted = $lessonModel->isCompleted($lessonId, $studentId);
        
        // Get enrollment info for progress display
        $enrollment = $enrollmentModel->getOne($lesson['course_id'], $studentId);
        
        $pageTitle = $lesson['title'];
        require __DIR__ . '/../views/student/lesson_view.php';
    }

    public function markLessonComplete()
    {
        $this->requireStudent();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonId = (int)($_POST['lesson_id'] ?? 0);
            $studentId = (int)$_SESSION['user_id'];
            
            if ($lessonId > 0) {
                $lessonModel = new Lesson();
                $lesson = $lessonModel->findById($lessonId);
                
                if ($lesson) {
                    $enrollmentModel = new Enrollment();
                    
                    // Mark lesson as completed
                    $lessonModel->markCompleted($lessonId, $studentId);
                    
                    // Update course progress
                    $enrollmentModel->completeLesson($lesson['course_id'], $studentId, $lessonId);
                    
                    $_SESSION['success'] = 'Bài học đã được đánh dấu hoàn thành!';
                }
            }
        }
        
        // Check if redirect is to course progress
        $redirect = $_POST['redirect'] ?? 'index.php?controller=Student&action=myCourses';
        if (strpos($redirect, 'viewLesson') !== false) {
            // If redirecting to lesson, stay on lesson page
            header("Location: $redirect");
        } else {
            // Otherwise, redirect to course progress to see the updated status
            $lessonModel = new Lesson();
            $lesson = $lessonModel->findById($lessonId);
            if ($lesson) {
                header("Location: index.php?controller=Student&action=courseProgress&course_id={$lesson['course_id']}");
            } else {
                header("Location: $redirect");
            }
        }
        exit;
    }

    public function resetLesson()
    {
        $this->requireStudent();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonId = (int)($_POST['lesson_id'] ?? 0);
            $studentId = (int)$_SESSION['user_id'];
            
            if ($lessonId > 0) {
                $lessonModel = new Lesson();
                $lesson = $lessonModel->findById($lessonId);
                
                if ($lesson) {
                    $enrollmentModel = new Enrollment();
                    $db = Database::getInstance()->getConnection();
                    
                    // Remove from completed_lessons table
                    $sql = 'DELETE FROM completed_lessons WHERE lesson_id = :lesson_id AND student_id = :student_id';
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':lesson_id' => $lessonId,
                        ':student_id' => $studentId,
                    ]);
                    
                    // Calculate new progress correctly
                    $totalLessonsSql = 'SELECT COUNT(*) as total FROM lessons WHERE course_id = :course_id';
                    $totalStmt = $db->prepare($totalLessonsSql);
                    $totalStmt->execute([':course_id' => $lesson['course_id']]);
                    $totalLessons = $totalStmt->fetchColumn();
                    
                    $completedLessonsSql = 'SELECT COUNT(*) as completed FROM completed_lessons WHERE course_id = :course_id AND student_id = :student_id';
                    $completedStmt = $db->prepare($completedLessonsSql);
                    $completedStmt->execute([':course_id' => $lesson['course_id'], ':student_id' => $studentId]);
                    $completedCount = $completedStmt->fetchColumn();
                    
                    $newProgress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 1) : 0;
                    
                    // Update progress
                    $enrollmentModel->updateProgress($lesson['course_id'], $studentId, $newProgress);
                    
                    $_SESSION['success'] = 'Bài học đã được đặt lại. Tiến độ: ' . $newProgress . '%';
                }
            }
        }
        
        $lessonId = $_POST['lesson_id'] ?? 0;
        header("Location: index.php?controller=Student&action=viewLesson&lesson_id=$lessonId");
        exit;
    }

    public function resetCourse()
    {
        $this->requireStudent();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseId = (int)($_POST['course_id'] ?? 0);
            $studentId = (int)$_SESSION['user_id'];
            
            if ($courseId > 0) {
                $enrollmentModel = new Enrollment();
                
                // Verify student is enrolled
                if (!$enrollmentModel->isEnrolled($studentId, $courseId)) {
                    $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này!';
                } else {
                    // Delete all completed lessons for this course and student
                    $db = Database::getInstance()->getConnection();
                    $sql = 'DELETE FROM completed_lessons WHERE course_id = :course_id AND student_id = :student_id';
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':course_id' => $courseId,
                        ':student_id' => $studentId,
                    ]);
                    
                    // Reset progress to 0
                    $enrollmentModel->updateProgress($courseId, $studentId, 0);
                    
                    $_SESSION['success'] = 'Khóa học đã được đặt lại. Bạn có thể học lại từ đầu!';
                }
            }
        }
        
        header("Location: index.php?controller=Student&action=courseProgress&course_id=$courseId");
        exit;
    }

    public function profile()
    {
        // Allow access for students viewing their own profile OR admins viewing any profile
        $studentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $isOwnProfile = false;
        
        if ($studentId === 0) {
            // No ID specified, show current user's profile
            $this->requireStudent();
            $studentId = (int)$_SESSION['user_id'];
            $isOwnProfile = true;
        } else {
            // ID specified, check permissions
            if ((int)($_SESSION['user_role'] ?? 0) === 2) {
                // Admin can view any profile
                $this->requireAdmin();
            } else {
                // Student can only view their own profile
                $this->requireStudent();
                if ($studentId !== (int)$_SESSION['user_id']) {
                    $_SESSION['error'] = 'Bạn không có quyền xem hồ sơ này!';
                    header('Location: index.php?controller=Student&action=dashboard');
                    exit;
                }
                $isOwnProfile = true;
            }
        }
        
        // Get student information
        $db = Database::getInstance()->getConnection();
        $sql = 'SELECT id, username, email, fullname, created_at FROM users WHERE id = :id AND role = 0';
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $studentId]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$student) {
            $_SESSION['error'] = 'Học viên không tồn tại!';
            if ($isOwnProfile) {
                header('Location: index.php?controller=Student&action=dashboard');
            } else {
                header('Location: index.php?controller=Admin&action=allEnrollments');
            }
            exit;
        }
        
        // Get enrollment information with course details
        $enrollmentModel = new Enrollment();
        $db = Database::getInstance()->getConnection();
        
        $sql = 'SELECT e.*, c.title, c.description, cat.name as category_name, u.fullname as instructor_name
                FROM enrollments e 
                JOIN courses c ON e.course_id = c.id
                LEFT JOIN categories cat ON c.category_id = cat.id
                LEFT JOIN users u ON c.instructor_id = u.id
                WHERE e.student_id = :student_id
                ORDER BY e.enrolled_date DESC';
        $stmt = $db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Calculate statistics
        $totalCourses = count($enrollments);
        $avgProgress = 0;
        $completedCourses = 0;
        
        if ($totalCourses > 0) {
            $totalProgress = array_sum(array_column($enrollments, 'progress'));
            $avgProgress = round($totalProgress / $totalCourses, 1);
            $completedCourses = count(array_filter($enrollments, function($e) { return $e['progress'] >= 100; }));
        }
        
        $pageTitle = $isOwnProfile ? 'Hồ sơ của tôi' : 'Hồ sơ học viên: ' . $student['fullname'];
        require __DIR__ . '/../views/student/profile.php';
    }

    public function browseCourses()
    {
        $this->requireStudent();
        
        $courseModel = new Course();
        $categoryModel = new Category();
        
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $categoryId = isset($_GET['category_id']) ? $_GET['category_id'] : null;
        
        $courses = $courseModel->searchApproved($keyword, $categoryId);
        $categories = $categoryModel->getAll();
        
        $pageTitle = 'Khám phá khóa học';
        require __DIR__ . '/../views/courses/index.php';
    }
}
