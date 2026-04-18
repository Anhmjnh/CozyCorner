<?php
// models/AddressModel.php
require_once __DIR__ . '/../core/Model.php';

class AddressModel extends Model {
    
    // Lấy toàn bộ sổ địa chỉ của 1 user
    public function getUserAddresses($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM user_addresses WHERE user_id = ? ORDER BY is_default DESC, id DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy địa chỉ mặc định
    public function getDefaultAddress($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM user_addresses WHERE user_id = ? AND is_default = 1 LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lấy 1 địa chỉ cụ thể (để nạp vào form sửa)
    public function getAddressById($id, $user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm địa chỉ mới
    public function addAddress($data) {
        if (!empty($data['is_default'])) {
            $this->resetDefault($data['user_id']); // Nếu set mặc định, gỡ mặc định các cái cũ
        } else {
            // Nếu user chưa có địa chỉ nào, ép cái đầu tiên thêm vào thành mặc định
            $existing = $this->getUserAddresses($data['user_id']);
            if (empty($existing)) {
                $data['is_default'] = 1;
            }
        }

        $sql = "INSERT INTO user_addresses (user_id, ho_ten, so_dien_thoai, province_id, district_id, ward_code, province_name, district_name, ward_name, dia_chi_chi_tiet, loai_dia_chi, is_default) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issiissssssi", 
            $data['user_id'], $data['ho_ten'], $data['so_dien_thoai'], 
            $data['province_id'], $data['district_id'], $data['ward_code'], 
            $data['province_name'], $data['district_name'], $data['ward_name'], 
            $data['dia_chi_chi_tiet'], $data['loai_dia_chi'], $data['is_default']
        );
        return $stmt->execute();
    }

    // Xóa địa chỉ
    public function deleteAddress($id, $user_id) {
        // Kiểm tra xem có phải địa chỉ mặc định không
        $addr = $this->getAddressById($id, $user_id);
        if ($addr && $addr['is_default']) {
            // Gán 1 địa chỉ cũ khác làm mặc định thay thế (nếu còn)
            $stmt = $this->conn->prepare("UPDATE user_addresses SET is_default = 1 WHERE user_id = ? AND id != ? LIMIT 1");
            $stmt->bind_param("ii", $user_id, $id);
            $stmt->execute();
        }

        $stmt = $this->conn->prepare("DELETE FROM user_addresses WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Đặt địa chỉ làm mặc định
    public function setDefaultAddress($id, $user_id) {
        $this->resetDefault($user_id);
        $stmt = $this->conn->prepare("UPDATE user_addresses SET is_default = 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        return $stmt->execute();
    }

    // Tiện ích: Reset is_default về 0 cho toàn bộ địa chỉ của 1 user
    private function resetDefault($user_id) {
        $stmt = $this->conn->prepare("UPDATE user_addresses SET is_default = 0 WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
}