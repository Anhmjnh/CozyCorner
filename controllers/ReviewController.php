<?php
// controllers/ReviewController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/ReviewModel.php';

class ReviewController {
    public function add() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Bạn cần đăng nhập để gửi đánh giá.']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = intval($_POST['product_id'] ?? 0);
            $rating = intval($_POST['rating'] ?? 5);
            $comment = trim($_POST['comment'] ?? '');
            $user_id = $_SESSION['user_id'];

            if ($product_id <= 0 || empty($comment)) {
                echo json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập nội dung đánh giá.']);
                exit;
            }

            $reviewModel = new ReviewModel();
            if ($reviewModel->addReview($product_id, $user_id, $rating, $comment)) {
                echo json_encode(['status' => 'success', 'msg' => 'Cảm ơn bạn đã đánh giá sản phẩm!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Lỗi hệ thống, vui lòng thử lại sau.']);
            }
        }
    }
}