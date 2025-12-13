<?php
require_once __DIR__ . '/../config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Kiểm tra cột other đã tồn tại chưa
    $checkColumn = $db->query("SHOW COLUMNS FROM users LIKE 'other'");
    
    if ($checkColumn->rowCount() == 0) {
        // Thêm cột other nếu chưa tồn tại
        $sql = "ALTER TABLE users ADD COLUMN other TEXT NULL AFTER education";
        $db->exec($sql);
        echo "Đã thêm cột 'other' vào bảng users thành công!";
    } else {
        echo "Cột 'other' đã tồn tại trong bảng users!";
    }
    
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
