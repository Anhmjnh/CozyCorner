<?php
// controllers/WebhookController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/OrderModel.php';

// Load thư viện PHPMailer và các model cần thiết
require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../models/UserModel.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class WebhookController {
    // --- WEBHOOK GHN  ---
    public function ghn() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        // Nhận dữ liệu từ GHN qua Webhook
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data || !isset($data['OrderCode']) || !isset($data['Status'])) {
            header('HTTP/1.0 400 Bad Request');
            echo json_encode(['success' => false, 'message' => 'No data received']);
            exit;
        }

        $ghn_order_code = $data['OrderCode'];
        $status = $data['Status']; // Trạng thái của GHN: cancel, delivered, ...

        $orderModel = new OrderModel();
        $order_id = $orderModel->getOrderIdByGhnCode($ghn_order_code);

        if ($order_id) {
            // Cập nhật trạng thái Hủy từ GHN
            if ($status === 'cancel') {
                $orderModel->updateOrderStatus($order_id, 'Huy');
            } 
            // Cập nhật trạng thái Hoàn thành khi giao hàng thành công 
            elseif ($status === 'delivered') {
                $orderModel->updateOrderStatus($order_id, 'HoanThanh');
                
                $user_id = $orderModel->getUserIdByOrderId($order_id);
                if ($user_id) {
                    $userModel = new UserModel();
                    $userModel->updateUserRank($user_id);
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

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
        
        // Nếu không có dữ liệu thì dừng lại 
        if (!$data) {
            echo json_encode(['success' => false, 'message' => 'No data received']);
            exit;
        }

        // 2. Lấy nội dung chuyển khoản và số tiền từ SePay gửi về
        $content = $data['content'] ?? ''; 
        $amount = intval($data['transferAmount'] ?? 0);

        // 3. Dùng Regex tìm mã đơn hàng trong nội dung 
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

                    // GỬI EMAIL XÁC NHẬN KHI THANH TOÁN QR THÀNH CÔNG
                    $userModel = new UserModel();
                    $user = $userModel->getUserById($user_id);
                    $orderDetails = $orderModel->getOrderDetails($order_id); // Lấy chi tiết sản phẩm

                    if ($user && !empty($orderDetails)) {
                        $this->sendOrderConfirmationEmail($user, $order_id, $orderInfo['tong_tien'], $orderDetails);
                    }
                }
            }
        }
        
       
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }

    // --- HÀM GỬI EMAIL  ---
    private function sendOrderConfirmationEmail($user, $order_id, $tong_tien_cuoi, $cartItems) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USERNAME;
            $mail->Password   = SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = SMTP_PORT;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(SMTP_USERNAME, 'COZY CORNER');
            $mail->addAddress($user['email'], $user['ho_ten']);

            $mail->isHTML(true);
            $mail->Subject = "Thanh toán thành công đơn hàng #ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT);
            
            $itemsHtml = '';
            foreach ($cartItems as $item) {
                // Lấy tên sản phẩm từ 'ten_sp' nếu có, nếu không thì từ 'name'
                $itemName = $item['ten_sp'] ?? ($item['name'] ?? 'Sản phẩm');
                $subtotal = number_format($item['gia'] * $item['so_luong'], 0, ',', '.');
                $price = number_format($item['gia'], 0, ',', '.');
                $itemsHtml .= "
                    <tr>
                        <td style='padding: 10px; border-bottom: 1px solid #eee;'>{$itemName}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: center;'>{$item['so_luong']}</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$price}đ</td>
                        <td style='padding: 10px; border-bottom: 1px solid #eee; text-align: right;'>{$subtotal}đ</td>
                    </tr>
                ";
            }

            $totalFormatted = number_format($tong_tien_cuoi, 0, ',', '.');

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);'>
                    <div style='background-color: #2e5932; color: #fff; padding: 25px; text-align: center;'>
                        <h2 style='margin: 0; font-size: 24px;'>Thanh Toán Thành Công!</h2>
                    </div>
                    <div style='padding: 30px; color: #444; line-height: 1.6;'>
                        <p style='font-size: 16px;'>Xin chào <strong>{$user['ho_ten']}</strong>,</p>
                        <p style='font-size: 15px;'>COZY CORNER xác nhận đã nhận được thanh toán cho đơn hàng <strong>#ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT) . "</strong>. Chúng tôi sẽ sớm giao hàng cho bạn.</p>
                        
                        <h3 style='border-bottom: 2px solid #eee; padding-bottom: 10px; color: #2e5932; margin-top: 30px;'>Chi tiết đơn hàng</h3>
                        <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;'>
                            <thead><tr style='background-color: #f8fbf9;'><th style='padding: 12px 10px; text-align: left; border-bottom: 2px solid #ddd; color: #2e5932;'>Sản phẩm</th><th style='padding: 12px 10px; text-align: center; border-bottom: 2px solid #ddd; color: #2e5932;'>SL</th><th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd; color: #2e5932;'>Đơn giá</th><th style='padding: 12px 10px; text-align: right; border-bottom: 2px solid #ddd; color: #2e5932;'>Thành tiền</th></tr></thead>
                            <tbody>{$itemsHtml}</tbody>
                            <tfoot><tr><td colspan='3' style='padding: 20px 10px; text-align: right;'>Tổng thanh toán:</td><td style='padding: 20px 10px; text-align: right;'>{$totalFormatted}đ</td></tr></tfoot>
                        </table>
                        <p style='text-align: center; margin-top: 35px;'><a href='" . BASE_URL . "index.php?url=user/account&tab=orders' style='background-color: #2e5932; color: #fff; padding: 14px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;'>Xem Lịch Sử Đơn Hàng</a></p>
                    </div>
                    <div style='background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 13px; color: #888; border-top: 1px solid #eee;'><p style='margin: 0 0 5px 0;'>Đây là email tự động từ hệ thống, vui lòng không trả lời email này.</p><p style='margin: 0; font-weight: bold;'>© " . date('Y') . " COZY CORNER.</p></div>
                </div>
            ";
            
            $mail->send();
        } catch (Exception $e) {
            error_log("Lỗi gửi mail xác nhận thanh toán QR: " . $mail->ErrorInfo);
        }
    }
}