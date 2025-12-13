<?php
require_once __DIR__ . '/../config/Database.php';

class Course
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getApprovedCourseCount()
    {
        $sql = 'SELECT COUNT(*) as count FROM courses WHERE status = "approved"';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getAverageRating()
    {
        $sql = 'SELECT AVG(rating) as avg_rating FROM courses WHERE status = "approved" AND rating > 0';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $avgRating = $result['avg_rating'] ?? 0;
        // Convert to percentage (multiply by 20 since rating is 1-5 scale)
        return round($avgRating * 20, 1);
    }

    public function getFeaturedCourses($limit = 8)
    {
        $sql = 'SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id 
                WHERE c.status = "approved" 
                ORDER BY c.created_at DESC 
                LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllApproved()
    {
        $sql = 'SELECT c.*, u.fullname as instructor_name 
                FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                WHERE c.status = "approved" 
                ORDER BY c.created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM courses ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($keyword = '', $categoryId = null)
    {
        $sql = 'SELECT * FROM courses WHERE 1=1';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' AND (title LIKE :kw OR description LIKE :kw)';
            $params[':kw'] = '%' . $keyword . '%';
        }

        if (!empty($categoryId)) {
            $sql .= ' AND category_id = :cat_id';
            $params[':cat_id'] = (int)$categoryId;
        }

        $sql .= ' ORDER BY created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchApproved($keyword = '', $categoryId = null)
    {
        // First, check if status column exists
        $checkColumn = $this->db->query("SHOW COLUMNS FROM courses LIKE 'status'");
        $statusColumnExists = $checkColumn->rowCount() > 0;
        
        $sql = 'SELECT c.*, cat.name as category_name, u.fullname as instructor_name 
                FROM courses c 
                LEFT JOIN categories cat ON c.category_id = cat.id 
                LEFT JOIN users u ON c.instructor_id = u.id 
                WHERE 1=1';
                
        // Only add status filter if the column exists
        if ($statusColumnExists) {
            $sql .= ' AND c.status = "approved"';
        }
        
        $params = [];

        if ($keyword !== '') {
            $sql .= ' AND (c.title LIKE :kw OR c.description LIKE :kw)';
            $params[':kw'] = '%' . $keyword . '%';
        }

        if (!empty($categoryId)) {
            $sql .= ' AND c.category_id = :cat_id';
            $params[':cat_id'] = (int)$categoryId;
        }

        $sql .= ' ORDER BY c.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseWithInstructor($id)
    {
        $sql = 'SELECT c.*, cat.name as category_name, u.fullname as instructor_name 
                FROM courses c 
                LEFT JOIN categories cat ON c.category_id = cat.id 
                LEFT JOIN users u ON c.instructor_id = u.id 
                WHERE c.id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = 'SELECT * FROM courses WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByInstructor($instructorId)
    {
        $sql = 'SELECT * FROM courses WHERE instructor_id = :instructor_id ORDER BY created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':instructor_id' => $instructorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = 'INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, status, created_at, updated_at) 
                VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, :status, NOW(), NOW())';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':instructor_id' => $data['instructor_id'],
            ':category_id' => $data['category_id'],
            ':price' => $data['price'],
            ':duration_weeks' => $data['duration_weeks'],
            ':level' => $data['level'],
            ':image' => $data['image'] ?? '',
            ':status' => 'pending', // New courses start as pending
        ]);
    }

    public function update($id, $data)
    {
        $sql = 'UPDATE courses SET title = :title, description = :description, category_id = :category_id, price = :price,
                duration_weeks = :duration_weeks, level = :level, image = :image, updated_at = NOW()
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':category_id' => $data['category_id'],
            ':price' => $data['price'],
            ':duration_weeks' => $data['duration_weeks'],
            ':level' => $data['level'],
            ':image' => $data['image'] ?? '',
            ':id' => $id,
        ]);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM courses WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function updateStatus($id, $status)
    {
        $sql = 'UPDATE courses SET status = :status, updated_at = NOW() WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }

    public function getPendingApproval()
    {
        $sql = 'SELECT c.*, u.fullname as instructor_name, cat.name as category_name FROM courses c 
                JOIN users u ON c.instructor_id = u.id 
                LEFT JOIN categories cat ON c.category_id = cat.id
                WHERE c.status = "pending"
                ORDER BY c.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApproved()
    {
        $sql = 'SELECT c.*, u.fullname as instructor_name FROM courses c 
                LEFT JOIN users u ON c.instructor_id = u.id 
                WHERE c.status = "approved" 
                ORDER BY c.created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
