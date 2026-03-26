<?php
require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);
$segments = explode('/', $url);

// ---- ROUTING CHO ADMIN ----
if (isset($segments[0]) && $segments[0] === 'admin') {
    require_once __DIR__ . '/controllers/AdminController.php';
    $adminController = new AdminController();
    $adminAction = isset($segments[1]) ? $segments[1] : 'index';
    if (method_exists($adminController, $adminAction)) {
        $adminController->$adminAction();
    } else {
        echo "<h1>404 Not Found </h1>";
    }
    exit; // 
}

$controllerNameSegment = !empty($segments[0]) ? $segments[0] : 'home';

if (strtolower($controllerNameSegment) === 'ghn') {
    $controllerName = 'GHNController';
} else {
    $controllerName = ucfirst($controllerNameSegment) . 'Controller';
}
$action = !empty($segments[1]) ? $segments[1] : 'index';

$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();

    if (method_exists($controller, $action)) {

        $params = array_slice($segments, 2);
        call_user_func_array([$controller, $action], $params);
    } else {
        echo "<h1>404 - Action không tồn tại: $action</h1>";
    }
} else {

}