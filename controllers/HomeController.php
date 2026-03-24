<?php
// controllers/HomeController.php
class HomeController {
    public function index() {
        // Sửa đường dẫn include view đúng
        require_once __DIR__ . '/../view/TrangChu.php';
        // Hoặc dùng đường dẫn tuyệt đối từ gốc dự án để an toàn hơn:
        // require_once __DIR__ . '/../views/home/TrangChu.php';
    }
}
?>