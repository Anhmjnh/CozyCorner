<?php
// controllers/ContactController.php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/ContactModel.php';

// Load thư viện PHPMailer
require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController {
    public function index() {
        $success = '';
        $errors = [];
        $old_data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ho_ten = trim($_POST['ho_ten'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $so_dien_thoai = trim($_POST['so_dien_thoai'] ?? '');
            $tieu_de = trim($_POST['tieu_de'] ?? '');
            $noi_dung = trim($_POST['noi_dung'] ?? '');

            $old_data = $_POST;

            if (empty($ho_ten) || empty($email) || empty($noi_dung)) {
                $errors[] = "Vui lòng điền đầy đủ thông tin bắt buộc.";
            }

            if (empty($errors)) {
                $contactModel = new ContactModel();
                
                // 1. Lưu vào CSDL qua Model
                if ($contactModel->saveContact($ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung)) {
                    
                    // 2. Gửi email thông báo cho Admin
                    $mailSent = $this->sendEmailToAdmin($ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung);

                    if ($mailSent) {
                        $success = "Cảm ơn bạn! Chúng tôi đã nhận được liên hệ và sẽ phản hồi sớm qua email.";
                        $old_data = []; // Reset form
                    } else {
                        // Dù lỗi gửi mail cho Admin thì vẫn báo thành công cho Khách hàng
                        $success = "Cảm ơn bạn! Chúng tôi đã nhận được liên hệ và sẽ phản hồi sớm.";
                        $old_data = [];
                    }
                } else {
                    $errors[] = "Lỗi hệ thống: Không thể lưu liên hệ. Vui lòng đảm bảo CSDL đã có cột 'tieu_de'.";
                }
            }
        }

        // Chuẩn bị CSS cho trang và render view
        $page_css = ['assets/css/LienHe.css'];
        require_once __DIR__ . '/../view/LienHe.php';
    }

    private function sendEmailToAdmin($ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung) {
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

            $mail->setFrom(SMTP_USERNAME, 'COZY CORNER SYSTEM');
            $mail->addAddress(SMTP_USERNAME); // Gửi về chính email cấu hình của shop (Admin)
            $mail->addReplyTo($email, $ho_ten); // Để Admin có thể bấm "Trả lời" thẳng cho khách trong Gmail

            $mail->isHTML(true);
            $mail->Subject = "Khách hàng liên hệ: " . $tieu_de;
            
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                    <h2 style='color: #2e5932;'>Bạn vừa nhận được một liên hệ mới!</h2>
                    <p><strong>Khách hàng:</strong> {$ho_ten}</p>
                    <p><strong>Email:</strong> {$email}</p>
                    <p><strong>SĐT:</strong> {$so_dien_thoai}</p>
                    <p><strong>Tiêu đề:</strong> {$tieu_de}</p>
                    <hr>
                    <p><strong>Nội dung:</strong></p>
                    <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #2e5932;'>" . nl2br(htmlspecialchars($noi_dung)) . "</div>
                </div>
            ";
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Lỗi gửi mail liên hệ: " . $mail->ErrorInfo);
            return false;
        }
    }
}