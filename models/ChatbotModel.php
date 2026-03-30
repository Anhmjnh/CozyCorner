<?php
// models/ChatbotModel.php
require_once __DIR__ . '/../core/Model.php';

class ChatbotModel extends Model
{
    private $apiKey;
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        parent::__construct();
        $this->apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : '';

        if ($this->conn) {
            $this->conn->set_charset("utf8mb4");


            $this->conn->query("CREATE TABLE IF NOT EXISTS `chat_messages` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) DEFAULT NULL,
              `session_id` varchar(255) DEFAULT NULL,
              `role` enum('user','bot') NOT NULL,
              `content` text NOT NULL,
              `is_cleared` tinyint(1) DEFAULT 0,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");
        }
    }

    // Xác định ý định (Intent Detection)
    private function detectIntent($message)
    {
        $msg = mb_strtolower($message, 'UTF-8');

        if (strpos($msg, 'đơn') !== false || strpos($msg, 'giao') !== false || strpos($msg, 'ord') !== false || strpos($msg, 'kiểm tra') !== false || strpos($msg, 'hủy') !== false)
            return 'ORDER';
        if (strpos($msg, 'mã') !== false || strpos($msg, 'giảm') !== false || strpos($msg, 'voucher') !== false || strpos($msg, 'freeship') !== false)
            return 'PROMOTION';
        if (strpos($msg, 'shop có bán những gì') !== false || strpos($msg, 'shop có gì') !== false || strpos($msg, 'shop bán gì') !== false)
            return 'LIST_CATEGORIES';
        if (strpos($msg, 'nồi') !== false || strpos($msg, 'chảo') !== false || strpos($msg, 'dao') !== false || strpos($msg, 'thớt') !== false || strpos($msg, 'chén') !== false || strpos($msg, 'sản phẩm') !== false || strpos($msg, 'bán') !== false || strpos($msg, 'mua') !== false || strpos($msg, 'máy') !== false || strpos($msg, 'bếp') !== false || strpos($msg, 'ấm') !== false)
            return 'PRODUCT';
        if (strpos($msg, 'bảo hành') !== false || strpos($msg, 'địa chỉ') !== false || strpos($msg, 'shop') !== false || strpos($msg, 'liên hệ') !== false || strpos($msg, 'ở đâu') !== false || strpos($msg, 'bạn là ai') !== false)
            return 'INFO';
        if (strpos($msg, 'mẹo') !== false || strpos($msg, 'cách') !== false || strpos($msg, 'tin tức') !== false || strpos($msg, 'bảo quản') !== false)
            return 'NEWS';

        return 'OTHER';
    }

