<?php
// Script to add status column to courses table for approval workflow
require_once __DIR__ . '/../config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    echo "Adding status column to courses table...\n";
    
    // Check if status column exists
    $checkColumn = $db->query("SHOW COLUMNS FROM courses LIKE 'status'");
    $statusExists = $checkColumn->rowCount() > 0;
    
    if (!$statusExists) {
        // Add status column
        echo "Adding status column...\n";
        $db->exec("ALTER TABLE courses ADD COLUMN status VARCHAR(20) DEFAULT 'pending' AFTER price");
        
        // Add index for better performance
        $db->exec("CREATE INDEX idx_course_status ON courses(status)");
        
        // Update existing courses to 'approved' so they remain visible
        echo "Updating existing courses to approved status...\n";
        $db->exec("UPDATE courses SET status = 'approved' WHERE status IS NULL OR status = 'pending'");
        
        echo "Status column added successfully!\n";
    } else {
        echo "Status column already exists.\n";
    }
    
    // Show current table structure
    echo "\nCurrent courses table structure:\n";
    $result = $db->query("DESCRIBE courses");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']}: {$row['Type']} ({$row['Null']}, {$row['Key']}, Default: {$row['Default']})\n";
    }
    
    // Show course status distribution
    echo "\nCourse status distribution:\n";
    $result = $db->query("SELECT status, COUNT(*) as count FROM courses GROUP BY status");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['status']}: {$row['count']} courses\n";
    }
    
} catch (Exception $e) {
    echo "Error adding status column: " . $e->getMessage() . "\n";
}
?>
