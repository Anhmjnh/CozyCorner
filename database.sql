-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 03, 2026 lúc 04:26 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `do_gia_dung`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `vai_tro` enum('Admin','Staff') DEFAULT 'Staff',
  `trang_thai` enum('HoatDong','Khoa') DEFAULT 'HoatDong',
  `ho_ten` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `gioi_tinh` enum('Nam','Nu') DEFAULT 'Nam',
  `ngay_sinh` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `vai_tro`, `trang_thai`, `ho_ten`, `email`, `so_dien_thoai`, `dia_chi`, `gioi_tinh`, `ngay_sinh`, `created_at`, `avatar`) VALUES
(1, 'admin', '$2y$10$hGpRPUqY2Sy92W/zsb5I6ue5DGKuQi789mkehZX4EYWMNnfyAxi.K', 'Admin', 'HoatDong', 'Admin', 'Minhkendy1902@gmail.com', '0911078382', 'Sài Gòn', 'Nam', '2026-03-06', '2026-03-10 02:02:48', '1774332748_admin_default-avatar.png'),
(5, 'staff', '$2y$10$b1iYNTLF8kWgU3tUbQoL4OZmCf6idwoNeLD9eEzgMLdJrLevdID3S', 'Staff', 'HoatDong', 'Staff', 'staff123@gmail.com', '012344234', 'hà nội', 'Nam', '2026-03-14', '2026-03-22 11:25:29', '1774178825_admin_A-210-Dia-ANM-26020092-1.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`) VALUES
(8, 4, NULL, '2026-03-19 07:16:42'),
(9, NULL, '988tnlb1j3rnd8u3s8ro3qapqp', '2026-03-19 08:32:18'),
(10, NULL, 'eeo231cgp5rcms2pdc6ar4nuc1', '2026-03-19 09:44:17'),
(16, 5, NULL, '2026-03-22 10:37:55'),
(40, NULL, '579fr85nfvkhqrs82mef05mg35', '2026-03-24 10:29:55'),
(47, NULL, 'iv2v9r899gp84npar8ca7uf9v2', '2026-03-26 15:36:03'),
(68, NULL, '8i0rt8js2rtdriaoauapvjja24', '2026-03-29 10:57:26'),
(69, NULL, 'v17e960sidvqmmvqmf5hi83gtd', '2026-03-29 15:24:07'),
(86, NULL, 'vhv70q672mnol3gi1aj3vckumt', '2026-03-30 13:31:12'),
(87, NULL, '0etk3qs9j9j5fgr5kco6kvopqd', '2026-03-31 04:51:59'),
(88, NULL, '44l0lcijdv4ht5fm6ag3drks9n', '2026-03-31 05:42:53'),
(96, NULL, 'qbcdhaafoov25u4mkie5ndajd2', '2026-03-31 09:22:11'),
(98, NULL, '8pbd2m85div1g5lmsbgtkagoht', '2026-03-31 10:15:48'),
(99, NULL, '9velts18sathr6omgi23jlm15r', '2026-03-31 11:01:53'),
(101, NULL, 'fgp53i90h7i3uq0o5vd6ehcgsg', '2026-03-31 11:11:05'),
(103, NULL, 'safoufb9k0ohvjbugabi24gll9', '2026-03-31 11:48:59'),
(104, NULL, 'uf7i1egpj45u7h811uf61phjsd', '2026-03-31 12:10:29'),
(105, NULL, 'r2ljvdcfjdv1ivt3vrnm5oiqps', '2026-03-31 12:55:13'),
(107, NULL, 'kuc2mr2tvan6c4hhfjrrgrlims', '2026-04-02 12:53:38'),
(108, NULL, 'j4bf33tfdle070d9o5j4f6pdss', '2026-04-03 05:51:37'),
(113, NULL, 'o9ncret384ur9q65uj2d8gkkin', '2026-04-03 06:21:01'),
(114, NULL, 'f3409lg13nv7rvcsm8grrng5nl', '2026-04-03 06:58:18'),
(116, NULL, 'gdr0k1nfmj7thjp5nmu9cib7je', '2026-04-03 08:34:21'),
(121, NULL, 'glb1lecf5ulnikoq0pg412a1au', '2026-04-03 14:08:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`) VALUES
(158, 69, 36, 1, '2026-03-29 15:24:09'),
(159, 69, 37, 1, '2026-03-29 15:24:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `trang_thai` enum('HienThi','An') DEFAULT 'HienThi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `ten_danh_muc`, `slug`, `trang_thai`, `created_at`) VALUES
(7, 'Chảo', 'ch-o', 'HienThi', '2026-03-18 09:45:26'),
(9, 'Nồi', 'n-i', 'HienThi', '2026-03-18 10:05:23'),
(10, 'Đồ Điện', '-i-n', 'HienThi', '2026-03-18 10:05:35'),
(11, 'Chén', 'ch-n', 'HienThi', '2026-03-18 10:05:46'),
(12, 'Thớt', 'th-t', 'HienThi', '2026-03-18 10:05:51'),
(13, 'Dao', 'dao', 'HienThi', '2026-03-18 10:05:55');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chatbot_faq`
--

CREATE TABLE `chatbot_faq` (
  `id` int(11) NOT NULL,
  `keywords` text NOT NULL COMMENT 'Các từ khóa, cách nhau bởi dấu phẩy',
  `answer` text NOT NULL COMMENT 'Câu trả lời, hỗ trợ Markdown',
  `status` enum('HoatDong','Khoa') DEFAULT 'HoatDong',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chatbot_faq`
--

INSERT INTO `chatbot_faq` (`id`, `keywords`, `answer`, `status`, `created_at`) VALUES
(1, 'tài khoản,thông tin cá nhân,account,xem thông tin', 'Dạ, bạn có thể quản lý thông tin cá nhân và lịch sử mua hàng tại trang Tài khoản của tôi nhé.', 'HoatDong', '2026-03-31 08:24:17'),
(2, 'quên mật khẩu,lấy lại mật khẩu,đổi mật khẩu,reset pass,mất pass', 'Dạ, để lấy lại mật khẩu, bạn vui lòng ấn vào nút \"Đăng nhập\", sau đó chọn \"Quên mật khẩu\" và làm theo hướng dẫn gửi về Email nhé.', 'HoatDong', '2026-03-31 08:24:17'),
(3, 'địa chỉ,liên hệ,cửa hàng,shop ở đâu,hotline,email', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 'HoatDong', '2026-03-31 08:24:17'),
(4, 'giờ làm việc,mấy giờ mở cửa,thời gian hoạt động,mở cửa lúc mấy giờ,khi nào đóng cửa', 'Dạ, cửa hàng COZY CORNER mở cửa phục vụ từ **08:00 sáng đến 22:00 tối** tất cả các ngày trong tuần (kể cả Lễ, Tết) ạ. Bot thì hoạt động 24/7 luôn nhé!', 'HoatDong', '2026-03-31 08:24:17'),
(5, 'mua hàng,đặt hàng,cách mua,hướng dẫn mua,làm sao mua,đặt sao,mua ntn', 'Dạ để đặt hàng, bạn chỉ cần chọn sản phẩm ưng ý -> Thêm vào giỏ hàng -> Vào giỏ hàng chọn \"Thanh toán\" -> Điền địa chỉ và xác nhận là xong ạ. Cực kỳ đơn giản!', 'HoatDong', '2026-03-31 08:24:17'),
(6, 'vận chuyển,giao hàng,phí ship,ship,bao lâu nhận,giao hỏa tốc,freeship', 'Dạ, shop giao hàng toàn quốc qua đối tác Giao Hàng Nhanh (GHN):\n- **Thời gian:** 1-2 ngày (Nội thành HCM), 3-5 ngày (Tỉnh thành khác).\n- **Phí ship:** Được tính tự động tại trang thanh toán. Đừng quên săn mã Freeship của shop nhé!', 'HoatDong', '2026-03-31 08:24:17'),
(7, 'đồng kiểm,cho xem hàng không,được bóc hàng không,kiểm tra hàng', 'Dạ, COZY CORNER hỗ trợ **ĐỒNG KIỂM**. Bạn hoàn toàn được mở bưu kiện kiểm tra ngoại quan sản phẩm (không dùng thử) trước khi thanh toán cho Shipper ạ.', 'HoatDong', '2026-03-31 08:24:17'),
(8, 'đổi trả,hoàn hàng,hoàn tiền,trả hàng,hàng lỗi,móp méo,bể vỡ', 'Dạ, COZY CORNER có chính sách **1 ĐỔI 1 TRONG VÒNG 7 NGÀY** (miễn phí ship) nếu:\n- Sản phẩm lỗi do nhà sản xuất.\n- Hàng bể vỡ do vận chuyển.\nBạn vui lòng chụp ảnh/quay video lúc mở hàng và gửi cho shop qua mục Liên hệ để được xử lý ngay lập tức ạ!', 'HoatDong', '2026-03-31 08:24:17'),
(9, 'bảo hành,chính sách bảo hành,sửa chữa', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 'HoatDong', '2026-03-31 08:24:17'),
(10, 'khiếu nại,thái độ nhân viên,hàng giả,fake,không hài lòng,tệ', 'Dạ, Cozy Bot vô cùng xin lỗi nếu bạn có trải nghiệm chưa tốt. Bạn vui lòng liên hệ trực tiếp Hotline CSKH: **0888 888 888** để quản lý cửa hàng tiếp nhận và giải quyết thỏa đáng nhất cho bạn ạ!', 'HoatDong', '2026-03-31 08:24:17'),
(11, 'hủy đơn,muốn hủy,không mua nữa,cancel order,đổi ý', 'Dạ, nếu đơn hàng của bạn đang ở trạng thái \"Chờ xác nhận\", bạn có thể vào \"Lịch sử đơn hàng\" để tự hủy. Nếu đơn đã chuyển sang \"Đang giao\", bạn vui lòng từ chối nhận hàng giúp shop khi Shipper gọi tới nhé!', 'HoatDong', '2026-03-31 08:24:17'),
(12, 'đổi địa chỉ,sửa địa chỉ,đổi số điện thoại,sai thông tin', 'Dạ, nếu đơn hàng chưa được đóng gói, bạn hãy gọi ngay Hotline **0888 888 888** để nhân viên hỗ trợ cập nhật lại địa chỉ/SĐT cho bạn nhé. Bot không tự sửa được thông tin này ạ.', 'HoatDong', '2026-03-31 08:24:17'),
(13, 'thanh toán,chuyển khoản,cod,thanh toán khi nhận hàng,momo,vnpay', 'Dạ, shop hiện hỗ trợ các hình thức:\n- Nhận hàng thanh toán tiền mặt (COD).\n- Chuyển khoản ngân hàng (Quét mã QR tự động).', 'HoatDong', '2026-03-31 08:24:17'),
(14, 'hóa đơn đỏ,xuất vat,hóa đơn công ty', 'Dạ, shop có hỗ trợ xuất hóa đơn điện tử (VAT). Bạn vui lòng ghi chú [Mã số thuế + Tên công ty + Email] ở bước Thanh toán, kế toán bên shop sẽ gửi hóa đơn sau khi hoàn tất đơn hàng ạ.', 'HoatDong', '2026-03-31 08:24:17'),
(15, 'chào,hello,hi,bạn là ai,bot là ai,bot tên gì', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 'HoatDong', '2026-03-31 08:24:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `role` enum('user','bot') NOT NULL,
  `content` text NOT NULL,
  `is_cleared` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `session_id`, `role`, `content`, `is_cleared`, `created_at`) VALUES
(1, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì?', 1, '2026-03-30 10:39:00'),
(2, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Cozy Bot đang xử lý nhiều yêu cầu cùng lúc.Vui lòng thử lại sau ít phút để được hỗ trợ tốt nhất nhé!', 1, '2026-03-30 10:39:00'),
(3, NULL, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì?', 1, '2026-03-30 10:53:29'),
(4, NULL, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào bạn! Cozy Bot rất vui được hỗ trợ bạn ạ. 😊\n\nTại COZY CORNER, chúng mình có rất nhiều sản phẩm gia dụng chất lượng để giúp không gian bếp của bạn thêm ấm cúng và tiện nghi đó ạ. Bạn có thể tham khảo các nhóm sản phẩm chính sau đây nhé:\n\n*   **Dao các loại:** Từ dao thái chuyên dụng đến dao chặt xương, ví dụ như [Dao Nigara Anmon](http://localhost:8080/cozycorner/index.php?url=product/detail&id=36) hay [Dao chặt xương Nhật](http://localhost:8080/cozycorner/index.php?url=product/detail&id=40).\n*   **Nồi:** Đa dạng các loại nồi như [Nồi cơm điện Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=45), [Nồi áp suất Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=47) và [Nồi lẩu inox](http://localhost:8080/cozycorner/index.php?url=product/detail&id=52).\n*   **Đồ Điện gia dụng:** Các thiết bị tiện ích như [Ấm đun nước siêu tốc](http://localhost:8080/cozycorner/index.php?url=product/detail&id=54), [Bếp từ đơn Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=55) và [Nồi chiên không dầu](http://localhost:8080/cozycorner/index.php?url=product/detail&id', 1, '2026-03-30 10:53:29'),
(5, NULL, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 10:53:49'),
(6, NULL, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ chào bạn, Cozy Bot rất sẵn lòng hỗ trợ bạn tra cứu thông tin đơn hàng ạ. 😊\n\nĐể mình có thể kiểm tra chính xác nhất, bạn vui lòng cung cấp giúp mình **mã đơn hàng** của bạn nhé (ví dụ: ORD00001).\n\nNgoài ra, bạn hiện chưa đăng nhập vào hệ thống của COZY CORNER. Nếu bạn đăng nhập, bạn có thể dễ dàng tra cứu trạng thái đơn hàng của mình và xem hạng thành viên của mình bất cứ lúc nào đó ạ.\n\nMình chờ mã đơn hàng từ bạn nhé!', 1, '2026-03-30 10:53:49'),
(7, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì?', 1, '2026-03-30 10:55:23'),
(8, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào anh Đào Công Anh Minh, Cozy Bot xin chào ạ! 👋\n\nDạ, tại COZY CORNER, chúng em có rất nhiều sản phẩm gia dụng chất lượng để phục vụ nhu cầu của quý khách. Anh Minh có thể tham khảo các nhóm sản phẩm chính sau đây ạ:\n\n-   **Dao:** Các loại dao đa dạng như [Dao Nigara Anmon](http://localhost:8080/cozycorner/index.php?url=product/detail&id=36), [Dao chặt xương Nhật](http://localhost:8080/cozycorner/index.php?url=product/detail&id=40), [Dao thái sashimi](http://localhost:8080/cozycorner/index.php?url=product/detail&id=41), v.v.\n-   **Nồi:** Bao gồm [Nồi cơm điện Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=45), [Nồi áp suất Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=47), [Bộ 3 nồi inox](http://localhost:8080/cozycorner/index.php?url=product/detail&id=50), v.v.\n-   **Đồ Điện Gia Dụng:** Như [Ấm đun nước siêu tốc](http://localhost:8080/cozycorner/index.php?url=product/detail&id=54), [Bếp từ đơn Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=55), [Nồi chiên không dầu](http://localhost:8080/cozycorner/index.php?url=product/detail&id=59), v.v.\n-   **Chảo:** Có [Chảo chống dính cao cấp](http://localhost:8080/cozycorner/index.php?url=product/detail&id=60), [Chảo inox](http://localhost:8080/cozycorner/index.php?url=product/detail&id=61), [Chảo chống dính sâu lòng](http://localhost:8080/cozycorner/index.php?url=product/detail&id=64), v.v.\n-   **Chén & Dĩa:** Các mẫu đáng yêu như [Bát Kuromi](http://localhost:8080/cozycorner/index.php?url=product/detail&id=66), [Dĩa quả bơ](http://localhost:8080/cozycorner/index.php?url=', 1, '2026-03-30 10:55:23'),
(9, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì?', 1, '2026-03-30 11:31:14'),
(10, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào Anh Đào Công Anh Minh, Cozy Bot xin chào ạ! 😊\n\nDạ, tại COZY CORNER, chúng mình có rất nhiều sản phẩm gia dụng đa dạng để giúp không gian bếp nhà mình thêm tiện nghi và ấm cúng đó ạ. Anh Minh có thể tham khảo một số dòng sản phẩm nổi bật như:\n\n*   **Dụng cụ bếp:**\n    *   [Dao chặt xương Nhật](http://localhost:8080/cozycorner/index.php?url=product/detail&id=40)\n    *   [Dao thái sashimi](http://localhost:8080/cozycorner/index.php?url=product/detail&id=41)\n*   **Nồi & Chảo:**\n    *   [Nồi cơm điện Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=45)\n    *   [Chảo chống dính cao cấp](http://localhost:8080/cozycorner/index.php?url=product/detail&id=60)\n*   **Đồ điện gia dụng:**\n    *   [Bếp từ đơn Kalpen](http://localhost:8080/cozycorner/index.php?url=product/detail&id=55)\n    *   [Máy xay sinh tố](http://localhost:8080/cozycorner/index.php?url=product/detail&id=56)\n*   **Đồ dùng bàn ăn:**\n    *   [Bát Kuromi](http://localhost:8080/cozycorner/index.php?url=product/detail&id=66)\n    *   [Thớt gỗ đa dụng](http://localhost:8080/cozycorner/index.php?url=product/detail&id=75)\n\nNgoài ra, COZY CORNER còn có rất nhiều sản phẩm khác nữa ạ. Anh Minh muốn tìm hiểu thêm về loại sản phẩm nào không ạ? Mình rất sẵn lòng hỗ trợ! ✨', 1, '2026-03-30 11:31:14'),
(11, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 12:07:28'),
(12, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ, đây là các đơn hàng gần nhất của bạn:\n- Mã **ORD00036** | 27.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00035** | 37.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00034** | 88.600đ | Trạng thái: *Huy*\n\n👉 [Xem chi tiết tất cả đơn hàng](http://localhost:8080/cozycorner/index.php?url=user/account&tab=orders)', 1, '2026-03-30 12:07:28'),
(13, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-30 12:07:36'),
(14, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', '🎁 Hiện shop đang có các mã giảm giá sau:\n- Mã **TET2026** : Giảm 5% (Đơn từ 20.000đ)\n- Mã **TET** : Giảm 2.000đ (Đơn từ 10.000đ)\n- Mã **XUAN** : Giảm 5.000đ (Đơn từ 30.000đ)\n- Mã **FREESHIP** : Giảm Freeship tối đa 10.000đ (Đơn từ 30.000đ)\n', 1, '2026-03-30 12:07:36'),
(15, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 12:16:31'),
(16, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Hiện tại hệ thống chưa ghi nhận đơn hàng nào của bạn ạ.', 1, '2026-03-30 12:16:31'),
(17, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-30 12:16:38'),
(18, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', '🎁 Hiện shop đang có các mã giảm giá sau:\n- Mã **TET2026** : Giảm 5% (Đơn từ 20.000đ)\n- Mã **TET** : Giảm 2.000đ (Đơn từ 10.000đ)\n- Mã **XUAN** : Giảm 5.000đ (Đơn từ 30.000đ)\n- Mã **FREESHIP** : Giảm Freeship tối đa 10.000đ (Đơn từ 30.000đ)\n', 1, '2026-03-30 12:16:38'),
(19, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Chính sách bảo hành', 1, '2026-03-30 12:16:39'),
(20, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào bạn, đây là thông tin của COZY CORNER:\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n- **Hotline:** 0888 888 888 | **Email:** Cozy@cv.com.vn\n- **Bảo hành:** 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.\n- **Giao hàng:** Toàn quốc qua GHN, hỗ trợ COD và chuyển khoản QR.', 1, '2026-03-30 12:16:39'),
(21, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-03-30 12:16:42'),
(22, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào bạn, đây là thông tin của COZY CORNER:\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n- **Hotline:** 0888 888 888 | **Email:** Cozy@cv.com.vn\n- **Bảo hành:** 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.\n- **Giao hàng:** Toàn quốc qua GHN, hỗ trợ COD và chuyển khoản QR.', 1, '2026-03-30 12:16:42'),
(23, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 12:31:07'),
(24, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Hiện tại hệ thống chưa ghi nhận đơn hàng nào của bạn ạ.', 1, '2026-03-30 12:31:07'),
(25, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-30 12:31:09'),
(26, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', '🎁 Hiện shop đang có các mã giảm giá sau:\n- Mã **TET2026** : Giảm 5% (Đơn từ 20.000đ)\n- Mã **TET** : Giảm 2.000đ (Đơn từ 10.000đ)\n- Mã **XUAN** : Giảm 5.000đ (Đơn từ 30.000đ)\n- Mã **FREESHIP** : Giảm Freeship tối đa 10.000đ (Đơn từ 30.000đ)\n', 1, '2026-03-30 12:31:09'),
(27, 4, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 12:35:06'),
(28, 4, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Hiện tại hệ thống chưa ghi nhận đơn hàng nào của bạn ạ.', 1, '2026-03-30 12:35:06'),
(29, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì', 1, '2026-03-30 12:45:11'),
(30, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-30 12:45:11'),
(31, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Shop có bán những gì', 1, '2026-03-30 13:26:36'),
(32, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-30 13:26:36'),
(33, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'shop ở đâu', 1, '2026-03-30 13:26:51'),
(34, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào bạn, đây là thông tin của COZY CORNER:\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n- **Hotline:** 0888 888 888 | **Email:** Cozy@cv.com.vn\n- **Bảo hành:** 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.\n- **Giao hàng:** Toàn quốc qua GHN, hỗ trợ COD và chuyển khoản QR.', 1, '2026-03-30 13:26:51'),
(35, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Bạn là ai', 1, '2026-03-30 13:27:04'),
(36, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Chào bạn, đây là thông tin của COZY CORNER:\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. HCM\n- **Hotline:** 0888 888 888 | **Email:** Cozy@cv.com.vn\n- **Bảo hành:** 1 đổi 1 trong 7 ngày nếu có lỗi nhà sản xuất.\n- **Giao hàng:** Toàn quốc qua GHN, hỗ trợ COD và chuyển khoản QR.', 1, '2026-03-30 13:27:04'),
(37, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'tôi muốn mua thì làm như nào', 1, '2026-03-30 13:27:29'),
(38, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ chào bạn! Rất vui khi bạn quan tâm đến sản phẩm của COZY CORNER', 1, '2026-03-30 13:27:29'),
(39, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'chỉ tôi cách mua hàng', 1, '2026-03-30 13:27:46'),
(40, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ chào bạn! Để mua hàng tại COZY CORNER, bạn có thể làm theo các', 1, '2026-03-30 13:27:46'),
(41, 5, 'vhv70q672mnol3gi1aj3vckumt', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-30 13:30:57'),
(42, 5, 'vhv70q672mnol3gi1aj3vckumt', 'bot', 'Dạ, đây là các đơn hàng gần nhất của bạn:\n- Mã **ORD00036** | 27.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00035** | 37.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00034** | 88.600đ | Trạng thái: *Huy*\n\n👉 [Xem chi tiết tất cả đơn hàng](http://localhost:8080/cozycorner/index.php?url=user/account&tab=orders)', 1, '2026-03-30 13:30:57'),
(43, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'user', 'đơn tôi bị hủy hả', 1, '2026-03-31 06:19:12'),
(44, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'bot', 'Dạ, đây là các đơn hàng gần nhất của bạn:\n- Mã **ORD00036** | 27.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00035** | 37.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00034** | 88.600đ | Trạng thái: *Huy*\n\n👉 [Xem chi tiết tất cả đơn hàng](http://localhost:8080/cozycorner/index.php?url=user/account&tab=orders)', 1, '2026-03-31 06:19:12'),
(45, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'user', 'tôi mua mấy đơn rồi', 1, '2026-03-31 06:19:32'),
(46, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'bot', 'Dạ, đây là các đơn hàng gần nhất của bạn:\n- Mã **ORD00036** | 27.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00035** | 37.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00034** | 88.600đ | Trạng thái: *Huy*\n\n👉 [Xem chi tiết tất cả đơn hàng](http://localhost:8080/cozycorner/index.php?url=user/account&tab=orders)', 1, '2026-03-31 06:19:32'),
(47, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'user', 'tổi muốn trả hàng thì làm sao', 1, '2026-03-31 06:20:02'),
(48, 5, '2o96t73jb1q9n7sia2bjsc9ha9', 'bot', 'Dạ, COZY CORNER có chính sách **1 đổi 1 trong vòng 7 ngày** đối với các sản phẩm có lỗi từ nhà sản xuất.\n\nNếu sản phẩm của bạn gặp vấn đề, vui lòng liên hệ ngay với shop kèm hình ảnh/video để được hỗ trợ nhanh nhất nhé!', 1, '2026-03-31 06:20:02'),
(49, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 06:39:21'),
(50, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-31 06:39:21'),
(51, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi muốn đổi mật khẩu', 1, '2026-03-31 06:41:36'),
(52, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang **Tài khoản của tôi**.\n\n👉 Bấm vào đây để đến trang tài khoản của bạn.', 1, '2026-03-31 06:41:36'),
(53, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 06:48:07'),
(54, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-31 06:48:07'),
(55, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'dùng voucher', 1, '2026-03-31 06:48:16'),
(56, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để sử dụng mã giảm giá, bạn chỉ cần nhập mã vào ô **\"Mã giảm giá\"** ở trang thanh toán và nhấn \"Áp dụng\".\n\nHệ thống sẽ tự động trừ số tiền được giảm vào tổng đơn hàng của bạn. Bạn có thể xem các mã giảm giá hiện có ở trang thanh toán nhé!', 1, '2026-03-31 06:48:16'),
(57, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi muốn xem thông tin cá nhân thì ở đâu', 1, '2026-03-31 06:48:41'),
(58, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể liên hệ với COZY CORNER qua các thông tin sau:\n\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn\n\nNếu cần hỗ trợ gấp, bạn có thể tiếp tục trò chuyện với mình hoặc vào trang liên hệ nhé!', 1, '2026-03-31 06:48:41'),
(59, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'thông tin cá nhân', 1, '2026-03-31 06:48:54'),
(60, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang **Tài khoản của tôi**.\n\n👉 Bấm vào đây để đến trang tài khoản của bạn.', 1, '2026-03-31 06:48:54'),
(61, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 06:49:53'),
(62, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-31 06:49:53'),
(63, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 06:50:55'),
(64, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, đây là các đơn hàng gần nhất của bạn:\n- Mã **ORD00036** | 27.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00035** | 37.900đ | Trạng thái: *HoanThanh*\n- Mã **ORD00034** | 88.600đ | Trạng thái: *Huy*\n\n👉 [Xem chi tiết tất cả đơn hàng](http://localhost:8080/cozycorner/index.php?url=user/account&tab=orders)', 1, '2026-03-31 06:50:55'),
(65, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'đặt hàng như nào', 1, '2026-03-31 06:51:15'),
(66, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ để mua hàng tại COZY CORNER, bạn có thể làm theo các bước sau ạ:\n\n1.  **Chọn sản phẩm:** Duyệt qua các danh mục sản phẩm và chọn món đồ bạn yêu thích.\n2.  **Thêm vào giỏ:** Tại trang chi tiết sản phẩm, nhấn nút \"Thêm vào giỏ hàng\".\n3.  **Thanh toán:** Vào giỏ hàng của bạn, kiểm tra lại sản phẩm và nhấn \"Tiến hành thanh toán\".\n4.  **Điền thông tin:** Nhập địa chỉ giao hàng, chọn mã giảm giá (nếu có) và phương thức thanh toán.\n\nChúc bạn có một trải nghiệm mua sắm tuyệt vời! 🛒', 1, '2026-03-31 06:51:15'),
(67, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi muốn xem thông tin cá nhân thì ở đâu', 1, '2026-03-31 06:59:11'),
(68, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý mọi thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang Tài khoản của tôi.\n\nChỉ cần click vào link là đến trang đó ngay ạ!', 1, '2026-03-31 06:59:11'),
(69, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi đang là hạng gì', 1, '2026-03-31 06:59:32'),
(70, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ em xin lỗi ạ, hiện tại Cozy Bot chưa thể kiểm tra hạng thành viên của quý khách được ạ.\n\nĐể biết thêm thông tin chi tiết về hạng thành viên và các ưu đãi dành riêng cho mình, bạn vui lòng liên hệ trực tiếp với bộ phận Chăm sóc khách hàng qua Hotline: **0888 888 888** hoặc Email: **Cozy@cv.com.vn** nhé!\n\nCozy Bot rất tiếc vì sự bất tiện này ạ!', 1, '2026-03-31 06:59:32'),
(71, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Tôi đang ở hạng gì', 1, '2026-03-31 07:13:18'),
(72, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Chào bạn Đào Công Anh Minh thân mến!\n\nCozy Bot xin phép thông báo:\n- Hiện tại, bạn đang là thành viên hạng **Kim Cương** của COZY CORNER ạ!\n\nNếu bạn cần Cozy Bot hỗ trợ thêm thông tin gì, đừng ngần ngại cho Cozy Bot biết nhé!', 1, '2026-03-31 07:13:18'),
(73, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi có thể xem thông tin cá nhân ở đâu', 1, '2026-03-31 07:13:46'),
(74, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý mọi thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang Tài khoản của tôi.\n\nChỉ cần click vào link là đến trang đó ngay ạ!', 1, '2026-03-31 07:13:46'),
(75, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 07:13:52'),
(76, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER chuyên cung cấp các mặt hàng gia dụng chất lượng, bao gồm:\n- **[Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)**\n- **[Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)**\n- **[Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)**\n- **[Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)**\n- **[Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)**\n- **[Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)**\n\n👉 [Xem tất cả sản phẩm tại đây](http://localhost:8080/cozycorner/index.php?url=product)', 1, '2026-03-31 07:13:52'),
(77, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 07:13:53'),
(78, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 07:13:53'),
(79, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 0, '2026-03-31 07:14:47'),
(80, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 0, '2026-03-31 07:14:47'),
(81, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 0, '2026-03-31 07:14:54'),
(82, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', '🎁 Hiện shop đang có các mã giảm giá sau:\n- Mã **TET2026** : Giảm 5% (Đơn từ 20.000đ)\n- Mã **TET** : Giảm 2.000đ (Đơn từ 10.000đ)\n- Mã **XUAN** : Giảm 5.000đ (Đơn từ 30.000đ)\n- Mã **FREESHIP** : Giảm Freeship tối đa 10.000đ (Đơn từ 30.000đ)\n', 0, '2026-03-31 07:14:54'),
(83, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 0, '2026-03-31 07:14:55'),
(84, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, tất cả sản phẩm tại COZY CORNER đều được áp dụng chính sách bảo hành **1 đổi 1 trong vòng 7 ngày** nếu phát sinh lỗi từ nhà sản xuất. Bạn vui lòng giữ lại hóa đơn và xem chi tiết tại trang chính sách bảo hành để được hỗ trợ tốt nhất ạ!', 0, '2026-03-31 07:14:55'),
(85, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 0, '2026-03-31 07:25:36'),
(86, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 0, '2026-03-31 07:25:36'),
(87, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 0, '2026-03-31 07:26:08'),
(88, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, shop sử dụng dịch vụ **Giao Hàng Nhanh (GHN)** cho tất cả các đơn hàng.\n\n- **Phí vận chuyển:** Sẽ được tự động tính toán dựa trên địa chỉ của bạn ở trang thanh toán.\n- **Thời gian giao hàng:** Thông thường từ 2-4 ngày làm việc tùy thuộc vào khu vực của bạn.\n\nBạn cứ yên tâm đặt hàng, hệ thống sẽ hiển thị chi tiết phí ship trước khi bạn xác nhận ạ!', 0, '2026-03-31 07:26:08'),
(89, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi là ai', 0, '2026-03-31 07:27:30'),
(90, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 0, '2026-03-31 07:27:30'),
(91, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'tôi là ai', 0, '2026-03-31 07:27:41'),
(92, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 0, '2026-03-31 07:27:41'),
(93, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 0, '2026-03-31 07:27:44'),
(94, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể liên hệ với COZY CORNER qua các thông tin sau:\n\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn\n\nHoặc bạn có thể đến trực tiếp trang liên hệ để gửi tin nhắn cho shop ạ!', 0, '2026-03-31 07:27:44'),
(95, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 0, '2026-03-31 07:29:14'),
(96, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, shop sử dụng dịch vụ **Giao Hàng Nhanh (GHN)** cho tất cả các đơn hàng.\n\n- **Phí vận chuyển:** Sẽ được tự động tính toán dựa trên địa chỉ của bạn ở trang thanh toán.\n- **Thời gian giao hàng:** Thông thường từ 2-4 ngày làm việc tùy thuộc vào khu vực của bạn.\n\nBạn cứ yên tâm đặt hàng, hệ thống sẽ hiển thị chi tiết phí ship trước khi bạn xác nhận ạ!', 0, '2026-03-31 07:29:14'),
(97, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 0, '2026-03-31 07:29:17'),
(98, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện hỗ trợ 2 phương thức thanh toán chính:\n\n- **Thanh toán khi nhận hàng (COD):** Bạn sẽ thanh toán tiền mặt trực tiếp cho nhân viên giao hàng.\n- **Chuyển khoản ngân hàng:** Bạn có thể thanh toán qua mã QR động được tạo tự động sau khi đặt hàng thành công.\n\nBạn có thể lựa chọn phương thức phù hợp nhất ở trang thanh toán nhé!', 0, '2026-03-31 07:29:17'),
(99, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Địa chỉ shop ở đâu?', 0, '2026-03-31 07:29:20'),
(100, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể liên hệ với COZY CORNER qua các thông tin sau:\n\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn\n\nHoặc bạn có thể đến trực tiếp trang liên hệ để gửi tin nhắn cho shop ạ!', 0, '2026-03-31 07:29:20'),
(101, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 0, '2026-03-31 07:29:54'),
(102, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 0, '2026-03-31 07:29:54'),
(103, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 0, '2026-03-31 07:29:55'),
(104, 4, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể liên hệ với COZY CORNER qua các thông tin sau:\n\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn\n\nHoặc bạn có thể đến trực tiếp trang liên hệ để gửi tin nhắn cho shop ạ!', 0, '2026-03-31 07:29:55'),
(105, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 07:39:41'),
(106, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-03-31 07:39:41'),
(107, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 07:39:43'),
(108, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 07:39:43'),
(109, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-03-31 07:39:45'),
(110, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể liên hệ với COZY CORNER qua các thông tin sau:\n\n- **Địa chỉ:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn\n\nHoặc bạn có thể đến trực tiếp trang liên hệ để gửi tin nhắn cho shop ạ!', 1, '2026-03-31 07:39:45'),
(111, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 1, '2026-03-31 07:39:47'),
(112, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, tất cả sản phẩm tại COZY CORNER đều được áp dụng chính sách bảo hành **1 đổi 1 trong vòng 7 ngày** nếu phát sinh lỗi từ nhà sản xuất. Bạn vui lòng giữ lại hóa đơn và liên hệ với shop để được hỗ trợ tốt nhất ạ!', 1, '2026-03-31 07:39:47'),
(113, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-31 07:39:54'),
(114, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Chào bạn Đào Công Anh Minh, Cozy Bot xin gửi bạn các mã giảm giá siêu hấp dẫn đang có tại Cozy Corner đây ạ:\n\n*   **Mã TET2026**: Giảm ngay 5% cho đơn hàng từ 20.000đ.\n*   **Mã TET**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **Mã XUAN**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nBạn nhớ áp dụng mã khi thanh toán để nhận ưu đãi nhé! Chúc bạn mua sắm vui vẻ ạ! 😊', 1, '2026-03-31 07:39:54'),
(115, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'cách thanh toán qr', 1, '2026-03-31 07:50:43'),
(116, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện hỗ trợ 2 phương thức thanh toán chính:\n\n- **Thanh toán khi nhận hàng (COD):** Bạn sẽ thanh toán tiền mặt trực tiếp cho nhân viên giao hàng.\n- **Chuyển khoản ngân hàng:** Bạn có thể thanh toán qua mã QR động được tạo tự động sau khi đặt hàng thành công.\n\nBạn có thể lựa chọn phương thức phù hợp nhất ở trang thanh toán nhé!', 1, '2026-03-31 07:50:43'),
(117, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'đơn hàng của tôi tới đâu rồi sao mãi chưa thấy giao', 1, '2026-03-31 07:51:25'),
(118, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 07:51:25'),
(119, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'kiểm tra tình trạng đơn #ORD00036', 1, '2026-03-31 07:51:49'),
(120, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 07:51:49'),
(121, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-31 08:05:32'),
(122, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Chào bạn Đào Công Anh Minh, thành viên hạng Kim Cương của COZY CORNER! ✨\n\nDạ, COZY CORNER có những mã giảm giá siêu hấp dẫn đang chờ bạn đây ạ:\n\n*   **Mã \'TET2026\'**: Giảm ngay **5%** cho đơn hàng từ 20.000đ.\n*   **Mã \'TET\'**: Giảm **2.000đ** cho đơn hàng từ 10.000đ.\n*   **Mã \'XUAN\'**: Giảm **5.000đ** cho đơn hàng từ 30.000đ.\n\nBạn nhớ áp dụng mã phù hợp khi thanh toán để nhận ưu đãi nhé! Chúc bạn có trải nghiệm mua sắm thật vui vẻ tại COZY CORNER ạ! 😊', 1, '2026-03-31 08:05:32'),
(123, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 08:05:51'),
(124, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 08:05:51'),
(125, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'hello', 1, '2026-03-31 08:06:43'),
(126, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI thông minh tại cửa hàng gia dụng COZY CORNER.\n\nMình có thể giúp bạn:\n- Tư vấn và tìm kiếm sản phẩm.\n- Cung cấp thông tin về mã giảm giá.\n- Hỗ trợ kiểm tra đơn hàng.\n\nBạn cần mình giúp gì hôm nay ạ?', 1, '2026-03-31 08:06:43'),
(127, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'link tài khoản', 1, '2026-03-31 08:06:57'),
(128, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý mọi thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang Tài khoản của tôi.\n\nChỉ cần click vào link là đến trang đó ngay ạ!', 1, '2026-03-31 08:06:57'),
(129, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Cho tôi xem thông tin sản phẩm', 1, '2026-03-31 08:08:12'),
(130, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn có thể quản lý mọi thông tin cá nhân, xem lịch sử đơn hàng và đổi mật khẩu tại trang Tài khoản của tôi.', 1, '2026-03-31 08:08:12'),
(131, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 08:09:31'),
(132, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 08:09:31'),
(133, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-31 08:09:52'),
(134, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Chào bạn Đào Công Anh Minh, Cozy Bot xin gửi bạn các mã giảm giá đang áp dụng tại Cozy Corner đây ạ:\n\n*   **TET2026**: Giảm 5% cho đơn hàng từ 20.000đ.\n*   **TET**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **XUAN**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nBạn có thể áp dụng các mã này khi thanh toán để nhận ưu đãi nhé! Chúc bạn mua sắm vui vẻ ạ! 😊', 1, '2026-03-31 08:09:52'),
(135, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 1, '2026-03-31 08:09:54'),
(136, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, tất cả sản phẩm tại COZY CORNER đều được áp dụng chính sách bảo hành **1 đổi 1 trong vòng 7 ngày** nếu phát sinh lỗi từ nhà sản xuất. Bạn vui lòng giữ lại hóa đơn và liên hệ với shop để được hỗ trợ tốt nhất ạ!', 1, '2026-03-31 08:09:54'),
(137, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 08:21:41'),
(138, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, để kiểm tra tình trạng các đơn hàng đã đặt, bạn vui lòng truy cập trang Lịch sử đơn hàng nhé. Mọi thông tin đều được cập nhật ở đó ạ!', 1, '2026-03-31 08:21:41'),
(139, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-03-31 08:25:30'),
(140, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!', 1, '2026-03-31 08:25:30'),
(141, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'ord0036', 1, '2026-03-31 08:25:46'),
(142, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, đơn hàng **ORD00036** (tạo ngày 29/03/2026) có tổng giá trị **27.900đ** hiện đang ở trạng thái: **HoanThanh**.', 1, '2026-03-31 08:25:46'),
(143, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 08:25:52'),
(144, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-03-31 08:25:52'),
(145, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'cho tôi xem cái chảo', 1, '2026-03-31 08:26:02'),
(146, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ vâng, COZY CORNER hiện có các loại chảo sau đây ạ:\n\n*   [Chảo chống dính cao cấp](http://localhost:8080/cozycorner/index.php?url=product/detail&id=60) - Giá 15.000đ\n*   [Chảo inox](http://localhost:8080/cozycorner/index.php?url=product/detail&id=61) - Giá 10.000đ\n*   [Chảo chống dính ceramic](http://localhost:8080/cozycorner/index.php?url=product/detail&id=62) - Giá 10.000đ\n*   [Chảo chống dính](http://localhost:8080/cozycorner/index.php?url=product/detail&id=63) - Giá 15.000đ\n\nBạn quan tâm đến loại chảo nào ạ?', 1, '2026-03-31 08:26:02'),
(147, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 1, '2026-03-31 08:26:08'),
(148, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 1, '2026-03-31 08:26:08'),
(149, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Mã giảm giá hôm nay', 1, '2026-03-31 08:26:17'),
(150, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ vâng, Cozy Bot xin thông báo các mã giảm giá hiện có tại COZY CORNER để anh/chị Đào Công Anh Minh tham khảo ạ:\n\n*   **Mã \'TET2026\'**: Giảm 5% cho đơn hàng từ 20.000đ.\n*   **Mã \'TET\'**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **Mã \'XUAN\'**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nAnh/chị Đào Công Anh Minh có thể áp dụng các mã này khi thanh toán nhé! Nếu cần hỗ trợ thêm, đừng ngần ngại cho Cozy Bot biết ạ. 😊', 1, '2026-03-31 08:26:17'),
(151, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-03-31 08:26:25'),
(152, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-03-31 08:26:25'),
(153, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'có xuất hóa đơn ko', 1, '2026-03-31 08:26:43'),
(154, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ có ạ! COZY CORNER có xuất hóa đơn VAT theo yêu cầu của quý khách hàng. Khi đặt hàng, anh/chị Đào Công Anh Minh chỉ cần cung cấp thông tin cần thiết để xuất hóa đơn là được ạ. 😊', 1, '2026-03-31 08:26:43'),
(155, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Tôi có thể mua được mấy sản phẩm 1 lần', 1, '2026-03-31 08:29:24'),
(156, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Chào bạn Đào Công Anh Minh! Cozy Bot rất vui được hỗ trợ bạn ạ.\n\nRất tiếc, Cozy Bot hiện tại chưa có thông tin về số lượng sản phẩm tối đa mà bạn có thể mua trong một lần. Thông tin này có thể phụ thuộc vào chính sách vận chuyển hoặc quy định của từng sản phẩm cụ thể.\n\nĐể biết thông tin chính xác nhất, bạn vui lòng kiểm tra trực tiếp trên trang sản phẩm hoặc liên hệ với bộ phận hỗ trợ khách hàng của Cozy Corner nhé!\n\nNếu bạn cần tìm hiểu về các sản phẩm của Cozy Corner, Cozy Bot luôn sẵn lòng giúp đỡ ạ:\n*   [Thớt gỗ đa dụng](http://localhost:8080/cozycorner/index.php?url=product/detail&id=75)\n*   [Dao Nigara Anmon](http://localhost:8080/cozycorner/index.php?url=product/detail&id=36)\n*   [Dao Shigekatsu](http://localhost:8080/cozycorner/index.php?url=product/detail&id=37)\n*   [Thớt gỗ](http://localhost:8080/cozycorner/index.php?url=product/detail&id=72)', 1, '2026-03-31 08:29:24'),
(157, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Shop có bán những gì', 1, '2026-03-31 08:29:42'),
(158, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-03-31 08:29:42'),
(159, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'Chính sách bảo hành', 1, '2026-03-31 08:29:46'),
(160, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 1, '2026-03-31 08:29:46'),
(161, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'bạn là ai dị', 1, '2026-03-31 09:21:45'),
(162, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 1, '2026-03-31 09:21:45'),
(163, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'user', 'bạn có gì ăn không', 1, '2026-03-31 09:21:58'),
(164, 5, 'qbcdhaafoov25u4mkie5ndajd2', 'bot', 'Dạ, em là trợ lý AI nên em không có gì để ăn đâu ạ! 😅\n\nCOZY CORNER chuyên cung cấp các sản phẩm đồ dùng nhà bếp chất lượng cao như chảo, nồi, dao, thớt... Bạn có muốn em giới thiệu sản phẩm nào không ạ?', 1, '2026-03-31 09:21:58'),
(165, 5, 'uf7i1egpj45u7h811uf61phjsd', 'user', 'Shop có bán những gì', 1, '2026-03-31 12:11:46'),
(166, 5, 'uf7i1egpj45u7h811uf61phjsd', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-03-31 12:11:46'),
(167, 5, 'uf7i1egpj45u7h811uf61phjsd', 'user', 'Bạn có giỏi không', 1, '2026-03-31 12:11:57'),
(168, 5, 'uf7i1egpj45u7h811uf61phjsd', 'bot', 'Dạ, em là Cozy Bot, trợ lý AI của COZY CORNER ạ! Em được thiết kế để giúp quý khách hàng tìm kiếm thông tin sản phẩm, giải đáp thắc mắc và hỗ trợ mua sắm một cách nhanh chóng và tiện lợi nhất.\n\nEm rất vui được phục vụ bạn, Đào Công Anh Minh! Nếu bạn cần tìm sản phẩm hay có bất kỳ câu hỏi nào, đừng ngần ngại hỏi em nhé! 😊', 1, '2026-03-31 12:11:57'),
(169, 5, 'uf7i1egpj45u7h811uf61phjsd', 'user', 'Bán cho tôi 1 con dao thật sắc để đi quánh lộn', 1, '2026-03-31 12:12:28'),
(170, 5, 'uf7i1egpj45u7h811uf61phjsd', 'bot', 'Dạ, em rất xin lỗi ạ, nhưng các sản phẩm dao của COZY CORNER đều là dụng cụ nhà bếp chuyên dụng, được thiết kế để hỗ trợ quý khách trong việc nấu nướng và chuẩn bị thực phẩm thôi ạ. Chúng em không kinh doanh hay khuyến khích sử dụng sản phẩm cho bất kỳ mục đích nào khác ngoài việc bếp núc an toàn và hợp pháp ạ.\n\nNếu bạn Đào Công Anh Minh đang tìm kiếm dao để phục vụ cho việc bếp núc, em rất sẵn lòng giới thiệu các mẫu dao chất lượng cao của COZY CORNER ạ! 😊', 1, '2026-03-31 12:12:28'),
(171, 5, 'uf7i1egpj45u7h811uf61phjsd', 'user', 'Bạn bán điện thoại không', 1, '2026-03-31 12:14:13'),
(172, 5, 'uf7i1egpj45u7h811uf61phjsd', 'bot', 'Chào bạn! Cozy Bot rất vui được hỗ trợ bạn ạ! 😊\n\nHiện tại, Cozy Corner chuyên cung cấp các sản phẩm đồ dùng nhà bếp chất lượng cao thôi ạ, như:\n*   [Thớt gỗ đa dụng](http://localhost:8080/cozycorner/index.php?url=product/detail&id=75)\n*   [Dao Nigara Anmon](http://localhost:8080/cozycorner/index.php?url=product/detail&id=36)\n*   [Dao Shigekatsu](http://localhost:8080/cozycorner/index.php?url=product/detail&id=37)\n*   [Thớt gỗ](http://localhost:8080/cozycorner/index.php?url=product/detail&id=72)\n\nCozy Corner chưa kinh doanh mặt hàng điện thoại bạn nhé. Rất mong được phục vụ bạn với các sản phẩm nhà bếp tiện ích của chúng mình ạ!', 1, '2026-03-31 12:14:13'),
(173, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-04-03 12:46:28'),
(174, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!', 1, '2026-04-03 12:46:28'),
(175, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'chào buổi sáng', 1, '2026-04-03 12:46:36'),
(176, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 1, '2026-04-03 12:46:36'),
(177, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'mấy giờ rồi bạn', 1, '2026-04-03 12:46:43'),
(178, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Dạ, mình là trợ lý AI nên mình không có thông tin về thời gian hiện tại ạ. Bạn có thể xem trên thiết bị của mình nhé! 😊', 1, '2026-04-03 12:46:43'),
(179, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-04-03 12:46:47'),
(180, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-03 12:46:47'),
(181, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'Cho tôi mua 1 con dao để đánh nhau', 1, '2026-04-03 12:47:05'),
(182, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Dạ bạn ơi, các sản phẩm dao tại COZY CORNER đều là dao bếp chuyên dụng, được thiết kế để hỗ trợ công việc nấu nướng và làm bếp an toàn, hiệu quả thôi ạ. Mình không cung cấp sản phẩm cho mục đích khác bạn nhé.\n\nNếu bạn đang tìm kiếm một con dao chất lượng để phục vụ cho việc bếp núc, mình rất sẵn lòng giới thiệu các sản phẩm phù hợp ạ! 😊', 1, '2026-04-03 12:47:05'),
(183, 5, 'glb1lecf5ulnikoq0pg412a1au', 'user', 'Mã giảm giá hôm nay', 1, '2026-04-03 13:22:57'),
(184, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Chào bạn Đào Công Anh Minh, thành viên Kim Cương của Cozy Corner! 😊\n\nDạ, các mã giảm giá đang áp dụng tại Cozy Corner hôm nay là:\n\n*   **Mã TET2026**: Giảm ngay 5% cho đơn hàng từ 20.000đ.\n*   **Mã TET**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **Mã XUAN**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nBạn nhớ áp dụng mã khi thanh toán để nhận ưu đãi nhé! Chúc bạn mua sắm vui vẻ ạ! ✨', 1, '2026-04-03 13:22:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `tieu_de` varchar(255) DEFAULT NULL,
  `noi_dung` text NOT NULL,
  `trang_thai` enum('ChuaDoc','DaDoc') DEFAULT 'ChuaDoc',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `ho_ten`, `email`, `so_dien_thoai`, `tieu_de`, `noi_dung`, `trang_thai`, `created_at`) VALUES
(1, 'minh', 'admin123@gmail.com', '0123456789', '123', '123', 'ChuaDoc', '2026-03-26 11:01:30'),
(2, 'a', 'admin123@gmail.com', '0123456789', '123', '1', 'ChuaDoc', '2026-03-26 11:08:29'),
(3, 'minh', 'admin123@gmail.com', '0123456789', 'test', 'test', 'ChuaDoc', '2026-03-26 11:17:54'),
(4, '1', 'admin123@gmail.com', '0123456789', 'test', '1', 'ChuaDoc', '2026-03-26 11:18:37'),
(5, '1', 'admin123@gmail.com', '0123456789', 'test', '1', 'ChuaDoc', '2026-03-26 11:25:25'),
(6, 'minh', 'admin123@gmail.com', '0123456789', 'test', 'test', 'ChuaDoc', '2026-03-26 11:25:47'),
(7, 'minh', 'admin123@gmail.com', '0123456789', 'test', 'test', 'ChuaDoc', '2026-03-26 11:26:20'),
(8, 'minh', 'admin123@gmail.com', '0123456789', 'test', 'test', 'ChuaDoc', '2026-03-26 11:28:03'),
(9, 'Đào Công Anh Minh', 'daoconganhminh1902@gmail.com', '0911078383', '123', '123', 'ChuaDoc', '2026-03-29 06:20:14'),
(10, 'Đào Công Anh Minh', 'admin123@gmail.com', '0911078383', 'ád', 'ád', 'ChuaDoc', '2026-04-03 12:43:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `guest_rate_limits`
--

CREATE TABLE `guest_rate_limits` (
  `ip_address` varchar(45) NOT NULL,
  `action_date` date NOT NULL,
  `daily_count` int(11) DEFAULT 0,
  `last_request_time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `guest_rate_limits`
--

INSERT INTO `guest_rate_limits` (`ip_address`, `action_date`, `daily_count`, `last_request_time`) VALUES
('::1', '2026-03-31', 11, 1774963243);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `tieu_de` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `noi_dung` text NOT NULL,
  `danh_muc` varchar(50) DEFAULT 'Mẹo vặt',
  `anh` varchar(255) DEFAULT NULL,
  `luot_xem` int(11) DEFAULT 0,
  `trang_thai` enum('HienThi','An') DEFAULT 'HienThi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `admin_id`, `tieu_de`, `slug`, `noi_dung`, `danh_muc`, `anh`, `luot_xem`, `trang_thai`, `created_at`) VALUES
(2, 1, 'Mẹo Bảo Quản Dụng Cụ Nhà Bếp Hiệu Quả', 'm-o-b-o-qu-n-d-ng-c-nh-b-p-hi-u-qu--1774693302', 'Gian bếp là nơi lưu giữ những bữa cơm ấm cúng, là không gian gắn kết yêu thương trong mỗi gia đình Việt. Nhưng sau những phút giây nấu nướng, nếu không biết cách bảo quản, dụng cụ nhà bếp dễ xuống cấp, kém vệ sinh và nhanh hỏng.\r\n\r\nĐể căn bếp luôn sạch đẹp, đồ dùng luôn bền như mới, dưới đây là những mẹo đơn giản mà người nội trợ nào cũng nên biết:\r\n\r\n1. Lau khô hoàn toàn sau khi rửa\r\nĐừng để các dụng cụ ướt tự khô trong không khí. Đặc biệt với dụng cụ inox, gỗ, chống dính – nếu còn đọng nước, chúng rất dễ bị ố màu, hoen gỉ, nứt nẻ hoặc bong lớp phủ.\r\n👉 Sau khi rửa, hãy dùng khăn mềm lau khô và để ở nơi thoáng khí trước khi cất đi.\r\n\r\n2. Không ngâm đồ gỗ hoặc dao quá lâu trong nước\r\nNgâm lâu khiến gỗ hút nước, nhanh mục và biến dạng, còn dao thì nhanh cùn, dễ gỉ lưỡi. Với các vật dụng này, hãy rửa ngay sau khi dùng, lau khô kỹ và cất đúng nơi quy định.\r\n\r\n3. Cất đồ đúng cách – tránh trầy xước, va đập\r\nXếp chồng chéo chảo chống dính hoặc nồi inox có thể khiến bề mặt bị trầy xước, bong lớp chống dính. Hãy lót khăn mỏng, vải nỉ hoặc sử dụng giá treo riêng biệt để bảo vệ sản phẩm tốt hơn.\r\n\r\n4. Làm sạch định kỳ các thiết bị điện nhỏ\r\nMáy xay, máy ép, nồi chiên… nếu không được làm sạch thường xuyên có thể tích tụ cặn bẩn, dầu mỡ và gây mùi khó chịu.\r\n👉 Hãy tháo rời và vệ sinh đúng cách sau mỗi lần sử dụng, đồng thời kiểm tra các chi tiết như gioăng, nắp, khe thoát hơi để đảm bảo thiết bị vận hành ổn định.\r\n\r\n5. Ưu tiên sản phẩm chất lượng – dễ vệ sinh, an toàn\r\nĐầu tư ban đầu vào dụng cụ nhà bếp đạt chuẩn Châu Âu, dễ làm sạch, chống oxy hóa tốt và an toàn cho sức khỏe sẽ giúp tiết kiệm lâu dài về sau.\r\nVà đừng quên, Elmich luôn đồng hành cùng bạn với các sản phẩm nhà bếp bền đẹp, tiện dụng, đạt chuẩn Châu Âu.\r\n\r\nMột căn bếp sạch là khởi nguồn của những bữa ăn ngon – Một dụng cụ bền là người bạn đồng hành tin cậy trong mỗi lần vào bếp.\r\nHãy bắt đầu từ những điều nhỏ nhất để gian bếp luôn là nơi truyền cảm hứng mỗi ngày.', 'Mẹo vặt', '1774693302_news_img-tintuc1.png', 3, 'HienThi', '2026-03-28 10:21:42'),
(3, 1, 'Top 5 Sản Phẩm Gia Dụng Không Thể Thiếu Cho Mỗi Gia Đình', 'top-5-s-n-ph-m-gia-d-ng-kh-ng-th-thi-u-cho-m-i-gia-nh-1774693687', 'Trong bối cảnh cuộc sống hiện đại ngày càng bận rộn, các sản phẩm gia dụng đóng vai trò quan trọng trong việc tối ưu hóa thời gian và nâng cao chất lượng sinh hoạt. Thực tế cho thấy, nhu cầu sử dụng đồ gia dụng tại Việt Nam ngày càng đa dạng với nhiều nhóm sản phẩm phục vụ từ nấu nướng, bảo quản thực phẩm đến chăm sóc sức khỏe gia đình .\r\n\r\nDưới đây là những sản phẩm thiết yếu mà hầu hết các gia đình nên trang bị để đảm bảo sự tiện nghi và hiệu quả trong sinh hoạt hàng ngày.\r\n\r\n1. Nồi chiên không dầu\r\n\r\nNồi chiên không dầu là một trong những thiết bị nhà bếp phổ biến nhất hiện nay nhờ khả năng chế biến thực phẩm với lượng dầu tối thiểu. Thiết bị này giúp giảm chất béo trong món ăn, đồng thời vẫn giữ được hương vị và độ giòn cần thiết.\r\n\r\nNgoài chức năng chiên, nhiều dòng sản phẩm còn tích hợp nướng, sấy hoặc hâm nóng, đáp ứng đa dạng nhu cầu nấu ăn trong gia đình.\r\n\r\n2. Máy xay sinh tố\r\n\r\nMáy xay sinh tố là thiết bị hỗ trợ chế biến thực phẩm nhanh chóng, đặc biệt phù hợp với nhu cầu bổ sung dinh dưỡng hằng ngày. Từ sinh tố, nước ép đến cháo hoặc súp, thiết bị này giúp tiết kiệm đáng kể thời gian chuẩn bị.\r\n\r\nĐây cũng là sản phẩm gần như không thể thiếu trong các gia đình có trẻ nhỏ hoặc người cao tuổi.\r\n\r\n3. Bộ nồi chảo chống dính\r\n\r\nBộ nồi chảo chất lượng cao giúp việc nấu ăn trở nên thuận tiện hơn, hạn chế tình trạng thức ăn bám dính và dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nHiện nay, các sản phẩm nồi chảo được sản xuất với nhiều chất liệu như inox, nhôm phủ chống dính hoặc hợp kim cao cấp, đáp ứng nhu cầu đa dạng của người tiêu dùng. Những sản phẩm này không chỉ phục vụ nấu nướng mà còn góp phần nâng cao trải nghiệm bếp núc hàng ngày.\r\n\r\n4. Ấm siêu tốc\r\n\r\nẤm siêu tốc là thiết bị quen thuộc trong hầu hết các gia đình nhờ khả năng đun nước nhanh chóng và tiện lợi. Chỉ trong vài phút, người dùng có thể chuẩn bị nước nóng để pha trà, cà phê hoặc phục vụ các nhu cầu sinh hoạt khác.\r\n\r\nVới thiết kế ngày càng cải tiến về độ an toàn và tiết kiệm điện, ấm siêu tốc trở thành một trong những thiết bị thiết yếu trong không gian bếp hiện đại.\r\n\r\n5. Hộp đựng thực phẩm\r\n\r\nHộp đựng thực phẩm đóng vai trò quan trọng trong việc bảo quản thức ăn và giữ vệ sinh cho tủ lạnh. Các sản phẩm hiện nay thường được thiết kế kín khí, giúp hạn chế mùi và ngăn vi khuẩn phát triển.\r\n\r\nTheo xu hướng tiêu dùng, các loại hộp bảo quản thực phẩm đang ngày càng được ưa chuộng nhờ tính tiện lợi và khả năng sử dụng trong nhiều môi trường như tủ lạnh hoặc lò vi sóng .\r\n\r\nKết luận\r\n\r\nViệc lựa chọn và trang bị các sản phẩm gia dụng phù hợp không chỉ giúp tối ưu hóa công việc nội trợ mà còn góp phần nâng cao chất lượng cuộc sống. Trong bối cảnh thị trường gia dụng ngày càng phong phú với nhiều mẫu mã và phân khúc khác nhau , người tiêu dùng nên ưu tiên những sản phẩm có chất lượng tốt, an toàn và đáp ứng đúng nhu cầu sử dụng lâu dài.\r\n\r\nMột không gian bếp tiện nghi, được trang bị đầy đủ những thiết bị cần thiết sẽ là nền tảng cho những bữa ăn trọn vẹn và sự gắn kết trong mỗi gia đình.', 'Sản phẩm', '1774693687_news_img-tintuc2.png', 6, 'HienThi', '2026-03-28 10:28:07'),
(4, 1, 'Công Nghệ Hiện Đại Trong Thiết Bị Nhà Bếp', 'c-ng-ngh-hi-n-i-trong-thi-t-b-nh-b-p-1774693942', 'Sự phát triển của công nghệ đang làm thay đổi đáng kể thói quen nấu nướng và sinh hoạt trong gia đình. Nếu như trước đây, các thiết bị nhà bếp chỉ dừng lại ở chức năng cơ bản, thì ngày nay, nhiều sản phẩm đã được tích hợp công nghệ hiện đại nhằm tối ưu hiệu suất, tiết kiệm thời gian và nâng cao trải nghiệm người dùng.\r\n\r\nNhững cải tiến này không chỉ giúp việc nội trợ trở nên đơn giản hơn mà còn góp phần xây dựng một không gian bếp tiện nghi, thông minh và an toàn.\r\n\r\n1.Thiết bị nhà bếp thông minh kết nối IoT\r\n\r\nMột trong những xu hướng nổi bật là sự xuất hiện của các thiết bị nhà bếp thông minh có khả năng kết nối Internet (IoT). Người dùng có thể điều khiển nồi cơm điện, lò nướng hoặc máy pha cà phê từ xa thông qua điện thoại di động.\r\n\r\nViệc theo dõi và điều chỉnh quá trình nấu nướng theo thời gian thực giúp hạn chế rủi ro và đảm bảo món ăn đạt chất lượng ổn định. Đây là bước tiến quan trọng trong việc tự động hóa không gian bếp hiện đại.\r\n\r\n2.Công nghệ tiết kiệm năng lượng\r\n\r\nCác thiết bị gia dụng ngày nay được chú trọng cải tiến nhằm giảm thiểu mức tiêu thụ điện năng. Công nghệ inverter, cảm biến nhiệt thông minh hay chế độ tự ngắt khi không sử dụng giúp tiết kiệm chi phí điện và tăng độ bền cho sản phẩm.\r\n\r\nKhông chỉ mang lại lợi ích kinh tế, xu hướng này còn phù hợp với định hướng sử dụng năng lượng bền vững và thân thiện với môi trường.\r\n\r\n3.Vật liệu cao cấp và an toàn cho sức khỏe\r\n\r\nSự đổi mới không chỉ nằm ở công nghệ mà còn ở chất liệu sản phẩm. Nhiều thiết bị nhà bếp hiện nay sử dụng inox cao cấp, hợp kim nhôm phủ chống dính an toàn hoặc nhựa không chứa BPA.\r\n\r\nCác vật liệu này giúp hạn chế phản ứng hóa học trong quá trình nấu nướng, đồng thời tăng khả năng chịu nhiệt và kéo dài tuổi thọ sản phẩm.\r\n\r\n4.Tích hợp đa chức năng\r\n\r\nXu hướng tích hợp nhiều chức năng trong một thiết bị đang ngày càng phổ biến. Một chiếc nồi chiên không dầu có thể kết hợp chiên, nướng, sấy; hay máy xay đa năng có thể xay thực phẩm, ép trái cây và nghiền đá.\r\n\r\nĐiều này giúp tiết kiệm không gian bếp và giảm chi phí đầu tư cho nhiều thiết bị riêng lẻ.\r\n\r\n5.Tối ưu trải nghiệm người dùng\r\n\r\nCác nhà sản xuất ngày càng chú trọng đến thiết kế và trải nghiệm sử dụng. Bảng điều khiển cảm ứng, màn hình hiển thị rõ ràng, chế độ cài đặt sẵn và hệ thống cảnh báo an toàn giúp người dùng dễ dàng thao tác, kể cả với những người ít kinh nghiệm nấu ăn.\r\n\r\nNgoài ra, yếu tố thẩm mỹ cũng được nâng cao, góp phần tạo nên không gian bếp hiện đại và hài hòa hơn.\r\n\r\nKết luận\r\n\r\nCông nghệ hiện đại đang từng bước thay đổi cách con người tiếp cận việc nấu nướng và quản lý không gian bếp. Việc lựa chọn các thiết bị gia dụng tích hợp công nghệ tiên tiến không chỉ mang lại sự tiện lợi mà còn góp phần nâng cao chất lượng cuộc sống.\r\n\r\nTrong bối cảnh thị trường ngày càng đa dạng, người tiêu dùng cần cân nhắc kỹ về nhu cầu sử dụng, tính năng và độ an toàn để đưa ra lựa chọn phù hợp. Một gian bếp được trang bị đúng cách sẽ không chỉ phục vụ tốt cho sinh hoạt hàng ngày mà còn trở thành không gian truyền cảm hứng cho mỗi gia đình.', 'Thiết bị', '1774693942_news_img-tintuc3.png', 4, 'HienThi', '2026-03-28 10:32:22'),
(5, 1, 'Làm Sao Để Chọn Dụng Cụ Bếp An Toàn Cho Sức Khỏe', 'l-m-sao-ch-n-d-ng-c-b-p-an-to-n-cho-s-c-kh-e-1774694160', 'Dụng cụ nhà bếp là những vật dụng tiếp xúc trực tiếp với thực phẩm mỗi ngày, vì vậy yếu tố an toàn luôn được đặt lên hàng đầu. Tuy nhiên, trên thị trường hiện nay có rất nhiều sản phẩm với chất liệu và mức giá khác nhau, khiến người tiêu dùng gặp khó khăn trong việc lựa chọn.\r\n\r\nViệc trang bị đúng dụng cụ bếp không chỉ giúp nâng cao hiệu quả nấu nướng mà còn góp phần bảo vệ sức khỏe cho cả gia đình trong thời gian dài.\r\n\r\n1. Ưu tiên chất liệu an toàn\r\n\r\nChất liệu là yếu tố quan trọng nhất khi lựa chọn dụng cụ nhà bếp. Các sản phẩm làm từ inox 304, thủy tinh chịu nhiệt, gốm sứ cao cấp hoặc nhựa an toàn không chứa BPA thường được đánh giá cao về độ an toàn.\r\n\r\nNgược lại, các sản phẩm kém chất lượng có thể chứa tạp chất hoặc giải phóng chất độc hại khi tiếp xúc với nhiệt độ cao, ảnh hưởng trực tiếp đến sức khỏe người sử dụng.\r\n\r\n2. Lựa chọn sản phẩm có nguồn gốc rõ ràng\r\n\r\nNgười tiêu dùng nên ưu tiên các sản phẩm có thương hiệu, xuất xứ minh bạch và đạt các tiêu chuẩn an toàn. Những sản phẩm này thường được kiểm định chất lượng trước khi đưa ra thị trường, đảm bảo an toàn khi sử dụng lâu dài.\r\n\r\nTránh mua các sản phẩm trôi nổi, không nhãn mác hoặc có giá quá rẻ so với mặt bằng chung, vì tiềm ẩn nhiều rủi ro.\r\n\r\n3. Chú ý đến khả năng chịu nhiệt và độ bền\r\n\r\nDụng cụ nhà bếp cần có khả năng chịu nhiệt tốt và không bị biến dạng trong quá trình sử dụng. Đặc biệt, với các sản phẩm như nồi, chảo hoặc hộp đựng thực phẩm, khả năng chịu nhiệt sẽ quyết định độ an toàn khi nấu nướng.\r\n\r\nNgoài ra, sản phẩm có độ bền cao sẽ hạn chế tình trạng bong tróc lớp phủ hoặc nứt vỡ, từ đó giảm nguy cơ ảnh hưởng đến thực phẩm.\r\n\r\n4. Dễ vệ sinh và bảo quản\r\n\r\nMột tiêu chí quan trọng khác là khả năng vệ sinh sau khi sử dụng. Dụng cụ bếp dễ làm sạch sẽ giúp hạn chế vi khuẩn tích tụ, đảm bảo an toàn vệ sinh thực phẩm.\r\n\r\nNgười dùng nên lựa chọn các sản phẩm có bề mặt trơn, ít bám bẩn và thiết kế thuận tiện cho việc lau rửa cũng như bảo quản.\r\n\r\nKết luận\r\n\r\nLựa chọn dụng cụ bếp an toàn không chỉ là vấn đề tiện ích mà còn liên quan trực tiếp đến sức khỏe của cả gia đình. Việc ưu tiên chất liệu tốt, nguồn gốc rõ ràng và tính năng phù hợp sẽ giúp người tiêu dùng yên tâm hơn trong quá trình sử dụng.\r\n\r\nMột gian bếp an toàn, sạch sẽ chính là nền tảng quan trọng để tạo nên những bữa ăn chất lượng và cuộc sống bền vững.', 'Sức khỏe', '1774694160_news_img-tintuc4.png', 5, 'HienThi', '2026-03-28 10:36:00'),
(6, 1, 'Mẹo Vệ Sinh Nhà Bếp Nhanh Chóng Và Hiệu Quả', 'm-o-v-sinh-nh-b-p-nhanh-ch-ng-v-hi-u-qu-1774695243', 'Trong quá trình nấu nướng hàng ngày, nhà bếp là khu vực dễ tích tụ dầu mỡ, vi khuẩn và mùi thực phẩm. Nếu không được vệ sinh đúng cách, không gian bếp không chỉ mất thẩm mỹ mà còn ảnh hưởng trực tiếp đến sức khỏe của các thành viên trong gia đình.\r\n\r\nViệc duy trì thói quen vệ sinh khoa học sẽ giúp không gian bếp luôn sạch sẽ, an toàn và tạo cảm hứng trong quá trình sử dụng.\r\n\r\n1. Vệ sinh ngay sau khi nấu ăn\r\n\r\nSau mỗi lần chế biến, nên lau sạch bề mặt bếp, bàn và khu vực xung quanh để tránh dầu mỡ bám lâu ngày. Việc làm sạch ngay từ đầu giúp hạn chế vết bẩn cứng đầu và tiết kiệm thời gian dọn dẹp.\r\n\r\n2. Sử dụng nguyên liệu làm sạch an toàn\r\n\r\nCác nguyên liệu tự nhiên như giấm, chanh hoặc baking soda có khả năng làm sạch hiệu quả mà vẫn đảm bảo an toàn. Đây là giải pháp phù hợp để khử mùi và loại bỏ dầu mỡ trong không gian bếp.\r\n\r\n3. Làm sạch định kỳ các thiết bị\r\n\r\nCác thiết bị như bếp nấu, lò vi sóng, máy hút mùi hoặc tủ lạnh cần được vệ sinh định kỳ để đảm bảo hoạt động ổn định. Việc tích tụ cặn bẩn lâu ngày có thể làm giảm hiệu suất và gây mùi khó chịu.\r\n\r\n4. Giữ không gian bếp khô ráo và gọn gàng\r\n\r\nĐộ ẩm cao là điều kiện thuận lợi cho vi khuẩn phát triển. Vì vậy, cần đảm bảo khu vực bếp luôn thông thoáng, sạch sẽ và được sắp xếp hợp lý để dễ dàng vệ sinh.\r\n\r\nKết luận\r\n\r\nVệ sinh nhà bếp không chỉ là công việc hàng ngày mà còn là yếu tố quan trọng giúp bảo vệ sức khỏe gia đình và duy trì không gian sống sạch đẹp. Áp dụng những mẹo đơn giản nhưng hiệu quả sẽ giúp bạn tiết kiệm thời gian và công sức trong quá trình dọn dẹp.\r\n\r\nMột căn bếp sạch sẽ, gọn gàng sẽ luôn là nền tảng cho những bữa ăn ngon và cuộc sống chất lượng hơn.', 'Mẹo vặt', '1774695243_news_dọn-vệ-sinh-nhà-bếp.jpg', 14, 'HienThi', '2026-03-28 10:54:03'),
(7, 1, 'Cách Bảo Quản Dụng Cụ Nhà Bếp Để Sử Dụng Được Dài Lâu', 'c-ch-b-o-qu-n-d-ng-c-nh-b-p-s-d-ng-c-d-i-l-u-1774695344', 'Bên cạnh việc lựa chọn sản phẩm chất lượng, cách bảo quản dụng cụ nhà bếp đóng vai trò quan trọng trong việc duy trì độ bền và hiệu quả sử dụng. Thực tế cho thấy, nhiều thiết bị nhanh hư hỏng không phải do chất lượng kém mà xuất phát từ việc sử dụng và bảo quản chưa đúng cách.\r\n\r\nViệc bảo quản khoa học không chỉ giúp kéo dài tuổi thọ sản phẩm mà còn đảm bảo an toàn trong quá trình sử dụng lâu dài.\r\n\r\n1. Lau khô trước khi cất giữ\r\n\r\nSau khi rửa, các dụng cụ cần được lau khô hoàn toàn trước khi cất vào tủ. Độ ẩm còn lại có thể gây hoen gỉ hoặc ẩm mốc, đặc biệt với các vật dụng bằng kim loại và gỗ.\r\n\r\n2. Tránh xếp chồng gây trầy xước\r\n\r\nCác dụng cụ như nồi, chảo chống dính không nên xếp chồng trực tiếp lên nhau. Điều này có thể làm trầy bề mặt và ảnh hưởng đến chất lượng sử dụng.\r\n\r\n3. Bảo quản đúng vị trí\r\n\r\nMỗi loại dụng cụ nên được đặt ở vị trí phù hợp để tránh va đập hoặc hư hỏng. Dao nên để trong giá riêng, các thiết bị điện nên đặt nơi khô ráo và tránh tiếp xúc với nước.\r\n\r\n4. Kiểm tra và thay thế định kỳ\r\n\r\nTrong quá trình sử dụng, nếu phát hiện sản phẩm có dấu hiệu hư hỏng như bong tróc, nứt vỡ hoặc biến dạng, nên thay thế kịp thời để đảm bảo an toàn.\r\n\r\nKết luận\r\n\r\nBảo quản dụng cụ nhà bếp đúng cách là yếu tố quan trọng giúp duy trì chất lượng và hiệu quả sử dụng lâu dài. Những thói quen nhỏ trong quá trình sử dụng hàng ngày có thể tạo ra sự khác biệt lớn về độ bền của sản phẩm.\r\n\r\nMột không gian bếp được chăm sóc đúng cách không chỉ giúp tiết kiệm chi phí mà còn mang lại sự tiện nghi và an toàn cho cuộc sống gia đình.', 'Mẹo vặt', '1774695344_news_cach-cat-giu-dung-cu-nha-bep-ben-dep-su-dung-lau-de-dang-don-avt-1200x676.jpg', 4, 'HienThi', '2026-03-28 10:55:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ghn_order_code` varchar(50) DEFAULT NULL COMMENT 'Mã vận đơn của GHN',
  `tong_tien` decimal(12,2) UNSIGNED NOT NULL,
  `phi_van_chuyen` decimal(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `ten_nguoi_nhan` varchar(100) NOT NULL,
  `sdt_nguoi_nhan` varchar(20) NOT NULL,
  `dia_chi_giao` text NOT NULL,
  `trang_thai` enum('ChoXacNhan','DangGiao','HoanThanh','Huy') DEFAULT 'ChoXacNhan',
  `phuong_thuc_thanh_toan` varchar(50) DEFAULT 'COD',
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `giam_gia_thanh_vien` int(11) UNSIGNED DEFAULT 0,
  `ma_voucher` varchar(50) DEFAULT NULL,
  `giam_gia_voucher` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `ghn_order_code`, `tong_tien`, `phi_van_chuyen`, `ten_nguoi_nhan`, `sdt_nguoi_nhan`, `dia_chi_giao`, `trang_thai`, `phuong_thuc_thanh_toan`, `ghi_chu`, `created_at`, `giam_gia_thanh_vien`, `ma_voucher`, `giam_gia_voucher`) VALUES
(1, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 11:21:37', 0, NULL, 0),
(2, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:22:32', 0, NULL, 0),
(3, 5, NULL, 49000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 11:23:09', 0, NULL, 0),
(4, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:27:20', 0, NULL, 0),
(5, 5, NULL, 49000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'Huy', 'COD', 'Phương thức: COD', '2026-03-23 11:32:56', 0, NULL, 0),
(6, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'Huy', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:33:05', 0, NULL, 0),
(7, 5, NULL, 49000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:04:21', 0, NULL, 0),
(8, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:12:13', 0, NULL, 0),
(9, 5, NULL, 49000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:29:10', 0, NULL, 0),
(10, 5, NULL, 42000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:33:05', 0, NULL, 0),
(11, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 12:34:09', 0, NULL, 0),
(12, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:34:18', 0, NULL, 0),
(13, 5, NULL, 49000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Đà Lạt', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-24 06:27:32', 0, NULL, 0),
(14, 5, NULL, 40000.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Đà Lạt', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-24 06:28:19', 0, NULL, 0),
(15, 5, NULL, 30900.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 2, Quận 10, Hồ Chí Minh', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-25 07:54:16', 0, NULL, 0),
(16, 5, NULL, 92500.00, 0.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Thị Trấn Si Ma Cai, Huyện Si Ma Cai, Lào Cai', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-26 08:04:21', 0, NULL, 0),
(17, 5, 'LTXTTT', 48500.00, 38500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 1, Thành phố Cà Mau, Cà Mau', 'HoanThanh', 'COD', '', '2026-03-26 08:27:56', 0, NULL, 0),
(18, 5, 'LTXT86', 10000.00, 82500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Chiềng Lương, Huyện Mai Sơn, Sơn La', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-26 08:41:01', 0, NULL, 0),
(19, 5, 'LTXT8N', 10000.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường Thái Bình, Thành phố Hòa Bình, Hòa Bình', 'Huy', 'ChuyenKhoan', '', '2026-03-26 08:41:22', 0, NULL, 0),
(20, 5, 'LTXHLL', 70500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường Khắc Niệm, Thành phố Bắc Ninh, Bắc Ninh', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-26 08:50:30', 0, NULL, 0),
(21, 5, 'LTXAG9', 39900.00, 20900.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường 10, Quận Tân Bình, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-26 11:40:27', 0, NULL, 0),
(22, 5, 'LTXAVB', 70500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường Hiến Nam, Thành phố Hưng Yên, Hưng Yên', 'Huy', 'COD', '', '2026-03-26 11:49:48', 0, NULL, 0),
(23, 5, 'LTAXW9', 81500.00, 71500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Đồng Thanh, Huyện Kim Động, Hưng Yên', 'Huy', 'COD', '', '2026-03-28 12:41:18', 0, NULL, 0),
(24, 5, 'LTAXTR', 79500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường Chiềng An, Thành phố Sơn La, Sơn La', 'Huy', 'COD', '', '2026-03-28 12:44:12', 0, NULL, 0),
(25, 5, 'LTAXME', 92500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Chiềng Mung, Huyện Mai Sơn, Sơn La', 'Huy', 'ChuyenKhoan', '', '2026-03-28 13:04:57', 0, NULL, 0),
(26, 5, 'LTAEFX', 30900.00, 20900.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 10, Quận Tân Bình, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-29 06:18:49', 0, NULL, 0),
(27, 5, 'LTAEFA', 70500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường Thịnh Lang, Thành phố Hòa Bình, Hòa Bình', 'HoanThanh', 'COD', '', '2026-03-29 06:19:57', 0, NULL, 0),
(28, 5, 'LTAE6Y', 69500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Tân Thành, Thành phố Ngã Bảy, Hậu Giang', 'ChoXacNhan', 'COD', '', '2026-03-29 06:47:01', 1000, '', 0),
(29, 5, 'LTAEBD', 69500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Tân Lộc Đông, Huyện Thới Bình, Cà Mau', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-29 06:56:37', 1000, '', 0),
(30, 5, 'LTAEB3', 91500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Xã Quỳnh Hoa, Huyện Quỳnh Phụ, Thái Bình', 'Huy', 'ChuyenKhoan', '', '2026-03-29 06:57:43', 1000, '', 0),
(31, 5, 'LTAEX3', 79500.00, 71500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Hiên Vân, Huyện Tiên Du, Bắc Ninh', 'HoanThanh', 'COD', '', '2026-03-29 07:27:03', 2000, 'TET2025', 10000),
(32, 5, 'LT8QGB', 114800.00, 82500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: a, Xã Nậm Mười, Huyện Văn Chấn, Yên Bái', 'HoanThanh', 'COD', '', '2026-03-29 07:55:33', 3800, 'TET2026', 1900),
(33, 5, 'LT8QCD', 45500.00, 38500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường IV, Thành phố Vị Thanh, Hậu Giang', 'HoanThanh', 'COD', '', '2026-03-29 08:10:54', 1000, 'TET', 2000),
(34, 5, 'LT8QVC', 88600.00, 71500.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 8, Xã Thanh Khương, Thị xã Thuận Thành, Bắc Ninh', 'Huy', 'COD', '', '2026-03-29 08:14:12', 1900, '', 0),
(35, 5, 'LT8QV9', 37900.00, 20900.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 2, Quận Tân Bình, Hồ Chí Minh', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-29 08:15:18', 2000, 'TET2026', 1000),
(36, 5, 'LT8QV6', 27900.00, 20900.00, 'Đào Công Anh Minh', '0911078383', 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường 3, Quận Phú Nhuận, Hồ Chí Minh', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-29 08:19:03', 1000, 'TET', 2000),
(37, 5, 'LTRX8N', 27900.00, 20900.00, 'Đào Công Anh Minh', '0911078383', '123, Phường 12, Quận 10, Hồ Chí Minh', 'HoanThanh', 'ChuyenKhoan', '', '2026-04-03 10:41:04', 1000, 'TET', 2000),
(40, 5, 'LTR89Y', 47500.00, 38500.00, 'Đào Công Anh Minh', '0911078383', '123, Xã Phong Nẫm, Thành phố Phan Thiết, Bình Thuận', 'Huy', 'COD', '', '2026-04-03 12:40:56', 1000, '', 0),
(41, 5, 'LTR89R', 97600.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '123, Xã Vinh Thanh, Huyện Phú Vang, Thừa Thiên Huế', 'Huy', 'COD', '', '2026-04-03 12:41:34', 1900, 'TET', 2000);

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `trg_hoan_ton_kho_khi_huy_don` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    -- Chỉ thực thi khi trạng thái mới cập nhật thành 'Huy'
    IF NEW.trang_thai = 'Huy' AND OLD.trang_thai != 'Huy' THEN
        UPDATE `products` p
        JOIN `order_details` od ON p.id = od.product_id
        SET p.so_luong_ton = p.so_luong_ton + od.so_luong,
            p.luot_ban = p.luot_ban - od.so_luong
        WHERE od.order_id = NEW.id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `ten_sp_snapshot` varchar(255) NOT NULL,
  `anh_sp_snapshot` varchar(255) DEFAULT NULL,
  `so_luong` int(11) UNSIGNED NOT NULL,
  `gia` decimal(12,2) UNSIGNED NOT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `ten_sp_snapshot`, `anh_sp_snapshot`, `so_luong`, `gia`) VALUES
(1, 1, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(2, 2, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(3, 3, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(4, 4, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(5, 5, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(6, 6, 72, 'Thớt gỗ', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 1, 10000.00),
(7, 7, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(8, 8, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(9, 9, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(10, 10, 76, 'Thớt gỗ tròn', '1773833790_thot-go-trang-tri-hinh-tron-6572836103997b00cce7174f-1.jpg', 1, 12000.00),
(11, 11, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(12, 12, 71, 'Bát cánh cụt', '1773833394_20260113_iIloUP5722.jpg', 1, 10000.00),
(13, 13, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(14, 14, 72, 'Thớt gỗ', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 1, 10000.00),
(15, 15, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(16, 16, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(17, 17, 71, 'Bát cánh cụt', '1773833394_20260113_iIloUP5722.jpg', 1, 10000.00),
(18, 18, 71, 'Bát cánh cụt', '1773833394_20260113_iIloUP5722.jpg', 1, 10000.00),
(19, 19, 74, 'Thớt nhựa ', '1773833681_thot-nhua-khang-khuan-homeselect-tron-30cm-10236-0-65bcc8c4b4eee16ecd576d70.jpg', 1, 10000.00),
(20, 20, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(21, 21, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(22, 22, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(23, 23, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(24, 24, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(25, 25, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(26, 26, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(27, 27, 72, 'Thớt gỗ', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 1, 10000.00),
(28, 28, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(29, 29, 71, 'Bát cánh cụt', '1773833394_20260113_iIloUP5722.jpg', 1, 10000.00),
(30, 30, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(31, 31, 72, 'Thớt gỗ', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 2, 10000.00),
(32, 32, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 2, 19000.00),
(33, 33, 36, 'Dao  Nigara Anmon', '1773829903_dao1.jpg', 1, 10000.00),
(34, 34, 75, 'Thớt gỗ đa dụng', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 1, 19000.00),
(35, 35, 74, 'Thớt nhựa ', '1773833681_thot-nhua-khang-khuan-homeselect-tron-30cm-10236-0-65bcc8c4b4eee16ecd576d70.jpg', 2, 10000.00),
(36, 36, 37, 'Dao  Shigekatsu ', '1773829999_dao2.jpg', 1, 10000.00),
(37, 37, 74, 'Thớt nhựa ', NULL, 1, 10000.00),
(40, 40, 72, 'Thớt gỗ', NULL, 1, 10000.00),
(41, 41, 75, 'Thớt gỗ đa dụng', NULL, 1, 19000.00);

--
-- Bẫy `order_details`
--
DELIMITER $$
CREATE TRIGGER `trg_tru_ton_kho_khi_dat_hang` AFTER INSERT ON `order_details` FOR EACH ROW BEGIN
    UPDATE `products`
    SET `so_luong_ton` = `so_luong_ton` - NEW.so_luong,
        `luot_ban` = `luot_ban` + NEW.so_luong
    WHERE `id` = NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `ten_sp` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `gia` decimal(12,2) UNSIGNED NOT NULL,
  `gia_cu` decimal(12,2) UNSIGNED DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `weight` int(11) UNSIGNED NOT NULL DEFAULT 200,
  `so_luong_ton` int(11) UNSIGNED DEFAULT 100,
  `luot_ban` int(11) UNSIGNED DEFAULT 0,
  `trang_thai` enum('HienThi','An','HetHang') DEFAULT 'HienThi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `ten_sp`, `slug`, `gia`, `gia_cu`, `mo_ta`, `anh`, `category_id`, `weight`, `so_luong_ton`, `luot_ban`, `trang_thai`, `created_at`) VALUES
(36, 'Dao  Nigara Anmon', 'dao-nigara-anmon', 10000.00, 15000.00, 'Dao Nigara Anmon nổi bật với thiết kế cao cấp và độ hoàn thiện tinh xảo, phù hợp cho nhu cầu sử dụng chuyên sâu.\r\n\r\nLưỡi dao sắc bén, bền bỉ giúp xử lý thực phẩm nhanh chóng và chính xác. Sản phẩm không chỉ mang lại hiệu quả sử dụng mà còn tạo điểm nhấn thẩm mỹ cho gian bếp.\r\n\r\nĐây là lựa chọn dành cho người dùng yêu cầu cao về chất lượng và trải nghiệm.', '1773829903_dao1.jpg', 13, 200, 11, 9, 'HienThi', '2026-03-18 10:31:43'),
(37, 'Dao  Shigekatsu ', 'dao-shigekatsu-', 10000.00, 20000.00, 'Dao Shigekatsu là sản phẩm chất lượng cao, mang lại trải nghiệm cắt thái chính xác và hiệu quả.\r\n\r\nLưỡi dao được gia công tỉ mỉ giúp duy trì độ sắc lâu dài. Thiết kế chắc chắn, cân đối giúp người dùng thao tác dễ dàng và an toàn hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự chuyên nghiệp trong nấu nướng.', '1773829999_dao2.jpg', 13, 200, 18, 7, 'HienThi', '2026-03-18 10:33:19'),
(38, 'Dao  Kagahaki', 'dao-kagahaki', 14999.00, 25000.00, 'Dao Kagahaki được thiết kế tinh tế, đáp ứng tốt nhu cầu chế biến thực phẩm hàng ngày.\r\n\r\nLưỡi dao sắc giúp cắt thái nhanh chóng, hạn chế dập nát thực phẩm. Chất liệu bền bỉ giúp sản phẩm sử dụng lâu dài mà vẫn giữ được hiệu quả.\r\n\r\nĐây là lựa chọn phù hợp cho gian bếp gia đình.', '1773830055_dao3.jpg', 13, 200, 100, 0, 'HienThi', '2026-03-18 10:34:15'),
(39, 'Dao  Hamatogi', 'dao-hamatogi', 12000.00, 15000.00, 'Dao Hamatogi mang phong cách hiện đại, phù hợp với nhiều nhu cầu sử dụng khác nhau trong nhà bếp.\r\n\r\nLưỡi dao sắc bén giúp cắt thái nhanh gọn, trong khi tay cầm chắc chắn tạo cảm giác thoải mái khi sử dụng. Sản phẩm có độ bền cao và dễ vệ sinh.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng yêu thích sự tiện dụng.', '1773830130_dao4.jpg', 13, 200, 30, 0, 'HienThi', '2026-03-18 10:35:30'),
(40, 'Dao chặt xương Nhật', 'dao-ch-t-x-ng-nh-t', 19999.00, 30000.00, 'Dao chặt xương Nhật là dụng cụ chuyên dụng với độ bền cao, phù hợp cho việc chặt thực phẩm cứng.\r\n\r\nLưỡi dao dày và chắc giúp xử lý xương hoặc thực phẩm cứng một cách dễ dàng. Thiết kế cân đối giúp giảm lực khi sử dụng và tăng độ an toàn.\r\n\r\nĐây là lựa chọn cần thiết cho gian bếp chuyên nghiệp và gia đình.', '1773830219_dao5.jpg', 13, 200, 10, 0, 'HienThi', '2026-03-18 10:36:59'),
(41, 'Dao thái sashimi', 'dao-th-i-sashimi', 13000.00, 15000.00, 'Dao thái sashimi được thiết kế chuyên biệt để cắt lát mỏng các loại cá sống với độ chính xác cao.\r\n\r\nLưỡi dao dài và sắc giúp tạo ra những lát cắt mịn, không làm nát thực phẩm. Chất liệu cao cấp giúp duy trì độ sắc và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là sản phẩm lý tưởng cho những ai yêu thích ẩm thực Nhật Bản.', '1773830270_dao6.jpg', 13, 200, 40, 0, 'HienThi', '2026-03-18 10:37:50'),
(42, 'Dao thái bản to', 'dao-th-i-b-n-to', 15000.00, 20000.00, 'Dao thái bản to là dụng cụ chuyên dụng giúp cắt thái thực phẩm nhanh chóng và hiệu quả.\r\n\r\nVới bản dao rộng và chắc chắn, sản phẩm phù hợp để thái thịt, chặt nhẹ hoặc sơ chế thực phẩm số lượng lớn. Thiết kế cân đối giúp thao tác ổn định và chính xác hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai thường xuyên nấu ăn và cần sự tiện lợi.', '1773830388_dao7.jpg', 13, 200, 80, 0, 'HienThi', '2026-03-18 10:39:48'),
(43, 'Dao  Shinzu', 'dao-shinzu', 10000.00, 25000.00, 'Dao Shinzu nổi bật với thiết kế tinh tế và khả năng cắt thái linh hoạt trong gian bếp.\r\n\r\nLưỡi dao được gia công sắc bén, giúp xử lý nhiều loại thực phẩm từ rau củ đến thịt cá một cách dễ dàng. Tay cầm chắc chắn giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là sản phẩm không thể thiếu cho công việc nấu nướng hàng ngày.', '1773830466_dao8.jpg', 13, 200, 100, 0, 'HienThi', '2026-03-18 10:41:06'),
(44, 'Dao Kagenkio', 'dao-kagenkio', 10000.00, 15000.00, 'Dao Kagenkio là sản phẩm được thiết kế chuyên dụng cho việc cắt thái thực phẩm với độ chính xác cao.\r\n\r\nLưỡi dao sắc bén giúp thao tác nhanh gọn, hạn chế dập nát thực phẩm. Chất liệu bền chắc giúp duy trì độ sắc lâu dài và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho cả người nội trợ và người yêu thích nấu ăn chuyên nghiệp.', '1773903954_dao9.jpg', 13, 200, 17, 0, 'HienThi', '2026-03-18 10:42:54'),
(45, 'Nồi cơm điện Kalpen', 'n-i-c-m-i-n-kalpen', 20000.00, 30000.00, 'Nồi cơm điện Kalpen mang đến giải pháp nấu ăn hiện đại với thiết kế sang trọng và nhiều tính năng tiện ích.\r\n\r\nSản phẩm hỗ trợ nhiều chế độ nấu như cơm, cháo, hấp… giúp đáp ứng đa dạng nhu cầu sử dụng. Lòng nồi bền bỉ, truyền nhiệt tốt giúp cơm chín nhanh và ngon hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai muốn nâng cấp trải nghiệm nấu ăn trong gia đình.', '1773831102_noicomdien.jpg', 9, 200, 100, 0, 'HienThi', '2026-03-18 10:51:42'),
(46, 'Nồi cơm điện chống dính', 'n-i-c-m-i-n-ch-ng-d-nh', 10000.00, 25000.00, 'Nồi cơm điện chống dính là thiết bị quen thuộc trong mỗi gia đình, giúp nấu cơm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm được trang bị lòng nồi phủ chống dính, giúp cơm không bị bám dính và dễ dàng vệ sinh sau khi sử dụng. Công nghệ gia nhiệt ổn định giúp cơm chín đều, giữ được độ dẻo và hương vị tự nhiên.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần sự tiện lợi và tiết kiệm thời gian trong nấu nướng.', '1773831219_noi-com-r3-2.jpg', 9, 200, 10, 0, 'HienThi', '2026-03-18 10:53:39'),
(47, 'Nồi áp suất Kalpen', 'n-i-p-su-t-kalpen', 10000.00, 15000.00, 'Nồi áp suất Kalpen giúp rút ngắn thời gian nấu nướng mà vẫn đảm bảo thực phẩm chín mềm và giữ được dinh dưỡng.\r\n\r\nSản phẩm được trang bị các chế độ an toàn cùng khả năng điều chỉnh áp suất linh hoạt. Thiết kế hiện đại giúp việc sử dụng trở nên dễ dàng hơn.\r\n\r\nĐây là thiết bị cần thiết cho những gia đình bận rộn.', '1773831292_noi-ap-suat-kalpen-p4.jpg', 9, 200, 25, 0, 'HienThi', '2026-03-18 10:54:52'),
(48, 'Nồi nấu chậm Kalpen', 'n-i-n-u-ch-m-kalpen', 10000.00, 20000.00, 'Nồi nấu chậm Kalpen là thiết bị giúp chế biến các món ăn như hầm, nấu cháo hoặc súp một cách dễ dàng.\r\n\r\nCông nghệ nấu chậm giúp giữ nguyên hương vị và dưỡng chất trong thực phẩm. Thiết kế tiện lợi, dễ sử dụng phù hợp với nhiều nhu cầu nấu ăn khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho những bữa ăn dinh dưỡng.', '1773831341_noi-nau-cham-sk2.jpg', 9, 200, 15, 0, 'HienThi', '2026-03-18 10:55:41'),
(49, 'Nồi ủ chân không ', 'n-i-ch-n-kh-ng-', 20000.00, 25000.00, 'Nồi ủ chân không là thiết bị hỗ trợ nấu ăn tiết kiệm năng lượng, giữ nhiệt lâu và giúp thực phẩm chín mềm tự nhiên.\r\n\r\nSản phẩm hoạt động bằng cách giữ nhiệt sau khi đun sôi, giúp món ăn tiếp tục chín mà không cần sử dụng thêm điện hoặc gas. Điều này giúp giữ lại dưỡng chất trong thực phẩm.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên sự tiện lợi và tiết kiệm.', '1773831420_noi-u-e13-6.jpg', 9, 200, 20, 0, 'HienThi', '2026-03-18 10:57:00'),
(50, 'Bộ 3 nồi inox ', 'b-3-n-i-inox-', 20000.00, 50000.00, 'Bộ 3 nồi inox là giải pháp tiện lợi cho nhu cầu nấu nướng đa dạng trong gia đình.\r\n\r\nSản phẩm bao gồm nhiều kích thước khác nhau, phù hợp để chế biến nhiều loại món ăn. Chất liệu inox bền bỉ giúp đảm bảo an toàn và dễ vệ sinh.\r\n\r\nĐây là lựa chọn tối ưu giúp tiết kiệm chi phí và không gian.', '1773831518_bo-noi-inox-kalpen-gl1.jpg', 9, 200, 100, 0, 'HienThi', '2026-03-18 10:58:38'),
(51, 'Nồi inox 304', 'n-i-inox-304', 10000.00, 12000.00, 'Nồi inox 304 được đánh giá cao nhờ chất liệu cao cấp, an toàn cho sức khỏe và độ bền vượt trội.\r\n\r\nSản phẩm có khả năng chống ăn mòn, chịu nhiệt tốt và không phản ứng với thực phẩm trong quá trình nấu. Thiết kế tiện dụng giúp việc nấu ăn trở nên dễ dàng hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho gian bếp hiện đại.', '1773831602_noi.jpg', 9, 200, 10, 0, 'HienThi', '2026-03-18 11:00:02'),
(52, 'Nồi lẩu inox', 'n-i-l-u-inox', 12000.00, 15000.00, 'Nồi lẩu inox là sản phẩm lý tưởng cho những bữa ăn sum họp gia đình và bạn bè.\r\n\r\nVới chất liệu inox bền chắc, nồi có khả năng giữ nhiệt tốt và phân bổ nhiệt đều. Thiết kế rộng rãi giúp chế biến nhiều loại thực phẩm cùng lúc.\r\n\r\nĐây là lựa chọn hoàn hảo cho những bữa ăn ấm cúng.', '1773831704_noilau.jpg', 9, 200, 2, 0, 'HienThi', '2026-03-18 11:01:44'),
(53, 'Ấm đun nước inox', '-m-un-n-c-inox', 12000.00, 15000.00, 'Ấm đun nước inox là lựa chọn truyền thống kết hợp với độ bền cao và tính an toàn.\r\n\r\nChất liệu inox giúp chống gỉ sét, chịu nhiệt tốt và dễ dàng vệ sinh. Thiết kế chắc chắn giúp sản phẩm sử dụng ổn định trong thời gian dài.\r\n\r\nĐây là sản phẩm phù hợp cho mọi gia đình.', '1773831772_am-dun-nuoc-inox-2-5l.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:02:52'),
(54, 'Ấm đun nước siêu tốc', '-m-un-n-c-si-u-t-c', 15000.00, 20000.00, 'Ấm đun nước siêu tốc là thiết bị quen thuộc trong mỗi gia đình, giúp đun nước nhanh chóng chỉ trong vài phút.\r\n\r\nSản phẩm được thiết kế tiện lợi, dễ sử dụng với khả năng tự ngắt khi nước sôi, đảm bảo an toàn. Chất liệu bền bỉ giúp duy trì hiệu suất sử dụng lâu dài.\r\n\r\nĐây là giải pháp tiện ích cho nhu cầu sinh hoạt hàng ngày.', '1773831818_am-dun-sieu-toc-hai-lop-kalpen-ar49-1-8l.jpg', 10, 200, 25, 0, 'HienThi', '2026-03-18 11:03:38'),
(55, 'Bếp từ đơn Kalpen', 'b-p-t-n-kalpen', 10000.00, 15000.00, 'Bếp từ đơn Kalpen mang đến giải pháp nấu nướng hiện đại, an toàn và tiết kiệm điện năng.\r\n\r\nSản phẩm sử dụng công nghệ từ giúp làm nóng nhanh, kiểm soát nhiệt độ chính xác và hạn chế thất thoát nhiệt. Thiết kế nhỏ gọn, phù hợp với nhiều không gian bếp khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho cuộc sống tiện nghi và hiện đại.', '1773831875_ik2.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:04:35'),
(56, 'Máy xay sinh tố ', 'm-y-xay-sinh-t-', 10000.00, 15000.00, 'Máy xay sinh tố là thiết bị không thể thiếu trong gian bếp hiện đại, giúp chế biến thực phẩm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm hỗ trợ xay sinh tố, nước ép, cháo hoặc thực phẩm mềm một cách dễ dàng. Lưỡi dao sắc bén cùng công suất ổn định giúp nguyên liệu được xay nhuyễn mịn, giữ trọn dinh dưỡng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình chú trọng đến chế độ ăn uống lành mạnh.', '1773831947_may-xay-da-nang-3-coi-thuy-tinh-kalpen-b8-500w-1.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:05:47'),
(57, 'Máy ép chậm Kalpen', 'm-y-p-ch-m-kalpen', 10000.00, 15000.00, 'Máy ép chậm Kalpen là thiết bị hỗ trợ ép trái cây và rau củ với hiệu suất cao, giúp giữ lại tối đa dưỡng chất.\r\n\r\nCông nghệ ép chậm hạn chế sinh nhiệt, giúp nước ép giữ được màu sắc và hương vị tự nhiên. Thiết kế hiện đại, dễ vệ sinh và vận hành ổn định.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình quan tâm đến chế độ ăn uống lành mạnh và dinh dưỡng', '1773831985_dsc06964.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:06:25'),
(58, 'Máy vắt cam thông minh', 'm-y-v-t-cam-th-ng-minh', 10000.00, 15000.00, 'Máy vắt cam thông minh giúp việc chuẩn bị nước ép trở nên nhanh chóng và tiện lợi hơn.\r\n\r\nThiết kế nhỏ gọn, dễ sử dụng cùng khả năng tách nước hiệu quả giúp giữ trọn hương vị và dưỡng chất từ trái cây. Sản phẩm phù hợp cho nhu cầu sử dụng hàng ngày.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích đồ uống tươi và tốt cho sức khỏe.', '1773832030_may-vat-cam-thong-minh-kalpen-1.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:07:10'),
(59, 'Nồi chiên không dầu ', 'n-i-chi-n-kh-ng-d-u-', 10000.00, 15000.00, 'Nồi chiên không dầu là thiết bị hiện đại giúp chế biến món ăn với lượng dầu tối thiểu, phù hợp với xu hướng ăn uống lành mạnh.\r\n\r\nSản phẩm có thể chiên, nướng hoặc hâm nóng thực phẩm một cách nhanh chóng. Công nghệ làm nóng giúp thực phẩm chín đều mà vẫn giữ được độ giòn bên ngoài.\r\n\r\nĐây là thiết bị không thể thiếu trong gian bếp hiện đại.', '1773832213_b(151).jpg', 10, 200, 15, 0, 'HienThi', '2026-03-18 11:10:13'),
(60, 'Chảo chống dính cao cấp', 'ch-o-ch-ng-d-nh-cao-c-p', 15000.00, 24000.00, 'Chảo chống dính cao cấp mang lại trải nghiệm nấu nướng tối ưu nhờ lớp phủ chống dính chất lượng cao.\r\n\r\nSản phẩm giúp giảm lượng dầu mỡ, hạn chế bám dính và dễ dàng vệ sinh. Thiết kế chắc chắn, tay cầm tiện dụng giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai muốn nâng cấp trải nghiệm nấu ăn.', '1773832301_chao-chong-dinh-cao-cap-kalpen-durker-3.jpg', 7, 200, 10, 0, 'HienThi', '2026-03-18 11:11:41'),
(61, 'Chảo inox', 'ch-o-inox', 10000.00, 15000.00, 'Chảo inox là sản phẩm bền bỉ, phù hợp với nhiều nhu cầu nấu nướng khác nhau trong gia đình.\r\n\r\nVới chất liệu inox chắc chắn, chảo có khả năng chịu nhiệt tốt và ít bị biến dạng. Sản phẩm giúp phân bổ nhiệt đều, hỗ trợ quá trình nấu ăn hiệu quả hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho việc sử dụng lâu dài.', '1773832344_dsc07011.jpg', 7, 200, 10, 0, 'HienThi', '2026-03-18 11:12:24'),
(62, 'Chảo chống dính ceramic', 'ch-o-ch-ng-d-nh-ceramic', 10000.00, 15000.00, 'Chảo chống dính ceramic được đánh giá cao nhờ lớp phủ an toàn, không chứa các chất gây hại khi nấu ở nhiệt độ cao.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, chống bám dính hiệu quả và dễ vệ sinh. Ngoài ra, thiết kế hiện đại giúp tăng tính thẩm mỹ cho không gian bếp.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng quan tâm đến sức khỏe và chất lượng bữa ăn.', '1773832411_chao-chong-dinh-baby-kalpen-3.jpg', 7, 200, 15, 0, 'HienThi', '2026-03-18 11:13:31'),
(63, 'Chảo chống dính', 'ch-o-ch-ng-d-nh', 15000.00, 18000.00, 'Chảo chống dính là dụng cụ không thể thiếu trong mỗi gian bếp nhờ tính tiện lợi và dễ sử dụng.\r\n\r\nLớp phủ chống dính giúp hạn chế cháy khét và giữ nguyên hương vị món ăn. Sản phẩm phù hợp với nhiều món như chiên trứng, xào rau hoặc chế biến các món ăn nhanh.\r\n\r\nĐây là lựa chọn cơ bản nhưng cần thiết cho mọi gia đình.', '1773832435_img-chao-size3.png', 7, 200, 10010, 0, 'HienThi', '2026-03-18 11:13:55'),
(64, 'Chảo chống dính sâu lòng', 'ch-o-ch-ng-d-nh-s-u-l-ng', 10000.00, 15000.00, 'Chảo chống dính sâu lòng được thiết kế với lòng chảo rộng và sâu, phù hợp cho nhiều món ăn như chiên, xào hoặc nấu.\r\n\r\nLớp chống dính chất lượng giúp hạn chế thức ăn bám dính, giảm lượng dầu mỡ khi nấu và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp thao tác nấu ăn trở nên linh hoạt hơn.\r\n\r\nSản phẩm là trợ thủ đắc lực cho các bữa ăn gia đình hàng ngày.', '1773832492_chao-chong-dinh-cao-cap-kalpen-lipper-1.jpg', 7, 200, 15, 0, 'HienThi', '2026-03-18 11:14:52'),
(65, 'Chảo inox 304', 'ch-o-inox-304', 10000.00, 25000.00, 'Chảo inox 304 là sản phẩm được ưa chuộng nhờ độ bền cao và khả năng chống ăn mòn tốt. Chất liệu inox 304 giúp đảm bảo an toàn khi tiếp xúc với thực phẩm.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, phân bổ nhiệt đều giúp món ăn chín nhanh và giữ được hương vị tự nhiên. Ngoài ra, chảo dễ vệ sinh và ít bị biến dạng khi sử dụng lâu dài.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên độ bền và tính an toàn trong gian bếp.', '1773832551_chao-inox-lien-khoi-ts26.jpg', 7, 200, 16, 0, 'HienThi', '2026-03-18 11:15:51'),
(66, 'Bát Kuromi', 'b-t-kuromi', 10000.00, 16000.00, 'Bát Kuromi nổi bật với thiết kế dễ thương, lấy cảm hứng từ nhân vật hoạt hình được nhiều người yêu thích. Sản phẩm mang đến cảm giác vui tươi và sinh động cho mỗi bữa ăn.\r\n\r\nĐược làm từ chất liệu an toàn, bề mặt nhẵn mịn và dễ vệ sinh, bát phù hợp để đựng cơm, canh hoặc các món ăn hàng ngày. Kích thước vừa phải giúp người dùng dễ dàng sử dụng cho nhiều đối tượng.\r\n\r\nĐây là lựa chọn lý tưởng để tạo điểm nhấn cho bàn ăn, đặc biệt phù hợp với gia đình có trẻ nhỏ.', '1773832795_20260228_D9xP4YASJQ.jpg', 11, 200, 100, 0, 'HienThi', '2026-03-18 11:19:55'),
(67, 'Dĩa ANM', 'd-a-anm', 12000.00, 14000.00, 'Đĩa ANM có thiết kế đơn giản nhưng hiện đại, phù hợp với nhiều phong cách bàn ăn khác nhau.\r\n\r\nSản phẩm được изготов từ chất liệu bền, an toàn và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp việc bày trí món ăn trở nên gọn gàng và đẹp mắt hơn.\r\n\r\nĐây là lựa chọn phù hợp cho nhu cầu sử dụng hàng ngày trong gia đình.', '1773832834_A-211-Dia-ANM-FLO-26020091.jpg', 11, 200, 10, 0, 'HienThi', '2026-03-18 11:20:34'),
(68, 'Dĩa quả bơ', 'd-a-qu-b-', 10000.00, 15000.00, 'Đĩa quả bơ sở hữu thiết kế sáng tạo, lấy cảm hứng từ hình dáng tự nhiên, mang lại sự mới lạ cho không gian bếp.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bền chắc và dễ vệ sinh. Kích thước phù hợp giúp trình bày món ăn đẹp mắt hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự độc đáo và tinh tế.', '1773832881_A-210-Dia-ANM-26020092-1.jpg', 11, 200, 15, 0, 'HienThi', '2026-03-18 11:21:21'),
(69, 'Bát Shin', 'b-t-shin', 12000.00, 15000.00, 'Bát Shin được thiết kế với họa tiết nhân vật quen thuộc, mang lại cảm giác gần gũi và vui nhộn khi sử dụng. Đây là sản phẩm được nhiều gia đình lựa chọn, đặc biệt là cho trẻ em.\r\n\r\nChất liệu bền, an toàn cho sức khỏe, cùng thiết kế tiện dụng giúp việc sử dụng trở nên dễ dàng hơn. Bát phù hợp để đựng nhiều loại thực phẩm khác nhau.\r\n\r\nSản phẩm không chỉ hữu ích mà còn tạo điểm nhấn thú vị cho bàn ăn.', '1773832928_20260228_wzhA6Th1vM.jpg', 11, 200, 15, 0, 'HienThi', '2026-03-18 11:22:08'),
(70, 'Bát dễ thương', 'b-t-d-th-ng', 10000.00, 15000.00, 'Bát dễ thương là sản phẩm mang phong cách trẻ trung, phù hợp với nhiều không gian bếp hiện đại. Thiết kế nhỏ gọn, tiện lợi giúp người dùng dễ dàng sử dụng trong sinh hoạt hàng ngày.\r\n\r\nChất liệu an toàn, bền bỉ và dễ làm sạch giúp sản phẩm luôn giữ được vẻ ngoài sạch đẹp. Đây là lựa chọn phù hợp cho cả gia đình, đặc biệt là giới trẻ.\r\n\r\nSản phẩm góp phần tạo nên những bữa ăn vui vẻ và ấm cúng.', '1773833246_20260228_pIvBWIZG1e.jpg', 11, 200, 100, 0, 'HienThi', '2026-03-18 11:27:26'),
(71, 'Bát cánh cụt', 'b-t-c-nh-c-t', 10000.00, 15000.00, 'Bát cánh cụt gây ấn tượng với thiết kế đáng yêu, phù hợp cho gia đình có trẻ nhỏ hoặc những ai yêu thích phong cách dễ thương.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bề mặt nhẵn mịn, dễ vệ sinh và sử dụng hàng ngày. Kích thước vừa phải giúp thuận tiện trong việc đựng cơm, canh hoặc các món ăn khác.\r\n\r\nĐây là lựa chọn giúp bữa ăn trở nên sinh động và thú vị hơn.', '1773833394_20260113_iIloUP5722.jpg', 11, 200, 96, 4, 'HienThi', '2026-03-18 11:29:54'),
(72, 'Thớt gỗ', 'th-t-g-', 10000.00, 15000.00, 'Thớt gỗ là dụng cụ nhà bếp truyền thống, được nhiều gia đình tin dùng nhờ độ bền và tính an toàn cao. Sản phẩm phù hợp cho nhiều loại thực phẩm khác nhau.\r\n\r\nVới chất liệu gỗ tự nhiên, thớt có khả năng chịu lực tốt, ít cong vênh và không làm ảnh hưởng đến lưỡi dao khi sử dụng. Ngoài ra, sản phẩm còn dễ vệ sinh và có tuổi thọ lâu dài.\r\n\r\nĐây là lựa chọn đáng tin cậy cho mọi gian bếp.', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 12, 200, 4, 6, 'HienThi', '2026-03-18 11:32:16'),
(73, 'Thớt gỗ tre hình quả táo', 'th-t-g-tre-h-nh-qu-t-o', 10000.00, 15000.00, 'Thớt gỗ tre hình quả táo nổi bật với thiết kế độc đáo, mang lại điểm nhấn thẩm mỹ cho không gian bếp. Sản phẩm không chỉ phục vụ nhu cầu chế biến mà còn có thể dùng để trang trí hoặc bày biện món ăn.\r\n\r\nChất liệu tre tự nhiên thân thiện với môi trường, có độ bền cao và an toàn cho sức khỏe. Bề mặt thớt được xử lý mịn, giúp dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nSản phẩm phù hợp với những ai yêu thích sự sáng tạo và tinh tế trong gian bếp.', '1773833599_thot-go-tre-hinh-qua-tao-30x30cm-9068-1-6597ace803b66fafeb1974af.jpg', 12, 200, 100, 0, 'HienThi', '2026-03-18 11:33:19'),
(74, 'Thớt nhựa ', 'th-t-nh-a-', 10000.00, 15000.00, 'Thớt nhựa là sản phẩm phổ biến nhờ trọng lượng nhẹ và dễ dàng vệ sinh. Với thiết kế hiện đại, sản phẩm phù hợp cho nhiều mục đích sử dụng trong gian bếp hàng ngày.\r\n\r\nChất liệu nhựa an toàn giúp hạn chế bám mùi thực phẩm, đồng thời có khả năng chống thấm nước tốt. Bề mặt thớt được thiết kế chống trượt, giúp thao tác cắt thái an toàn hơn.\r\n\r\nĐây là giải pháp tiện lợi cho những ai ưu tiên sự gọn nhẹ và dễ sử dụng.', '1773833681_thot-nhua-khang-khuan-homeselect-tron-30cm-10236-0-65bcc8c4b4eee16ecd576d70.jpg', 12, 200, 96, 5, 'HienThi', '2026-03-18 11:34:41'),
(75, 'Thớt gỗ đa dụng', 'th-t-g-a-d-ng', 19000.00, 20000.00, 'Thớt gỗ đa dụng được thiết kế nhằm đáp ứng nhiều nhu cầu sử dụng khác nhau trong nhà bếp như cắt rau củ, thịt cá hay chế biến thực phẩm.\r\n\r\nVới chất liệu gỗ bền chắc, sản phẩm có khả năng chịu lực tốt, hạn chế nứt vỡ và đảm bảo độ an toàn khi sử dụng. Thiết kế tiện lợi giúp người dùng dễ dàng thao tác và vệ sinh sau khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần một sản phẩm linh hoạt và bền bỉ.', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 12, 200, 95, 11, 'HienThi', '2026-03-18 11:35:25'),
(76, 'Thớt gỗ tròn', 'th-t-g-tr-n', 12000.00, 15000.00, 'Thớt gỗ tròn là lựa chọn phù hợp cho những ai yêu thích sự đơn giản và tiện dụng trong gian bếp. Với thiết kế tròn gọn gàng, sản phẩm giúp thao tác cắt thái trở nên linh hoạt và dễ dàng hơn.\r\n\r\nSản phẩm được làm từ gỗ tự nhiên, bề mặt chắc chắn, hạn chế trầy xước dao và đảm bảo an toàn khi tiếp xúc thực phẩm. Ngoài ra, thớt còn dễ vệ sinh và có độ bền cao khi sử dụng lâu dài.\r\n\r\nĐây là vật dụng không thể thiếu giúp công việc nấu nướng trở nên thuận tiện và hiệu quả hơn.', '1773833790_thot-go-trang-tri-hinh-tron-6572836103997b00cce7174f-1.jpg', 12, 200, 0, 1, 'HienThi', '2026-03-18 11:36:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(4, 75, 5, 1, '123', '2026-03-28 09:05:22'),
(5, 75, 5, 3, '1', '2026-03-28 09:05:43'),
(6, 75, 5, 3, '7', '2026-03-28 09:13:06'),
(7, 75, 5, 5, '8', '2026-03-28 09:13:20'),
(8, 75, 5, 5, '46', '2026-03-28 09:13:37'),
(10, 73, 5, 5, 'Xịn', '2026-03-28 09:41:51'),
(11, 73, 5, 5, '-', '2026-03-28 09:45:07'),
(12, 74, 4, 5, 'đẹp', '2026-03-29 06:24:33'),
(13, 75, 5, 5, 'Quá đẹp', '2026-03-29 09:58:08'),
(14, 36, 5, 5, 'Xài tốt', '2026-04-03 10:23:44'),
(15, 72, 5, 5, 'Xịn', '2026-04-03 12:43:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `gioi_tinh` varchar(10) DEFAULT 'Nam',
  `hang` varchar(50) DEFAULT 'Đồng',
  `trang_thai` enum('HoatDong','Khoa') DEFAULT 'HoatDong',
  `ngay_sinh` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_expire` datetime DEFAULT NULL,
  `chat_daily_count` int(11) NOT NULL DEFAULT 0,
  `last_chat_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `ho_ten`, `email`, `google_id`, `mat_khau`, `so_dien_thoai`, `dia_chi`, `gioi_tinh`, `hang`, `trang_thai`, `ngay_sinh`, `avatar`, `created_at`, `remember_token`, `remember_expire`, `chat_daily_count`, `last_chat_date`) VALUES
(4, 'Đào Công Anh Minh', 'Minhkendy1903@gmail.com', NULL, '$2y$10$kDeZ/bc0Ai9WW5jA0Z0eMedyY3DP4remjYLms7YfkOvOJpN2oP2Ri', '0911078381', 'Sài Gòn', 'Nam', 'Đồng', 'HoatDong', '2026-03-20', 'uploads/1773833815_dao1.jpg', '2026-03-16 12:43:44', NULL, NULL, 13, '2026-03-31'),
(5, 'Đào Công Anh Minh', 'daoconganhminh1902@gmail.com', '100715689387117212188', '$2y$10$28hBcsBgAAxfrsdimRpMq.28Ij8EbH8i2sAW4xT1I/lqKqFbOibDS', '0911078383', 'Đà Lạt', 'Nam', 'Kim Cương', 'HoatDong', '2026-02-26', 'uploads/1774333586_default-avatar.png', '2026-03-22 11:32:22', NULL, NULL, 6, '2026-04-03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `ma_voucher` varchar(50) NOT NULL,
  `loai_voucher` enum('PhanTram','TienMat','FreeShip') NOT NULL,
  `gia_tri` int(11) NOT NULL,
  `giam_toi_da` int(11) DEFAULT 0,
  `don_toi_thieu` int(11) DEFAULT 0,
  `so_luong` int(11) DEFAULT 0,
  `da_dung` int(11) DEFAULT 0,
  `ngay_bat_dau` datetime DEFAULT NULL,
  `ngay_het_han` datetime DEFAULT NULL,
  `trang_thai` enum('HoatDong','Khoa') DEFAULT 'HoatDong'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `ma_voucher`, `loai_voucher`, `gia_tri`, `giam_toi_da`, `don_toi_thieu`, `so_luong`, `da_dung`, `ngay_bat_dau`, `ngay_het_han`, `trang_thai`) VALUES
(3, 'TET2026', 'PhanTram', 5, 5000, 20000, 24, 2, '2026-03-29 14:41:00', '2026-05-01 14:41:00', 'HoatDong'),
(4, 'TET', 'TienMat', 2000, 0, 10000, 20, 4, '2026-03-20 15:00:00', '2026-04-25 15:03:00', 'HoatDong'),
(5, 'XUAN', 'TienMat', 5000, 0, 30000, 6, 0, '2026-03-20 15:01:00', '2026-05-09 15:01:00', 'HoatDong'),
(6, 'FREESHIP', 'FreeShip', 10000, 0, 30000, 9, 0, '2026-03-29 15:02:00', '2026-05-02 15:02:00', 'HoatDong'),
(10, 'COZYCORNER', 'TienMat', 1000, 0, 50000, 0, 0, NULL, NULL, 'HoatDong');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `chatbot_faq`
--
ALTER TABLE `chatbot_faq`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `guest_rate_limits`
--
ALTER TABLE `guest_rate_limits`
  ADD PRIMARY KEY (`ip_address`,`action_date`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_news_admin` (`admin_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reviews_product` (`product_id`),
  ADD KEY `fk_reviews_user` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_voucher` (`ma_voucher`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `chatbot_faq`
--
ALTER TABLE `chatbot_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `fk_chat_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
