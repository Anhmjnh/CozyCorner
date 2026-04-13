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

    public function getSimilarProducts($id, $category_id, $limit = 4) {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id != ? AND p.category_id = ? AND p.trang_thai IN ('HienThi', 'HetHang') ORDER BY RAND() LIMIT ?");
        $stmt->bind_param("iii", $id, $category_id, $limit);
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

    public function getBoughtTogetherProducts($product_id, $limit = 4) {
        // 0. Lấy category_id của sản phẩm hiện tại để loại trừ khi lấy gợi ý mua kèm
        $stmt_cat = $this->conn->prepare("SELECT category_id FROM products WHERE id = ?");
        $stmt_cat->bind_param("i", $product_id);
        $stmt_cat->execute();
        $res_cat = $stmt_cat->get_result()->fetch_assoc();
        $current_category_id = $res_cat ? $res_cat['category_id'] : 0;
        $stmt_cat->close();

        // 1. Thuật toán: Tìm các sản phẩm được mua cùng hóa đơn nhiều nhất
        $sql = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug, COUNT(od2.product_id) as mua_kem_count 
                FROM order_details od1 
                JOIN order_details od2 ON od1.order_id = od2.order_id AND od1.product_id != od2.product_id
                JOIN products p ON od2.product_id = p.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE od1.product_id = ? AND p.trang_thai IN ('HienThi', 'HetHang')
                GROUP BY p.id 
                ORDER BY mua_kem_count DESC 
                LIMIT ?";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $product_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // 2. Fallback (Bù đắp) Nâng cấp: Xử lý Popularity Bias và Tối ưu Cross-selling
        $count = count($result);
        if ($count < $limit) {
            $needed = $limit - $count;
            $exclude_ids = array_map(function($item) { return $item['id']; }, $result);
            $exclude_ids[] = $product_id; // Loại trừ cả sản phẩm hiện tại
            $exclude_str = implode(',', $exclude_ids);
            
            // Lấy Top 20 sản phẩm bán chạy thuộc CÁC DANH MỤC KHÁC (Để bán chéo)
            $sql_fallback = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug 
                             FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id 
                             WHERE p.id NOT IN ($exclude_str) 
                             AND p.category_id != ? 
                             AND p.trang_thai IN ('HienThi', 'HetHang') 
                             ORDER BY p.luot_ban DESC 
                             LIMIT 20";
            $stmt_fb = $this->conn->prepare($sql_fallback);
            $stmt_fb->bind_param("i", $current_category_id);
            $stmt_fb->execute();
            $fallback_result = $stmt_fb->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt_fb->close();
            
            if (count($fallback_result) >= $needed) {
                // Trộn ngẫu nhiên (Shuffle) để tránh luôn hiển thị cố định các món siêu hot
                shuffle($fallback_result);
                $fallback_result = array_slice($fallback_result, 0, $needed);
            } else {
                // Nếu shop quá ít đồ khác danh mục, lấy đại sản phẩm ngẫu nhiên bù vào cho đủ layout
                $still_needed = $needed - count($fallback_result);
                $exclude_ids = array_merge($exclude_ids, array_map(function($item) { return $item['id']; }, $fallback_result));
                $exclude_str = implode(',', $exclude_ids);

                $sql_fb_any = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug 
                               FROM products p LEFT JOIN categories c ON p.category_id = c.id 
                               WHERE p.id NOT IN ($exclude_str) AND p.trang_thai IN ('HienThi', 'HetHang') 
                               ORDER BY RAND() LIMIT ?";
                $stmt_fb_any = $this->conn->prepare($sql_fb_any);
                $stmt_fb_any->bind_param("i", $still_needed);
                $stmt_fb_any->execute();
                $any_result = $stmt_fb_any->get_result()->fetch_all(MYSQLI_ASSOC);
                $stmt_fb_any->close();
                
                $fallback_result = array_merge($fallback_result, $any_result);
            }
            
            $result = array_merge($result, $fallback_result);
        }
        
        // Đồng bộ logic số lượng tồn kho với các module khác
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

    public function getProductsByIds(array $ids) {
        if (empty($ids)) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $sql = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id IN ($placeholders) AND p.trang_thai IN ('HienThi', 'HetHang')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAutoCompetitors(array $exclude_ids, $category_id, $price, $limit = 2) {
        $placeholders = empty($exclude_ids) ? '0' : implode(',', array_fill(0, count($exclude_ids), '?'));
        $types = 'i' . (!empty($exclude_ids) ? str_repeat('i', count($exclude_ids)) : '') . 'di';
        $params = array_merge([$category_id], $exclude_ids, [$price, $limit]);

        $sql = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug 
                FROM products p LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? AND p.id NOT IN ($placeholders) AND p.trang_thai IN ('HienThi', 'HetHang')
                ORDER BY ABS(p.gia - ?) ASC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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

    // --- SẢN PHẨM TRANG CHỦ ---

    public function logProductView($product_id, $user_id = null, $session_id = null) {
        $stmt = $this->conn->prepare("INSERT INTO product_views (product_id, user_id, session_id) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $product_id, $user_id, $session_id);
        $stmt->execute();
        $stmt->close();
    }

    public function getSaleProducts($limit = 9) {
        $stmt = $this->conn->prepare("SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.trang_thai IN ('HienThi', 'HetHang') AND p.gia_cu > p.gia ORDER BY (p.gia_cu - p.gia) DESC LIMIT ?");
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

    public function getPersonalizedProducts($user_id, $session_id, $limit = 9) {
        $cat_ids = [];
        // 1. Phân tích danh mục từ lịch sử mua hàng 
        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT p.category_id, COUNT(*) as cnt FROM order_details od JOIN orders o ON od.order_id = o.id JOIN products p ON od.product_id = p.id WHERE o.user_id = ? GROUP BY p.category_id ORDER BY cnt DESC LIMIT 2");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()) {
                $cat_ids[] = $row['category_id'];
            }
            $stmt->close();
        }

        // 2. Phân tích từ lịch sử xem sản phẩm 
        if (count($cat_ids) < 2) {
            $view_query = $user_id ? "user_id = ?" : "session_id = ?";
            $param = $user_id ? $user_id : $session_id;
            $stmt = $this->conn->prepare("SELECT p.category_id, COUNT(*) as cnt FROM product_views pv JOIN products p ON pv.product_id = p.id WHERE pv.$view_query GROUP BY p.category_id ORDER BY cnt DESC LIMIT 2");
            if ($user_id) {
                $stmt->bind_param("i", $param);
            } else {
                $stmt->bind_param("s", $param);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()) {
                if (!in_array($row['category_id'], $cat_ids)) {
                    $cat_ids[] = $row['category_id'];
                }
            }
            $stmt->close();
        }

        // 3. Truy xuất sản phẩm thuộc các danh mục đó 
        if (!empty($cat_ids)) {
            $cat_placeholders = implode(',', array_fill(0, count($cat_ids), '?'));
            $sql = "SELECT p.*, c.ten_danh_muc as danh_muc, c.slug as category_slug FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.trang_thai IN ('HienThi', 'HetHang') AND p.category_id IN ($cat_placeholders) ORDER BY RAND() LIMIT ?";
            $stmt = $this->conn->prepare($sql);
            $types = str_repeat('i', count($cat_ids)) . 'i';
            $params = $cat_ids;
            $params[] = $limit;
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            
            if (count($result) >= 4) { // Nếu có đủ sản phẩm để hiển thị đẹp
                foreach ($result as &$product) {
                    if ($product['trang_thai'] === 'HetHang') $product['so_luong_ton'] = 0;
                }
                return $result;
            }
        }

        // 4. Fallback: Nếu không có dữ liệu cá nhân, trả về Top sản phẩm Bán Chạy nhất
        return $this->getBestsellerProducts($limit);
    }
}
