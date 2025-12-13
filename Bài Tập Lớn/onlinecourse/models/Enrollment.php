<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getEnrolledCount($courseId)
    {
        $sql = 'SELECT COUNT(*) as count FROM enrollments WHERE course_id = :course_id AND status = "active"';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['count'] : 0;
    }

    public function enroll($courseId, $studentId)
    {
        $sql = 'INSERT INTO enrollments (course_id, student_id, enrolled_date, status, progress) VALUES (:course_id, :student_id, NOW(), :status, :progress)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':course_id' => $courseId,
            ':student_id' => $studentId,
            ':status' => 'active',
            ':progress' => 0,
        ]);
    }

    public function getByStudent($studentId)
    {
        $sql = 'SELECT e.*, c.title, c.image FROM enrollments e JOIN courses c ON e.course_id = c.id WHERE e.student_id = :student_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($courseId, $studentId)
    {
        $sql = 'SELECT * FROM enrollments WHERE course_id = :course_id AND student_id = :student_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
            ':student_id' => $studentId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isEnrolled($studentId, $courseId)
    {
        $sql = 'SELECT id FROM enrollments WHERE student_id = :student_id AND course_id = :course_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':student_id' => $studentId,
            ':course_id' => $courseId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function updateProgress($courseId, $studentId, $progress)
    {
        $sql = 'UPDATE enrollments SET progress = :progress WHERE course_id = :course_id AND student_id = :student_id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':progress' => $progress,
            ':course_id' => $courseId,
            ':student_id' => $studentId,
        ]);
    }

    public function completeLesson($courseId, $studentId, $lessonId)
    {
        // Get enrollment record
        $enrollment = $this->getOne($courseId, $studentId);
        if (!$enrollment) {
            return false;
        }
        
        // Insert completed lesson record
        $sql = 'INSERT IGNORE INTO completed_lessons (student_id, lesson_id, course_id) VALUES (:student_id, :lesson_id, :course_id)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':student_id' => $studentId,
            ':lesson_id' => $lessonId,
            ':course_id' => $courseId,
        ]);
        
        // Calculate new progress
        $lessons = $this->db->prepare('SELECT COUNT(*) as total FROM lessons WHERE course_id = :course_id');
        $lessons->execute([':course_id' => $courseId]);
        $totalLessons = $lessons->fetchColumn();
        
        // Get completed lessons count
        $completed = $this->db->prepare('SELECT COUNT(*) as completed FROM completed_lessons WHERE course_id = :course_id AND student_id = :student_id');
        $completed->execute([':course_id' => $courseId, ':student_id' => $studentId]);
        $completedCount = $completed->fetchColumn();
        
        $newProgress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100, 1) : 100;
        
        return $this->updateProgress($courseId, $studentId, min($newProgress, 100));
    }

    public function getLessonProgress($courseId, $studentId, $lessonId)
    {
        // Check if lesson is completed
        $sql = 'SELECT id FROM completed_lessons WHERE student_id = :student_id AND lesson_id = :lesson_id AND course_id = :course_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':student_id' => $studentId,
            ':lesson_id' => $lessonId,
            ':course_id' => $courseId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function getEnrollmentWithProgress($courseId, $studentId)
    {
        $sql = 'SELECT e.*, c.title, c.image FROM enrollments e 
                JOIN courses c ON e.course_id = c.id 
                WHERE e.course_id = :course_id AND e.student_id = :student_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
            ':student_id' => $studentId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteByCourse($courseId)
    {
        // Delete completed lessons first
        $sql = 'DELETE FROM completed_lessons WHERE course_id = :course_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        
        // Delete enrollments
        $sql = 'DELETE FROM enrollments WHERE course_id = :course_id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':course_id' => $courseId]);
    }
    
    public function findByUserAndCourse($userId, $courseId)
    {
        $sql = 'SELECT * FROM enrollments WHERE student_id = :user_id AND course_id = :course_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':course_id' => $courseId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
