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
            SELECT r.*, u.ho_ten, u.avatar 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
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
}