<?php
class LessonController
{
    private function requireInstructor()
    {
        if (empty($_SESSION['user_id']) || (int)($_SESSION['user_role'] ?? 0) !== 1) {
            header('Location: index.php?controller=Auth&action=login');
            exit;
        }
    }

    public function index()
    {
    }

    public function view()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $lessonModel = new Lesson();
        $materialModel = new Material();
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();

        // Lấy thông tin bài học
        $sql = 'SELECT * FROM lessons WHERE id = :id LIMIT 1';
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lesson) {
            http_response_code(404);
            echo 'Bài học không tồn tại';
            return;
        }

        $materials = $materialModel->getByLesson($id);
        
        // Get course info
        $course = $courseModel->getCourseWithInstructor($lesson['course_id']);
        
        // Get all lessons for navigation
        $allLessons = $lessonModel->getByCourse($lesson['course_id']);
        
        // Check if lesson is completed (for logged in students)
        $isCompleted = false;
        if (isset($_SESSION['user_id']) && (int)($_SESSION['user_role'] ?? 0) === 0) {
            $studentId = (int)$_SESSION['user_id'];
            if ($enrollmentModel->isEnrolled($studentId, $lesson['course_id'])) {
                $isCompleted = $enrollmentModel->getLessonProgress($lesson['course_id'], $studentId, $id) !== false;
            }
        }

        $pageTitle = $lesson['title'];
        require __DIR__ . '/../views/student/lesson_view.php';
    }

    // Giảng viên quản lý bài học theo khóa học
    public function manage()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $lessonModel = new Lesson();
        $courseModel = new Course();

        $course = $courseModel->findById($courseId);
        $lessons = $lessonModel->getByCourse($courseId);

        $pageTitle = 'Quản lý bài học - ' . ($course['title'] ?? '');
        require __DIR__ . '/../views/instructor/lessons/manage.php';
    }

    public function create()
    {
        $this->requireInstructor();
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        $pageTitle = 'Thêm bài học';
        require __DIR__ . '/../views/instructor/lessons/create.php';
    }

    public function store()
    {
        $this->requireInstructor();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel = new Lesson();
            $lessonModel->create([
                'course_id' => (int)($_POST['course_id'] ?? 0),
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'video_url' => $_POST['video_url'] ?? '',
                'order' => (int)($_POST['order'] ?? 0),
            ]);
        }

        $courseId = (int)($_POST['course_id'] ?? 0);
        header('Location: index.php?controller=Lesson&action=manage&course_id=' . $courseId);
        exit;
    }

    public function edit()
    {
        $this->requireInstructor();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($id);
        $pageTitle = 'Chỉnh sửa bài học';
        require __DIR__ . '/../views/instructor/lessons/edit.php';
    }

    public function update()
    {
        $this->requireInstructor();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0) {
            $lessonModel = new Lesson();
            $lessonModel->update($id, [
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'video_url' => $_POST['video_url'] ?? '',
                'order' => (int)($_POST['order'] ?? 0),
            ]);
        }

        $courseId = (int)($_POST['course_id'] ?? 0);
        header('Location: index.php?controller=Lesson&action=manage&course_id=' . $courseId);
        exit;
    }

    public function delete()
    {
        $this->requireInstructor();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;

        if ($id > 0) {
            $lessonModel = new Lesson();
            $lessonModel->delete($id);
        }

        header('Location: index.php?controller=Lesson&action=manage&course_id=' . $courseId);
        exit;
    }

    // Upload tài liệu cho bài học
    public function uploadMaterial()
    {
        $this->requireInstructor();
        $lessonId = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['material']) && $_FILES['material']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'assets/uploads/materials/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $name = basename($_FILES['material']['name']);
                $targetPath = $uploadDir . time() . '_' . $name;

                if (move_uploaded_file($_FILES['material']['tmp_name'], $targetPath)) {
                    $materialModel = new Material();
                    $materialModel->create([
                        'lesson_id' => $lessonId,
                        'filename' => $name,
                        'file_path' => $targetPath,
                        'file_type' => pathinfo($name, PATHINFO_EXTENSION),
                    ]);
                    $_SESSION['success'] = 'Tải tài liệu thành công!';
                } else {
                    $_SESSION['error'] = 'Không thể tải tài liệu';
                }
            } else {
                $_SESSION['error'] = 'Vui lòng chọn file để tải lên';
            }

            header('Location: index.php?controller=Lesson&action=manageMaterials&lesson_id=' . $lessonId);
            exit;
        }

        // Get lesson information for the view
        $lessonModel = new Lesson();
        $lesson = $lessonModel->findById($lessonId);
        
        $pageTitle = 'Tải tài liệu lên';
        require __DIR__ . '/../views/instructor/materials/upload.php';
    }

    public function manageMaterials()
    {
        $this->requireInstructor();
        $lessonId = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;
        
        $lessonModel = new Lesson();
        $materialModel = new Material();
        
        $lesson = $lessonModel->findById($lessonId);
        $materials = $materialModel->getByLesson($lessonId);
        
        $pageTitle = 'Quản lý tài liệu - ' . ($lesson['title'] ?? '');
        require __DIR__ . '/../views/instructor/materials/manage.php';
    }

    public function deleteMaterial()
    {
        $this->requireInstructor();
        $materialId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $lessonId = isset($_GET['lesson_id']) ? (int)$_GET['lesson_id'] : 0;
        
        if ($materialId > 0) {
            $materialModel = new Material();
            $material = $materialModel->findById($materialId);
            
            // Delete file from filesystem
            if ($material && file_exists($material['file_path'])) {
                unlink($material['file_path']);
            }
            
            $materialModel->delete($materialId);
            $_SESSION['success'] = 'Xóa tài liệu thành công';
        }
        
        header('Location: index.php?controller=Lesson&action=manageMaterials&lesson_id=' . $lessonId);
        exit;
    }
}
