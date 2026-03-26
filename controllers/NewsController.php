<?php
// controllers/NewsController.php
require_once __DIR__ . '/../config.php';

class NewsController {
    // Danh mục tin tức (trang list)
    public function index() {
        $conn = connectDB();

        // Load tất cả tin tức hiển thị (mới nhất trước)
        $query = "SELECT * FROM news WHERE trang_thai = 'HienThi' ORDER BY created_at DESC LIMIT 12";
        $result = $conn->query($query);

        $news_list = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $news_list[] = $row;
            }
        }

        $conn->close();

        // Render view danh mục
        // Chuẩn bị CSS và dữ liệu cho view
        $page_css = ['assets/css/DanhMucTinTuc.css'];
        require_once __DIR__ . '/../view/news/DanhMucTinTuc.php';
    }

    // Chi tiết một bài tin tức (load theo id)
    public function chiTiet() {
        $conn = connectDB();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $news = null;
        $related_news = [];

        if ($id > 0) {
            // Load bài viết chi tiết
            $stmt = $conn->prepare("SELECT * FROM news WHERE id = ? AND trang_thai = 'HienThi'");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $news = $result->fetch_assoc();
            $stmt->close();

            // Nếu có bài viết, load bài liên quan (3 bài mới nhất khác id này)
            if ($news) {
                $related_stmt = $conn->prepare("
                    SELECT * FROM news 
                    WHERE id != ? AND trang_thai = 'HienThi' 
                    ORDER BY created_at DESC 
                    LIMIT 3
                ");
                $related_stmt->bind_param("i", $id);
                $related_stmt->execute();
                $related_result = $related_stmt->get_result();
                while ($row = $related_result->fetch_assoc()) {
                    $related_news[] = $row;
                }
                $related_stmt->close();
            }
        }

        $conn->close();

        // Render view chi tiết
        require_once __DIR__ . '/../view/news/ChiTietTinTuc.php';
    }
}