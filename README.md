COZY CORNER - HỆ THỐNG THƯƠNG MẠI CỬA HÀNG GIA DỤNG

Cozy Corner là website thương mại điện tử chuyên cung cấp thiết bị gia dụng nhà bếp. Dự án được xây dựng bằng PHP thuần theo mô hình MVC (Custom MVC), tích hợp các API thực tế để mô phỏng hệ thống production.

--------------------------------------------------

1. THÔNG TIN DỰ ÁN

- Tên dự án: Cozy Corner
- Công nghệ: PHP (Custom MVC), MySQLi, HTML, CSS, JavaScript
- Thư viện & API: PHPMailer, GHN API, SePay, Chart.js,
- Mục đích: Đồ án
- Tác giả: Anh Minh

--------------------------------------------------

2. TÍNH NĂNG CHÍNH

2.1. Người dùng
- Tìm kiếm, lọc và xem sản phẩm
- Giỏ hàng 
- Tính phí vận chuyển tự động (GHN)
- Áp dụng mã giảm giá
- Thanh toán QR (SePay)
- Đăng ký, đăng nhập, quên mật khẩu bằng OTP
- Quản lý đơn hàng và tài khoản

2.2. Quản trị viên
- Dashboard thống kê
- Quản lý sản phẩm
- Quản lý đơn hàng
- Quản lý mã giảm giá
- Quản lý người dùng
- Quản lý bài viết

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



--------------------------------------------------

5. TÀI KHOẢN MẶC ĐỊNH

5.1. Admin
- URL: http://localhost/cozycorner/view/user/DangNhap.php
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