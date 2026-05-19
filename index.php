<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/core/Router.php';

// Đảm bảo PHP luôn chạy theo múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo Router (Bộ định tuyến trung tâm của hệ thống)
$app = new Router();