<?php
// models/ReviewModel.php
require_once __DIR__ . '/../config.php';

class ReviewModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getReviewsByProductId($product_id) {
        $stmt = $this->conn->prepare("
            SELECT r.*, IFNULL(u.ho_ten, 'Người dùng đã xóa') AS ho_ten, IFNULL(u.avatar, 'default-avatar.png') AS avatar 
            FROM reviews r 
            LEFT JOIN users u ON r.user_id = u.id 
            WHERE r.product_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function addReview($product_id, $user_id, $rating, $comment) {
        $stmt = $this->conn->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function updateReview($review_id, $user_id, $rating, $comment) {
        $stmt = $this->conn->prepare("UPDATE reviews SET rating = ?, comment = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("isii", $rating, $comment, $review_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function deleteReview($review_id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM reviews WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $review_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}