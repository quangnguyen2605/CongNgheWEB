<?php
require_once 'config/Database.php';
require_once 'models/User.php';

$db = Database::getInstance()->getConnection();
$user = new User(Database::getInstance());

echo "=== DEBUG OTHER COLUMN ===\n";

// Kiểm tra cột other có tồn tại không
echo "1. Checking if 'other' column exists...\n";
$result = $db->query("DESCRIBE users");
$otherColumnExists = false;
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if($row['Field'] === 'other') {
        echo "Column 'other' exists: " . $row['Type'] . "\n";
        $otherColumnExists = true;
        break;
    }
}

if (!$otherColumnExists) {
    echo "ERROR: Column 'other' does not exist!\n";
    exit;
}

// Kiểm tra users có cột other
echo "\n2. Checking users with 'other' column...\n";
$users = $db->query("SELECT id, username, email, other FROM users WHERE other IS NOT NULL AND other != '' LIMIT 10");
$data = $users->fetchAll(PDO::FETCH_ASSOC);

if(empty($data)) {
    echo "No users with 'other' column found\n";
    echo "All users have empty 'other' column\n";
} else {
    echo "Found " . count($data) . " users with 'other' column:\n";
    foreach($data as $u) {
        echo "ID: {$u['id']}, Email: {$u['email']}, Other: {$u['other']}\n";
    }
}

// Test findByOther method
echo "\n3. Testing findByOther method...\n";
$testLinks = [
    'https://facebook.com/test',
    'https://www.facebook.com/test',
    'https://plus.google.com/test',
    'https://accounts.google.com',
    'https://www.facebook.com/quang.nguyen.490818/',
    'https://facebook.com/quang.nguyen.490818/',
    'https://www.facebook.com/quang.nguyen.490818'
];

foreach($testLinks as $link) {
    $foundUser = $user->findByOther($link);
    echo "Searching for: $link\n";
    if($foundUser) {
        echo "  FOUND: ID {$foundUser['id']}, Email {$foundUser['email']}, Other: '{$foundUser['other']}'\n";
    } else {
        echo "  NOT FOUND\n";
    }
}

echo "\n4. Sample user data:\n";
$allUsers = $db->query("SELECT id, username, email, other FROM users LIMIT 5");
$sampleData = $allUsers->fetchAll(PDO::FETCH_ASSOC);
foreach($sampleData as $u) {
    echo "ID: {$u['id']}, Username: {$u['username']}, Email: {$u['email']}, Other: " . ($u['other'] ?? 'NULL') . "\n";
}
?>
