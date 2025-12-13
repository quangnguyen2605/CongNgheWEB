<?php
// File này để tạo bảng completed_lessons
require_once __DIR__ . '/../config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Tạo bảng completed_lessons
    $sql = 'CREATE TABLE IF NOT EXISTS completed_lessons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        lesson_id INT NOT NULL,
        course_id INT NOT NULL,
        completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_student_lesson (student_id, lesson_id),
        FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
        FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
    )';
    
    $db->exec($sql);
    
    // Thêm index để tối ưu performance
    $db->exec('CREATE INDEX IF NOT EXISTS idx_student_course ON completed_lessons(student_id, course_id)');
    $db->exec('CREATE INDEX IF NOT EXISTS idx_completed_at ON completed_lessons(completed_at)');
    
    echo "Bảng completed_lessons đã được tạo thành công!";
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
