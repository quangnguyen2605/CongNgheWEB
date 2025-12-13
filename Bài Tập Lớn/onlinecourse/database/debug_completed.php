<?php
require_once __DIR__ . '/../config/Database.php';

$studentId = 1; // Thay bằng ID học viên thực tế
$lessonId = 1; // Thay bằng ID bài học thực tế

try {
    $db = Database::getInstance()->getConnection();
    
    // Kiểm tra bảng có tồn tại không
    $tables = $db->query("SHOW TABLES LIKE 'completed_lessons'")->fetchAll();
    echo "Bảng completed_lessons: " . (count($tables) > 0 ? "Đã tồn tại" : "Chưa tồn tại") . "\n";
    
    if (count($tables) > 0) {
        // Kiểm tra dữ liệu
        $sql = "SELECT * FROM completed_lessons WHERE student_id = ? AND lesson_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$studentId, $lessonId]);
        $completed = $stmt->fetchAll();
        
        echo "Dữ liệu completed_lessons cho student=$studentId, lesson=$lessonId: " . count($completed) . " records\n";
        
        // Hiển thị tất cả dữ liệu
        $all = $db->query("SELECT * FROM completed_lessons")->fetchAll();
        echo "Tổng số records trong completed_lessons: " . count($all) . "\n";
    }
    
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
