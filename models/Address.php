<?php
// models/Address.php
require_once __DIR__ . '/../config.php';

class Address {
    public static function getAllByUserId($userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC, id DESC");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        $conn->close();
        return $data;
    }

    public static function getById($id, $userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->bind_param('ii', $id, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        $conn->close();
        return $data;
    }

    // Lấy địa chỉ hồ sơ gốc (bảng users)
    public static function getProfileAddress($userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT ho_ten as ten_nguoi_nhan, so_dien_thoai, dia_chi FROM users WHERE id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $data;
    }

    // Cập nhật địa chỉ hồ sơ gốc (bảng users)
    public static function updateProfileAddress($userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE users SET ho_ten = ?, so_dien_thoai = ?, dia_chi = ? WHERE id = ?");
        $stmt->bind_param('sssi', $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $userId);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }

    public static function resetDefault($userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    public static function add($userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default) {
        if ($is_default) self::resetDefault($userId);
        $conn = connectDB();
        try {
            $stmt = $conn->prepare("INSERT INTO user_addresses (user_id, ten_nguoi_nhan, so_dien_thoai, dia_chi, is_default) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('isssi', $userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default);
            $success = $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            $success = false;
        }
        $conn->close();
        return $success;
    }

    public static function update($id, $userId, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default) {
        if ($is_default) self::resetDefault($userId);
        $conn = connectDB();
        try {
            $stmt = $conn->prepare("UPDATE user_addresses SET ten_nguoi_nhan = ?, so_dien_thoai = ?, dia_chi = ?, is_default = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param('ssssii', $ten_nguoi_nhan, $so_dien_thoai, $dia_chi, $is_default, $id, $userId);
            $success = $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            $success = false;
        }
        $conn->close();
        return $success;
    }

    public static function delete($id, $userId) {
        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->bind_param('ii', $id, $userId);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;
    }
}