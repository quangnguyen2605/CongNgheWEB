<?php
require_once 'config/Database.php';

$db = Database::getInstance()->getConnection();
$result = $db->query('DESCRIBE users');

echo "=== COLUMNS IN USERS TABLE ===\n";
while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}
?>
