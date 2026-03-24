<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['status' => 'error', 'msg' => 'Unauthorized']);
    exit;
}

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/AdminModel.php';

$model = new AdminModel();

// --- DEBUGGING START ---
error_log("--- API Request ---");
error_log("POST Data: " . print_r($_POST, true));
error_log("FILES Data: " . print_r($_FILES, true));
// --- DEBUGGING END ---

$action = $_GET['action'] ?? '';

if ($action === 'chart_data') {
    header('Content-Type: application/json');
    echo json_encode($model->getRevenueChartData());
    exit;
}

if ($action === 'add_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $ten_sp = $_POST['ten_sp'] ?? '';
    $gia = $_POST['gia'] ?? 0;
    $gia_cu = $_POST['gia_cu'] ?? 0;
    $danh_muc = $_POST['danh_muc'] ?? 'Khac';
    $so_luong = $_POST['so_luong'] ?? 0;
    $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

    $anh = '';
    if (isset($_FILES['anh']) && $_FILES['anh']['tmp_name'] != '') {
        $target_dir = __DIR__ . "/../uploads/";
        $filename = time() . "_" . basename($_FILES["anh"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_file)) {
            $anh = $filename;
        }
    }
    if ($model->addProduct($ten_sp, $gia, $gia_cu, $danh_muc, $so_luong, $trang_thai, $anh)) {
        echo json_encode(['status' => 'success', 'msg' => 'Thêm sản phẩm thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi thêm vào CSDL.']);
    }
    exit;
}

if ($action === 'get_product') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 0;
    $product = $model->getProductById($id);
    if ($product) {
        echo json_encode(['status' => 'success', 'data' => $product]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy sản phẩm.']);
    }
    exit;
}

if ($action === 'update_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    $ten_sp = $_POST['ten_sp'] ?? '';
    $gia = $_POST['gia'] ?? 0;
    $gia_cu = $_POST['gia_cu'] ?? 0;
    $danh_muc = $_POST['danh_muc'] ?? 'Khac';
    $so_luong = $_POST['so_luong'] ?? 0;
    $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

    $anh = null;
    if (isset($_FILES['anh']) && $_FILES['anh']['tmp_name'] != '') {
        $target_dir = __DIR__ . "/../uploads/";
        $filename = time() . "_" . basename($_FILES["anh"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_file)) {
            $anh = $filename;
        }
    } else if (isset($_POST['current_anh'])) { // Giữ ảnh cũ nếu không upload ảnh mới
        $anh = $_POST['current_anh'];
    }

    if ($model->updateProduct($id, $ten_sp, $gia, $gia_cu, $danh_muc, $so_luong, $trang_thai, $anh)) {
        echo json_encode(['status' => 'success', 'msg' => 'Cập nhật sản phẩm thành công!']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi cập nhật sản phẩm.']);
    }
    exit;
}

if ($action === 'delete_product') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        if ($model->deleteProduct($data['id'])) {
            echo json_encode(['status' => 'success', 'msg' => 'Xóa thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa.']);
        }
    }
    exit;
}

if ($action === 'get_category') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 0;
    $category = $model->getCategoryById($id);
    if ($category) {
        echo json_encode(['status' => 'success', 'data' => $category]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy danh mục.']);
    }
    exit;
}

