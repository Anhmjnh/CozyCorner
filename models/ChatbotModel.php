<?php
// models/ChatbotModel.php
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/VoucherModel.php';

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
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $this->conn->query("CREATE TABLE IF NOT EXISTS `guest_rate_limits` (
              `ip_address` varchar(45) NOT NULL,
              `action_date` date NOT NULL,
              `daily_count` int(11) DEFAULT 0,
              `last_request_time` int(11) DEFAULT 0,
              PRIMARY KEY (`ip_address`, `action_date`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $this->conn->query("CREATE TABLE IF NOT EXISTS `chatbot_faq` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `keywords` text NOT NULL,
              `answer` text NOT NULL,
              `status` enum('HoatDong','Khoa') DEFAULT 'HoatDong',
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    // Kiểm tra & Cập nhật IP Rate Limit
    public function checkAndLogGuestRateLimit($ip, $dailyLimit = 100, $rateLimitSeconds = 5)
    {
        $today = date('Y-m-d');
        $currentTime = time();

        $stmt = $this->conn->prepare("SELECT daily_count, last_request_time FROM guest_rate_limits WHERE ip_address = ? AND action_date = ?");
        $stmt->bind_param("ss", $ip, $today);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            if ($result['daily_count'] >= $dailyLimit) {
                return ['status' => 'blocked', 'msg' => "Cozy Bot xin lỗi, bạn đã sử dụng hết {$dailyLimit} lượt hỏi đáp miễn phí trong hôm nay. Vui lòng quay lại vào ngày mai nhé!"];
            }
            if (($currentTime - $result['last_request_time']) < $rateLimitSeconds) {
                $wait = $rateLimitSeconds - ($currentTime - $result['last_request_time']);
                return ['status' => 'wait', 'msg' => "Bot đang xử lý... Bạn vui lòng đợi {$wait} giây nữa rồi nhắn tiếp nhé!"];
            }

            // Update
            $newCount = $result['daily_count'] + 1;
            $updateStmt = $this->conn->prepare("UPDATE guest_rate_limits SET daily_count = ?, last_request_time = ? WHERE ip_address = ? AND action_date = ?");
            $updateStmt->bind_param("iiss", $newCount, $currentTime, $ip, $today);
            $updateStmt->execute();
        } else {
            // Insert
            $insertStmt = $this->conn->prepare("INSERT INTO guest_rate_limits (ip_address, action_date, daily_count, last_request_time) VALUES (?, ?, 1, ?)");
            $insertStmt->bind_param("ssi", $ip, $today, $currentTime);
            $insertStmt->execute();
        }
        return ['status' => 'ok'];
    }

    // NHẬN DIỆN Ý ĐỊNH ĐỘNG
    private function detectIntent($message)
    {
        $msg = mb_strtolower($message, 'UTF-8');

        if (strpos($msg, 'đơn hàng của tôi') !== false || strpos($msg, 'kiểm tra đơn') !== false || strpos($msg, 'đơn của tôi') !== false || strpos($msg, 'tình trạng đơn') !== false)
            return 'ORDER';

        if (strpos($msg, 'kiểm tra voucher') !== false || strpos($msg, 'check voucher') !== false || strpos($msg, 'dùng được voucher') !== false)
            return 'VOUCHER_CHECK';

        if (strpos($msg, 'mã giảm giá') !== false || strpos($msg, 'khuyến mãi') !== false || strpos($msg, 'voucher') !== false || strpos($msg, 'freeship') !== false)
            return 'PROMOTION';

        if (strpos($msg, 'shop có bán những gì') !== false || strpos($msg, 'danh mục sản phẩm') !== false || strpos($msg, 'shop bán gì') !== false)
            return 'LIST_CATEGORIES';

        if (strpos($msg, 'nồi') !== false || strpos($msg, 'chảo') !== false || strpos($msg, 'dao') !== false || strpos($msg, 'thớt') !== false || strpos($msg, 'chén') !== false || strpos($msg, 'sản phẩm') !== false || strpos($msg, 'máy') !== false || strpos($msg, 'bếp') !== false || strpos($msg, 'ấm') !== false)
            return 'PRODUCT';

        return 'OTHER';
    }

    // KIỂM TRA FAQ BẰNG SQL
    private function checkFaqRules($userMessage)
    {
        $faqs = $this->conn->query("SELECT keywords, answer FROM chatbot_faq WHERE status = 'HoatDong'");
        if ($faqs && $faqs->num_rows > 0) {
            $userMsgLower = mb_strtolower($userMessage, 'UTF-8');
            while ($faq = $faqs->fetch_assoc()) {
                $keywords = explode(',', $faq['keywords']);
                foreach ($keywords as $keyword) {
                    $trimmedKeyword = trim(mb_strtolower($keyword, 'UTF-8'));
                    if (!empty($trimmedKeyword) && strpos($userMsgLower, $trimmedKeyword) !== false) {
                        return $faq['answer'];
                    }
                }
            }
        }
        return null;
    }

    private function getStoreKnowledge($userMessage, $user_id = null)
    {
        $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/cozycorner/';
        $intent = $this->detectIntent($userMessage);
        $knowledge = "THÔNG TIN HỆ THỐNG COZY CORNER:\n";

        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT ho_ten, hang FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            if ($user) {
                $knowledge .= "KHÁCH HÀNG HIỆN TẠI: Tên '{$user['ho_ten']}', Hạng '{$user['hang']}'.\n";
            }
        } else {
            $knowledge .= "KHÁCH HÀNG: Chưa đăng nhập.\n";
        }

        if ($intent === 'PROMOTION' || $intent === 'OTHER') {
            $voucherQuery = $this->conn->query("SELECT ma_voucher, loai_voucher, gia_tri, don_toi_thieu FROM vouchers WHERE trang_thai = 'HoatDong' AND (ngay_het_han IS NULL OR ngay_het_han >= NOW()) LIMIT 3");
            $knowledge .= "MÃ GIẢM GIÁ ĐANG CHẠY:\n";
            if ($voucherQuery && $voucherQuery->num_rows > 0) {
                while ($v = $voucherQuery->fetch_assoc()) {
                    $loai = $v['loai_voucher'] == 'PhanTram' ? $v['gia_tri'] . '%' : number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    if ($v['loai_voucher'] == 'FreeShip')
                        $loai = "Freeship tối đa " . number_format($v['gia_tri'], 0, ',', '.') . 'đ';
                    $knowledge .= "- Mã '{$v['ma_voucher']}': Giảm {$loai} (Đơn tối thiểu: " . number_format($v['don_toi_thieu'], 0, ',', '.') . "đ).\n";
                }
            } else {
                $knowledge .= "- Hiện không có mã giảm giá.\n";
            }
        }

        if ($intent === 'PRODUCT' || $intent === 'OTHER') {
            $search_keyword = '';
            $categories = ['nồi', 'chảo', 'dao', 'thớt', 'chén', 'máy', 'bếp', 'ấm'];
            foreach ($categories as $cat) {
                if (strpos(mb_strtolower($userMessage, 'UTF-8'), $cat) !== false) {
                    $search_keyword = $cat;
                    break;
                }
            }
            $knowledge .= "SẢN PHẨM (GIỚI HẠN 4 SẢN PHẨM):\n";
            if ($search_keyword) {
                $stmt = $this->conn->prepare("SELECT id, ten_sp, gia, so_luong_ton FROM products WHERE trang_thai = 'HienThi' AND ten_sp LIKE ? LIMIT 4");
                $like = "%" . $search_keyword . "%";
                $stmt->bind_param("s", $like);
            } else {
                $stmt = $this->conn->prepare("SELECT id, ten_sp, gia, so_luong_ton FROM products WHERE trang_thai = 'HienThi' ORDER BY luot_ban DESC LIMIT 4");
            }
            $stmt->execute();
            $prodQuery = $stmt->get_result();
            if ($prodQuery && $prodQuery->num_rows > 0) {
                while ($p = $prodQuery->fetch_assoc()) {
                    $trangThai = $p['so_luong_ton'] > 0 ? 'Còn hàng' : 'Hết hàng';
                    $gia = number_format($p['gia'], 0, ',', '.') . 'đ';
                    $link = $base_url . "index.php?url=product/detail&id=" . $p['id'];
                    $knowledge .= "- {$p['ten_sp']}: Giá {$gia} | {$trangThai} | Link: {$link}\n";
                }
            }
        }
        return ['intent' => $intent, 'knowledge' => $knowledge];
    }

    private function getOrderStatusById($order_id, $user_id)
    {
        if (!$user_id) {
            $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/cozycorner/';
            return "Dạ, bạn cần [đăng nhập](" . $base_url . "index.php?url=user/login) để thực hiện chức năng này ạ.";
        }
        $stmt = $this->conn->prepare("SELECT trang_thai, tong_tien, created_at FROM orders WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $order = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($order) {
            $orderCode = "ORD" . str_pad($order_id, 5, '0', STR_PAD_LEFT);
            $status = $order['trang_thai'];
            $total = number_format($order['tong_tien'], 0, ',', '.');
            $date = date('d/m/Y', strtotime($order['created_at']));
            return "Dạ, đơn hàng **{$orderCode}** (tạo ngày {$date}) có tổng giá trị **{$total}đ** hiện đang ở trạng thái: **{$status}**.";
        } else {
            return "Dạ, mình không tìm thấy đơn hàng có mã này trong tài khoản của bạn. Bạn vui lòng kiểm tra lại mã đơn hàng nhé.";
        }
    }

    public function askGemini($userMessage, $chatHistory = [], $user_id = null)
    {
        if (empty($this->apiKey))
            return "Lỗi: Hệ thống chưa được cấu hình API Key của AI.";
        $base_url = defined('BASE_URL') ? BASE_URL : 'http://localhost/cozycorner/';

        // BƯỚC 1: XỬ LÝ THEO NGỮ CẢNH
        if (isset($_SESSION['chatbot_context'])) {
            $context = $_SESSION['chatbot_context'];
            unset($_SESSION['chatbot_context']);

            if ($context === 'awaiting_order_id') {
                if (preg_match('/(?:ORD|#|mã)?\s*(\d+)/i', $userMessage, $matches)) {
                    $order_id = intval($matches[1]);
                    return $this->getOrderStatusById($order_id, $user_id);
                }
            }

            if ($context === 'awaiting_voucher_code') {
                $voucher_code = strtoupper(trim($userMessage));
                if (preg_match('/^[A-Z0-9]{3,}$/', $voucher_code)) {
                    $voucherModel = new VoucherModel();
                    $check = $voucherModel->checkVoucher($voucher_code);
                    return $check['msg'];
                }
            }
        }

        // BƯỚC 2: KIỂM TRA FAQ SQL TĨNH
        $faqAnswer = $this->checkFaqRules($userMessage);
        if ($faqAnswer !== null)
            return $faqAnswer;

        // BƯỚC 3: NHẬN DIỆN Ý ĐỊNH ĐỘNG
        $storeData = $this->getStoreKnowledge($userMessage, $user_id);
        $intent = $storeData['intent'];
        $knowledge = $storeData['knowledge'];

        if ($intent === 'LIST_CATEGORIES') {
            $cats = $this->conn->query("SELECT ten_danh_muc, slug FROM categories WHERE trang_thai = 'HienThi'");
            if ($cats && $cats->num_rows > 0) {
                $reply = "Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n";
                while ($cat = $cats->fetch_assoc()) {
                    $link = $base_url . 'index.php?url=product&category=' . $cat['slug'];
                    $reply .= "- [{$cat['ten_danh_muc']}]({$link})\n";
                }
                return $reply . "\nBạn muốn xem danh mục nào ạ?";
            }
            return "Dạ hiện tại shop đang cập nhật sản phẩm ạ.";
        }

        if ($intent === 'ORDER') {
            if (!$user_id)
                return "Dạ bạn cần [đăng nhập](" . $base_url . "index.php?url=user/login) để mình kiểm tra đơn hàng nhé!";

            $_SESSION['chatbot_context'] = 'awaiting_order_id';
            return "Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!";
        }

        if ($intent === 'VOUCHER_CHECK') {
            $_SESSION['chatbot_context'] = 'awaiting_voucher_code';
            return "Dạ, bạn vui lòng nhập mã voucher muốn kiểm tra ạ.";
        }

        // BƯỚC 4: GỌI GEMINI AI
        $url = $this->apiUrl . '?key=' . $this->apiKey;
        $systemInstruction = "Bạn là 'Cozy Bot', trợ lý AI của COZY CORNER. Tính cách vui vẻ, lễ phép.\n" .
            $knowledge . "\nQUY TẮC:\n" .
            "1. Trả lời đúng trọng tâm. Dùng Markdown (gạch đầu dòng).\n" .
            "2. Luôn chèn Link dưới định dạng [Tên](URL) nếu có.\n" .
            "3. Không tự bịa thông tin sản phẩm, nếu không có dữ liệu hãy xin lỗi khéo léo.";

        $contents = [];
        foreach ($chatHistory as $msg) {
            $contents[] = [
                "role" => $msg['role'] === 'user' ? 'user' : 'model',
                "parts" => [["text" => $msg['content']]]
            ];
        }
        $contents[] = ["role" => "user", "parts" => [["text" => $userMessage]]];

        $payload = [
            "system_instruction" => ["parts" => [["text" => $systemInstruction]]],
            "contents" => $contents,
            "generationConfig" => ["temperature" => 0.4, "maxOutputTokens" => 500]
        ];

        $jsonData = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $result['candidates'][0]['content']['parts'][0]['text'];
        }
        return "Xin lỗi, Cozy Bot đang bị quá tải, bạn vui lòng thử lại sau ít phút nhé.";
    }

    public function saveMessage($user_id, $session_id, $role, $content)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("INSERT INTO chat_messages (user_id, session_id, role, content) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $session_id, $role, $content);
            return $stmt->execute();
        }
        return false;
    }

    public function getChatHistory($user_id, $session_id, $limit = 30)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("SELECT role, content FROM (SELECT id, role, content FROM chat_messages WHERE user_id = ? AND is_cleared = 0 ORDER BY id DESC LIMIT ?) sub ORDER BY id ASC");
            $stmt->bind_param("ii", $user_id, $limit);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function clearChatHistory($user_id, $session_id)
    {
        if ($user_id) {
            $stmt = $this->conn->prepare("UPDATE chat_messages SET is_cleared = 1 WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            return $stmt->execute();
        }
        return false;
    }
}
?>