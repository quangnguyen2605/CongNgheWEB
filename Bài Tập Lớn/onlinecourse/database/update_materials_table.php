<?php
// Script to update materials table structure
require_once __DIR__ . '/../config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    echo "Updating materials table structure...\n";
    
    // Check if course_id column exists
    $checkColumn = $db->query("SHOW COLUMNS FROM materials LIKE 'course_id'");
    $courseIdExists = $checkColumn->rowCount() > 0;
    
    if (!$courseIdExists) {
        // Add course_id column
        echo "Adding course_id column...\n";
        $db->exec("ALTER TABLE materials ADD COLUMN course_id INT NULL AFTER lesson_id");
        
        // Add foreign key constraint
        echo "Adding foreign key constraint for course_id...\n";
        $db->exec("ALTER TABLE materials ADD CONSTRAINT fk_materials_course 
                   FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE");
    } else {
        echo "course_id column already exists.\n";
    }
    
    // Check if description column exists
    $checkDescColumn = $db->query("SHOW COLUMNS FROM materials LIKE 'description'");
    $descExists = $checkDescColumn->rowCount() > 0;
    
    if (!$descExists) {
        // Add description column
        echo "Adding description column...\n";
        $db->exec("ALTER TABLE materials ADD COLUMN description TEXT NULL AFTER file_type");
    } else {
        echo "description column already exists.\n";
    }
    
    // Check if uploaded_at column exists
    $checkDateColumn = $db->query("SHOW COLUMNS FROM materials LIKE 'uploaded_at'");
    $dateExists = $checkDateColumn->rowCount() > 0;
    
    if (!$dateExists) {
        // Add uploaded_at column if it doesn't exist
        echo "Adding uploaded_at column...\n";
        $db->exec("ALTER TABLE materials ADD COLUMN uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    } else {
        echo "uploaded_at column already exists.\n";
    }
    
    // Add indexes for better performance
    echo "Adding indexes...\n";
    
    // Check if index exists before adding
    $checkIndex = $db->query("SHOW INDEX FROM materials WHERE Key_name = 'idx_course_id'");
    if ($checkIndex->rowCount() == 0) {
        $db->exec("CREATE INDEX idx_course_id ON materials(course_id)");
    }
    
    $checkIndex = $db->query("SHOW INDEX FROM materials WHERE Key_name = 'idx_lesson_id'");
    if ($checkIndex->rowCount() == 0) {
        $db->exec("CREATE INDEX idx_lesson_id ON materials(lesson_id)");
    }
    
    echo "Materials table updated successfully!\n";
    
    // Show current table structure
    echo "\nCurrent materials table structure:\n";
    $result = $db->query("DESCRIBE materials");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']}: {$row['Type']} ({$row['Null']}, {$row['Key']})\n";
    }
    
} catch (Exception $e) {
    echo "Error updating materials table: " . $e->getMessage() . "\n";
}
?>