if ($action === 'update_category' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

    if (!empty($ten_danh_muc)) {
        if ($model->updateCategory($id, $ten_danh_muc, $trang_thai)) {
            echo json_encode(['status' => 'success', 'msg' => 'Cập nhật danh mục thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Lỗi: Tên danh mục có thể đã tồn tại hoặc không có gì thay đổi.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Tên danh mục không được để trống.']);
    }
    exit;
}

if ($action === 'add_category' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $ten_danh_muc = $_POST['ten_danh_muc'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

    if (!empty($ten_danh_muc)) {
        if ($model->addCategory($ten_danh_muc, $trang_thai)) {
            echo json_encode(['status' => 'success', 'msg' => 'Thêm danh mục thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Lỗi: Tên danh mục có thể đã tồn tại.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Tên danh mục không được để trống.']);
    }
    exit;
}

if ($action === 'get_user') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 0;
    $user = $model->getUserById($id);
    if ($user) {
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy người dùng.']);
    }
    exit;
}

if ($action === 'update_user' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    $ho_ten = $_POST['ho_ten'] ?? '';
    $email = $_POST['email'] ?? '';
    $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
    $dia_chi = $_POST['dia_chi'] ?? '';
    $gioi_tinh = $_POST['gioi_tinh'] ?? 'Nam';
    $ngay_sinh = $_POST['ngay_sinh'] ?? null;

    if (!empty($ho_ten) && !empty($email)) {
        if ($model->updateUser($id, $ho_ten, $email, $so_dien_thoai, $dia_chi, $gioi_tinh, $ngay_sinh)) {
            echo json_encode(['status' => 'success', 'msg' => 'Cập nhật người dùng thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi cập nhật người dùng.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Họ tên và Email không được để trống.']);
    }
    exit;
}

if ($action === 'add_news' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $tieu_de = $_POST['tieu_de'] ?? '';
    $noi_dung = $_POST['noi_dung'] ?? '';
    $trang_thai = $_POST['trang_thai'] ?? 'HienThi';

    $anh = null;
    if (isset($_FILES['anh']) && $_FILES['anh']['tmp_name'] != '') {
        $target_dir = __DIR__ . "/../uploads/";
        $filename = time() . "_" . basename($_FILES["anh"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["anh"]["tmp_name"], $target_file)) {
            $anh = $filename;
        }
    }

    if (!empty($tieu_de) && !empty($noi_dung)) {
        if ($model->addNews($tieu_de, $noi_dung, $trang_thai, $anh)) {
            echo json_encode(['status' => 'success', 'msg' => 'Thêm tin tức thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Lỗi khi thêm tin tức.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Tiêu đề và nội dung không được để trống.']);
    }
    exit;
}

if ($action === 'delete_category') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id'])) {
        if ($model->deleteCategory($data['id'])) {
            echo json_encode(['status' => 'success', 'msg' => 'Xóa danh mục thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Không thể xóa danh mục.']);
        }
    }
    exit;
}

// --- API LẤY CHI TIẾT ĐƠN HÀNG ---
if ($action === 'get_order') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 0;
    $conn = connectDB();
    $stmt = $conn->prepare("SELECT o.*, u.ho_ten as user_name FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($order) {
        // Lấy chi tiết các sản phẩm bên trong đơn hàng
        $stmt_items = $conn->prepare("SELECT od.*, p.ten_sp, p.anh FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = ?");
        $stmt_items->bind_param("i", $id);
        $stmt_items->execute();
        $order['items'] = $stmt_items->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt_items->close();
        echo json_encode(['status' => 'success', 'data' => $order]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Không tìm thấy đơn hàng.']);
    }
    $conn->close();
    exit;
}

// --- API CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG ---
if ($action === 'update_order_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    $trang_thai = $_POST['trang_thai'] ?? '';

    if ($id > 0 && in_array($trang_thai, ['ChoXacNhan', 'DangGiao', 'HoanThanh', 'Huy'])) {
        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE orders SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $trang_thai, $id);
        if ($stmt->execute()) {
            // Tự động cập nhật hạng cho user sau khi đổi trạng thái đơn hàng
            require_once __DIR__ . '/../models/UserModel.php';
            $stmtUser = $conn->prepare("SELECT user_id FROM orders WHERE id = ?");
            $stmtUser->bind_param("i", $id);
            $stmtUser->execute();
            $resUser = $stmtUser->get_result()->fetch_assoc();
            if ($resUser && $resUser['user_id']) {
                $userModel = new UserModel();
                $userModel->updateUserRank($resUser['user_id']);
            }
            $stmtUser->close();

            echo json_encode(['status' => 'success', 'msg' => 'Cập nhật trạng thái thành công!']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Lỗi cập nhật trạng thái.']);
        }
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Dữ liệu không hợp lệ.']);
    }
    exit;
}