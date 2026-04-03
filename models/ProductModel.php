<?php
// models/ProductModel.php
require_once __DIR__ . '/../core/Model.php';

class ProductModel extends Model {
    /**
     * Tìm sản phẩm bằng ID.
     * Chỉ trả về sản phẩm nếu nó đang ở trạng thái 'HienThi'.
     *
     * @param int $id ID của sản phẩm
     * @return array|null Trả về mảng thông tin sản phẩm hoặc null nếu không tìm thấy.
     */
    public function findById(int $id): ?array {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? AND p.trang_thai IN ('HienThi', 'HetHang')");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        
        if ($product && $product['trang_thai'] === 'HetHang') {
            $product['so_luong_ton'] = 0;
        }
        
        return $product;
    }

    public function getSimilarProducts($id, $limit = 4) {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id != ? AND p.trang_thai IN ('HienThi', 'HetHang') ORDER BY p.created_at DESC LIMIT ?");
        $stmt->bind_param("ii", $id, $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        foreach ($result as &$product) {
            if ($product['trang_thai'] === 'HetHang') {
                $product['so_luong_ton'] = 0;
            }
        }
        
        return $result;
    }

    public function getBestsellerProducts($limit = 9) {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.trang_thai IN ('HienThi', 'HetHang') ORDER BY p.luot_ban DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        foreach ($result as &$product) {
            if ($product['trang_thai'] === 'HetHang') {
                $product['so_luong_ton'] = 0;
            }
        }
        
        return $result;
    }

    public function getNewProducts($limit = 9) {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.trang_thai IN ('HienThi', 'HetHang') ORDER BY p.created_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        foreach ($result as &$product) {
            if ($product['trang_thai'] === 'HetHang') {
                $product['so_luong_ton'] = 0;
            }
        }
        
        return $result;
    }

    public function getActiveCategories() {
        $result = $this->conn->query("SELECT id, ten_danh_muc, slug FROM categories WHERE trang_thai = 'HienThi' ORDER BY id ASC");
        $cats = $result->fetch_all(MYSQLI_ASSOC);
        return $cats;
    }

    public function getFilteredProducts($filters, $limit, $offset) {
        $where = ["p.trang_thai IN ('HienThi', 'HetHang')"];
        $params = [];
        $types = "";

        // Lọc theo từ khóa tìm kiếm
        if (!empty($filters['search'])) {
            $where[] = "p.ten_sp LIKE ?";
            $params[] = "%" . $filters['search'] . "%";
            $types .= "s";
        }

        // Lọc theo mảng danh mục
        if (!empty($filters['categories'])) {
            $cat_placeholders = implode(',', array_fill(0, count($filters['categories']), '?'));
            $where[] = "(c.slug IN ($cat_placeholders) OR c.ten_danh_muc IN ($cat_placeholders))";
            foreach ($filters['categories'] as $cat) {
                $params[] = $cat;
                $types .= "s";
            }
            foreach ($filters['categories'] as $cat) {
                $params[] = $cat;
                $types .= "s";
            }
        }

        $where_clause = implode(" AND ", $where);
        
        // Sắp xếp
        $order_by = "p.created_at DESC"; // Mặc định Mới nhất
        if (($filters['sort'] ?? '') === 'price_asc') $order_by = "p.gia ASC";
        elseif (($filters['sort'] ?? '') === 'price_desc') $order_by = "p.gia DESC";
        elseif (($filters['sort'] ?? '') === 'bestseller') $order_by = "p.luot_ban DESC";

        // Đếm tổng số lượng để phân trang
        $count_sql = "SELECT COUNT(p.id) as total FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE $where_clause";
        $stmt_count = $this->conn->prepare($count_sql);
        if ($types) { $stmt_count->bind_param($types, ...$params); }
        $stmt_count->execute();
        $total = $stmt_count->get_result()->fetch_assoc()['total'];
        $stmt_count->close();

        // Lấy dữ liệu sản phẩm
        $sql = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE $where_clause ORDER BY $order_by LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        
        $types .= "ii";
        $params[] = $limit;
        $params[] = $offset;

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        foreach ($products as &$product) {
            if ($product['trang_thai'] === 'HetHang') {
                $product['so_luong_ton'] = 0;
            }
        }
        
        return ['products' => $products, 'total' => $total];
    }
}
