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
    
    // Query to get instructors from users table where role = 1
    // SỬA: Giữ nguyên tên cột như trong bảng
    $query = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.fullname,
            u.avatar,
            u.role,
            u.created_at,
            COALESCE(u.specialization, 'Lập trình web & Phát triển phần mềm') as specialization,
            COALESCE(u.bio, 'Giảng viên chuyên ngành công nghệ thông tin với nhiều năm kinh nghiệm giảng dạy') as bio,
            u.experience,  -- SỬA: Giữ nguyên tên cột
            u.courses,     -- SỬA: Giữ nguyên tên cột
            COALESCE(u.rating, 4.0) as rating,
            COALESCE(u.education, 'Đại học Công nghệ thông tin') as education
        FROM users u
        WHERE u.role = 1
        ORDER BY u.rating DESC, u.fullname ASC
        LIMIT 9
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Trong phần format data, thay thế bằng:
$formattedInstructors = [];
foreach ($instructors as $instructor) {
    // Xử lý kinh nghiệm
    $experience = $instructor['experience'];
    if (empty($experience) && isset($instructor['experience_years'])) {
        $experience = $instructor['experience_years'];
    }
    
    // Đảm bảo kinh nghiệm có đơn vị "năm"
    if (is_numeric($experience)) {
        $experience = $experience . ' năm kinh nghiệm';
    } elseif (!empty($experience) && stripos($experience, 'năm') === false) {
        $experience = $experience . ' năm kinh nghiệm';
    }
    
    // Xử lý số khóa học
    $courses = $instructor['courses'] ?? $instructor['courses_count'] ?? 0;
    
    $formattedInstructors[] = [
        'id' => $instructor['id'],
        'name' => $instructor['fullname'] ?? $instructor['username'],
        'email' => $instructor['email'],
        'specialization' => $instructor['specialization'],
        'bio' => $instructor['bio'],
        'avatar' => $instructor['avatar'],
        'experience' => $experience,
        'courses' => (int)$courses,
        'rating' => (float)$instructor['rating'],
        'education' => $instructor['education']
    ];
}
    echo json_encode([
        'success' => true,
        'instructors' => $formattedInstructors
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'instructors' => []
    ]);
}
?>