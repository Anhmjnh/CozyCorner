COZY CORNER - HỆ THỐNG THƯƠNG MẠI CỬA HÀNG GIA DỤNG

Cozy Corner là website thương mại điện tử chuyên cung cấp thiết bị gia dụng nhà bếp. Dự án được xây dựng bằng PHP thuần theo mô hình MVC (Custom MVC), tích hợp các API thực tế (GHN, SePay, Google, Gemini AI) để mô phỏng một hệ thống production hoàn chỉnh.

--------------------------------------------------

1. THÔNG TIN DỰ ÁN

- Tên dự án: Cozy Corner
- Công nghệ: PHP (Custom MVC), MySQLi, HTML, CSS, JavaScript
- Thư viện & API: PHPMailer, GHN API, SePay, Google OAuth, Gemini AI, Chart.js
- Mục đích: Đồ án
- Tác giả: Anh Minh

--------------------------------------------------

2. TÍNH NĂNG CHÍNH

2.1. Người dùng
- Tìm kiếm, lọc và xem sản phẩm.
- Giỏ hàng và quản lý giỏ hàng (thêm, xóa, cập nhật số lượng).
- Đăng ký, đăng nhập (thường, Google), quên mật khẩu qua OTP.
- Tính phí vận chuyển tự động theo địa chỉ (tích hợp API Giao Hàng Nhanh).
- Áp dụng mã giảm giá, voucher.
- Thanh toán khi nhận hàng (COD) hoặc chuyển khoản qua mã QR (tích hợp API SePay).
- Quản lý tài khoản cá nhân, xem lịch sử đơn hàng.
- Phân hạng thành viên (Đồng, Bạc, Vàng, Kim Cương) và nhận chiết khấu tương ứng.
- Người dùng có thể tự hủy đơn hàng.
- Để lại đánh giá cho các sản phẩm đã mua.
- Tương tác với Chatbot AI để được hỗ trợ và tư vấn sản phẩm.

2.2. Quản trị viên
- Dashboard thống kê doanh thu, đơn hàng, người dùng mới.
- Quản lý sản phẩm (thêm, sửa, xóa, tìm kiếm).
- Quản lý danh mục sản phẩm.
- Quản lý đơn hàng (cập nhật trạng thái, xem chi tiết).
- Quản lý mã giảm giá (voucher).
- Quản lý người dùng (khóa/mở tài khoản, chỉnh sửa thông tin).
- Quản lý nhân sự (phân quyền Admin, Staff).
- Quản lý bài viết (tin tức, mẹo vặt).
- Quản lý các câu hỏi và trả lời cho Chatbot.
- Quản lý thông tin cá nhân của quản trị viên.
- Xuất dữ liệu (sản phẩm, đơn hàng, người dùng,...) ra file CSV.

--------------------------------------------------

3. HƯỚNG DẪN CÀI ĐẶT

3.1. Chuẩn bị môi trường
- Cài XAMPP (PHP >= 7.4)
- Copy project vào:
  C:\xampp\htdocs\cozycorner

3.2. Import database
- Truy cập: http://localhost/phpmyadmin
- Tạo database: do_gia_dung.sql
- Import file: do_gia_dung.sql

--------------------------------------------------

4. CẤU HÌNH BẮT BUỘC

Mở file:
/config.php

4.1. Database

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'do_gia_dung');

4.2. Base URL

define('BASE_URL', 'http://localhost/cozycorner/');


4.3. PHPMailer

define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 465);
define('SMTP_USERNAME', 'your_email@gmail.com');
define('SMTP_PASSWORD', 'your_app_password');

Lưu ý:
- Dùng App Password Gmail
- Không dùng mật khẩu thường
- Email nên trùng với admin

4.4. GHN API

define('GHN_API_TOKEN', 'YOUR_TOKEN');
define('GHN_SHOP_ID', 'YOUR_SHOP_ID');
define('GHN_FROM_DISTRICT_ID', 1442);
define('GHN_FROM_WARD_CODE', '20104')

4.5. SePay

define('SEPAY_BANK_ID', 'YOUR_BANK');
define('SEPAY_BANK_ACC', 'YOUR_ACCOUNT');
define('SEPAY_BANK_NAME', 'YOUR_NAME');
define('SEPAY_WEBHOOK_SECRET', 'YOUR_SECRET');

4.6. Google OAuth

define('GOOGLE_CLIENT_ID', 'YOUR_CLIENT_ID');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET');
define('GOOGLE_REDIRECT_URI', 'http://localhost/cozycorner/index.php?url=auth/googleCallback');

Lưu ý:
- Redirect URI phải khớp với cấu hình trên Google Cloud Console.

4.7. Gemini AI (Chatbot)

define('GEMINI_API_KEY', 'YOUR_GEMINI_API_KEY');

Lưu ý:
- Đây là API Key để Chatbot có thể hoạt động.



--------------------------------------------------

5. TÀI KHOẢN MẶC ĐỊNH

5.1. Admin
- URL: http://localhost/cozycorner/index.php?url=auth/showLogin
- Email: admin
- Password: 123456



--------------------------------------------------

6. CẤU TRÚC THƯ MỤC

cozycorner/
- admin/        giao diện quản trị
- assets/       css, js, hình ảnh
- config.php    cấu hình chính
- controllers/  xử lý logic
- core/         router, base
- includes/     header, footer
- index.php     entry point
- libs/         thư viện ngoài
- models/       database
- uploads/      file upload
- view/         giao diện

--------------------------------------------------

7. LỖI THƯỜNG GẶP

- Không kết nối database
→ Sai DB_NAME

- Không gửi mail
→ Sai SMTP hoặc chưa tạo App Password

- Không load CSS
→ Sai BASE_URL

--------------------------------------------------

8. ĐỊNH HƯỚNG PHÁT TRIỂN

- Tách API riêng
- Tích hợp thanh toán online
- Tối ưu UI/UX
- Deploy production

--------------------------------------------------

9. LICENSE

Dự án phục vụ học tập và nghiên cứu.