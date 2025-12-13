<?php
session_start();

// Debug information
error_log("Index.php accessed - REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Not set'));
error_log("GET parameters: " . print_r($_GET, true));

// Debug: Check if we're accessing the root
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($requestUri, PHP_URL_PATH);
error_log("Path: " . $path);

// Check if this is the root path
if ($path === '/onlinecourse/onlinecourse/' || $path === '/onlinecourse/onlinecourse') {
    error_log("Root path detected, loading home index");
    require __DIR__ . '/views/home/index.php';
    exit;
}

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/config/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

if (empty($_GET['controller'])) {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    error_log("No controller specified, loading home index");
    require __DIR__ . '/views/home/index.php';
    exit;
}

$controllerName = ucfirst($_GET['controller']) . 'Controller';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "Controller not found";
    exit;
}

$controller = new $controllerName();

if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    echo "Action not found";
    exit;
}

$controller->{$actionName}();
