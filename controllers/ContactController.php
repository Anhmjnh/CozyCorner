<?php
// controllers/ContactController.php
require_once __DIR__ . '/../config.php';

class ContactController {
    public function index() {
        $success = '';
        $errors = [];
        $old_data = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $conn = connectDB();

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
                $stmt = $conn->prepare("
                    INSERT INTO contacts (ho_ten, email, so_dien_thoai, tieu_de, noi_dung) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("sssss", $ho_ten, $email, $so_dien_thoai, $tieu_de, $noi_dung);
                if ($stmt->execute()) {
                    $success = "Cảm ơn bạn! Chúng tôi đã nhận được liên hệ và sẽ phản hồi sớm.";
                    $old_data = [];
                } else {
                    $errors[] = "Lỗi lưu liên hệ: " . $stmt->error;
                }
                $stmt->close();
            }

            $conn->close();
        }

        // Sửa đường dẫn require view (tùy theo vị trí thực tế của bạn)
        require_once __DIR__ . '/../view/LienHe.php';   // Nếu view ở thư mục view/
        // Hoặc nếu bạn di chuyển vào views/contact/:
        // require_once __DIR__ . '/../views/contact/LienHe.php';
    }
}