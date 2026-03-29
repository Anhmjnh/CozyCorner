<?php
// models/VoucherModel.php
require_once __DIR__ . '/../core/Model.php';

class VoucherModel extends Model {
    // Lấy danh sách voucher đang hoạt động "
    public function getActiveVouchers() {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("
            SELECT * FROM vouchers 
            WHERE trang_thai = 'HoatDong' 
            AND (ngay_bat_dau IS NULL OR ngay_bat_dau <= ?)
            AND (ngay_het_han IS NULL OR ngay_het_han >= ?)
            AND (so_luong = 0 OR da_dung < so_luong)
        ");
        $stmt->bind_param("ss", $now, $now);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    // Kiểm tra tính hợp lệ của mã voucher khi user nhập tay hoặc chọn
    public function checkVoucher($ma_voucher) {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE ma_voucher = ? AND trang_thai = 'HoatDong'");
        $stmt->bind_param("s", $ma_voucher);
        $stmt->execute();
        $voucher = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$voucher) return ['status' => false, 'msg' => 'Mã voucher không tồn tại.'];
        if ($voucher['ngay_bat_dau'] && $now < $voucher['ngay_bat_dau']) return ['status' => false, 'msg' => 'Voucher chưa đến thời gian áp dụng.'];
        if ($voucher['ngay_het_han'] && $now > $voucher['ngay_het_han']) return ['status' => false, 'msg' => 'Voucher đã hết hạn.'];
        if ($voucher['so_luong'] > 0 && $voucher['da_dung'] >= $voucher['so_luong']) return ['status' => false, 'msg' => 'Voucher đã hết số lượt sử dụng.'];

        return ['status' => true, 'data' => $voucher];
    }

    // Tăng số lượt sử dụng voucher sau khi thanh toán thành công
    public function incrementVoucherUsage($ma_voucher) {
        if (empty($ma_voucher)) return false;
        $stmt = $this->conn->prepare("UPDATE vouchers SET da_dung = da_dung + 1 WHERE ma_voucher = ?");
        $stmt->bind_param("s", $ma_voucher);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // --- CÁC HÀM CHO TRANG ADMIN ---

    // Lấy danh sách voucher cho trang Admin (có phân trang và bộ lọc)
    public function getVouchersList($limit, $offset, $search = '', $loai_voucher = '', $trang_thai = '') {
        $sql = "SELECT * FROM vouchers WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND ma_voucher LIKE ?";
            $params[] = "%" . $search . "%";
            $types .= "s";
        }
        if (!empty($loai_voucher)) {
            $sql .= " AND loai_voucher = ?";
            $params[] = $loai_voucher;
            $types .= "s";
        }
        if (!empty($trang_thai)) {
            $sql .= " AND trang_thai = ?";
            $params[] = $trang_thai;
            $types .= "s";
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= "ii";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    // Đếm tổng số voucher cho trang Admin để phân trang
    public function getTotalVouchersCount($search = '', $loai_voucher = '', $trang_thai = '') {
        $sql = "SELECT COUNT(id) as total FROM vouchers WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND ma_voucher LIKE ?";
            $params[] = "%" . $search . "%";
            $types .= "s";
        }
        if (!empty($loai_voucher)) {
            $sql .= " AND loai_voucher = ?";
            $params[] = $loai_voucher;
            $types .= "s";
        }
        if (!empty($trang_thai)) {
            $sql .= " AND trang_thai = ?";
            $params[] = $trang_thai;
            $types .= "s";
        }

        $stmt = $this->conn->prepare($sql);
        if (!empty($types)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $total = $stmt->get_result()->fetch_assoc()['total'];
        $stmt->close();
        return $total;
    }

    // Lấy tất cả voucher cho chức năng export (không phân trang)
    public function getVouchersForExport($search = '', $loai_voucher = '', $trang_thai = '')
    {
        $sql = "SELECT * FROM vouchers WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND ma_voucher LIKE ?";
            $params[] = "%" . $search . "%";
            $types .= "s";
        }
        if (!empty($loai_voucher)) {
            $sql .= " AND loai_voucher = ?";
            $params[] = $loai_voucher;
            $types .= "s";
        }
        if (!empty($trang_thai)) {
            $sql .= " AND trang_thai = ?";
            $params[] = $trang_thai;
            $types .= "s";
        }

        $sql .= " ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        if (!empty($types))  $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    // Lấy voucher theo ID (cho form sửa)
    public function getVoucherById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    // Thêm voucher mới
    public function addVoucher($data) {
        $stmt = $this->conn->prepare("INSERT INTO vouchers (ma_voucher, loai_voucher, gia_tri, giam_toi_da, don_toi_thieu, so_luong, ngay_bat_dau, ngay_het_han, trang_thai) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiisss", $data['ma_voucher'], $data['loai_voucher'], $data['gia_tri'], $data['giam_toi_da'], $data['don_toi_thieu'], $data['so_luong'], $data['ngay_bat_dau'], $data['ngay_het_han'], $data['trang_thai']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Cập nhật voucher
    public function updateVoucher($id, $data) {
        $stmt = $this->conn->prepare("UPDATE vouchers SET ma_voucher = ?, loai_voucher = ?, gia_tri = ?, giam_toi_da = ?, don_toi_thieu = ?, so_luong = ?, ngay_bat_dau = ?, ngay_het_han = ?, trang_thai = ? WHERE id = ?");
        $stmt->bind_param("ssiiiisssi", $data['ma_voucher'], $data['loai_voucher'], $data['gia_tri'], $data['giam_toi_da'], $data['don_toi_thieu'], $data['so_luong'], $data['ngay_bat_dau'], $data['ngay_het_han'], $data['trang_thai'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Xóa voucher
    public function deleteVoucher($id) {
        $stmt = $this->conn->prepare("DELETE FROM vouchers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>