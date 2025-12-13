<?php
class PublicController
{
    public function viewCourse()
    {
        $courseId = isset($_GET['course_id']) ? (int)$_GET['course_id'] : 0;
        
        if ($courseId === 0) {
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $courseModel = new Course();
        $course = $courseModel->getCourseWithInstructor($courseId);
        
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại!';
            header('Location: index.php?controller=Student&action=browseCourses');
            exit;
        }
        
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($courseId);
        
        // Get enrolled students count
        $enrollmentModel = new Enrollment();
        $enrolledCount = $enrollmentModel->getEnrolledCount($courseId);
        
        $pageTitle = $course['title'] . ' - Khóa học';
        require __DIR__ . '/../views/public/course_view.php';
    }
    
    public function browseCourses()
    {
        $courseModel = new Course();
        $courses = $courseModel->getAllApproved();
        
        $pageTitle = 'Danh sách khóa học';
        require __DIR__ . '/../views/public/course_list.php';
    }
}
?>
