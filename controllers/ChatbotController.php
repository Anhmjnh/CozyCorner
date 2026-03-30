<?php
// controllers/ChatbotController.php
require_once __DIR__ . '/../core/Controller.php';

class ChatbotController extends Controller {
    
    public function ask() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            $user_id = $_SESSION['user_id'] ?? null;
            $session_id = session_id();
            $chatbotModel = $this->model('ChatbotModel');

            // Nút "Làm mới": Xóa lịch sử chat 
            if (isset($input['action']) && $input['action'] === 'clear') {
                if ($user_id) {
                    $chatbotModel->clearChatHistory($user_id, $session_id);
                }
                echo json_encode(['status' => 'success', 'reply' => 'Đã làm mới cuộc hội thoại.']);
                exit;
            }

            $message = trim($input['message'] ?? '');
            if (empty($message)) {
                echo json_encode(['status' => 'error', 'reply' => 'Vui lòng nhập tin nhắn.']);
                exit;
            }

            // TÍNH NĂNG GIỚI HẠN NGÀY (DAILY LIMIT) - PHÂN LUỒNG
            $today = date('Y-m-d');
            $dailyLimit = 20; // Mỗi khách hàng chỉ được nhắn tối đa 20 câu/ngày

            if ($user_id) { // Đã đăng nhập -> Dùng Database
                $userModel = $this->model('UserModel');
                $user = $userModel->getUserById($user_id);

                // Nếu qua ngày mới, reset bộ đếm
                if ($user['last_chat_date'] != $today) {
                    $userModel->resetUserChatCount($user_id);
                    $user['chat_daily_count'] = 0;
                }

                if ($user['chat_daily_count'] >= $dailyLimit) {
                    echo json_encode(['status' => 'success', 'reply' => 'Cozy Bot xin lỗi, bạn đã sử dụng hết ' . $dailyLimit . ' lượt hỏi đáp miễn phí trong hôm nay. Vui lòng quay lại vào ngày mai để tiếp tục trò chuyện nhé!']);
                    exit;
                }

            } else { // Chưa đăng nhập -> Dùng Session
                if (!isset($_SESSION['guest_chat_daily_limit_date']) || $_SESSION['guest_chat_daily_limit_date'] !== $today) {
                    $_SESSION['guest_chat_daily_limit_date'] = $today;
                    $_SESSION['guest_chat_daily_count'] = 0;
                }
                
                if ($_SESSION['guest_chat_daily_count'] >= $dailyLimit) {
                    echo json_encode(['status' => 'success', 'reply' => 'Cozy Bot xin lỗi, bạn đã sử dụng hết ' . $dailyLimit . ' lượt hỏi đáp miễn phí trong hôm nay. Vui lòng quay lại vào ngày mai để tiếp tục trò chuyện nhé!']);
                    exit;
                }
            }

            // TÍNH NĂNG GIỚI HẠN TIN NHẮN (RATE LIMIT) 
            $limit = 5; 
            $timeWindow = 60; // Thời gian giới hạn (60 giây)

            if (!isset($_SESSION['chat_rate_limit'])) {
                $_SESSION['chat_rate_limit'] = [];
            }

            $currentTime = time();
           
            $_SESSION['chat_rate_limit'] = array_filter($_SESSION['chat_rate_limit'], function($timestamp) use ($currentTime, $timeWindow) {
                return ($currentTime - $timestamp) < $timeWindow;
            });

            // Nếu khách gửi quá 5 câu trong vòng 60 giây
            if (count($_SESSION['chat_rate_limit']) >= $limit) {
                $waitTime = $timeWindow - ($currentTime - min($_SESSION['chat_rate_limit']));
                echo json_encode(['status' => 'success', 'reply' => "Cozy Bot đang phải hỗ trợ rất nhiều khách hàng cùng lúc . Bạn vui lòng đợi khoảng **{$waitTime} giây** nữa rồi hãy nhắn tiếp nhé!"]);
                exit;
            }
            
            // Nếu chưa chạm giới hạn -> Ghi nhận thời gian gửi câu hỏi này vào bộ đếm
            $_SESSION['chat_rate_limit'][] = $currentTime;

            // Tăng bộ đếm số câu trong ngày của User lên 1
            if ($user_id) {
                $userModel = $this->model('UserModel');
                $userModel->incrementUserChatCount($user_id);
            } else {
                $_SESSION['guest_chat_daily_count']++;
            }

            // Gọi AI
            $chatHistory = [];
            if ($user_id) {
                $chatHistory = $chatbotModel->getChatHistory($user_id, $session_id, 6); // Lấy từ DB
            } else {
                // Với khách chưa đăng nhập, lấy lịch sử từ Session
                $chatHistory = $_SESSION['guest_chat_history'] ?? [];
            }
            
            $reply = $chatbotModel->askGemini($message, $chatHistory, $user_id);

            // Lưu câu hỏi và trả lời
            if (strpos($reply, 'Lỗi') === false && strpos($reply, 'Xin lỗi') === false && strpos($reply, 'Cozy Bot đang') === false) {
                if ($user_id) {
                    $chatbotModel->saveMessage($user_id, $session_id, 'user', $message);
                    $chatbotModel->saveMessage($user_id, $session_id, 'bot', $reply);
                }
            }

            echo json_encode(['status' => 'success', 'reply' => $reply]);
            exit;
        }
    }

    // API lấy lịch sử chat cho Frontend hiển thị
    public function history() {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE) session_start();
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();
        $chatbotModel = $this->model('ChatbotModel');
        
        $chatHistory = [];
        if ($user_id) {
            $chatHistory = $chatbotModel->getChatHistory($user_id, $session_id, 50); 
        }
        
        echo json_encode(['status' => 'success', 'data' => $chatHistory]);
        exit;
    }
}
?>