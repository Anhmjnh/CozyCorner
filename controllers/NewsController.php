<?php
// controllers/NewsController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

class NewsController extends Controller {
    // Danh mục tin tức (trang list)
    public function index() {
        // Nhận tham số danh mục từ URL (nếu có)
        $category = isset($_GET['category']) ? trim($_GET['category']) : '';

        // Gọi Model để lấy dữ liệu
        $newsModel = $this->model('NewsModel');
        $news_list = $newsModel->getNewsByFilters($category, 12);

        // Render view danh mục
        // Chuẩn bị CSS và dữ liệu cho view
        $page_css = ['assets/css/DanhMucTinTuc.css'];
        $this->view('news/DanhMucTinTuc', [
            'news_list' => $news_list,
            'page_css' => $page_css
        ]);
    }

    // Chi tiết một bài tin tức (load theo id)
    public function chiTiet() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $news = null;
        $related_news = [];

        if ($id > 0) {
            $newsModel = $this->model('NewsModel');
            
            // Tăng lượt xem lên 1 trước khi lấy dữ liệu hiển thị
            $newsModel->increaseViewCount($id);
            
            // Load bài viết chi tiết
            $news = $newsModel->getNewsById($id);
            if ($news && $news['trang_thai'] === 'HienThi') {
                $related_news = $newsModel->getRelatedNews($id, 3);
            } else {
                $news = null;
            }
        }

        // Render view chi tiết
        $this->view('news/ChiTietTinTuc', [
            'news' => $news,
            'related_news' => $related_news
        ]);
    }
}