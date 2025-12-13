<?php
// Debug script to check what's happening
echo "<h1>Debug Information</h1>";
echo "<h2>Request Details:</h2>";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "<br>";
echo "SCRIPT_NAME: " . ($_SERVER['SCRIPT_NAME'] ?? 'Not set') . "<br>";
echo "PHP_SELF: " . ($_SERVER['PHP_SELF'] ?? 'Not set') . "<br>";
echo "QUERY_STRING: " . ($_SERVER['QUERY_STRING'] ?? 'Not set') . "<br>";

echo "<h2>GET Parameters:</h2>";
echo "<pre>" . print_r($_GET, true) . "</pre>";

echo "<h2>POST Parameters:</h2>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

echo "<h2>Server Variables:</h2>";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "<br>";
echo "SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'Not set') . "<br>";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "<br>";

echo "<h2>Path Analysis:</h2>";
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH);
echo "Parsed Path: " . $path . "<br>";
echo "Is Root Path: " . (($path === '/onlinecourse/onlinecourse/' || $path === '/onlinecourse/onlinecourse') ? 'YES' : 'NO') . "<br>";

echo "<h2>File Check:</h2>";
echo "Home Index exists: " . (file_exists(__DIR__ . '/views/home/index.php') ? 'YES' : 'NO') . "<br>";
echo "Current working directory: " . __DIR__ . "<br>";
?>
