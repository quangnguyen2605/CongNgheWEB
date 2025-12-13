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
    
    if ($_POST['action'] === 'send_contact') {
        // Lấy dữ liệu từ form
        $instructorId = $_POST['instructor_id'] ?? '';
        $instructorEmail = $_POST['instructor_email'] ?? '';
        $studentName = $_POST['student_name'] ?? '';
        $studentEmail = $_POST['student_email'] ?? '';
        $studentPhone = $_POST['student_phone'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $message = $_POST['message'] ?? '';
        
        // Validate dữ liệu
        if (empty($instructorId) || empty($studentName) || empty($studentEmail) || empty($subject) || empty($message)) {
            echo json_encode([
                'success' => false,
                'message' => 'Vui lòng điền đầy đủ các trường bắt buộc.'
            ]);
            exit;
        }
        
        // Validate email
        if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'success' => false,
                'message' => 'Email không hợp lệ.'
            ]);
            exit;
        }
        
        // Lấy thông tin giảng viên
        $stmt = $pdo->prepare("SELECT fullname, email FROM users WHERE id = ? AND role = 1");
        $stmt->execute([$instructorId]);
        $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$instructor) {
            echo json_encode([
                'success' => false,
                'message' => 'Giảng viên không tồn tại.'
            ]);
            exit;
        }
        
        // Lưu tin nhắn vào database (bảng contact_messages)
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (
                instructor_id, 
                instructor_email, 
                student_name, 
                student_email, 
                student_phone, 
                subject, 
                message, 
                status, 
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())
        ");
        
        $result = $stmt->execute([
            $instructorId,
            $instructor['email'],
            $studentName,
            $studentEmail,
            $studentPhone,
            $subject,
            $message
        ]);
        
        if ($result) {
            // Gửi email thông báo cho giảng viên (nếu có mail server)
            // Trong thực tế, bạn sẽ dùng PHPMailer hoặc thư viện tương tự
            // $sendEmail = sendEmailToInstructor($instructor['email'], $studentName, $subject, $message);
            
            echo json_encode([
                'success' => true,
                'message' => 'Tin nhắn của bạn đã được gửi thành công! Giảng viên sẽ liên hệ lại sớm.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu tin nhắn. Vui lòng thử lại.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Action không hợp lệ.'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
    ]);
}
?>
