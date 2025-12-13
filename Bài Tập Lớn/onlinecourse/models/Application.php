<?php
class Application {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($data) {
        $sql = 'INSERT INTO instructor_applications (fullname, email, phone, specialization, experience, education, bio, courses, availability, salary, portfolio, cv_file, status, created_at) 
                VALUES (:fullname, :email, :phone, :specialization, :experience, :education, :bio, :courses, :availability, :salary, :portfolio, :cv_file, :status, :created_at)';
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':fullname' => $data['fullname'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':specialization' => $data['specialization'],
            ':experience' => $data['experience'],
            ':education' => $data['education'],
            ':bio' => $data['bio'],
            ':courses' => $data['courses'],
            ':availability' => $data['availability'],
            ':salary' => $data['salary'],
            ':portfolio' => $data['portfolio'] ?? '',
            ':cv_file' => $data['cv_file'] ?? '',
            ':status' => 'pending',
            ':created_at' => $data['created_at']
        ]);
    }

    public function getAll() {
        $sql = 'SELECT * FROM instructor_applications ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = 'UPDATE instructor_applications SET status = :status WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function findById($id) {
        $sql = 'SELECT * FROM instructor_applications WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getApplicationsByEmail($email) {
        $sql = 'SELECT * FROM instructor_applications WHERE email = :email ORDER BY created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
