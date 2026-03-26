<?php
// models/UserModel.php
require_once __DIR__ . '/../config.php';

class UserModel {
    // Lấy thông tin user bằng số điện thoại
    public function getUserByPhone($phone) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT id, email FROM users WHERE so_dien_thoai = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $user;
    }

    // Cập nhật mật khẩu mới bằng Email
    public function updatePasswordByEmail($email, $hashedPassword) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE users SET mat_khau = ? WHERE email = ?");
        $stmt->bind_param('ss', $hashedPassword, $email);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }

    // Tự động tính toán và cập nhật hạng thành viên
    public function updateUserRank($user_id) {
        $conn = connectDB();
        
        // Tính tổng tiền các đơn hàng đã thanh toán (Hoàn Thành hoặc Đang Giao & Chuyển khoản)
        $stmt = $conn->prepare("SELECT SUM(tong_tien) as total_spent FROM orders WHERE user_id = ? AND (trang_thai = 'HoanThanh' OR (trang_thai = 'DangGiao' AND phuong_thuc_thanh_toan = 'ChuyenKhoan'))");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $totalSpent = $res['total_spent'] ?? 0;
        $stmt->close();
        
        $hang = 'Đồng';
        if ($totalSpent >= 500000) { $hang = 'Kim Cương'; } 
        elseif ($totalSpent >= 300000) { $hang = 'Vàng'; } 
        elseif ($totalSpent >= 200000) { $hang = 'Bạc'; }
        
        $stmtUpdate = $conn->prepare("UPDATE users SET hang = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $hang, $user_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();
        $conn->close();
    }
}