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

    public function update() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Bạn cần đăng nhập để sửa đánh giá.']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $review_id = intval($_POST['review_id'] ?? 0);
            $rating = intval($_POST['rating'] ?? 5);
            $comment = trim($_POST['comment'] ?? '');
            $user_id = $_SESSION['user_id'];

            if ($review_id <= 0 || empty($comment)) {
                echo json_encode(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ.']);
                exit;
            }

            $reviewModel = new ReviewModel();
            if ($reviewModel->updateReview($review_id, $user_id, $rating, $comment)) {
                echo json_encode(['status' => 'success', 'msg' => 'Cập nhật đánh giá thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Lỗi hệ thống, vui lòng thử lại sau.']);
            }
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Bạn cần đăng nhập để xóa đánh giá.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $review_id = intval($data['review_id'] ?? 0);
        $user_id = $_SESSION['user_id'];

        if ($review_id > 0) {
            $reviewModel = new ReviewModel();
            if ($reviewModel->deleteReview($review_id, $user_id)) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa đánh giá thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa đánh giá này.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ.']);
        }
    }
}