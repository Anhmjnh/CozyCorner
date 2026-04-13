<?php
// controllers/ProductController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

class ProductController extends Controller
{

    // Trang Danh sách / Lọc sản phẩm
    public function index()
    {
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $sort = trim($_GET['sort'] ?? 'newest');

        $categories_filter = isset($_GET['categories']) ? (is_array($_GET['categories']) ? $_GET['categories'] : [$_GET['categories']]) : [];
        $category_slug = trim($_GET['category'] ?? '');

        $productModel = $this->model('ProductModel');
        $all_categories = $productModel->getActiveCategories();

        if (!empty($category_slug)) {
            foreach ($all_categories as $cat) {
                if ($cat['slug'] === $category_slug && !in_array($cat['ten_danh_muc'], $categories_filter)) {
                    $categories_filter[] = $cat['ten_danh_muc'];
                }
            }
        }

        $filters = [
            'search' => $search,
            'sort' => $sort,
            'categories' => $categories_filter
        ];

        $result = $productModel->getFilteredProducts($filters, $limit, $offset);
        $products = $result['products'];
        $total = $result['total'];
        $totalPages = ceil($total / $limit);

        $page_css = ['assets/css/DanhMucSanPham.css'];
        $compare_mode = isset($_GET['compare_mode']) ? 1 : 0;
        $this->view('product/DanhMucSanPham', [
            'products' => $products,
            'total' => $total,
            'totalPages' => $totalPages,
            'all_categories' => $all_categories,
            'categories_filter' => $categories_filter,
            'sort' => $sort,
            'page' => $page,
            'page_css' => $page_css,
            'compare_mode' => $compare_mode
        ]);
    }
    // --- API Dành cho Tab Sản Phẩm Trang Chủ ---
    public function api_get_products_by_tab()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        header('Content-Type: application/json');

        $tab = $_GET['tab'] ?? 'new';
        $productModel = $this->model('ProductModel');
        $products = [];

        if ($tab === 'new') {
            $products = $productModel->getNewProducts(9);
        } elseif ($tab === 'sale') {
            $products = $productModel->getSaleProducts(9);
        } elseif ($tab === 'foryou') {
            $user_id = $_SESSION['user_id'] ?? null;
            $session_id = session_id();
            $products = $productModel->getPersonalizedProducts($user_id, $session_id, 9);
        }

        if (empty($products)) {
            echo json_encode(['status' => 'error', 'msg' => 'Chưa có sản phẩm nào.']);
            exit;
        }

        $html = '';
        $base_url = BASE_URL;

        foreach ($products as $row) {
            $id = $row['id'];
            $anh = htmlspecialchars($row['anh']);
            $ten_sp = htmlspecialchars($row['ten_sp']);
            $gia = number_format($row['gia']) . 'đ';

            $gia_cu_html = '';
            if ($row['gia_cu'] > 0) {
                $gia_cu = number_format($row['gia_cu']) . 'đ';
                $gia_cu_html = "<span class=\"product__list-old-price\">{$gia_cu}</span>";
            }

            $btn_html = '';
            if ($row['so_luong_ton'] > 0) {
                $btn_html = "<a href=\"javascript:void(0)\" class=\"product__list-cart-button js__add-to-cart\" data-product-id=\"{$id}\">
                                <img src=\"{$base_url}assets/icon/Icon-cart.svg\" alt=\"button cart\">
                            </a>";
            } else {
                $btn_html = "<span class=\"product__list-cart-button\" style=\"border-color: #ccc; background-color: #f5f5f5; cursor: not-allowed; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold; color: #999; padding: 12px; text-decoration: none;\" title=\"Hết hàng\">Hết hàng</span>";
            }

            $html .= "
            <div class=\"product__list-item\">
                <a href=\"{$base_url}view/product/ChiTietSanPham.php?id={$id}\">
                    <img src=\"{$base_url}uploads/{$anh}\" alt=\"{$ten_sp}\" class=\"product__list-image\">
                </a>
                <div class=\"product__list-text\">
                    <p class=\"product__list-item-title\">
                        {$ten_sp} <br>
                        <span class=\"product__list-price\">
                            {$gia}
                            {$gia_cu_html}
                        </span>
                    </p>
                    {$btn_html}
                </div>
            </div>";
        }

