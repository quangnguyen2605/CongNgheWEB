<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$dbname = 'onlinecourse';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['user_id']) || !isset($input['status'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.'
        ]);
        exit;
    }
    
    $userId = (int)$input['user_id'];
    $status = $input['status'];
    
    // Validate status
    if (!in_array($status, ['active', 'inactive'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Trạng thái không hợp lệ.'
        ]);
        exit;
    }
    
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode([
            'success' => false,
            'message' => 'Người dùng không tồn tại.'
        ]);
        exit;
    }
    
    // Update user status
    $stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $result = $stmt->execute([$status, $userId]);
    
    if ($result) {
        $action = $status === 'active' ? 'kích hoạt' : 'vô hiệu hóa';
        echo json_encode([
            'success' => true,
            'message' => "Đã {$action} người dùng '{$user['username']}' thành công."
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật trạng thái người dùng.'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi xảy ra. Vui lòng thử lại.',
        'error' => $e->getMessage()
    ]);
}
?>
