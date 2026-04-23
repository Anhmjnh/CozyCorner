<?php
// controllers/ChatbotController.php
require_once __DIR__ . '/../core/Controller.php';

class ChatbotController extends Controller
{

    public function ask()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $user_id = $_SESSION['user_id'] ?? null;
            $session_id = session_id();
            $chatbotModel = $this->model('ChatbotModel');

            if (isset($input['action']) && $input['action'] === 'clear') {
                if ($user_id) {
                    $chatbotModel->clearChatHistory($user_id, $session_id);
                } else {
                    unset($_SESSION['guest_chat_history']);
                }
                echo json_encode(['status' => 'success', 'reply' => 'Đã làm mới cuộc hội thoại.']);
                exit;
            }

            $message = trim($input['message'] ?? '');
            if (empty($message)) {
                echo json_encode(['status' => 'error', 'reply' => 'Vui lòng nhập tin nhắn.']);
                exit;
            }

            // Rate Limit
            $dailyLimit = 100;
            $rateLimitSeconds = 1;

            if ($user_id) {
                $userModel = $this->model('UserModel');
                $user = $userModel->getUserById($user_id);
                $today = date('Y-m-d');

                if (isset($user['last_chat_date']) && $user['last_chat_date'] != $today) {
                    $userModel->resetUserChatCount($user_id);
                    $user['chat_daily_count'] = 0;
                }

                if (isset($user['chat_daily_count']) && $user['chat_daily_count'] >= $dailyLimit) {
                    echo json_encode(['status' => 'success', 'reply' => 'Cozy Bot xin lỗi, bạn đã dùng hết lượt hỏi đáp miễn phí hôm nay.']);
                    exit;
                }

                $currentTime = time();
                if (isset($_SESSION['last_chat_time']) && ($currentTime - $_SESSION['last_chat_time']) < $rateLimitSeconds) {
                    $wait = $rateLimitSeconds - ($currentTime - $_SESSION['last_chat_time']);
                    echo json_encode(['status' => 'success', 'reply' => "Bot đang xử lý... Vui lòng đợi {$wait} giây nữa rồi nhắn tiếp nhé!"]);
                    exit;
                }
                $_SESSION['last_chat_time'] = $currentTime;
                $userModel->incrementUserChatCount($user_id);

            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
                $rateCheck = $chatbotModel->checkAndLogGuestRateLimit($ip, $dailyLimit, $rateLimitSeconds);

                if ($rateCheck['status'] !== 'ok') {
                    echo json_encode(['status' => 'success', 'reply' => $rateCheck['msg']]);
                    exit;
                }
            }

            $chatHistory = $user_id ? $chatbotModel->getChatHistory($user_id, $session_id, 6) : ($_SESSION['guest_chat_history'] ?? []);

            $reply = $chatbotModel->askGemini($message, $chatHistory, $user_id);

            if (strpos($reply, 'Lỗi') === false && strpos($reply, 'Xin lỗi') === false) {
                if ($user_id) {
                    $chatbotModel->saveMessage($user_id, $session_id, 'user', $message);
                    $chatbotModel->saveMessage($user_id, $session_id, 'bot', $reply);
                } else {
                    if (!isset($_SESSION['guest_chat_history']))
                        $_SESSION['guest_chat_history'] = [];
                    $_SESSION['guest_chat_history'][] = ['role' => 'user', 'content' => $message];
                    $_SESSION['guest_chat_history'][] = ['role' => 'bot', 'content' => $reply];
                    if (count($_SESSION['guest_chat_history']) > 10) {
                        $_SESSION['guest_chat_history'] = array_slice($_SESSION['guest_chat_history'], -10);
                    }
                }
            }

            echo json_encode(['status' => 'success', 'reply' => $reply]);
            exit;
        }
    }

    public function history()
    {
        header('Content-Type: application/json');
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $user_id = $_SESSION['user_id'] ?? null;
        $session_id = session_id();
        $chatbotModel = $this->model('ChatbotModel');

        $chatHistory = $user_id ? $chatbotModel->getChatHistory($user_id, $session_id, 50) : ($_SESSION['guest_chat_history'] ?? []);
        echo json_encode(['status' => 'success', 'data' => $chatHistory]);
        exit;
    }
}
?>