    // Hàm thu thập từ Database (Lọc theo Intent)
    private function getStoreKnowledge($userMessage, $user_id = null)
    {
        $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/cozycorner/';
        $intent = $this->detectIntent($userMessage);

        $knowledge = "THÔNG TIN CỬA HÀNG COZY CORNER:\n";
        $knowledge .= "- Tên shop: COZY CORNER\n";

        // 1. CHỈ CUNG CẤP THÔNG TIN CỬA HÀNG NẾU CẦN
        if ($intent === 'INFO' || $intent === 'OTHER') {
            $knowledge .= "- Địa chỉ: Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n";
            $knowledge .= "- Hotline: 0888 888 888 | Email: Cozy@cv.com.vn\n";
            $knowledge .= "- Chính sách bảo hành: Hỗ trợ 1 đổi 1 trong 7 ngày nếu có lỗi từ nhà sản xuất.\n";
            $knowledge .= "- Giao hàng & Thanh toán: Giao hàng toàn quốc qua GHN, hỗ trợ thanh toán khi nhận hàng (COD) và chuyển khoản qua mã QR.\n\n";
        }

        // 2. CHỈ TRUY VẤN ĐƠN HÀNG NẾU KHÁCH HỎI VỀ ĐƠN HÀNG
        if ($intent === 'ORDER') {
            if ($user_id) {
                $stmt = $this->conn->prepare("SELECT ho_ten, hang FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                if ($user) {
                    $knowledge .= "THÔNG TIN KHÁCH HÀNG: Tên {$user['ho_ten']}, Hạng {$user['hang']}\n";
                    $stmtOrder = $this->conn->prepare("SELECT id, tong_tien, trang_thai, created_at FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
                    $stmtOrder->bind_param("i", $user_id);
                    $stmtOrder->execute();
                    $orders = $stmtOrder->get_result()->fetch_all(MYSQLI_ASSOC);
                    if (count($orders) > 0) {
                        $knowledge .= "DANH SÁCH MÃ ĐƠN HÀNG CỦA KHÁCH (CHỈ DÙNG ĐỂ TRA CỨU KHI KHÁCH ĐỌC MÃ ĐƠN):\n";
                        foreach ($orders as $o) {
                            $knowledge .= "- Mã: ORD" . str_pad($o['id'], 5, '0', STR_PAD_LEFT) . " | Tiền: " . number_format($o['tong_tien'], 0, ',', '.') . "đ | Trạng thái: " . $o['trang_thai'] . "\n";
                        }
                    } else {
                        $knowledge .= "- Khách chưa có đơn hàng nào.\n";
                    }
                    $knowledge .= "=> Link xem chi tiết tất cả đơn hàng: " . $base_url . "index.php?url=user/account&tab=orders\n\n";
                }
            } else {
                $knowledge .= "KHÁCH HÀNG: Chưa đăng nhập. Hãy khuyên khách đăng nhập để tra cứu trạng thái đơn hàng.\n\n";
            }
        }

        // 3. CHỈ LẤY VOUCHER NẾU CẦN
        if ($intent === 'PROMOTION' || $intent === 'OTHER') {
            $voucherQuery = $this->conn->query("SELECT ma_voucher, loai_voucher, gia_tri, don_toi_thieu FROM vouchers WHERE trang_thai = 'HoatDong' AND (ngay_het_han IS NULL OR ngay_het_han >= NOW()) LIMIT 5");
            $knowledge .= "MÃ GIẢM GIÁ ĐANG CHẠY:\n";
            if ($voucherQuery && $voucherQuery->num_rows > 0) {
                while ($v = $voucherQuery->fetch_assoc()) {
                    $loai = $v['loai_voucher'] == 'PhanTram' ? $v['gia_tri'] . '%' : number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    if ($v['loai_voucher'] == 'FreeShip')
                        $loai = "Freeship tối đa " . number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    $knowledge .= "- Mã '{$v['ma_voucher']}': Giảm {$loai} (Đơn tối thiểu: " . number_format($v['don_toi_thieu'], 0, ',', '.') . "đ).\n";
                }
            } else {
                $knowledge .= "- Hiện tại không có mã giảm giá nào đang hoạt động.\n";
            }
            $knowledge .= "\n";
        }

        // 4. CHỈ LẤY SẢN PHẨM THEO TỪ KHÓA HOẶC GIỚI HẠN
        if ($intent === 'PRODUCT' || $intent === 'OTHER') {
            $search_keyword = '';
            $categories = ['nồi', 'chảo', 'dao', 'thớt', 'chén', 'máy', 'bếp', 'ấm'];
            foreach ($categories as $cat) {
                if (strpos(mb_strtolower($userMessage, 'UTF-8'), $cat) !== false) {
                    $search_keyword = $cat;
                    break;
                }
            }

            $knowledge .= "DANH SÁCH SẢN PHẨM (GIỚI HẠN 6 SẢN PHẨM TỐT NHẤT):\n";
            if ($search_keyword) {
                $stmt = $this->conn->prepare("SELECT id, ten_sp, danh_muc, gia, so_luong_ton FROM products WHERE trang_thai = 'HienThi' AND (ten_sp LIKE ? OR danh_muc LIKE ?) LIMIT 6");
                $like = "%" . $search_keyword . "%";
                $stmt->bind_param("ss", $like, $like);
            } else {
                $stmt = $this->conn->prepare("SELECT id, ten_sp, danh_muc, gia, so_luong_ton FROM products WHERE trang_thai = 'HienThi' ORDER BY luot_ban DESC LIMIT 6");
            }
            $stmt->execute();
            $prodQuery = $stmt->get_result();

            if ($prodQuery && $prodQuery->num_rows > 0) {
                while ($p = $prodQuery->fetch_assoc()) {
                    $trangThai = $p['so_luong_ton'] > 0 ? 'Còn hàng' : 'Hết hàng';
                    $gia = number_format($p['gia'], 0, ',', '.') . 'đ';
                    $link = $base_url . "index.php?url=product/detail&id=" . $p['id'];
                    $knowledge .= "- {$p['ten_sp']} ({$p['danh_muc']}): Giá {$gia} | {$trangThai} | Link: {$link}\n";
                }
            } else {
                $knowledge .= "- Hiện không tìm thấy sản phẩm phù hợp.\n";
            }
            $knowledge .= "\n";
        }

        // 5. CHỈ LẤY TIN TỨC NẾU CẦN
        if ($intent === 'NEWS') {
            $newsQuery = $this->conn->query("SELECT id, tieu_de FROM news WHERE trang_thai = 'HienThi' ORDER BY created_at DESC LIMIT 3");
            $knowledge .= "TIN TỨC / MẸO VẶT:\n";
            if ($newsQuery && $newsQuery->num_rows > 0) {
                while ($n = $newsQuery->fetch_assoc()) {
                    $link = $base_url . "index.php?url=news/chiTiet&id=" . $n['id'];
                    $knowledge .= "- {$n['tieu_de']} | Link: {$link}\n";
                }
            }
        }

        return [
            'intent' => $intent,
            'knowledge' => $knowledge
        ];
    }

    // Gọi API Gemini mang theo Lịch sử Chat
    public function askGemini($userMessage, $chatHistory = [], $user_id = null)
    {
        if (empty($this->apiKey)) {
            return "Lỗi: Hệ thống chưa được cấu hình API Key của AI.";
        }

        $url = $this->apiUrl . '?key=' . $this->apiKey;

        $storeData = $this->getStoreKnowledge($userMessage, $user_id);
        $intent = $storeData['intent'];
        $knowledge = $storeData['knowledge'];
        $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/cozycorner/';


        // 1. HỆ THỐNG HYBRID (RULE-BASED)


        if ($intent === 'INFO') {
            return "Chào bạn, đây là thông tin của COZY CORNER:\n" .
                "- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n" .
                "- **Hotline:** 0888 888 888 | **Email:** Cozy@cv.com.vn\n" .
                "- **Bảo hành:** 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.\n" .
                "- **Giao hàng:** Toàn quốc qua GHN, hỗ trợ COD và chuyển khoản QR.";
        }

        if ($intent === 'ORDER') {
            if (!$user_id) {
                return "Dạ bạn cần [đăng nhập](" . $base_url . "view/user/DangNhap.php) để mình kiểm tra đơn hàng nhé!";
            }

            $stmtOrder = $this->conn->prepare("SELECT id, tong_tien, trang_thai FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 3");
            $stmtOrder->bind_param("i", $user_id);
            $stmtOrder->execute();
            $orders = $stmtOrder->get_result()->fetch_all(MYSQLI_ASSOC);

            if (count($orders) > 0) {
                $reply = "Dạ, đây là các đơn hàng gần nhất của bạn:\n";
                foreach ($orders as $o) {
                    $reply .= "- Mã **ORD" . str_pad($o['id'], 5, '0', STR_PAD_LEFT) . "** | " . number_format($o['tong_tien'], 0, ',', '.') . "đ | Trạng thái: *" . $o['trang_thai'] . "*\n";
                }
                $reply .= "\n👉 [Xem chi tiết tất cả đơn hàng](" . $base_url . "index.php?url=user/account&tab=orders)";
                return $reply;
            }
            return "Hiện tại hệ thống chưa ghi nhận đơn hàng nào của bạn ạ.";
        }

        if ($intent === 'PROMOTION') {
            $voucherQuery = $this->conn->query("SELECT ma_voucher, loai_voucher, gia_tri, don_toi_thieu FROM vouchers WHERE trang_thai = 'HoatDong' AND (ngay_het_han IS NULL OR ngay_het_han >= NOW()) LIMIT 5");
            if ($voucherQuery && $voucherQuery->num_rows > 0) {
                $reply = "🎁 Hiện shop đang có các mã giảm giá sau:\n";
                while ($v = $voucherQuery->fetch_assoc()) {
                    $loai = $v['loai_voucher'] == 'PhanTram' ? $v['gia_tri'] . '%' : number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    if ($v['loai_voucher'] == 'FreeShip')
                        $loai = "Freeship tối đa " . number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    $reply .= "- Mã **" . $v['ma_voucher'] . "** : Giảm " . $loai . " (Đơn từ " . number_format($v['don_toi_thieu'], 0, ',', '.') . "đ)\n";
                }
                return $reply;
            }
            return "Dạ hiện tại shop chưa có chương trình khuyến mãi nào ạ.";
        }

        if ($intent === 'LIST_CATEGORIES') {
            $categoryQuery = $this->conn->query("SELECT ten_danh_muc, slug FROM categories WHERE trang_thai = 'HienThi'");
            if ($categoryQuery && $categoryQuery->num_rows > 0) {
                $reply = "Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n";
                while ($cat = $categoryQuery->fetch_assoc()) {
                    $cat_link = $base_url . "index.php?url=product&category=" . $cat['slug'];
                    $reply .= "- **[" . $cat['ten_danh_muc'] . "](" . $cat_link . ")**\n";
                }
                $reply .= "\n👉 [Xem tất cả sản phẩm tại đây](" . $base_url . "index.php?url=product)";
                return $reply;
            }
            return "Dạ hiện tại shop đang cập nhật sản phẩm ạ.";
        }

        // 2. AI FALLBACK 



        $systemInstruction = "Bạn là 'Cozy Bot', trợ lý AI thông minh của cửa hàng gia dụng COZY CORNER. Tính cách vui vẻ, dạ thưa lễ phép.\n\n" .
            "Ý ĐỊNH KHÁCH HÀNG (INTENT): " . $intent . "\n\n" .
            $knowledge . "\n" .
            "QUY TẮC BẮT BUỘC (SHOPEE STYLE):\n" .
            "1. TRẢ LỜI ĐÚNG TRỌNG TÂM: Đi thẳng vào vấn đề theo đúng Intent. Không lan man.\n" .
            "2. ĐÍNH KÈM LINK: BẮT BUỘC chèn đường link dưới dạng Markdown [Tên hiển thị](URL) khi tư vấn sản phẩm/tin tức.\n" .
            "3. TRA CỨU ĐƠN HÀNG: Nếu khách chưa đọc mã đơn, yêu cầu khách gửi mã (VD: ORD00001). Không tự liệt kê.\n" .
            "4. GỢI Ý SẢN PHẨM: Giới hạn tối đa 3-4 sản phẩm phù hợp nhất. Tuyệt đối không liệt kê dài dòng.\n" .
            "5. VĂN PHONG: Dùng Markdown gạch đầu dòng (-), giới hạn câu trả lời dưới 150 chữ. Nếu dữ liệu không có, hãy xin lỗi khéo léo.";

        $contents = [];


        if (empty($chatHistory)) {
            $firstMessage = "HƯỚNG DẪN DÀNH CHO AI:\n" . $systemInstruction . "\n\nCÂU HỎI CỦA KHÁCH HÀNG:\n" . $userMessage;
            $contents[] = ["role" => "user", "parts" => [["text" => $firstMessage]]];
        } else {
            foreach ($chatHistory as $index => $msg) {
                $text = $msg['content'];
                if ($index === 0 && $msg['role'] === 'user') {
                    $text = "HƯỚNG DẪN DÀNH CHO AI:\n" . $systemInstruction . "\n\nCÂU HỎI CỦA KHÁCH HÀNG:\n" . $text;
                }
                $contents[] = [
                    "role" => $msg['role'] === 'user' ? 'user' : 'model',
                    "parts" => [["text" => $text]]
                ];
            }
            $contents[] = ["role" => "user", "parts" => [["text" => $userMessage]]];
        }

        $payload = [
            "contents" => $contents,
            "generationConfig" => ["temperature" => 0.4, "maxOutputTokens" => 500]
        ];


        $jsonData = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        if ($jsonData === false) {
            return "Lỗi nội bộ: Không thể tạo payload JSON. (Có thể do lỗi mã hóa UTF-8)";
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "Lỗi kết nối mạng (cURL): " . $error_msg;
        }
        curl_close($ch);

        $result = json_decode($response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        }

        // Trả về trực tiếp lỗi từ Google API 
        if (isset($result['error']['message'])) {
            $err_msg = $result['error']['message'];
            if (strpos($err_msg, 'Quota') !== false || strpos($err_msg, '429') !== false) {
                return "Lỗi Quota API: " . $err_msg;
            }
            return "Lỗi máy chủ AI: " . $err_msg;
        }

        return "Xin lỗi, Cozy Bot không thể xử lý câu hỏi này lúc này. Response không hợp lệ.";
    }

    // --- LƯU LỊCH SỬ CHAT VÀO DB ---
    public function saveMessage($user_id, $session_id, $role, $content)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("INSERT INTO chat_messages (user_id, session_id, role, content) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("isss", $user_id, $session_id, $role, $content);
                return $stmt->execute();
            }
        }
        return false;
    }

    public function getChatHistory($user_id, $session_id, $limit = 30)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT role, content FROM (SELECT id, role, content FROM chat_messages WHERE user_id = ? AND is_cleared = 0 ORDER BY id DESC LIMIT ?) sub ORDER BY id ASC");
            if ($stmt) {
                $stmt->bind_param("ii", $user_id, $limit);
                $stmt->execute();
                return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            }
        }
        return [];
    }

    public function clearChatHistory($user_id, $session_id)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("UPDATE chat_messages SET is_cleared = 1 WHERE user_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $user_id);
                return $stmt->execute();
            }
        }
        return false;
    }
}
?>