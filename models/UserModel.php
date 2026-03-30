<?php
// models/UserModel.php
require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model {
    // Lấy thông tin user bằng số điện thoại
    public function getUserByPhone($phone) {
        $stmt = $this->conn->prepare("SELECT id, email FROM users WHERE so_dien_thoai = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Lấy thông tin user bằng email 
    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT id, ho_ten, mat_khau, trang_thai FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Cập nhật mật khẩu mới bằng Email
    public function updatePasswordByEmail($email, $hashedPassword) {
        $stmt = $this->conn->prepare("UPDATE users SET mat_khau = ? WHERE email = ?");
        $stmt->bind_param('ss', $hashedPassword, $email);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Tự động tính toán và cập nhật hạng thành viên
    public function updateUserRank($user_id) {
        // Tính tổng tiền các đơn hàng đã thanh toán (Hoàn Thành hoặc Đang Giao & Chuyển khoản)
        $stmt = $this->conn->prepare("SELECT SUM(tong_tien) as total_spent FROM orders WHERE user_id = ? AND (trang_thai = 'HoanThanh' OR (trang_thai = 'DangGiao' AND phuong_thuc_thanh_toan = 'ChuyenKhoan'))");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $totalSpent = $res['total_spent'] ?? 0;
        $stmt->close();
        
        $hang = 'Đồng';
        if ($totalSpent >= 500000) { $hang = 'Kim Cương'; } 
        elseif ($totalSpent >= 300000) { $hang = 'Vàng'; } 
        elseif ($totalSpent >= 200000) { $hang = 'Bạc'; }
        
        $stmtUpdate = $this->conn->prepare("UPDATE users SET hang = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $hang, $user_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function incrementUserChatCount($user_id) {
        $stmt = $this->conn->prepare("UPDATE users SET chat_daily_count = chat_daily_count + 1 WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
        return false;
    }

    public function resetUserChatCount($user_id) {
        $stmt = $this->conn->prepare("UPDATE users SET chat_daily_count = 0, last_chat_date = CURDATE() WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
        return false;
    }

    public function updateUserProfile($id, $ho_ten, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $avatar = null, $mat_khau = null) {
        $sql = "UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ?";
        $params = [$ho_ten, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh];
        $types = "sssss";
        if ($avatar) {
            $sql .= ", avatar = ?";
            $params[] = $avatar;
            $types .= "s";
        }
        if ($mat_khau) {
            $sql .= ", mat_khau = ?";
            $params[] = $mat_khau;
            $types .= "s";
        }
        $sql .= " WHERE id = ?";
        $params[] = $id;
        $types .= "i";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}