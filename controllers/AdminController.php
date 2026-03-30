<?php
// controllers/AdminController.php
require_once __DIR__ . '/../core/Controller.php';

class AdminController extends Controller
{
    private $model;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $this->model = $this->model('AdminModel');

        // Middleware Check Login
        if (!isset($_SESSION['admin_id'])) {
            header("Location: " . BASE_URL . "view/user/DangNhap.php");
            exit;
        }
    }

    public function logout()
    {

        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_name']);
        unset($_SESSION['admin_avatar']);
        unset($_SESSION['admin_role']);

        header("Location: " . BASE_URL . "view/user/DangNhap.php");
        exit;
    }

    // --- VIEWS ---
    public function index()
    {
        $stats = $this->model->getDashboardStats();
        $this->view('../admin/index', [
            'stats' => $stats
        ]);
    }

    public function products()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');

        $products = $this->model->getProducts($limit, $offset, $search, $category);
        $total = $this->model->getTotalProductsCount($search, $category);
        $totalPages = ceil($total / $limit);
        $all_categories = $this->model->getCategories();

        $this->view('../admin/products', [
            'products' => $products,
            'total' => $total,
            'totalPages' => $totalPages,
            'all_categories' => $all_categories,
            'search' => $search,
            'category' => $category,
            'page' => $page
        ]);
    }

    public function users()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $hang = trim($_GET['hang'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        $users = $this->model->getUsersList($limit, $offset, $search, $hang, $trang_thai);
        $total = $this->model->getTotalUsersCount($search, $hang, $trang_thai);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/users', [
            'users' => $users,
            'total' => $total,
            'totalPages' => $totalPages,
            'search' => $search,
            'hang' => $hang,
            'trang_thai' => $trang_thai,
            'page' => $page
        ]);
    }

    public function categories()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        $categories = $this->model->getCategoriesList($limit, $offset, $search, $trang_thai);
        $total = $this->model->getTotalCategoriesCount($search, $trang_thai);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/categories', [
            'categories' => $categories,
            'total' => $total,
            'totalPages' => $totalPages,
            'search' => $search,
            'trang_thai' => $trang_thai,
            'page' => $page
        ]);
    }

    public function staffs()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $vai_tro = trim($_GET['vai_tro'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        $staffs = $this->model->getStaffsList($limit, $offset, $search, $vai_tro, $trang_thai);
        $total = $this->model->getTotalStaffsCount($search, $vai_tro, $trang_thai);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/staffs', [
            'staffs' => $staffs,
            'total' => $total,
            'totalPages' => $totalPages,
            'search' => $search,
            'vai_tro' => $vai_tro,
            'trang_thai' => $trang_thai,
            'page' => $page
        ]);
    }

    public function orders()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 15;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');
        $from_date = trim($_GET['from_date'] ?? '');
        $to_date = trim($_GET['to_date'] ?? '');

        $orders = $this->model->getOrdersList($limit, $offset, $search, $trang_thai, $from_date, $to_date);
        $total = $this->model->getTotalOrdersCount($search, $trang_thai, $from_date, $to_date);
        $total_revenue = $this->model->getTotalRevenue($search, $trang_thai, $from_date, $to_date);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/orders', [
            'orders' => $orders,
            'total' => $total,
            'total_revenue' => $total_revenue,
            'totalPages' => $totalPages,
            'search' => $search,
            'trang_thai' => $trang_thai,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'page' => $page
        ]);
    }

    public function chatbot_faq()
    {
        $this->view('../admin/chatbot_faq');
    }

    public function export_orders_to_csv()
    {
        // Lấy các tham số lọc tương tự trang danh sách đơn hàng
        $search = trim($_GET['search'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');
        $from_date = trim($_GET['from_date'] ?? '');
        $to_date = trim($_GET['to_date'] ?? '');

        // Lấy tất cả dữ liệu đơn hàng phù hợp với bộ lọc (không phân trang)
        $orders = $this->model->getOrdersForExport($search, $trang_thai, $from_date, $to_date);

        // Đặt tên file và header
        $filename = "cozycorner_orders_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Mở output stream
        $output = fopen('php://output', 'w');


        fputs($output, chr(0xFF) . chr(0xFE));

        $memory = fopen('php://memory', 'w+');

        // Ghi dòng tiêu đề
        fputcsv($memory, [
            'ID Đơn Hàng',
            'Mã Vận Đơn',
            'Tên Khách Hàng',
            'Tổng Tiền',
            'Phí Ship',
            'Giảm Giá TV',
            'Mã Voucher',
            'Giảm Giá Voucher',
            'Địa Chỉ Giao',
            'Trạng Thái',
            'PT Thanh Toán',
            'Ghi Chú',
            'Ngày Tạo'
        ], "\t"); // Sử dụng Tab làm dấu phân cách

        // Ghi dữ liệu
        if (!empty($orders)) {
            foreach ($orders as $order) {
                // Thêm khoảng trắng trước ngày tháng để Excel hiểu là dạng Text, tránh hiển thị lỗi '###'
                if (!empty($order['created_at'])) {
                    $order['created_at'] = " " . date('d/m/Y H:i:s', strtotime($order['created_at']));
                }
                fputcsv($memory, $order, "\t");
            }
        }

        // Đọc dữ liệu từ bộ đệm, chuyển sang UTF-16LE và xuất ra file
        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);

        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));

        fclose($output);
        exit;
    }

    public function export_products_to_csv()
    {
        // Lấy các tham số lọc
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? '');

        // Lấy tất cả dữ liệu sản phẩm phù hợp
        $products = $this->model->getProductsForExport($search, $category);

        // Đặt tên file và header
        $filename = "cozycorner_products_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Mở output stream
        $output = fopen('php://output', 'w');

        // Ghi BOM cho UTF-16LE
        fputs($output, chr(0xFF) . chr(0xFE));

        // Dùng bộ đệm
        $memory = fopen('php://memory', 'w+');

        // Ghi dòng tiêu đề
        fputcsv($memory, [
            'ID', 'Tên SP', 'Slug', 'Giá', 'Giá Cũ', 'Mô Tả', 'Ảnh', 'Danh Mục', 'Cân nặng (g)', 'Tồn kho', 'Lượt bán', 'Trạng thái', 'Ngày Tạo'
        ], "\t");

        // Ghi dữ liệu
        if (!empty($products)) {
            foreach ($products as $product) {
                if (!empty($product['created_at'])) {
                    $product['created_at'] = " " . date('d/m/Y H:i:s', strtotime($product['created_at']));
                }
                fputcsv($memory, $product, "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function export_categories_to_csv()
    {
        // Lấy các tham số lọc
        $search = trim($_GET['search'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        // Lấy tất cả dữ liệu danh mục phù hợp
        $categories = $this->model->getCategoriesForExport($search, $trang_thai);

        // Đặt tên file và header
        $filename = "cozycorner_categories_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Mở output stream
        $output = fopen('php://output', 'w');

        // Ghi BOM cho UTF-16LE
        fputs($output, chr(0xFF) . chr(0xFE));

        // Dùng bộ đệm
        $memory = fopen('php://memory', 'w+');

        // Ghi dòng tiêu đề
        fputcsv($memory, [
            'ID', 'Tên Danh Mục', 'Slug', 'Trạng Thái', 'Ngày Tạo'
        ], "\t");

        // Ghi dữ liệu
        if (!empty($categories)) {
            foreach ($categories as $category) {
                if (isset($category['trang_thai'])) {
                    $category['trang_thai'] = ($category['trang_thai'] == 'HienThi') ? 'Hiển Thị' : 'Ẩn';
                }
                if (!empty($category['created_at'])) {
                    $category['created_at'] = " " . date('d/m/Y H:i:s', strtotime($category['created_at']));
                }
                fputcsv($memory, $category, "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function export_vouchers_to_csv()
    {
        $voucherModel = $this->model('VoucherModel');

        // Lấy các tham số lọc
        $search = trim($_GET['search'] ?? '');
        $loai_voucher = trim($_GET['loai_voucher'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        // Lấy tất cả dữ liệu voucher phù hợp
        $vouchers = $voucherModel->getVouchersForExport($search, $loai_voucher, $trang_thai);

        // Đặt tên file và header
        $filename = "cozycorner_vouchers_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        // Mở output stream
        $output = fopen('php://output', 'w');

        // Ghi BOM cho UTF-16LE
        fputs($output, chr(0xFF) . chr(0xFE));

        // Dùng bộ đệm
        $memory = fopen('php://memory', 'w+');

        // Ghi dòng tiêu đề
        fputcsv($memory, [
            'ID', 'Mã Voucher', 'Loại', 'Giá trị', 'Giảm tối đa', 'Đơn tối thiểu', 'Số lượng', 'Đã dùng', 'Ngày bắt đầu', 'Ngày hết hạn', 'Trạng thái'
        ], "\t");

        // Ghi dữ liệu
        if (!empty($vouchers)) {
            foreach ($vouchers as $voucher) {
                if (isset($voucher['loai_voucher'])) {
                    switch ($voucher['loai_voucher']) {
                        case 'PhanTram':
                            $voucher['loai_voucher'] = 'Phần Trăm';
                            break;
                        case 'TienMat':
                            $voucher['loai_voucher'] = 'Tiền Mặt';
                            break;
                        case 'FreeShip':
                            $voucher['loai_voucher'] = 'Miễn phí vận chuyển';
                            break;
                    }
                }
                if (isset($voucher['trang_thai'])) {
                    $voucher['trang_thai'] = ($voucher['trang_thai'] == 'HoatDong') ? 'Hoạt Động' : 'Khóa';
                }
                if (!empty($voucher['ngay_bat_dau'])) {
                    $voucher['ngay_bat_dau'] = " " . date('d/m/Y H:i:s', strtotime($voucher['ngay_bat_dau']));
                }
                if (!empty($voucher['ngay_het_han'])) {
                    $voucher['ngay_het_han'] = " " . date('d/m/Y H:i:s', strtotime($voucher['ngay_het_han']));
                }

                fputcsv($memory, [
                    $voucher['id'], $voucher['ma_voucher'], $voucher['loai_voucher'], $voucher['gia_tri'], $voucher['giam_toi_da'], $voucher['don_toi_thieu'], $voucher['so_luong'], $voucher['da_dung'], $voucher['ngay_bat_dau'], $voucher['ngay_het_han'], $voucher['trang_thai']
                ], "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function export_users_to_csv()
    {
        // Lấy các tham số lọc
        $search = trim($_GET['search'] ?? '');
        $hang = trim($_GET['hang'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        // Lấy tất cả dữ liệu người dùng phù hợp
        $users = $this->model->getUsersForExport($search, $hang, $trang_thai);

        // Đặt tên file và header
        $filename = "cozycorner_users_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputs($output, chr(0xFF) . chr(0xFE));
        $memory = fopen('php://memory', 'w+');

        fputcsv($memory, ['ID', 'Họ Tên', 'Email', 'SĐT', 'Địa chỉ', 'Giới tính', 'Hạng', 'Trạng thái', 'Ngày sinh', 'Ngày đăng ký'], "\t");

        if (!empty($users)) {
            foreach ($users as $user) {
                $user['trang_thai'] = ($user['trang_thai'] == 'HoatDong') ? 'Hoạt Động' : 'Khóa';
                $user['created_at'] = " " . date('d/m/Y H:i:s', strtotime($user['created_at']));
                fputcsv($memory, [$user['id'], $user['ho_ten'], $user['email'], $user['so_dien_thoai'], $user['dia_chi'], $user['gioi_tinh'], $user['hang'], $user['trang_thai'], $user['ngay_sinh'], $user['created_at']], "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function export_staffs_to_csv()
    {
        $search = trim($_GET['search'] ?? '');
        $vai_tro = trim($_GET['vai_tro'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        $staffs = $this->model->getStaffsForExport($search, $vai_tro, $trang_thai);

        $filename = "cozycorner_staffs_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputs($output, chr(0xFF) . chr(0xFE));
        $memory = fopen('php://memory', 'w+');

        fputcsv($memory, ['ID', 'Username', 'Họ Tên', 'Email', 'SĐT', 'Vai Trò', 'Trạng Thái', 'Ngày Tham Gia'], "\t");

        if (!empty($staffs)) {
            foreach ($staffs as $staff) {
                $staff['trang_thai'] = ($staff['trang_thai'] == 'HoatDong') ? 'Hoạt Động' : 'Khóa';
                $staff['created_at'] = " " . date('d/m/Y H:i:s', strtotime($staff['created_at']));
                fputcsv($memory, [$staff['id'], $staff['username'], $staff['ho_ten'], $staff['email'], $staff['so_dien_thoai'], $staff['vai_tro'], $staff['trang_thai'], $staff['created_at']], "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function export_news_to_csv()
    {
        $newsModel = $this->model('NewsModel');
        $search = trim($_GET['search'] ?? '');
        $danh_muc = trim($_GET['danh_muc'] ?? '');
        $newsList = $newsModel->getNewsForExport($search, $danh_muc);

        $filename = "cozycorner_news_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=UTF-16LE');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputs($output, chr(0xFF) . chr(0xFE));
        $memory = fopen('php://memory', 'w+');

        fputcsv($memory, ['ID', 'Tiêu Đề', 'Slug', 'Danh Mục', 'Lượt Xem', 'Trạng Thái', 'Ngày Tạo'], "\t");

        if (!empty($newsList)) {
            foreach ($newsList as $news) {
                $news['trang_thai'] = ($news['trang_thai'] == 'HienThi') ? 'Hiển Thị' : 'Ẩn';
                $news['created_at'] = " " . date('d/m/Y H:i:s', strtotime($news['created_at']));
                fputcsv($memory, [$news['id'], $news['tieu_de'], $news['slug'], $news['danh_muc'], $news['luot_xem'], $news['trang_thai'], $news['created_at']], "\t");
            }
        }

        rewind($memory);
        $csv_data = stream_get_contents($memory);
        fclose($memory);
        fputs($output, mb_convert_encoding($csv_data, 'UTF-16LE', 'UTF-8'));
        fclose($output);
        exit;
    }

    public function vouchers()
    {
        $voucherModel = $this->model('VoucherModel');
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $loai_voucher = trim($_GET['loai_voucher'] ?? '');
        $trang_thai = trim($_GET['trang_thai'] ?? '');

        $vouchers = $voucherModel->getVouchersList($limit, $offset, $search, $loai_voucher, $trang_thai);
        $total = $voucherModel->getTotalVouchersCount($search, $loai_voucher, $trang_thai);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/vouchers', [
            'vouchers' => $vouchers,
            'total' => $total,
            'totalPages' => $totalPages,
            'search' => $search,
            'loai_voucher' => $loai_voucher,
            'trang_thai' => $trang_thai,
            'page' => $page
        ]);
    }

    public function news()
    {
        $newsModel = $this->model('NewsModel');

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $search = trim($_GET['search'] ?? '');
        $danh_muc = trim($_GET['danh_muc'] ?? '');

        $newsList = $newsModel->getAdminNewsList($limit, $offset, $search, $danh_muc);
        $total = $newsModel->getTotalAdminNewsCount($search, $danh_muc);
        $totalPages = ceil($total / $limit);

        $this->view('../admin/news', [
            'newsList' => $newsList,
            'total' => $total,
            'totalPages' => $totalPages,
            'search' => $search,
            'danh_muc' => $danh_muc,
            'page' => $page
        ]);
    }

    // --- AJAX APIs ---
    public function api_get_admin_profile()
    {
        header('Content-Type: application/json');
        $admin = $this->model->getAdminById($_SESSION['admin_id']);
        if ($admin) {
            unset($admin['password']); // Xóa password khỏi response để bảo mật
            echo json_encode(['status' => 'success', 'data' => $admin]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy thông tin admin.']);
        }
        exit;
    }

    public function api_update_admin_profile()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin_id = $_SESSION['admin_id'];
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $dia_chi = trim($_POST['dia_chi'] ?? '');
            $gioi_tinh = $_POST['gioi_tinh'] ?? 'Nam';
            $ngay_sinh = trim($_POST['ngay_sinh'] ?? '');

            $current_password = trim($_POST['current_password'] ?? '');
            $new_password = trim($_POST['new_password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');

            if (empty($ho_ten) || empty($email)) {
                echo json_encode(['status' => 'error', 'msg' => 'Họ tên và email không được để trống.']);
                exit;
            }

            // Kiểm tra đổi mật khẩu
            $changePassword = ($current_password !== '' || $new_password !== '' || $confirm_password !== '');
            if ($changePassword) {
                if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                    echo json_encode(['status' => 'error', 'msg' => 'Vui lòng điền đủ thông tin đổi mật khẩu.']);
                    exit;
                }
                if ($new_password !== $confirm_password) {
                    echo json_encode(['status' => 'error', 'msg' => 'Mật khẩu xác nhận không khớp.']);
                    exit;
                }
                if (strlen($new_password) < 6) {
                    echo json_encode(['status' => 'error', 'msg' => 'Mật khẩu mới phải có ít nhất 6 ký tự.']);
                    exit;
                }
                $admin = $this->model->getAdminById($admin_id);
                if (!password_verify($current_password, $admin['password']) && $current_password !== $admin['password']) {
                    echo json_encode(['status' => 'error', 'msg' => 'Mật khẩu hiện tại không đúng.']);
                    exit;
                }
            }

            // Xử lý Avatar
            $avatar = null;
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                $target_dir = __DIR__ . "/../uploads/";
                $filename = time() . "_admin_" . basename($_FILES["avatar"]["name"]);
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                    $avatar = $filename;
                }
            }

            // Lưu CSDL
            if ($this->model->updateAdminProfile($admin_id, $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $avatar)) {
                if ($changePassword) {
                    $newHash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->model->updateAdminPassword($admin_id, $newHash);
                }

                $_SESSION['admin_name'] = $ho_ten;
                if ($avatar)
                    $_SESSION['admin_avatar'] = $avatar;

                echo json_encode([
                    'status' => 'success',
                    'msg' => 'Cập nhật thông tin thành công!',
                    'name' => $ho_ten,
                    'avatar' => $_SESSION['admin_avatar'] ?? null
                ]);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại.']);
            }
        }
        exit;
    }

    public function api_chart_data()
    {
        header('Content-Type: application/json');
        echo json_encode($this->model->getRevenueChartData());
        exit;
    }

    public function api_add_product()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_sp = $_POST['ten_sp'] ?? '';
            $gia = $_POST['gia'] ?? 0;
            $gia_cu = $_POST['gia_cu'] ?? 0;
            $danh_muc = $_POST['danh_muc'] ?? 'Khac';
            $so_luong = $_POST['so_luong'] ?? 0;
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';
            $mo_ta = $_POST['mo_ta'] ?? '';

            // Xử lý upload ảnh
            $anh = '';
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $target_dir = __DIR__ . "/../uploads/";
                $filename = time() . "_" . basename($_FILES["anh"]["name"]);
                $target_file = $target_dir . $filename;
                if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_file)) {
                    $anh = $filename;
                }
            }

            if ($this->model->addProduct($ten_sp, $gia, $gia_cu, $danh_muc, $so_luong, $trang_thai, $anh, $mo_ta)) {
                echo json_encode(['status' => 'success', 'msg' => 'Thêm sản phẩm thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi thêm vào CSDL.']);
            }
        }
        exit;
    }

    public function api_delete_product()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($this->model->deleteProduct($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa.']);
            }
        }
        exit;
    }

    public function api_get_user()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $user = $this->model->getUserById($id);
        if ($user) {
            echo json_encode(['status' => 'success', 'data' => $user]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy người dùng.']);
        }
        exit;
    }

    public function api_save_user()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';
            $gioi_tinh = $_POST['gioi_tinh'] ?? 'Nam';
            $ngay_sinh = !empty($_POST['ngay_sinh']) ? $_POST['ngay_sinh'] : null;
            $hang = $_POST['hang'] ?? 'Đồng';
            $trang_thai = $_POST['trang_thai'] ?? 'HoatDong';
            $mat_khau = $_POST['mat_khau'] ?? '';

            if (!empty($ho_ten) && !empty($email)) {
                if (empty($id)) { // Logic Thêm Mới
                    if (empty($mat_khau)) {
                        echo json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập mật khẩu cho người dùng mới.']);
                        exit;
                    }
                    $hash = password_hash($mat_khau, PASSWORD_DEFAULT);
                    if ($this->model->addUser($ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai, $hash)) {
                        echo json_encode(['status' => 'success', 'msg' => 'Thêm người dùng thành công!']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Email này có thể đã tồn tại trong hệ thống.']);
                    }
                } else {
                    // Logic Cập Nhật
                    if ($this->model->updateUserAdmin($id, $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh, $hang, $trang_thai)) {
                        if (!empty($mat_khau)) {
                            $this->model->updateUserPassword($id, password_hash($mat_khau, PASSWORD_DEFAULT));
                        }
                        echo json_encode(['status' => 'success', 'msg' => 'Cập nhật người dùng thành công!']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi cập nhật.']);
                    }
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Họ tên và Email không được để trống.']);
            }
        }
        exit;
    }

    public function api_delete_user()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($this->model->deleteUser($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa người dùng thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa! Người dùng này có thể đang liên kết với các dữ liệu khác (như giỏ hàng, đơn hàng).']);
            }
        }
        exit;
    }

    public function api_toggle_user_status()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($this->model->toggleUserStatus($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Cập nhật trạng thái thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể cập nhật.']);
            }
        }
        exit;
    }

    public function api_get_faqs_list()
    {
        header('Content-Type: application/json');
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $search = trim($_GET['search'] ?? '');

        $faqs = $this->model->getFaqsList($limit, $offset, $search);
        $total = $this->model->getTotalFaqsCount($search);
        $totalPages = ceil($total / $limit);

        echo json_encode([
            'status' => 'success',
            'data' => $faqs,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'totalPages' => $totalPages
            ]
        ]);
        exit;
    }

    public function api_get_faq()
    {
        header('Content-Type: application/json');
        $id = intval($_GET['id'] ?? 0);
        $faq = $this->model->getFaqById($id);
        if ($faq) {
            echo json_encode(['status' => 'success', 'data' => $faq]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy câu hỏi.']);
        }
        exit;
    }

    public function api_save_faq()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $keywords = trim($_POST['keywords'] ?? '');
            $answer = trim($_POST['answer'] ?? '');
            $status = $_POST['status'] ?? 'HoatDong';

            if (empty($keywords) || empty($answer)) {
                echo json_encode(['status' => 'error', 'msg' => 'Từ khóa và câu trả lời không được để trống.']);
                exit;
            }

            if ($this->model->saveFaq($id, $keywords, $answer, $status)) {
                $msg = empty($id) ? 'Thêm FAQ thành công!' : 'Cập nhật FAQ thành công!';
                echo json_encode(['status' => 'success', 'msg' => $msg]);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Lưu thất bại. Vui lòng thử lại.']);
            }
        }
        exit;
    }

    public function api_delete_faq()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($this->model->deleteFaq($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa FAQ thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa.']);
            }
        }
        exit;
    }

    // --- API QUẢN LÝ NHÂN SỰ ---
    public function api_get_staff()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $staff = $this->model->getAdminById($id);
        if ($staff) {
            unset($staff['password']);
            echo json_encode(['status' => 'success', 'data' => $staff]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy tài khoản.']);
        }
        exit;
    }

    public function api_save_staff()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $vai_tro = $_POST['vai_tro'] ?? 'Staff';
            $trang_thai = $_POST['trang_thai'] ?? 'HoatDong';

            // Kiểm tra phân quyền: Staff không được tạo mới, không được sửa Admin
            if ($_SESSION['admin_role'] !== 'Admin') {
                if (empty($id)) {
                    echo json_encode(['status' => 'error', 'msg' => 'Bạn không có quyền thêm nhân viên mới.']);
                    exit;
                }
                $targetStaff = $this->model->getAdminById($id);
                if ($targetStaff['vai_tro'] === 'Admin' && $id != $_SESSION['admin_id']) {
                    echo json_encode(['status' => 'error', 'msg' => 'Bạn không có quyền chỉnh sửa thông tin của Admin.']);
                    exit;
                }
                $vai_tro = 'Staff'; // Ép kiểu, staff không thể tự thăng cấp lên Admin
            }

            if (empty($id)) { // THÊM MỚI
                $username = $_POST['username'] ?? '';
                $password = $_POST['password'] ?? '';
                if (empty($username) || empty($password) || empty($ho_ten)) {
                    echo json_encode(['status' => 'error', 'msg' => 'Vui lòng điền đủ thông tin bắt buộc.']);
                    exit;
                }
                $hash = password_hash($password, PASSWORD_DEFAULT);
                if ($this->model->addStaff($username, $email, $ho_ten, $so_dien_thoai, $vai_tro, $trang_thai, $hash)) {
                    echo json_encode(['status' => 'success', 'msg' => 'Thêm nhân sự thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Username hoặc Email có thể đã tồn tại.']);
                }
            } else { // CHỈNH SỬA
                if ($this->model->updateStaffManager($id, $ho_ten, $email, $so_dien_thoai, $vai_tro, $trang_thai)) {
                    if (!empty($_POST['password'])) {
                        $this->model->updateAdminPassword($id, password_hash($_POST['password'], PASSWORD_DEFAULT));
                    }
                    echo json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Lỗi cập nhật.']);
                }
            }
        }
        exit;
    }

    public function api_delete_staff()
    {
        header('Content-Type: application/json');
        if ($_SESSION['admin_role'] !== 'Admin') {
            echo json_encode(['status' => 'error', 'msg' => 'Chỉ Admin mới có quyền xóa.']);
            exit;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($data['id'] == $_SESSION['admin_id']) {
                echo json_encode(['status' => 'error', 'msg' => 'Bạn không thể tự xóa chính mình!']);
                exit;
            }
            if ($this->model->deleteStaff($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa tài khoản thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa.']);
            }
        }
        exit;
    }

    // --- API QUẢN LÝ TIN TỨC ---
    public function api_get_news()
    {
        header('Content-Type: application/json');
        require_once __DIR__ . '/../models/NewsModel.php';
        $newsModel = new NewsModel();
        $id = intval($_GET['id'] ?? 0);
        $data = $newsModel->getNewsById($id);

        if ($data)
            echo json_encode(['status' => 'success', 'data' => $data]);
        else
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy tin tức.']);
        exit;
    }

    public function api_add_news()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsModel = $this->model('NewsModel');

            $tieu_de = trim($_POST['tieu_de'] ?? '');
            $noi_dung = trim($_POST['noi_dung'] ?? '');
            $danh_muc = $_POST['danh_muc'] ?? 'Mẹo vặt';
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

            if (empty($tieu_de) || empty($noi_dung)) {
                echo json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập đủ tiêu đề và nội dung.']);
                exit;
            }

            $anh = '';
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $target_dir = __DIR__ . "/../uploads/";
                $filename = time() . "_news_" . basename($_FILES["anh"]["name"]);
                if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_dir . $filename)) {
                    $anh = $filename;
                }
            }

            if ($newsModel->addNews($tieu_de, $noi_dung, $danh_muc, $trang_thai, $anh))
                echo json_encode(['status' => 'success', 'msg' => 'Thêm tin tức thành công!']);
            else
                echo json_encode(['status' => 'error', 'msg' => 'Thêm tin tức thất bại.']);
        }
        exit;
    }

    public function api_update_news()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newsModel = $this->model('NewsModel');

            $id = intval($_POST['id'] ?? 0);
            $tieu_de = trim($_POST['tieu_de'] ?? '');
            $noi_dung = trim($_POST['noi_dung'] ?? '');
            $danh_muc = $_POST['danh_muc'] ?? 'Mẹo vặt';
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';
            $anh = $_POST['current_anh'] ?? '';

            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $target_dir = __DIR__ . "/../uploads/";
                $filename = time() . "_news_" . basename($_FILES["anh"]["name"]);
                if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_dir . $filename))
                    $anh = $filename;
            }

            if ($newsModel->updateNews($id, $tieu_de, $noi_dung, $danh_muc, $trang_thai, $anh))
                echo json_encode(['status' => 'success', 'msg' => 'Cập nhật thành công!']);
            else
                echo json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại.']);
        }
        exit;
    }

    public function api_delete_news()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            $newsModel = $this->model('NewsModel');
            if ($newsModel->deleteNews($data['id']))
                echo json_encode(['status' => 'success', 'msg' => 'Xóa tin tức thành công!']);
            else
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa tin tức này.']);
        }
        exit;
    }

    // --- API QUẢN LÝ SẢN PHẨM  ---
    public function api_get_product()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $product = $this->model->getProductById($id);
        if ($product) {
            echo json_encode(['status' => 'success', 'data' => $product]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy sản phẩm.']);
        }
        exit;
    }

    public function api_update_product()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $ten_sp = $_POST['ten_sp'] ?? '';
            $gia = $_POST['gia'] ?? 0;
            $gia_cu = $_POST['gia_cu'] ?? 0;
            $danh_muc = $_POST['danh_muc'] ?? 'Khac';
            $so_luong = $_POST['so_luong'] ?? 0;
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';
            $mo_ta = $_POST['mo_ta'] ?? '';

            $anh = null;
            if (isset($_FILES['anh']) && $_FILES['anh']['tmp_name'] != '') {
                $target_dir = __DIR__ . "/../uploads/";
                $filename = time() . "_" . basename($_FILES["anh"]["name"]);
                if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_dir . $filename)) {
                    $anh = $filename;
                }
            } else if (isset($_POST['current_anh'])) {
                $anh = $_POST['current_anh'];
            }

            if ($this->model->updateProduct($id, $ten_sp, $gia, $gia_cu, $danh_muc, $so_luong, $trang_thai, $anh, $mo_ta)) {
                echo json_encode(['status' => 'success', 'msg' => 'Cập nhật sản phẩm thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi cập nhật sản phẩm.']);
            }
        }
        exit;
    }

    // --- API QUẢN LÝ DANH MỤC  ---
    public function api_get_category()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $category = $this->model->getCategoryById($id);
        if ($category) {
            echo json_encode(['status' => 'success', 'data' => $category]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy danh mục.']);
        }
        exit;
    }

    public function api_add_category()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

            if (!empty($ten_danh_muc)) {
                if ($this->model->addCategory($ten_danh_muc, $trang_thai)) {
                    echo json_encode(['status' => 'success', 'msg' => 'Thêm danh mục thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Lỗi: Tên danh mục có thể đã tồn tại.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Tên danh mục không được để trống.']);
            }
        }
        exit;
    }

    public function api_update_category()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

            if (!empty($ten_danh_muc)) {
                if ($this->model->updateCategory($id, $ten_danh_muc, $trang_thai)) {
                    echo json_encode(['status' => 'success', 'msg' => 'Cập nhật danh mục thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Lỗi: Tên danh mục có thể đã tồn tại hoặc không có gì thay đổi.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Tên danh mục không được để trống.']);
            }
        }
        exit;
    }

    public function api_delete_category()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            if ($this->model->deleteCategory($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa danh mục thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa danh mục.']);
            }
        }
        exit;
    }

    // --- API QUẢN LÝ ĐƠN HÀNG  ---
    public function api_get_order()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $order = $this->model->getOrderById($id);

        if ($order) {
            $order['items'] = $this->model->getOrderDetailsByOrderId($id);
            echo json_encode(['status' => 'success', 'data' => $order]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy đơn hàng.']);
        }
        exit;
    }

    public function api_update_order_status()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $trang_thai = $_POST['trang_thai'] ?? '';

            if ($id > 0 && in_array($trang_thai, ['ChoXacNhan', 'DangGiao', 'HoanThanh', 'Huy'])) {
                

                if ($this->model->updateOrderStatus($id, $trang_thai)) {
                    $user_id = $this->model->getUserIdByOrderId($id);
                    if ($user_id) {
                        $userModel = $this->model('UserModel');
                        $userModel->updateUserRank($user_id);
                    }
                    echo json_encode(['status' => 'success', 'msg' => 'Cập nhật trạng thái thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Lỗi cập nhật trạng thái.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ.']);
            }
        }
        exit;
    }

    // --- API QUẢN LÝ VOUCHER ---
    public function api_get_voucher()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? 0;
        $voucherModel = $this->model('VoucherModel');
        $voucher = $voucherModel->getVoucherById($id);
        if ($voucher) {
            // Format lại ngày tháng để input datetime-local có thể nhận
            if ($voucher['ngay_bat_dau']) {
                $voucher['ngay_bat_dau'] = date('Y-m-d\TH:i', strtotime($voucher['ngay_bat_dau']));
            }
            if ($voucher['ngay_het_han']) {
                $voucher['ngay_het_han'] = date('Y-m-d\TH:i', strtotime($voucher['ngay_het_han']));
            }
            echo json_encode(['status' => 'success', 'data' => $voucher]);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy voucher.']);
        }
        exit;
    }

    public function api_save_voucher()
    {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';

            $data = [
                'ma_voucher' => strtoupper(trim($_POST['ma_voucher'] ?? '')),
                'loai_voucher' => $_POST['loai_voucher'] ?? 'TienMat',
                'gia_tri' => intval($_POST['gia_tri'] ?? 0),
                'giam_toi_da' => intval($_POST['giam_toi_da'] ?? 0),
                'don_toi_thieu' => intval($_POST['don_toi_thieu'] ?? 0),
                'so_luong' => intval($_POST['so_luong'] ?? 0),
                'ngay_bat_dau' => !empty($_POST['ngay_bat_dau']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_bat_dau'])) : null,
                'ngay_het_han' => !empty($_POST['ngay_het_han']) ? date('Y-m-d H:i:s', strtotime($_POST['ngay_het_han'])) : null,
                'trang_thai' => $_POST['trang_thai'] ?? 'HoatDong'
            ];

            if (empty($data['ma_voucher']) || $data['gia_tri'] <= 0) {
                echo json_encode(['status' => 'error', 'msg' => 'Mã voucher và Giá trị là bắt buộc.']);
                exit;
            }

            $voucherModel = $this->model('VoucherModel');
            if (empty($id)) { // Thêm mới
                if ($voucherModel->addVoucher($data)) {
                    echo json_encode(['status' => 'success', 'msg' => 'Thêm voucher thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Thêm thất bại. Mã voucher có thể đã tồn tại.']);
                }
            } else { // Cập nhật
                if ($voucherModel->updateVoucher($id, $data)) {
                    echo json_encode(['status' => 'success', 'msg' => 'Cập nhật voucher thành công!']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Cập nhật thất bại. Mã voucher có thể đã tồn tại.']);
                }
            }
        }
        exit;
    }

    public function api_delete_voucher()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            $voucherModel = $this->model('VoucherModel');
            if ($voucherModel->deleteVoucher($data['id'])) {
                echo json_encode(['status' => 'success', 'msg' => 'Xóa voucher thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa voucher.']);
            }
        }
        exit;
    }
}