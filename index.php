<?php
// index.php - Điểm vào chính của website (MVC router đơn giản)

// 1. Include file config (BASE_URL, DB, session, v.v.)
require_once __DIR__ . '/config.php';

// 2. Bắt đầu session nếu chưa có (để dùng $_SESSION cho đăng nhập)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Lấy URL từ query string (?url=...) hoặc mặc định là trang chủ
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';
$url = filter_var($url, FILTER_SANITIZE_URL);  // Làm sạch URL để tránh tấn công
$segments = explode('/', $url);

// ---- ROUTING CHO ADMIN ----
if (isset($segments[0]) && $segments[0] === 'admin') {
    require_once __DIR__ . '/controllers/AdminController.php';
    $adminController = new AdminController();
    $adminAction = isset($segments[1]) ? $segments[1] : 'index';
    if (method_exists($adminController, $adminAction)) {
        $adminController->$adminAction();
    } else {
        echo "<h1>404 Not Found - Admin API</h1>";
    }
    exit; // Dừng luồng xử lý Front-end
}

// 4. Xác định controller và action
$controllerNameSegment = !empty($segments[0]) ? $segments[0] : 'home';

// Xử lý trường hợp đặc biệt cho GHN (viết hoa)
if (strtolower($controllerNameSegment) === 'ghn') {
    $controllerName = 'GHNController';
} else {
    $controllerName = ucfirst($controllerNameSegment) . 'Controller';
}
$action = !empty($segments[1]) ? $segments[1] : 'index';  // Mặc định action là index

// 5. Đường dẫn đến file controller
$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

// 6. Kiểm tra và load controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Tạo instance controller
    $controller = new $controllerName();

    // Kiểm tra action tồn tại thì gọi, không thì báo lỗi
    if (method_exists($controller, $action)) {
        // Gọi action với tham số nếu có (ví dụ: /product/chitiet/123 → action=chitiet, param=123)
        $params = array_slice($segments, 2);
        call_user_func_array([$controller, $action], $params);
    } else {
        // Action không tồn tại → trang 404
        echo "<h1>404 - Action không tồn tại: $action</h1>";
    }
} else {
    // Controller không tồn tại → trang 404
    //echo "<h1>404 - Controller không tồn tại: $controllerName</h1>";
}