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
    
    // Debug: Check if reviews table exists and has data
    $checkQuery = "SELECT COUNT(*) as total FROM reviews";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute();
    $totalReviews = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    error_log("Total reviews in database: " . $totalReviews['total']);
    
    // Query to get reviews from reviews table with correct field names
    $query = "
        SELECT 
            r.id,
            r.user_id,
            r.course_id,
            r.rating,
            r.comment,
            r.created_at,
            r.updated_at,
            u.username as student_name,
            c.title as course_title
        FROM reviews r
        LEFT JOIN users u ON r.user_id = u.id
        LEFT JOIN courses c ON r.course_id = c.id
        ORDER BY r.created_at DESC
        LIMIT 6
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    error_log("Reviews found: " . count($reviews));
    
    // Format data for frontend
    $formattedReviews = [];
    foreach ($reviews as $review) {
        $formattedReviews[] = [
            'id' => $review['id'],
            'name' => $review['student_name'] ?? ('Học viên ' . $review['user_id']),
            'email' => '',
            'role' => 'Học viên khóa ' . ($review['course_title'] ?? 'khóa học'),
            'text' => $review['comment'],
            'rating' => (int)$review['rating'],
            'course_title' => $review['course_title'] ?? 'Khóa học',
            'created_at' => $review['created_at'],
            'updated_at' => $review['updated_at']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'testimonials' => $formattedReviews,
        'debug' => [
            'total_reviews' => $totalReviews['total'],
            'found_reviews' => count($reviews)
        ]
    ]);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
        'testimonials' => []
    ]);
}
?>
