<?php
// models/AdminModel.php
require_once __DIR__ . '/../core/Model.php';

class AdminModel extends Model
{

    // --- QUẢN LÝ ADMIN ---
    public function getAdminById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, username, email, ho_ten, avatar, so_dien_thoai, dia_chi, gioi_tinh, ngay_sinh, password, vai_tro, trang_thai, created_at FROM admins WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAdminByEmailOrUsername($login_id)
    {
        $stmt = $this->conn->prepare("SELECT id, username, password, ho_ten, avatar, vai_tro, trang_thai FROM admins WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $login_id, $login_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateAdminProfile($id, $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $avatar = null)
    {
        if ($avatar) {
            $sql = "UPDATE admins SET ho_ten = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ?, avatar = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssssssi", $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $avatar, $id);
        } else {
            $sql = "UPDATE admins SET ho_ten = ?, email = ?, so_dien_thoai = ?, dia_chi = ?, gioi_tinh = ?, ngay_sinh = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssssi", $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $id);
        }
        return $stmt->execute();
    }

    public function updateAdminPassword($id, $password)
    {
        $sql = "UPDATE admins SET password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $password, $id);
        return $stmt->execute();
    }

    // --- QUẢN LÝ NHÂN SỰ (ADMIN/STAFF) ---
    public function getStaffsList($limit = 10, $offset = 0, $search = '', $vai_tro = '', $trang_thai = '')
    {
        $params = [];
        $types = "";
        $sql = "SELECT id, username, ho_ten, email, so_dien_thoai, vai_tro, trang_thai, created_at FROM admins WHERE 1=1";

        if (!empty($search)) {
            $sql .= " AND (ho_ten LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?)";
            $searchTerm = "%" . $search . "%";
            array_push($params, $searchTerm, $searchTerm, $searchTerm);
            $types .= "sss";
        }
        if (!empty($vai_tro)) {
            $sql .= " AND vai_tro = ?";
            $params[] = $vai_tro;
            $types .= "s";
        }
        if (!empty($trang_thai)) {
            $sql .= " AND trang_thai = ?";
            $params[] = $trang_thai;
            $types .= "s";
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        array_push($params, $limit, $offset);
        $types .= "ii";

        $stmt = $this->conn->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalStaffsCount($search = '', $vai_tro = '', $trang_thai = '')
    {
        $params = [];
        $types = "";
        $sql = "SELECT COUNT(id) as total FROM admins WHERE 1=1";
        if (!empty($search)) {
            $sql .= " AND (ho_ten LIKE ? OR email LIKE ? OR so_dien_thoai LIKE ?)";
            $searchTerm = "%" . $search . "%";
            array_push($params, $searchTerm, $searchTerm, $searchTerm);
            $types .= "sss";
        }
        if (!empty($vai_tro)) {
            $sql .= " AND vai_tro = ?";
            $params[] = $vai_tro;
            $types .= "s";
        }
        if (!empty($trang_thai)) {
            $sql .= " AND trang_thai = ?";
            $params[] = $trang_thai;
            $types .= "s";
        }
        $stmt = $this->conn->prepare($sql);
        if ($types) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function addStaff($username, $email, $ho_ten, $so_dien_thoai, $vai_tro, $trang_thai, $password)
    {
        $sql = "INSERT INTO admins (username, email, ho_ten, so_dien_thoai, vai_tro, trang_thai, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $email, $ho_ten, $so_dien_thoai, $vai_tro, $trang_thai, $password);
        return $stmt->execute();
    }

    public function updateStaffManager($id, $ho_ten, $email, $so_dien_thoai, $vai_tro, $trang_thai)
    {
        $sql = "UPDATE admins SET ho_ten = ?, email = ?, so_dien_thoai = ?, vai_tro = ?, trang_thai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $ho_ten, $email, $so_dien_thoai, $vai_tro, $trang_thai, $id);
        return $stmt->execute();
    }

    public function deleteStaff($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getStaffsForExport($search = '', $vai_tro = '', $trang_thai = '')
    {
        $sql = "SELECT id, username, ho_ten, email, so_dien_thoai, vai_tro, trang_thai, created_at FROM admins WHERE 1=1";

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ho_ten LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR so_dien_thoai LIKE '%$search_esc%')";
        }
        if (!empty($vai_tro)) {
            $vt_esc = $this->conn->real_escape_string($vai_tro);
            $sql .= " AND vai_tro = '$vt_esc'";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }

        $sql .= " ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // --- THỐNG KÊ DASHBOARD ---
    public function getDashboardStats()
    {
        $stats = [];

        // Tổng sản phẩm
        $res = $this->conn->query("SELECT COUNT(id) as total FROM products");
        $stats['total_products'] = $res->fetch_assoc()['total'];

        // Tổng đơn hàng
        $res = $this->conn->query("SELECT COUNT(id) as total FROM orders");
        $stats['total_orders'] = $res->fetch_assoc()['total'];

        // Tổng doanh thu (Các đơn đã hoàn thành hoặc đã chuyển khoản)
        $res = $this->conn->query("SELECT o.giam_gia_thanh_vien, o.phi_van_chuyen, o.giam_gia_voucher, 
                                   (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham 
                                   FROM orders o WHERE o.trang_thai = 'HoanThanh' OR (o.trang_thai = 'DangGiao' AND o.phuong_thuc_thanh_toan = 'ChuyenKhoan')");
        $total = 0;
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $tong_san_pham = $row['tong_san_pham'] ?? 0;
                $tien_truoc_thue = $tong_san_pham - ($row['giam_gia_thanh_vien'] ?? 0) + ($row['phi_van_chuyen'] ?? 0) - ($row['giam_gia_voucher'] ?? 0);
                $tien_truoc_thue = max(0, $tien_truoc_thue);
                $tien_thue = round($tien_truoc_thue * 0.08);
                $total += ($tien_truoc_thue + $tien_thue);
            }
        }
        $stats['total_revenue'] = $total;

        // Tổng khách hàng
        $res = $this->conn->query("SELECT COUNT(id) as total FROM users");
        $stats['total_users'] = $res->fetch_assoc()['total'];

        return $stats;
    }

    // Lấy dữ liệu biểu đồ 
    public function getRevenueChartData()
    {
        $data = ['labels' => [], 'revenues' => []];
        $tempData = [];

        // Khởi tạo mảng 7 ngày gần nhất (bao gồm hôm nay) với doanh thu mặc định = 0
        for ($i = 6; $i >= 0; $i--) {
            $dateString = date('Y-m-d', strtotime("-$i days"));
            $label = date('d/m', strtotime($dateString));
            $data['labels'][] = $label;
            $tempData[$label] = 0;
        }

        // Truy vấn dữ liệu thực tế từ CSDL
        $sql = "SELECT DATE(o.created_at) as date, o.giam_gia_thanh_vien, o.phi_van_chuyen, o.giam_gia_voucher, 
                (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham 
                FROM orders o 
                WHERE (o.trang_thai = 'HoanThanh' OR (o.trang_thai = 'DangGiao' AND o.phuong_thuc_thanh_toan = 'ChuyenKhoan')) 
                AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)";
        $result = $this->conn->query($sql);
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $label = date('d/m', strtotime($row['date']));
                if (isset($tempData[$label])) {
                    $tong_san_pham = $row['tong_san_pham'] ?? 0;
                    $tien_truoc_thue = $tong_san_pham - ($row['giam_gia_thanh_vien'] ?? 0) + ($row['phi_van_chuyen'] ?? 0) - ($row['giam_gia_voucher'] ?? 0);
                    $tien_truoc_thue = max(0, $tien_truoc_thue);
                    $tien_thue = round($tien_truoc_thue * 0.08);
                    $tempData[$label] += ($tien_truoc_thue + $tien_thue);
                }
            }
        }
        
        // Đưa mảng giá trị vào revenues để Chart.js đọc
        $data['revenues'] = array_values($tempData);

        return $data;
    }

    // --- QUẢN LÝ SẢN PHẨM ---
    // Hàm hỗ trợ map tên danh mục ra ID
    public function getCategoryIdByName($name) {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE ten_danh_muc = ? OR slug = ?");
        $stmt->bind_param("ss", $name, $name);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        return $res ? $res['id'] : null;
    }

    public function getProducts($limit = 10, $offset = 0, $search = '', $category = '')
    {
        $sql = "SELECT p.*, c.ten_danh_muc as danh_muc FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND p.ten_sp LIKE '%$search_esc%'";
        }
        if (!empty($category)) {
            $cat_esc = $this->conn->real_escape_string($category);
            $sql .= " AND (c.ten_danh_muc = '$cat_esc' OR c.slug = '$cat_esc')";
        }
        $sql .= " ORDER BY p.id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalProductsCount($search = '', $category = '')
    {
        $sql = "SELECT COUNT(p.id) as total FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND p.ten_sp LIKE '%$search_esc%'";
        }
        if (!empty($category)) {
            $cat_esc = $this->conn->real_escape_string($category);
            $sql .= " AND (c.ten_danh_muc = '$cat_esc' OR c.slug = '$cat_esc')";
        }
        $res = $this->conn->query($sql);
        return $res->fetch_assoc()['total'];
    }

