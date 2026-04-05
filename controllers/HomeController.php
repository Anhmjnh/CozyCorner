<?php
// controllers/HomeController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../core/Controller.php';

class HomeController extends Controller {
    public function index() {
        //  Hủy các đơn hàng QR quá 10 phút
        $orderModel = $this->model('OrderModel');
        $orderModel->cancelExpiredQROrders();

        // Lấy danh sách sản phẩm từ Model
        $productModel = $this->model('ProductModel');
        $bestsellers = $productModel->getBestsellerProducts(9);
        $new_products = $productModel->getNewProducts(9);

        // Lấy danh sách tin tức mới nhất từ Model
        $newsModel = $this->model('NewsModel');
        $news_list = $newsModel->getLatestNews(3);

        // Nạp view hiển thị và truyền dữ liệu sang
        $this->view('TrangChu', [
            'bestsellers' => $bestsellers,
            'new_products' => $new_products,
            'news_list' => $news_list
        ]);
    }
}
?>