<?php
// models/UserModel.php
require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model
{
    // Lấy thông tin user bằng số điện thoại
    public function getUserByPhone($phone)
    {
        $stmt = $this->conn->prepare("SELECT id, email FROM users WHERE so_dien_thoai = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Lấy thông tin user bằng email 
    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT id, ho_ten, mat_khau, trang_thai FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Cập nhật mật khẩu mới bằng Email
    public function updatePasswordByEmail($email, $hashedPassword)
    {
        $stmt = $this->conn->prepare("UPDATE users SET mat_khau = ? WHERE email = ?");
        $stmt->bind_param('ss', $hashedPassword, $email);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    // Tự động tính toán và cập nhật hạng thành viên
    public function updateUserRank($user_id)
    {
        // Tính tổng tiền các đơn hàng đã thanh toán (Hoàn Thành hoặc Đang Giao & Chuyển khoản)
        $stmt = $this->conn->prepare("SELECT o.giam_gia_thanh_vien, o.phi_van_chuyen, o.giam_gia_voucher, 
                                      (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham 
                                      FROM orders o WHERE o.user_id = ? AND (o.trang_thai = 'HoanThanh' OR (o.trang_thai = 'DangGiao' AND o.phuong_thuc_thanh_toan = 'ChuyenKhoan'))");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $totalSpent = 0;
        while ($row = $res->fetch_assoc()) {
            $tong_san_pham = $row['tong_san_pham'] ?? 0;
            $tien_truoc_thue = $tong_san_pham - ($row['giam_gia_thanh_vien'] ?? 0) + ($row['phi_van_chuyen'] ?? 0) - ($row['giam_gia_voucher'] ?? 0);
            $tien_truoc_thue = max(0, $tien_truoc_thue);
            $tien_thue = round($tien_truoc_thue * 0.08);
            $totalSpent += ($tien_truoc_thue + $tien_thue);
        }
        $stmt->close();

        $hang = 'Đồng';
        if ($totalSpent >= 500000) {
            $hang = 'Kim Cương';
        } elseif ($totalSpent >= 300000) {
            $hang = 'Vàng';
        } elseif ($totalSpent >= 200000) {
            $hang = 'Bạc';
        }

        $stmtUpdate = $this->conn->prepare("UPDATE users SET hang = ? WHERE id = ?");
        $stmtUpdate->bind_param("si", $hang, $user_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $user;
    }

    public function incrementUserChatCount($user_id)
    {
        $stmt = $this->conn->prepare("UPDATE users SET chat_daily_count = chat_daily_count + 1 WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
        return false;
    }

    public function resetUserChatCount($user_id)
    {
        $stmt = $this->conn->prepare("UPDATE users SET chat_daily_count = 0, last_chat_date = CURDATE() WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
        return false;
    }

    public function updateUserProfile($id, $ho_ten, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $avatar = null, $mat_khau = null)
    {
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

    /**
     * Đăng ký người dùng mới.
     * @return int|string|false ID người dùng mới, 'email_exists' nếu email đã tồn tại, false nếu lỗi.
     */
    public function registerUser($ho_ten, $email, $hashedPassword, $so_dien_thoai, $gioi_tinh, $ngay_sinh)
    {
        // Kiểm tra email tồn tại
        $stmt_check = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt_check->bind_param('s', $email);
        $stmt_check->execute();
        if ($stmt_check->get_result()->num_rows > 0) {
            $stmt_check->close();
            return 'email_exists';
        }
        $stmt_check->close();

        // Thêm user mới
        $stmt = $this->conn->prepare("INSERT INTO users (ho_ten, email, mat_khau, so_dien_thoai, gioi_tinh, ngay_sinh) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $ho_ten, $email, $hashedPassword, $so_dien_thoai, $gioi_tinh, $ngay_sinh);

        if ($stmt->execute())
            return $this->conn->insert_id;
        return false;
    }

    public function checkCredentialExists($field, $value)
    {
        // Whitelist fields to prevent SQL injection
        if (!in_array($field, ['email', 'so_dien_thoai'])) {
            return false;
        }

        // Check in users table
        $sql_user = "SELECT id FROM users WHERE `$field` = ?";
        $stmt_user = $this->conn->prepare($sql_user);
        $stmt_user->bind_param("s", $value);
        $stmt_user->execute();
        if ($stmt_user->get_result()->num_rows > 0) {
            $stmt_user->close();
            return true;
        }
        $stmt_user->close();

        // Check in admins table
        $sql_admin = "SELECT id FROM admins WHERE `$field` = ?";
        $stmt_admin = $this->conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $value);
        $stmt_admin->execute();
        if ($stmt_admin->get_result()->num_rows > 0) {
            $stmt_admin->close();
            return true;
        }
        $stmt_admin->close();

        return false;
    }


    // --- CÁC HÀM CHO ĐĂNG NHẬP GOOGLE ---

    /**
     * Tạo một người dùng mới từ thông tin Google OAuth.
     * @param string $ho_ten Tên người dùng
     * @param string $email Email
     * @param string $google_id ID từ Google
     * @param string $avatar URL ảnh đại diện
     * @return int|false ID của người dùng mới hoặc false nếu lỗi
     */
    public function registerGoogleUser($ho_ten, $email, $google_id, $avatar)
    {
        // Tạo một mật khẩu ngẫu nhiên, phức tạp để tăng cường bảo mật cho tài khoản
        $random_password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (ho_ten, email, google_id, mat_khau, avatar, trang_thai) VALUES (?, ?, ?, ?, ?, 'HoatDong')");
        $stmt->bind_param('sssss', $ho_ten, $email, $google_id, $random_password, $avatar);

        if ($stmt->execute()) {
            $insert_id = $this->conn->insert_id;
            $stmt->close();
            return $insert_id;
        }

        $stmt->close();
        return false;
    }

    public function updateGoogleId($user_id, $google_id)
    {
        $stmt = $this->conn->prepare("UPDATE users SET google_id = ? WHERE id = ?");
        $stmt->bind_param('si', $google_id, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}