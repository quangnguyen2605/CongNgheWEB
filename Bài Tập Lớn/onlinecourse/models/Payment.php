<?php
class Payment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createPaymentOrder($courseId, $studentId, $amount, $paymentMethod)
    {
        $sql = 'INSERT INTO payments (course_id, student_id, amount, payment_method, status, created_at) 
                VALUES (:course_id, :student_id, :amount, :payment_method, :status, NOW())';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
            ':student_id' => $studentId,
            ':amount' => $amount,
            ':payment_method' => $paymentMethod,
            ':status' => 'pending',
        ]);
        
        return $this->db->lastInsertId();
    }

    public function getPaymentById($paymentId)
    {
        $sql = 'SELECT p.*, c.title as course_title, u.fullname as student_name 
                FROM payments p 
                JOIN courses c ON p.course_id = c.id 
                JOIN users u ON p.student_id = u.id 
                WHERE p.id = :payment_id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':payment_id' => $paymentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePaymentStatus($paymentId, $status, $transactionId = null)
    {
        $sql = 'UPDATE payments SET status = :status, transaction_id = :transaction_id, updated_at = NOW() 
                WHERE id = :payment_id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':payment_id' => $paymentId,
            ':status' => $status,
            ':transaction_id' => $transactionId,
        ]);
    }

    public function getPaymentsByStudent($studentId)
    {
        $sql = 'SELECT p.*, c.title as course_title FROM payments p 
                JOIN courses c ON p.course_id = c.id 
                WHERE p.student_id = :student_id 
                ORDER BY p.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkPendingPayment($courseId, $studentId)
    {
        $sql = 'SELECT id FROM payments WHERE course_id = :course_id AND student_id = :student_id AND status = "pending" LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':course_id' => $courseId,
            ':student_id' => $studentId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
