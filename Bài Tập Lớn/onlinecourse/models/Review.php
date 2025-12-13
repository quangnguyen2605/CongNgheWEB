<?php
require_once __DIR__ . '/../config/Database.php';

class Review
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    // Tạo đánh giá mới
    public function create($userId, $courseId, $rating, $comment = '')
    {
        $sql = "INSERT INTO reviews (user_id, course_id, rating, comment) 
                VALUES (:user_id, :course_id, :rating, :comment)
                ON DUPLICATE KEY UPDATE 
                rating = VALUES(rating), 
                comment = VALUES(comment),
                updated_at = CURRENT_TIMESTAMP";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':course_id' => $courseId,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    // Lấy đánh giá của user cho một khóa học
    public function getUserReview($userId, $courseId)
    {
        $sql = "SELECT * FROM reviews WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':course_id' => $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả đánh giá của một khóa học
    public function getCourseReviews($courseId, $limit = 10)
    {
        $sql = "SELECT r.*, u.fullname, u.avatar 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.course_id = :course_id 
                ORDER BY r.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đánh giá mới nhất cho trang chủ
    public function getLatestReviews($limit = 6)
    {
        $sql = "SELECT r.*, u.fullname, u.avatar, c.title as course_title
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                JOIN courses c ON r.course_id = c.id 
                WHERE c.status = 'approved'
                ORDER BY r.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tính rating trung bình của khóa học
    public function getAverageRating($courseId)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews 
                FROM reviews WHERE course_id = :course_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':course_id' => $courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xóa đánh giá
    public function delete($userId, $courseId)
    {
        $sql = "DELETE FROM reviews WHERE user_id = :user_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':user_id' => $userId, ':course_id' => $courseId]);
    }

    // Kiểm tra user đã đăng ký khóa học chưa (chỉ cho phép đánh giá nếu đã đăng ký)
    public function canUserReview($userId, $courseId)
    {
        $sql = "SELECT COUNT(*) as count FROM enrollments 
                WHERE user_id = :user_id AND course_id = :course_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId, ':course_id' => $courseId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>
