<?php
// models/ContactModel.php
require_once __DIR__ . '/../config.php';

class ContactModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function saveContact($ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung) {
        $stmt = $this->conn->prepare("
            INSERT INTO contacts (ho_ten, email, so_dien_thoai, tieu_de, noi_dung) 
            VALUES (?, ?, ?, ?, ?)
        ");
        
        if (!$stmt) return false;
        
        $stmt->bind_param("sssss", $ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}