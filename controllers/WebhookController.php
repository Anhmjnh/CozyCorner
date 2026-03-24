<?php
// controllers/WebhookController.php
require_once __DIR__ . '/../config.php';

class WebhookController {
    public function sepay() {
        // [BẢO MẬT 1] Chỉ nhận phương thức POST (Tránh việc ai đó gõ URL lên trình duyệt)
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        // [BẢO MẬT 2] Xác thực API Key từ SePay
        $headers = getallheaders();
        $mySecretKey = 'anhminh1902'; // Khớp chính xác với API Key bạn đã thiết lập trên SePay
        
        if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Apikey ' . $mySecretKey) {
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
            
            $conn = connectDB();
            // Lấy thông tin đơn hàng để so sánh số tiền
            $stmt = $conn->prepare("SELECT tong_tien, trang_thai FROM orders WHERE id = ?");
            $stmt->bind_param("i", $order_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // 4. Nếu khách chuyển ĐỦ HOẶC DƯ tiền & Đơn đang chờ xác nhận
                if ($amount >= floatval($row['tong_tien']) && $row['trang_thai'] === 'ChoXacNhan') {
                    // Cập nhật trạng thái thành Đang giao (Hoặc bạn có thể thêm trạng thái 'DaThanhToan')
                    $updateStmt = $conn->prepare("UPDATE orders SET trang_thai = 'DangGiao' WHERE id = ?");
                    $updateStmt->bind_param("i", $order_id);
                    $updateStmt->execute();
                    $updateStmt->close();
                }
            }
            $stmt->close();
            $conn->close();
        }
        
        // 5. Luôn trả về HTTP 200 JSON để SePay biết code bạn đã nhận, không gửi lại nữa gây spam
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
}