    public function addProduct($ten_sp, $gia, $gia_cu, $category_id, $so_luong, $trang_thai, $anh, $mo_ta)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $ten_sp)));
        $sql = "INSERT INTO products (ten_sp, slug, gia, gia_cu, category_id, so_luong_ton, trang_thai, anh, mo_ta) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssddiisss", $ten_sp, $slug, $gia, $gia_cu, $category_id, $so_luong, $trang_thai, $anh, $mo_ta);
        return $stmt->execute();
    }

    public function deleteProduct($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getProductById($id)
    {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProduct($id, $ten_sp, $gia, $gia_cu, $category_id, $so_luong, $trang_thai, $anh = null, $mo_ta)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $ten_sp)));
        $sql = "UPDATE products SET ten_sp = ?, slug = ?, gia = ?, gia_cu = ?, category_id = ?, so_luong_ton = ?, trang_thai = ?, mo_ta = ?" . ($anh ? ", anh = ?" : "") . " WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($anh)
            $stmt->bind_param("ssddiisssi", $ten_sp, $slug, $gia, $gia_cu, $category_id, $so_luong, $trang_thai, $mo_ta, $anh, $id);
        else
            $stmt->bind_param("ssddiissi", $ten_sp, $slug, $gia, $gia_cu, $category_id, $so_luong, $trang_thai, $mo_ta, $id);
        return $stmt->execute();
    }

    public function getProductsForExport($search = '', $category = '')
    {
        $sql = "SELECT p.id, p.ten_sp, p.slug, p.gia, p.gia_cu, p.mo_ta, p.anh, c.ten_danh_muc as danh_muc, p.weight, p.so_luong_ton, p.luot_ban, p.trang_thai, p.created_at FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND p.ten_sp LIKE '%$search_esc%'";
        }
        if (!empty($category)) {
            $cat_esc = $this->conn->real_escape_string($category);
            $sql .= " AND (c.ten_danh_muc = '$cat_esc' OR c.slug = '$cat_esc')";
        }
        $sql .= " ORDER BY p.id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // --- QUẢN LÝ DANH MỤC ---
    public function getCategories()
    {
        $result = $this->conn->query("SELECT * FROM categories ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategoriesList($limit = 10, $offset = 0, $search = '', $trang_thai = '')
    {
        $sql = "SELECT * FROM categories WHERE 1=1";

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ten_danh_muc LIKE '%$search_esc%' OR slug LIKE '%$search_esc%')";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCategoriesCount($search = '', $trang_thai = '')
    {
        $sql = "SELECT COUNT(id) as total FROM categories WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ten_danh_muc LIKE '%$search_esc%' OR slug LIKE '%$search_esc%')";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }
        return $this->conn->query($sql)->fetch_assoc()['total'];
    }

    public function addCategory($ten_danh_muc, $trang_thai)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $ten_danh_muc)));
        $sql = "INSERT INTO categories (ten_danh_muc, slug, trang_thai) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $ten_danh_muc, $slug, $trang_thai);
        return $stmt->execute();
    }

    public function getCategoryById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateCategory($id, $ten_danh_muc, $trang_thai)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $ten_danh_muc)));
        $sql = "UPDATE categories SET ten_danh_muc = ?, slug = ?, trang_thai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $ten_danh_muc, $slug, $trang_thai, $id);
        return $stmt->execute();
    }

    public function deleteCategory($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getCategoriesForExport($search = '', $trang_thai = '')
    {
        $sql = "SELECT id, ten_danh_muc, slug, trang_thai, created_at FROM categories WHERE 1=1";

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ten_danh_muc LIKE '%$search_esc%' OR slug LIKE '%$search_esc%')";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }

        $sql .= " ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // --- QUẢN LÝ ĐƠN HÀNG ---
    private function buildOrderWhereClause($search, $trang_thai, $from_date, $to_date)
    {
        $sql = " WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (o.id LIKE '%$search_esc%' OR u.ho_ten LIKE '%$search_esc%')";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND o.trang_thai = '$tt_esc'";
        }
        if (!empty($from_date)) {
            $fd_esc = $this->conn->real_escape_string($from_date);
            $sql .= " AND DATE(o.created_at) >= '$fd_esc'";
        }
        if (!empty($to_date)) {
            $td_esc = $this->conn->real_escape_string($to_date);
            $sql .= " AND DATE(o.created_at) <= '$td_esc'";
        }
        return $sql;
    }

    public function getOrdersList($limit = 15, $offset = 0, $search = '', $trang_thai = '', $from_date = '', $to_date = '')
    {
        $sql = "SELECT o.*, IFNULL(u.ho_ten, o.ten_nguoi_nhan) as user_name, IFNULL(u.email, o.email_nguoi_nhan) as user_email, (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham FROM orders o LEFT JOIN users u ON o.user_id = u.id" . $this->buildOrderWhereClause($search, $trang_thai, $from_date, $to_date) . " ORDER BY o.created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalOrdersCount($search = '', $trang_thai = '', $from_date = '', $to_date = '')
    {
        $sql = "SELECT COUNT(o.id) as total FROM orders o LEFT JOIN users u ON o.user_id = u.id" . $this->buildOrderWhereClause($search, $trang_thai, $from_date, $to_date);
        return $this->conn->query($sql)->fetch_assoc()['total'] ?? 0;
    }

    public function getTotalRevenue($search = '', $trang_thai = '', $from_date = '', $to_date = '')
    {
        $sql = "SELECT o.giam_gia_thanh_vien, o.phi_van_chuyen, o.giam_gia_voucher, 
                (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham 
                FROM orders o LEFT JOIN users u ON o.user_id = u.id" . $this->buildOrderWhereClause($search, $trang_thai, $from_date, $to_date) . " AND (o.trang_thai = 'HoanThanh' OR (o.trang_thai = 'DangGiao' AND o.phuong_thuc_thanh_toan = 'ChuyenKhoan'))";
        $result = $this->conn->query($sql);
        $total_revenue = 0;
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $tong_san_pham = $row['tong_san_pham'] ?? 0;
                $tien_truoc_thue = $tong_san_pham - ($row['giam_gia_thanh_vien'] ?? 0) + ($row['phi_van_chuyen'] ?? 0) - ($row['giam_gia_voucher'] ?? 0);
                $tien_truoc_thue = max(0, $tien_truoc_thue);
                $tien_thue = round($tien_truoc_thue * 0.08);
                $total_revenue += ($tien_truoc_thue + $tien_thue);
            }
        }
        return $total_revenue;
    }

    public function getOrdersForExport($search = '', $trang_thai = '', $from_date = '', $to_date = '')
    {
        $sql = "SELECT 
                    o.id,
                    o.ghn_order_code,
                    IFNULL(u.ho_ten, o.ten_nguoi_nhan) as user_name,
                    o.tong_tien,
                    o.phi_van_chuyen,
                    o.giam_gia_thanh_vien,
                    o.ma_voucher,
                    o.giam_gia_voucher,
                    (SELECT SUM(gia * so_luong) FROM order_details WHERE order_id = o.id) as tong_san_pham,
                    o.dia_chi_giao,
                    o.trang_thai,
                    o.phuong_thuc_thanh_toan,
                    o.ghi_chu,
                    o.created_at
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id"
            . $this->buildOrderWhereClause($search, $trang_thai, $from_date, $to_date)
            . " ORDER BY o.created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderById($id)
    {
        $stmt = $this->conn->prepare("SELECT o.*, IFNULL(u.ho_ten, o.ten_nguoi_nhan) as user_name, IFNULL(u.email, o.email_nguoi_nhan) as user_email FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderDetailsByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("SELECT od.*, p.ten_sp, p.anh FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateOrderStatus($id, $trang_thai)
    {
        $stmt = $this->conn->prepare("UPDATE orders SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $id);
        return $stmt->execute();
    }

    // --- QUẢN LÝ NGƯỜI DÙNG ---
    public function getUsersList($limit = 10, $offset = 0, $search = '', $hang = '', $trang_thai = '')
    {
        $sql = "SELECT id, ho_ten, email, so_dien_thoai, hang, trang_thai, created_at FROM users WHERE 1=1";

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ho_ten LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR so_dien_thoai LIKE '%$search_esc%')";
        }
        if (!empty($hang)) {
            $hang_esc = $this->conn->real_escape_string($hang);
            $sql .= " AND hang = '$hang_esc'";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }

        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalUsersCount($search = '', $hang = '', $trang_thai = '')
    {
        $sql = "SELECT COUNT(id) as total FROM users WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ho_ten LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR so_dien_thoai LIKE '%$search_esc%')";
        }
        if (!empty($hang)) {
            $hang_esc = $this->conn->real_escape_string($hang);
            $sql .= " AND hang = '$hang_esc'";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }
        $res = $this->conn->query($sql);
        return $res->fetch_assoc()['total'];
    }

    public function getUserIdByOrderId($order_id)
    {
        $stmt = $this->conn->prepare("SELECT user_id FROM orders WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['user_id'] : null;
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, ho_ten, email, so_dien_thoai, dia_chi, gioi_tinh, ngay_sinh, hang, trang_thai FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addUser($ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai, $mat_khau)
    {
        $sql = "INSERT INTO users (ho_ten, email, so_dien_thoai, dia_chi, gioi_tinh, ngay_sinh, hang, trang_thai, mat_khau, last_chat_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssss", $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai, $mat_khau);
        return $stmt->execute();
    }

    public function updateUserPassword($id, $mat_khau)
    {
        $sql = "UPDATE users SET mat_khau = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $mat_khau, $id);
        return $stmt->execute();
    }

    public function updateUserAdmin($id, $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai)
    {
        $sql = "UPDATE users SET ho_ten=?, email=?, so_dien_thoai=?, dia_chi=?, gioi_tinh=?, ngay_sinh=?, hang=?, trang_thai=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai, $id);
        return $stmt->execute();
    }

    public function toggleUserStatus($id)
    {
        $sql = "UPDATE users SET trang_thai = IF(trang_thai = 'HoatDong', 'Khoa', 'HoatDong') WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            return false;
        }
    }

    public function getUsersForExport($search = '', $hang = '', $trang_thai = '')
    {
        $sql = "SELECT id, ho_ten, email, so_dien_thoai, dia_chi, gioi_tinh, hang, trang_thai, ngay_sinh, created_at FROM users WHERE 1=1";

        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (ho_ten LIKE '%$search_esc%' OR email LIKE '%$search_esc%' OR so_dien_thoai LIKE '%$search_esc%')";
        }
        if (!empty($hang)) {
            $hang_esc = $this->conn->real_escape_string($hang);
            $sql .= " AND hang = '$hang_esc'";
        }
        if (!empty($trang_thai)) {
            $tt_esc = $this->conn->real_escape_string($trang_thai);
            $sql .= " AND trang_thai = '$tt_esc'";
        }

        $sql .= " ORDER BY id DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // --- QUẢN LÝ CHATBOT FAQ ---
    public function getFaqsList($limit = 10, $offset = 0, $search = '')
    {
        $sql = "SELECT * FROM chatbot_faq WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (keywords LIKE '%$search_esc%' OR answer LIKE '%$search_esc%')";
        }
        $sql .= " ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalFaqsCount($search = '')
    {
        $sql = "SELECT COUNT(id) as total FROM chatbot_faq WHERE 1=1";
        if (!empty($search)) {
            $search_esc = $this->conn->real_escape_string($search);
            $sql .= " AND (keywords LIKE '%$search_esc%' OR answer LIKE '%$search_esc%')";
        }
        return $this->conn->query($sql)->fetch_assoc()['total'];
    }

    public function getFaqById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM chatbot_faq WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function saveFaq($id, $keywords, $answer, $status)
    {
        if (empty($id)) { // Add
            $stmt = $this->conn->prepare("INSERT INTO chatbot_faq (keywords, answer, status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $keywords, $answer, $status);
        } else { // Update
            $stmt = $this->conn->prepare("UPDATE chatbot_faq SET keywords = ?, answer = ?, status = ? WHERE id = ?");
            $stmt->bind_param("sssi", $keywords, $answer, $status, $id);
        }
        return $stmt->execute();
    }

    public function deleteFaq($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM chatbot_faq WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}