        echo json_encode(['status' => 'success', 'html' => $html]);
        exit;
    }


    // Trang Chi tiết 1 sản phẩm
    public function detail()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . 'index.php?url=product');
            exit;
        }

        $productModel = $this->model('ProductModel');
        $product = $productModel->findById($id);

        $similar_products = [];
        $bought_together_products = [];
        if ($product) {
            $similar_products = $productModel->getSimilarProducts($id, $product['category_id'], 4);
            $bought_together_products = $productModel->getBoughtTogetherProducts($id, 4);
        }

        // Lấy Đánh giá
        $reviewModel = $this->model('ReviewModel');
        $reviews = $reviewModel->getReviewsByProductId($id);
        $total_reviews = count($reviews);
        $avg_rating = 0;
        $rating_counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        if ($total_reviews > 0) {
            $total_rating_sum = 0;
            foreach ($reviews as $review) {
                $total_rating_sum += $review['rating'];
                if (isset($rating_counts[$review['rating']]))
                    $rating_counts[$review['rating']]++;
            }
            $avg_rating = round($total_rating_sum / $total_reviews, 1);
        }
        // Ghi nhận lịch sử xem sản phẩm
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();
        $productModel->logProductView($id, $user_id, $session_id);


        // Thông tin User (để hiển thị form đánh giá nếu đã đăng nhập)
        $is_logged_in = isset($_SESSION['user_id']);
        $user_info = null;
        if ($is_logged_in) {
            $userModel = $this->model('UserModel');
            $user_info = $userModel->getUserById($_SESSION['user_id']);
        }

        $page_css = ['assets/css/ChiTietSanPham.css'];
        $this->view('product/ChiTietSanPham', [
            'product' => $product,
            'similar_products' => $similar_products,
            'bought_together_products' => $bought_together_products,
            'reviews' => $reviews,
            'total_reviews' => $total_reviews,
            'avg_rating' => $avg_rating,
            'rating_counts' => $rating_counts,
            'is_logged_in' => $is_logged_in,
            'user_info' => $user_info,
            'page_css' => $page_css
        ]);
    }

    // --- CHỨC NĂNG SO SÁNH SẢN PHẨM ---
    public function api_compare_add() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $data = json_decode(file_get_contents('php://input'), true);
        $product_id = intval($data['product_id'] ?? 0);
        $category_id = intval($data['category_id'] ?? 0);
        $force_clear = $data['force_clear'] ?? false;

        if ($force_clear) {
            unset($_SESSION['compare_list']);
        }
        if (!isset($_SESSION['compare_list'])) {
            $_SESSION['compare_list'] = ['category_id' => $category_id, 'items' => []];
        }
        // Giải quyết góc khuất: Xung đột danh mục
        if ($_SESSION['compare_list']['category_id'] !== $category_id && !empty($_SESSION['compare_list']['items'])) {
            echo json_encode(['status' => 'conflict', 'msg' => 'Bạn chỉ có thể so sánh các sản phẩm cùng danh mục. Bạn có muốn tạo danh sách so sánh mới không?']);
            exit;
        }
        if (!in_array($product_id, $_SESSION['compare_list']['items'])) {
            $_SESSION['compare_list']['category_id'] = $category_id;
            $_SESSION['compare_list']['items'][] = $product_id;
            // Thuật toán FIFO: Nếu vượt quá 3, đẩy cái cũ nhất ra
            if (count($_SESSION['compare_list']['items']) > 3) {
                array_shift($_SESSION['compare_list']['items']);
            }
        }
        echo json_encode(['status' => 'success']);
        exit;
    }

    public function api_compare_remove() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $data = json_decode(file_get_contents('php://input'), true);
        $product_id = intval($data['product_id'] ?? 0);
        if (isset($_SESSION['compare_list']['items'])) {
            $_SESSION['compare_list']['items'] = array_values(array_filter($_SESSION['compare_list']['items'], function($id) use ($product_id) {
                return $id != $product_id;
            }));
            if (empty($_SESSION['compare_list']['items'])) unset($_SESSION['compare_list']);
        }
        echo json_encode(['status' => 'success']);
        exit;
    }

    public function compare() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $compare_items = $_SESSION['compare_list']['items'] ?? [];
        if (empty($compare_items)) {
            header("Location: " . BASE_URL . "index.php?url=product");
            exit;
        }
        $productModel = $this->model('ProductModel');
        $products = $productModel->getProductsByIds($compare_items);
        

        // Cấp độ 2: Heuristic Scoring - Chấm điểm gắn nhãn
        $reviewModel = $this->model('ReviewModel');
        $ratings = $reviewModel->getAverageRatings(array_column($products, 'id'));
        $cheapest_id = null; $bestseller_id = null; $highest_rated_id = null;
        $min_price = PHP_INT_MAX; $max_sales = -1; $max_rating = -1;

        foreach ($products as &$p) {
            $id = $p['id'];
            $p['rating'] = $ratings[$id]['avg_rating'] ?? 0;
            $p['total_reviews'] = $ratings[$id]['total_reviews'] ?? 0;
            if ($p['gia'] < $min_price) { $min_price = $p['gia']; $cheapest_id = $id; }
            if ($p['luot_ban'] > $max_sales) { $max_sales = $p['luot_ban']; $bestseller_id = $id; }
            if ($p['rating'] > $max_rating) { $max_rating = $p['rating']; $highest_rated_id = $id; }
            $p['badges'] = [];
        }

        foreach ($products as &$p) {
            if ($p['id'] == $cheapest_id && count($products) > 1) $p['badges'][] = ['text' => '💰 Rẻ nhất', 'bg' => '#e74c3c'];
            if ($p['id'] == $bestseller_id && $max_sales > 0 && count($products) > 1) $p['badges'][] = ['text' => '🔥 Bán chạy', 'bg' => '#f39c12'];
            if ($p['id'] == $highest_rated_id && $max_rating > 0 && count($products) > 1) $p['badges'][] = ['text' => '⭐ Tốt nhất', 'bg' => '#28a745'];
        }

        $this->view('product/SoSanh', ['products' => $products]);
    }
}