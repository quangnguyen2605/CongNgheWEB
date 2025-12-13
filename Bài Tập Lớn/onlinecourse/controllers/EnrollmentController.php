<?php
class EnrollmentController
{
    private function requireLogin()
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function enroll()
    {
        $this->requireLogin();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];

        if ($courseId > 0) {
            $enrollmentModel = new Enrollment();
            $courseModel = new Course();
            
            // Check if course exists and is approved
            $course = $courseModel->findById($courseId);
            if (!$course || $course['status'] !== 'approved') {
                $_SESSION['error'] = 'Khóa học không tồn tại hoặc chưa được duyệt';
                header('Location: index.php?controller=Course&action=index');
                exit;
            }
            
            // Check if already enrolled
            $existing = $enrollmentModel->getOne($courseId, $studentId);
            if ($existing) {
                $_SESSION['error'] = 'Bạn đã đăng ký khóa học này rồi';
            } else {
                $enrolled = $enrollmentModel->enroll($courseId, $studentId);
                if ($enrolled) {
                    $_SESSION['success'] = 'Đăng ký khóa học thành công!';
                } else {
                    $_SESSION['error'] = 'Không thể đăng ký khóa học';
                }
            }
        }

        header('Location: index.php?controller=Course&action=detail&id=' . $courseId);
        exit;
    }

    public function myCourses()
    {
        $this->requireLogin();
        $studentId = (int)$_SESSION['user_id'];
        $enrollmentModel = new Enrollment();
        $courses = $enrollmentModel->getByStudent($studentId);

        $pageTitle = 'Khóa học của tôi';
        require __DIR__ . '/../views/student/my_courses.php';
    }

    public function progress()
    {
        $this->requireLogin();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];

        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        $lessonModel = new Lesson();

        $enrollment = $enrollmentModel->getOne($courseId, $studentId);
        $course = $courseModel->getCourseWithInstructor($courseId);
        $lessons = $lessonModel->getByCourse($courseId);
        $completedLessons = $lessonModel->getCompletedByStudent($courseId, $studentId);

        if (!$enrollment || !$course) {
            http_response_code(404);
            echo 'Bạn chưa đăng ký khóa học này';
            return;
        }

        $pageTitle = 'Tiến độ khóa học - ' . $course['title'];
        require __DIR__ . '/../views/student/course_progress.php';
    }

    public function viewLesson()
    {
        $this->requireLogin();
        $lessonId = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];

        $lessonModel = new Lesson();
        $enrollmentModel = new Enrollment();
        $materialModel = new Material();

        $lesson = $lessonModel->findById($lessonId);
        if (!$lesson) {
            http_response_code(404);
            echo 'Bài học không tồn tại';
            return;
        }

        // Check if student is enrolled in the course
        $enrollment = $enrollmentModel->getOne($lesson['course_id'], $studentId);
        if (!$enrollment) {
            http_response_code(403);
            echo 'Bạn chưa đăng ký khóa học này';
            return;
        }

        $materials = $materialModel->getByLesson($lessonId);
        $pageTitle = $lesson['title'];
        require __DIR__ . '/../views/student/lesson_view.php';
    }

    public function markLessonComplete()
    {
        $this->requireLogin();
        $lessonId = isset($_POST['lesson_id']) ? (int)$_POST['lesson_id'] : 0;
        $courseId = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];

        if ($lessonId > 0 && $courseId > 0) {
            $enrollmentModel = new Enrollment();
            $lessonModel = new Lesson();
            
            // Mark lesson as completed
            $lessonModel->markCompleted($lessonId, $studentId);
            
            // Update overall progress
            $lessons = $lessonModel->getByCourse($courseId);
            $completedLessons = $lessonModel->getCompletedByStudent($courseId, $studentId);
            $progress = count($lessons) > 0 ? (count($completedLessons) / count($lessons)) * 100 : 0;
            
            $enrollmentModel->updateProgress($courseId, $studentId, $progress);
        }

        header('Location: index.php?controller=Enrollment&action=progress&course_id=' . $courseId);
        exit;
    }

    public function courseMaterials()
    {
        $this->requireLogin();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $studentId = (int)$_SESSION['user_id'];

        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        $materialModel = new Material();

        // Check if student is enrolled
        if (!$enrollmentModel->isEnrolled($studentId, $courseId)) {
            $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này!';
            header('Location: index.php?controller=Course&action=index');
            exit;
        }

        $course = $courseModel->getCourseWithInstructor($courseId);
        $allMaterials = $materialModel->getByCourse($courseId);

        // Separate course-level and lesson-level materials
        $courseMaterials = [];
        $lessonMaterials = [];

        foreach ($allMaterials as $material) {
            if ($material['lesson_id'] === null) {
                $courseMaterials[] = $material;
            } else {
                if (!isset($lessonMaterials[$material['lesson_id']])) {
                    $lessonMaterials[$material['lesson_id']] = [
                        'lesson_title' => $material['lesson_title'],
                        'files' => []
                    ];
                }
                $lessonMaterials[$material['lesson_id']]['files'][] = $material;
            }
        }

        $pageTitle = 'Tài liệu khóa học - ' . htmlspecialchars($course['title']);
        require __DIR__ . '/../views/student/course_materials.php';
    }
}
