<?php
// controllers/WebhookController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/OrderModel.php';

class WebhookController {
    public function sepay() {
        //  Chỉ nhận phương thức POST 
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        //  Xác thực API Key từ SePay
        $headers = getallheaders();
        $mySecretKey = defined('SEPAY_WEBHOOK_SECRET') ? SEPAY_WEBHOOK_SECRET : ''; 
        
        if (empty($mySecretKey) || !isset($headers['Authorization']) || $headers['Authorization'] !== 'Apikey ' . $mySecretKey) {
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(['success' => false, 'message' => 'Sai API Key bảo mật!']);
            exit;
        }

        // 1. SePay sẽ gửi dữ liệu báo biến động số dư dạng JSON thông qua phương thức POST
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Nếu không có dữ liệu thì dừng lại (Tránh lỗi khi ai đó cố tình vào link này)
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'No data received']);
            exit;
        }

        // 2. Lấy nội dung chuyển khoản và số tiền từ SePay gửi về
        $content = $data['content'] ?? ''; 
        $amount = intval($data['transferAmount'] ?? 0);

        // 3. Dùng Regex tìm mã đơn hàng trong nội dung (Ví dụ khách quét QR nó ra nội dung: "Thanh toan don hang ORD12")
        preg_match('/ORD(\d+)/i', $content, $matches);
        
        if (isset($matches[1])) {
            $order_id = intval($matches[1]);
            
            $orderModel = new OrderModel();
            $orderInfo = $orderModel->getOrderForWebhook($order_id);

            if ($orderInfo) {
                // 4. Nếu khách chuyển ĐỦ HOẶC DƯ tiền & Đơn đang chờ xác nhận
                if ($amount >= floatval($orderInfo['tong_tien']) && $orderInfo['trang_thai'] === 'ChoXacNhan') {
                    // Cập nhật trạng thái thành Đang giao (Hoặc bạn có thể thêm trạng thái 'DaThanhToan')
                    $orderModel->updateOrderStatus($order_id, 'DangGiao');
                    
                    // Cập nhật hạng thành viên
                    require_once __DIR__ . '/../models/UserModel.php';
                    $user_id = $orderModel->getUserIdByOrderId($order_id);
                    if ($user_id) {
                        $userModel = new UserModel();
                        $userModel->updateUserRank($user_id);
                    }
                }
            }
        }
        
        // 5. Luôn trả về HTTP 200 JSON để SePay biết code bạn đã nhận, không gửi lại nữa gây spam
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}