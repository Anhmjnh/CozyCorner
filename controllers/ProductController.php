<?php
// controllers/ProductController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

class ProductController extends Controller {
    
    // Trang Danh sách / Lọc sản phẩm
    public function index() {
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
        $this->view('product/DanhMucSanPham', [
            'products' => $products,
            'total' => $total,
            'totalPages' => $totalPages,
            'all_categories' => $all_categories,
            'categories_filter' => $categories_filter,
            'sort' => $sort,
            'page' => $page,
            'page_css' => $page_css
        ]);
    }

    // Trang Chi tiết 1 sản phẩm
    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id <= 0) {
            header('Location: ' . BASE_URL . 'index.php?url=product');
            exit;
        }

        $productModel = $this->model('ProductModel');
        $product = $productModel->findById($id);
        $similar_products = $productModel->getSimilarProducts($id, 4);

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
                if (isset($rating_counts[$review['rating']])) $rating_counts[$review['rating']]++;
            }
            $avg_rating = round($total_rating_sum / $total_reviews, 1);
        }

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
            'reviews' => $reviews,
            'total_reviews' => $total_reviews,
            'avg_rating' => $avg_rating,
            'rating_counts' => $rating_counts,
            'is_logged_in' => $is_logged_in,
            'user_info' => $user_info,
            'page_css' => $page_css
        ]);
    }
}