-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 13, 2026 lúc 08:23 PM
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
(121, NULL, 'glb1lecf5ulnikoq0pg412a1au', '2026-04-03 14:08:40'),
(126, NULL, '5vfcmg8q4q5p184lvdtlp48trr', '2026-04-07 09:18:58'),
(128, NULL, 'qe5vbp7n942c9jlil7mbv4qmfd', '2026-04-12 11:47:50'),
(132, NULL, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:45:13');

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
(159, 69, 37, 1, '2026-03-29 15:24:11'),
(257, 16, 75, 1, '2026-04-13 15:07:04');

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
(1, 'tài khoản,thông tin cá nhân,account,xem thông tin', 'Dạ, bạn có thể quản lý thông tin cá nhân và lịch sử mua hàng tại trang Tài khoản của tôi nhé.', 'HoatDong', '2026-03-31 01:24:17'),
(2, 'quên mật khẩu,lấy lại mật khẩu,đổi mật khẩu,reset pass,mất pass', 'Dạ, để lấy lại mật khẩu, bạn vui lòng ấn vào nút \"Đăng nhập\", sau đó chọn \"Quên mật khẩu\" và làm theo hướng dẫn gửi về Email nhé.', 'HoatDong', '2026-03-31 01:24:17'),
(3, 'địa chỉ,liên hệ,cửa hàng,shop ở đâu,hotline,email', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 'HoatDong', '2026-03-31 01:24:17'),
(4, 'giờ làm việc,mấy giờ mở cửa,thời gian hoạt động,mở cửa lúc mấy giờ,khi nào đóng cửa', 'Dạ, cửa hàng COZY CORNER mở cửa phục vụ từ **08:00 sáng đến 22:00 tối** tất cả các ngày trong tuần (kể cả Lễ, Tết) ạ. Bot thì hoạt động 24/7 luôn nhé!', 'HoatDong', '2026-03-31 01:24:17'),
(5, 'mua hàng,đặt hàng,cách mua,hướng dẫn mua,làm sao mua,đặt sao,mua ntn', 'Dạ để đặt hàng, bạn chỉ cần chọn sản phẩm ưng ý -> Thêm vào giỏ hàng -> Vào giỏ hàng chọn \"Thanh toán\" -> Điền địa chỉ và xác nhận là xong ạ. Cực kỳ đơn giản!', 'HoatDong', '2026-03-31 01:24:17'),
(6, 'vận chuyển,giao hàng,phí ship,ship,bao lâu nhận,giao hỏa tốc,freeship', 'Dạ, shop giao hàng toàn quốc qua đối tác Giao Hàng Nhanh (GHN):\n- **Thời gian:** 1-2 ngày (Nội thành HCM), 3-5 ngày (Tỉnh thành khác).\n- **Phí ship:** Được tính tự động tại trang thanh toán. Đừng quên săn mã Freeship của shop nhé!', 'HoatDong', '2026-03-31 01:24:17'),
(7, 'đồng kiểm,cho xem hàng không,được bóc hàng không,kiểm tra hàng', 'Dạ, COZY CORNER hỗ trợ **ĐỒNG KIỂM**. Bạn hoàn toàn được mở bưu kiện kiểm tra ngoại quan sản phẩm (không dùng thử) trước khi thanh toán cho Shipper ạ.', 'HoatDong', '2026-03-31 01:24:17'),
(8, 'đổi trả,hoàn hàng,hoàn tiền,trả hàng,hàng lỗi,móp méo,bể vỡ', 'Dạ, COZY CORNER có chính sách **1 ĐỔI 1 TRONG VÒNG 7 NGÀY** (miễn phí ship) nếu:\n- Sản phẩm lỗi do nhà sản xuất.\n- Hàng bể vỡ do vận chuyển.\nBạn vui lòng chụp ảnh/quay video lúc mở hàng và gửi cho shop qua mục Liên hệ để được xử lý ngay lập tức ạ!', 'HoatDong', '2026-03-31 01:24:17'),
(9, 'bảo hành,chính sách bảo hành,sửa chữa', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 'HoatDong', '2026-03-31 01:24:17'),
(10, 'khiếu nại,thái độ nhân viên,hàng giả,fake,không hài lòng,tệ', 'Dạ, Cozy Bot vô cùng xin lỗi nếu bạn có trải nghiệm chưa tốt. Bạn vui lòng liên hệ trực tiếp Hotline CSKH: **0888 888 888** để quản lý cửa hàng tiếp nhận và giải quyết thỏa đáng nhất cho bạn ạ!', 'HoatDong', '2026-03-31 01:24:17'),
(11, 'hủy đơn,muốn hủy,không mua nữa,cancel order,đổi ý', 'Dạ, nếu đơn hàng của bạn đang ở trạng thái \"Chờ xác nhận\", bạn có thể vào \"Lịch sử đơn hàng\" để tự hủy. Nếu đơn đã chuyển sang \"Đang giao\", bạn vui lòng từ chối nhận hàng giúp shop khi Shipper gọi tới nhé!', 'HoatDong', '2026-03-31 01:24:17'),
(12, 'đổi địa chỉ,sửa địa chỉ,đổi số điện thoại,sai thông tin', 'Dạ, nếu đơn hàng chưa được đóng gói, bạn hãy gọi ngay Hotline **0888 888 888** để nhân viên hỗ trợ cập nhật lại địa chỉ/SĐT cho bạn nhé. Bot không tự sửa được thông tin này ạ.', 'HoatDong', '2026-03-31 01:24:17'),
(13, 'thanh toán,chuyển khoản,cod,thanh toán khi nhận hàng,momo,vnpay', 'Dạ, shop hiện hỗ trợ các hình thức:\n- Nhận hàng thanh toán tiền mặt (COD).\n- Chuyển khoản ngân hàng (Quét mã QR tự động qua SePay).', 'HoatDong', '2026-03-31 01:24:17'),
(14, 'hóa đơn đỏ,xuất vat,hóa đơn công ty', 'Dạ, shop có hỗ trợ xuất hóa đơn điện tử (VAT). Bạn vui lòng ghi chú [Mã số thuế + Tên công ty + Email] ở bước Thanh toán, kế toán bên shop sẽ gửi hóa đơn sau khi hoàn tất đơn hàng ạ.', 'HoatDong', '2026-03-31 01:24:17'),
(15, 'chào,hello,hi,bạn là ai,bot là ai,bot tên gì', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 'HoatDong', '2026-03-31 01:24:17'),
(16, 'cách vệ sinh chảo,rửa chảo mới mua,bảo quản chảo chống dính,chảo bị xước,làm sạch chảo', '**Mẹo bảo quản chảo chống dính:**\r\nĐể chảo bền lâu, bạn KHÔNG nên rửa chảo khi đang nóng (gây sốc nhiệt làm tróc lớp chống dính). Hãy đợi chảo nguội hẳn, dùng mút mềm để rửa (không dùng cước sắt). Khi nấu chỉ nên dùng muôi/sạn bằng gỗ hoặc silicone nhé!', 'HoatDong', '2026-04-13 07:00:00'),
(17, 'khử mùi nồi chiên,nồi chiên có mùi nhựa,cách dùng nồi chiên lần đầu,vệ sinh nồi chiên', '**Khử mùi nồi chiên không dầu mới:**\r\nNồi chiên mới mua thường có mùi nhựa. Bạn có thể cắt vài lát chanh (hoặc vỏ cam, sả) cho vào lồng nồi, bật 180 độ C trong 10-15 phút. Sau đó để nguội, rửa sạch lồng nồi bằng mút mềm là có thể dùng bình thường ạ!', 'HoatDong', '2026-04-13 07:00:00'),
(18, 'ấm nước bị cặn,bình đun có cặn trắng,làm sạch ấm siêu tốc,tẩy cặn canxi', '**Làm sạch ấm siêu tốc:**\r\nCặn trắng dưới đáy ấm là do khoáng chất trong nước sinh hoạt. Bạn chỉ cần đun sôi hỗn hợp nước và giấm trắng (tỉ lệ 1:1), ngâm khoảng 30 phút rồi đổ đi, rửa lại bằng nước sạch là đáy ấm sẽ sáng bóng như mới!', 'HoatDong', '2026-04-13 07:00:00'),
(19, 'cách mài dao,dao bị cùn,bảo quản dao không gỉ,dao thép carbon,cách rửa dao', '**Bảo quản dao luôn sắc bén:**\r\nĐối với dao bếp (đặc biệt là dao thép Carbon), sau khi thái xong bạn nên rửa ngay và **lau thật khô** bằng khăn sạch trước khi cất lên giá/hộp cắm dao. Tuyệt đối không ngâm dao lâu trong bồn rửa để tránh bị rỉ sét bề mặt nhé.', 'HoatDong', '2026-04-13 07:00:00'),
(20, 'nồi inox bị ố,đáy nồi có màu cầu vồng,tẩy vết ố trên inox,cách làm sáng inox', 'Hiện tượng đáy nồi inox xuất hiện vệt màu cầu vồng hoặc ố vàng nhẹ là do \"sốc nhiệt\" khi đun nấu, hoàn toàn bình thường và an toàn. Bạn chỉ cần dùng một chút giấm trắng hoặc chanh chà nhẹ bề mặt, sau đó rửa lại là sạch bong ạ!', 'HoatDong', '2026-04-13 07:00:00'),
(21, 'thớt gỗ bị mốc,vệ sinh thớt gỗ,cách làm sạch thớt,thớt có mùi hôi,bảo quản thớt', '💡 **Xử lý thớt gỗ bị mùi/mốc:**\nThớt gỗ sau khi dùng nên rửa sạch, lau khô và dựng đứng ở nơi thoáng mát. Để khử mùi hôi thực phẩm trên thớt, bạn rắc một lớp muối hạt lên, dùng nửa trái chanh chà xát mạnh, sau đó rửa lại bằng nước nóng là thớt sẽ sạch và thơm.', 'HoatDong', '2026-04-13 07:00:00'),
(22, 'mua sỉ,chính sách đại lý,bán buôn,chiết khấu cao,mua số lượng lớn,quà tặng doanh nghiệp', 'Dạ, COZY CORNER luôn có chính sách chiết khấu (Discount) cực kỳ ưu đãi dành cho Khách hàng mua sỉ, đại lý hoặc doanh nghiệp mua số lượng lớn làm quà tặng. Bạn vui lòng liên hệ trực tiếp Hotline: **0888 888 888** để nhận bảng báo giá chi tiết nhé!', 'HoatDong', '2026-04-13 07:00:00'),
(23, 'không có nhà nhận hàng,shipper gọi đi vắng,hẹn lại ngày giao,giao ngoài giờ hành chính', 'Dạ, nếu bạn đang đi vắng khi Shipper GHN giao hàng đến, bưu tá thường sẽ hỗ trợ lưu kho và gọi lại vào ca giao tiếp theo (tối đa 3 lần). Bạn cũng có thể nghe máy và thỏa thuận trực tiếp với bưu tá để hẹn ngày/giờ nhận hàng phù hợp nhất ạ.', 'HoatDong', '2026-04-13 07:00:00'),
(24, 'shop bao lâu gửi hàng,khi nào đóng gói xong,thời gian chuẩn bị hàng,bao lâu thì giao cho vận chuyển', 'Dạ, thông thường tất cả các đơn hàng đặt tại COZY CORNER sẽ được nhân viên đóng gói cẩn thận và bàn giao cho đơn vị vận chuyển (Giao Hàng Nhanh) trong vòng **24h làm việc** kể từ khi đơn hàng của bạn được xác nhận trên hệ thống ạ.', 'HoatDong', '2026-04-13 07:00:00'),
(25, 'hàng chính hãng không,nguồn gốc xuất xứ,hàng nhập khẩu từ đâu,có chuẩn auth không,hàng thật không', 'Dạ bạn hoàn toàn yên tâm nhé! COZY CORNER cam kết **100% sản phẩm điện gia dụng và đồ dùng nhà bếp đều là hàng chính hãng**, có nguồn gốc xuất xứ rõ ràng và được bảo hành theo đúng tiêu chuẩn của nhà sản xuất (từ 12 đến 24 tháng).', 'HoatDong', '2026-04-13 07:00:00'),
(26, 'có gói quà không,tặng quà,viết thiệp,đóng gói làm quà tặng,hộp quà', 'Dạ, hiện tại COZY CORNER chưa cung cấp dịch vụ gói quà bằng giấy kiếng chuyên biệt. Tuy nhiên, tất cả sản phẩm của shop đều được bọc xốp chống sốc và đặt trong hộp carton in logo shop rất cứng cáp, lịch sự, hoàn toàn có thể mang đi tặng luôn ạ!', 'HoatDong', '2026-04-13 07:00:00'),
(27, 'mua linh kiện,phụ kiện thay thế,nắp vung kính bị vỡ,cối xay bị nứt,lưỡi dao máy xay', 'Dạ, đối với một số thiết bị điện (máy xay) hoặc bộ nồi chảo, shop có hỗ trợ khách hàng cũ đặt mua linh kiện/phụ kiện chính hãng để thay thế (như nắp vung kính, gioăng cao su, cối xay). Bạn liên hệ Zalo Hotline cung cấp mã đơn hàng cũ để shop hỗ trợ nhé!', 'HoatDong', '2026-04-13 07:00:00'),
(28, 'hủy đơn chuyển khoản,hoàn tiền qr,bao lâu nhận lại tiền,refund,hủy đơn đã thanh toán', 'Dạ, nếu bạn đã thanh toán trước qua mã QR (SePay) nhưng sau đó tự hủy đơn thành công (khi đơn chưa giao), hệ thống kế toán của shop sẽ tiến hành đối soát và tự động **hoàn tiền 100%** lại vào tài khoản ngân hàng của bạn trong vòng 24 - 48h làm việc ạ.', 'HoatDong', '2026-04-13 07:00:00'),
(29, 'chảo dùng bếp từ được không,nồi có bắt từ không,bếp từ báo lỗi,không nhận đáy nồi', 'Dạ, phần lớn nồi chảo kim loại tại COZY CORNER đều có đáy từ (dùng được cho mọi loại bếp). Để chắc chắn 100%, bạn có thể kéo xuống đọc trong phần **Mô tả chi tiết** của trang sản phẩm xem có dòng chữ *\"Sử dụng được cho bếp từ\"* không nhé!', 'HoatDong', '2026-04-13 07:00:00'),
(30, 'đơn vị vận chuyển,giao hàng bằng bên nào,ship bên nào,gửi viettel post,dùng ghn', 'Dạ, để đảm bảo hàng hóa gia dụng (vốn dễ vỡ, móp méo) được vận chuyển an toàn và đồng bộ hệ thống nhất, hiện tại COZY CORNER đang hợp tác giao hàng độc quyền thông qua đối tác **Giao Hàng Nhanh (GHN)** ạ. Phí ship sẽ được tự động tính ở bước thanh toán bạn nhé.', 'HoatDong', '2026-04-13 07:00:00'),
(31, 'bếp từ báo lỗi e0,bếp từ không nhận nồi,bếp kêu tít tít,chảo không bắt từ,đáy nồi không hít từ', 'Dạ, lỗi E0 (hoặc bếp kêu tít tít liên tục) thường là do nồi/chảo không có đáy từ hoặc đáy từ bị cong vênh, kích thước quá nhỏ. Bạn thử dùng nam châm thử dưới đáy nồi, nếu nam châm hút chặt thì mới dùng được cho bếp từ nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(32, 'nồi chiên không dầu bốc khói trắng,nồi chiên ra khói,nướng thịt bị khói,lỗi nồi chiên', 'Dạ, khi nướng các thực phẩm nhiều mỡ (thịt ba chỉ, gà có da...), mỡ thừa chảy xuống khay hứng và bị đốt nóng sẽ tạo ra khói trắng. Để khắc phục, bạn có thể đổ một chút nước (khoảng 2 muỗng) vào khay hứng mỡ dưới đáy nồi trước khi bắt đầu nướng nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(33, 'inox 304 là gì,inox 430 là gì,cách nhận biết inox 304,nồi inox nào tốt,chất liệu inox', '💡 **Góc kiến thức:**\n- **Inox 304:** Cực kỳ an toàn, chống rỉ sét tuyệt đối, không bắt từ (nam châm không hút). Thường dùng làm lòng nồi tiếp xúc trực tiếp thức ăn.\n- **Inox 430:** Có khả năng bắt từ tốt (nam châm hút), chống rỉ ở mức khá. Thường dùng làm lớp đáy ngoài cùng của nồi/chảo để dùng được trên mặt bếp từ ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(34, 'thớt gỗ teak bị nứt,bôi dầu cho thớt,cách lau dầu thớt gỗ,bảo dưỡng thớt,thớt bị cong vênh', '💡 **Bảo quản thớt gỗ tự nhiên:**\nĐể thớt gỗ (như gỗ Teak) luôn bóng đẹp và không bị nứt nẻ, mỗi tháng 1 lần bạn nên thoa một lớp mỏng dầu ăn (dầu oliu, dầu óc chó...) lên toàn bộ bề mặt thớt, để qua đêm rồi rửa sạch lại. Tuyệt đối không phơi thớt ngoài nắng gắt nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(35, 'dao bị mẻ lưỡi,dao chặt bị mẻ,mài dao bị mẻ,phục hồi lưỡi dao,đổi trả dao mẻ', 'Dạ, dao bị mẻ thường do chặt sai kỹ thuật (dùng dao thái mỏng để chặt xương) hoặc cắt vào vật quá cứng (đá, kim loại). Nếu mẻ nhẹ, bạn có thể dùng đá mài bùn (độ mịn 1000/6000) để mài lại. Nếu mẻ quá sâu, bạn nên mang đến các thợ mài dao chuyên nghiệp để hạ lại lưỡi ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(36, 'chảo chống dính bị xước,bong lớp chống dính,chảo xước có độc không,dùng chảo bị tróc,thay chảo mới', 'Dạ, các loại chảo cao cấp tại COZY CORNER sử dụng chất chống dính an toàn (không chứa PFOA). Tuy nhiên, khi chảo đã trầy xước sâu và lộ lớp kim loại, thức ăn sẽ dễ bị dính, cháy khét làm giảm độ ngon và khó vệ sinh. Tốt nhất bạn nên cân nhắc thay chảo mới để đảm bảo trải nghiệm nấu nướng tốt nhất nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(37, 'quét mã qr bị lỗi,chuyển khoản không được,lỗi sepay,ngân hàng bảo trì,không quét được mã', 'Dạ, nếu bạn không quét được mã QR, có thể do ứng dụng ngân hàng đang bảo trì. Bạn vui lòng thử **nhập tay số tài khoản và ngân hàng**, đồng thời **copy chính xác nội dung chuyển khoản** hiển thị trên màn hình nhé. Nếu vẫn không được, bạn có thể chọn thanh toán COD ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(38, 'giao hàng hỏa tốc,giao trong ngày,giao gấp,ship now,grab,ahamove,cần nhận hàng ngay', 'Dạ, hiện tại hệ thống tự động của COZY CORNER tích hợp với Giao Hàng Nhanh (GHN - giao tiêu chuẩn 1-3 ngày). Nếu bạn ở nội thành TP.HCM và cần nhận hàng GẤP trong 1-2 tiếng, vui lòng gọi ngay Hotline **0888 888 888** để quản lý shop hỗ trợ book Grab/Ahamove cho bạn nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(39, 'shipper có mang lên lầu không,giao tận phòng,lên chung cư,giao lên tầng,thu phí thang máy', 'Dạ, theo quy định chung của GHN, bưu tá chỉ hỗ trợ giao hàng tại tầng trệt/sảnh chung cư. Nếu bạn có nhu cầu nhờ bưu tá mang lên tận phòng, bạn vui lòng thỏa thuận trực tiếp với bưu tá khi nhận được cuộc gọi giao hàng nhé (tùy khu vực bưu tá có thể thu thêm chút phí gửi xe/thang máy ạ).', 'HoatDong', '2026-04-13 08:00:00'),
(40, 'mất hóa đơn giấy,kích hoạt bảo hành,bảo hành điện tử,tra cứu bảo hành,không có phiếu bảo hành', 'Dạ, COZY CORNER áp dụng **BẢO HÀNH ĐIỆN TỬ** cho 100% đơn hàng. Bạn không cần lo lắng nếu làm mất hóa đơn giấy nhé. Khi cần hỗ trợ kỹ thuật, bạn chỉ cần báo số điện thoại đặt hàng, hệ thống sẽ tự động tra cứu ra thời gian bảo hành còn lại của sản phẩm ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(41, 'không nhận hàng có sao không,hủy đơn lúc giao,từ chối nhận hàng,boom hàng', 'Dạ, nếu thay đổi ý định, mong bạn tự hủy trên website trước khi shop đóng gói. Nếu hàng đã đến nơi mà bạn từ chối nhận (không do lỗi sản phẩm), hệ thống sẽ ghi nhận lịch sử giao hàng thất bại, và tài khoản của bạn có thể bị hạn chế tính năng thanh toán COD cho các lần mua sau ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(42, 'mua làm quà tặng,giấu hóa đơn,không in giá,giao cho người khác,đơn quà tặng', 'Dạ tuyệt vời quá! Nếu bạn đặt để tặng người thân, bạn hãy thanh toán Chuyển khoản trước, sau đó ghi chú vào đơn hàng: *\"Đơn quà tặng, vui lòng không in biên lai có giá tiền\"*. Shop sẽ đóng gói thật đẹp và gửi đi như một món quà bất ngờ giúp bạn nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(43, 'hóa đơn vat trường học,xuất hóa đơn đỏ công ty,phiếu thu,báo giá cạnh tranh,mua cho công ty', 'Dạ, COZY CORNER cung cấp đầy đủ Hợp đồng, Báo giá cạnh tranh và xuất hóa đơn điện tử (VAT) cho các Doanh nghiệp, Trường học mua sắm thiết bị. Bạn vui lòng liên hệ Email: **Cozy@cv.com.vn** hoặc Zalo Hotline để được kế toán hỗ trợ thủ tục hồ sơ nhanh nhất nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(44, 'thớt nhựa bị ố,làm trắng thớt nhựa,thớt bị vàng,tẩy vết bẩn trên thớt', '💡 **Làm trắng thớt nhựa:**\nThớt nhựa dùng lâu dễ bị ố vàng do mủ củ quả (cà rốt, nghệ). Bạn hãy pha baking soda với nước cốt chanh thành hỗn hợp sệt, chà lên mặt thớt, để khoảng 15 phút rồi rửa lại bằng nước ấm. Thớt sẽ trắng sạch và bay hết mùi hôi cá thịt!', 'HoatDong', '2026-04-13 08:00:00'),
(45, 'nồi inox đun bếp gas bị đen,đáy nồi bị nhọ,cách làm sạch đáy nồi đen,lửa đỏ làm đen nồi', 'Dạ, nồi bị đen đáy khi đun bếp gas thường do lửa gas bị đỏ (dư gas hoặc nghẹt mâm chia lửa). Bạn nên nhờ thợ vệ sinh lại bếp gas nhé. Để tẩy vết đen nhọ đáy nồi, bạn có thể dùng kem tẩy rửa kim loại chuyên dụng hoặc ngâm với giấm và chà nhẹ là sạch bong ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(46, 'ấm siêu tốc kêu to,bình đun nước kêu rè rè,ấm đun ồn,sôi nước kêu to', 'Dạ, ấm siêu tốc khi đun nước phát ra tiếng kêu ồ ồ (đặc biệt lúc nước sắp sôi) là hiện tượng vật lý hoàn toàn bình thường do quá trình tạo bọt khí và sự chênh lệch nhiệt độ bên trong bình. Nếu ấm chỉ kêu mà vẫn tự ngắt điện khi nước sôi thì bạn hoàn toàn yên tâm sử dụng nhé!', 'HoatDong', '2026-04-13 08:00:00'),
(47, 'máy xay bị chảy nước,cối xay bị rỉ nước,gioăng cao su máy xay,hư ron cao su', 'Dạ, máy xay bị chảy nước ở đáy cối thường do vòng gioăng (ron) cao su bị đặt lệch, hoặc bị rão/rách sau thời gian dài sử dụng. Bạn hãy tháo phần đế lưỡi dao ra, kiểm tra và lắp lại gioăng cho khít nhé. Nếu gioăng đã hỏng, shop có bán phụ kiện thay thế chính hãng ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(48, 'nắp vung kính tự vỡ,vỡ nắp kính,nắp nồi bị nổ,kính cường lực tự nổ', 'Dạ, nắp nồi bằng kính cường lực có một tỷ lệ rất nhỏ (khoảng 0.1%) tự nổ vỡ vụn do thay đổi nhiệt độ quá đột ngột (sốc nhiệt). Nếu sản phẩm mua tại COZY CORNER gặp tình trạng này trong 30 ngày đầu, shop sẽ hỗ trợ **gửi tặng nắp kính mới hoàn toàn miễn phí** tận nhà cho bạn ạ!', 'HoatDong', '2026-04-13 08:00:00'),
(49, 'chảo size 20,chảo size 24,chảo size 28,nên mua chảo size mấy,chọn kích thước chảo', '💡 **Mẹo chọn size chảo:**\n- **Size 20cm:** Nhỏ gọn, hợp ốp la 1-2 quả trứng, rán đồ ăn ít (1 người).\n- **Size 24cm:** Size quốc dân phổ biến nhất, rán được 2-3 khúc cá, phù hợp gia đình 2-3 người.\n- **Size 28cm:** Chảo to, chiên được nguyên con cá lớn, phù hợp nhà đông người hoặc dùng khi có khách ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(50, 'gửi hàng bảo hành,địa chỉ bảo hành,trung tâm bảo hành elmich,bảo hành kalpen,sửa chữa ở đâu', 'Dạ, để gửi thiết bị điện bảo hành, bạn có 2 cách:\n1. Mang trực tiếp thiết bị đến cửa hàng COZY CORNER (P.7, Q. Bình Thạnh).\n2. Đóng gói máy vô hộp cẩn thận, ghi rõ Tên + SĐT ra ngoài hộp và gửi qua bưu điện về địa chỉ shop. Shop sẽ nhận, làm việc với hãng và gửi trả lại máy đã sửa xong về tận nhà cho bạn ạ.', 'HoatDong', '2026-04-13 08:00:00'),
(51, 'tích điểm,thành viên,thẻ vip,điểm thưởng,hạng thành viên', 'Dạ, COZY CORNER có chương trình khách hàng thân thiết. Mỗi đơn hàng thành công bạn sẽ được cộng điểm tích lũy. Khi đạt các mốc hạng Bạc, Vàng, Kim Cương, bạn sẽ nhận được các đặc quyền ưu đãi riêng biệt ạ!', 'HoatDong', '2026-04-13 07:55:00'),
(52, 'trả góp,mua thiếu,trả chậm,quẹt thẻ tín dụng,credit card,thẻ ghi nợ', 'Dạ, hiện shop có hỗ trợ thanh toán trả góp 0% qua thẻ tín dụng (Credit Card) của hơn 20 ngân hàng. Quá trình chuyển đổi trả góp sẽ được thực hiện hoàn toàn tự động ở bước thanh toán trên website ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(53, 'vi sóng có tia lửa,xẹt lửa,vi sóng bị nổ,hâm đồ ăn kêu lụp bụp,đánh lửa', '💡 **Lưu ý an toàn:**\nHiện tượng xẹt lửa thường do bạn đang dùng vật dụng kim loại (tô nhôm, đĩa có viền kim loại, giấy bạc) để hâm thức ăn. Bạn hãy tắt điện ngay, đổi sang hộp thủy tinh hoặc nhựa chịu nhiệt chuyên dụng nhé!', 'HoatDong', '2026-04-13 07:55:00'),
(54, 'kẹt bã ép,ép bị kẹt,tháo cối ép,không xoay được trục ép,ép cần tây bị kẹt', 'Dạ, khi ép các loại rau nhiều xơ (như cần tây, rau má) bã rất dễ quấn vào trục xoay gây kẹt. Bạn hãy bấm nút [REVERSE] (quay ngược) khoảng 3-5 giây để xả bã ra, sau đó mới tắt nguồn và tháo cối vệ sinh nhé.', 'HoatDong', '2026-04-13 07:55:00'),
(55, 'tủ lạnh đóng tuyết,ngăn đá bị đông đá,rỉ nước tủ lạnh,chảy nước', 'Dạ, nếu thiết bị đông lạnh có hiện tượng đóng tuyết dày hoặc rỉ nước bên dưới, có thể do ron cửa bị hở hoặc rãnh thoát nước bị tắc. Bạn thử rút điện, vệ sinh sạch sẽ, kiểm tra lại ron cao su xem có bị chai cứng không nhé.', 'HoatDong', '2026-04-13 07:55:00'),
(56, 'bàn ủi dính vải,khét vải,cháy quần áo,vệ sinh mặt đế ủi,rít mặt đế', '💡 **Làm sạch mặt đế bàn ủi:**\nNếu lỡ ủi cháy làm nilon dính vào mặt đế, bạn cắm điện cho hơi ấm lên, dùng một chiếc khăn ẩm chà xát mạnh vào vết bẩn. Hoặc thoa một chút kem đánh răng khi mặt đế đã nguội hẳn, lau lại bằng khăn mềm là sạch bong ạ!', 'HoatDong', '2026-04-13 07:55:00'),
(57, 'bao lâu thay lõi lọc,thời hạn thay lõi,nước có mùi lạ,đèn báo thay lõi', 'Dạ, thời gian thay bộ lọc nước tùy thuộc vào chất lượng nước nguồn, nhưng trung bình là: Lõi 1 (3-6 tháng), Lõi 2,3 (6-9 tháng), Màng RO (24-36 tháng). Nếu nước có mùi lạ hoặc chảy yếu, bạn nên kiểm tra và thay bộ lọc sớm hơn ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(58, 'quạt kêu to,trục quay bị rít,lồng quạt bám bụi,cánh quạt bị rung', 'Dạ, quạt điện dùng lâu ngày kêu to thường do khô dầu hoặc kẹt tóc/bụi ở trục quay. Bạn hãy tháo lồng, cánh quạt ra vệ sinh, nhỏ 1-2 giọt dầu chuyên dụng (hoặc dầu nhớt) vào ngay trục cốt là sẽ chạy êm ru lại ngay ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(59, 'cơm bị dính đáy,cơm bị khê,nấu cơm bị sống,lõi bong chống dính', 'Dạ, đun nấu bị khê/sống có thể do rơ-le nhiệt bị dính bụi hoặc hao mòn. Nếu phần lõi bị dính quá nhiều thì có thể lớp chống dính đã hết hạn sử dụng an toàn. Bạn có thể liên hệ Zalo Hotline của shop để mua lõi thay thế chính hãng nhé.', 'HoatDong', '2026-04-13 07:55:00'),
(60, 'xóa tài khoản,hủy account,delete account,không muốn dùng tài khoản', 'Dạ, nếu bạn muốn xóa hoàn toàn tài khoản và dữ liệu cá nhân trên hệ thống COZY CORNER, vui lòng gửi email yêu cầu về **Cozy@cv.com.vn** bằng chính email đã đăng ký. Quản trị viên sẽ xử lý và phản hồi trong 24h ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(61, 'nhờ lắp đặt,hỗ trợ kỹ thuật tại nhà,thợ đến nhà,lắp giùm', 'Dạ, COZY CORNER hiện hỗ trợ giao hàng toàn quốc qua đối tác vận chuyển nên chưa có dịch vụ cử kỹ thuật viên đến tận nhà lắp ráp. Tuy nhiên, các mặt hàng tại shop đều có HDSD tiếng Việt rất chi tiết, bạn chỉ cần xem qua là có thể tự lắp dễ dàng ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(62, 'lỗi thanh toán thẻ,bị trừ tiền nhưng chưa có đơn,lỗi trừ đúp tiền,chuyển khoản nhưng chưa lên đơn', 'Dạ bạn đừng quá lo lắng! Trong trường hợp ngân hàng đã báo trừ tiền mà hệ thống chưa ghi nhận đơn thành công (thường do trễ mạng hoặc lỗi cổng thanh toán), bạn vui lòng chụp lại biên lai gửi qua Zalo Hotline, shop sẽ xác nhận và lên đơn thủ công ngay cho bạn ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(63, 'tuyển dụng,xin việc,có tuyển nhân viên không,việc làm', 'Dạ, COZY CORNER hiện vẫn đang liên tục tìm kiếm các đồng đội ở vị trí Chăm sóc Khách hàng và Vận hành Kho. Bạn quan tâm vui lòng theo dõi Fanpage chính thức của shop để cập nhật các thông tin tuyển dụng mới nhất nhé.', 'HoatDong', '2026-04-13 07:55:00'),
(64, 'hợp tác,nhượng quyền,đối tác,cung cấp hàng', 'Dạ, COZY CORNER rất hân hạnh được hợp tác cùng các nhãn hàng và nhà phân phối uy tín. Để trao đổi chi tiết về chính sách đối tác hoặc nhượng quyền thương hiệu, anh/chị vui lòng liên hệ trực tiếp qua Email quản lý: **Cozy@cv.com.vn** ạ.', 'HoatDong', '2026-04-13 07:55:00'),
(65, 'bị lừa đảo,cảnh báo giả mạo,trang web giả,fanpage ảo,mạo danh', '⚠️ **Cảnh báo an toàn:**\nCOZY CORNER chỉ giao dịch qua duy nhất website chính thức và tài khoản ngân hàng của Công ty. Bạn tuyệt đối không chuyển khoản vào tài khoản cá nhân lạ, hoặc nhận bưu kiện từ đơn vị vận chuyển mà không kiểm tra đối chiếu mã vận đơn trên hệ thống để tránh bị mạo danh lừa đảo nhé!', 'HoatDong', '2026-04-13 07:55:00'),
(66, 'lỗi website,web lag,không bấm được,hình ảnh bị lỗi,tải trang chậm,lỗi mạng', 'Dạ, nếu website gặp sự cố tải chậm hoặc không hiển thị hình ảnh, bạn thử nhấn F5 (Refresh) hoặc xóa cache trình duyệt nhé. Nếu vẫn lỗi, bạn báo lại để đội ngũ kỹ thuật COZY CORNER kiểm tra và khắc phục ngay ạ!', 'HoatDong', '2026-04-13 12:55:00'),
(67, 'có app không,tải ứng dụng,app ios,app android,tải trên điện thoại', 'Dạ, hiện tại COZY CORNER chủ yếu hoạt động trên nền tảng Website để tối ưu tốc độ và không làm nặng dung lượng điện thoại của bạn. Bạn cứ truy cập trực tiếp bằng trình duyệt (Chrome, Safari) là dùng mượt mà lắm nha!', 'HoatDong', '2026-04-13 12:55:00'),
(68, 'hàng cồng kềnh,phụ phí hàng to,gửi xe,phí chung cư,phí bê vác', 'Dạ, với các mặt hàng kích thước lớn, bên vận chuyển có thể thu thêm một chút phụ phí hàng cồng kềnh (sẽ được báo trước ở bước thanh toán). Riêng phí gửi xe hoặc thang máy khi giao lên tận cửa phòng chung cư thì bạn thỏa thuận giúp shop với anh Shipper nhé.', 'HoatDong', '2026-04-13 12:55:00'),
(69, 'giao ra đảo,phú quốc,côn đảo,gửi chành xe,nhà xe,xe khách', 'Dạ, đối tác GHN của shop có giao đến tận các huyện đảo luôn ạ. Tuy nhiên, nếu bạn muốn gửi hàng qua chành xe/nhà xe quen cho nhanh, bạn vui lòng chuyển khoản trước và liên hệ Zalo Hotline để shop hỗ trợ gửi chành theo yêu cầu nhé.', 'HoatDong', '2026-04-13 12:55:00'),
(70, 'mất vỏ hộp,rách thùng,bỏ hộp giấy,mất bao bì,mất mút xốp', 'Dạ, để được hỗ trợ 1 đổi 1 nhanh chóng, bạn vui lòng giữ lại nguyên vẹn vỏ hộp, thùng carton và mút xốp bên trong trong vòng 7 ngày đầu tiên sau khi nhận hàng nhé. Nếu mất vỏ hộp gốc, shop sẽ rất khó hỗ trợ làm thủ tục đổi trả với hãng được ạ.', 'HoatDong', '2026-04-13 12:55:00'),
(71, 'chuyển dư tiền,lỡ chuyển dư,chuyển sai số tiền,thừa tiền', 'Dạ, nếu bạn lỡ chuyển khoản dư số tiền so với giá trị cần thanh toán, đừng lo lắng nhé! Bạn hãy nhắn ngay biên lai cho Zalo Hotline, kế toán bên shop sẽ đối soát và hoàn lại phần tiền thừa cho bạn ngay trong ngày làm việc ạ.', 'HoatDong', '2026-04-13 12:55:00'),
(72, 'quên ghi nội dung chuyển khoản,không ghi chú,quên ghi mã', 'Dạ, nếu bạn lỡ quét mã hoặc chuyển khoản mà quên ghi nội dung mã thanh toán, hệ thống sẽ không tự động xác nhận được. Bạn hãy chụp lại bill chuyển khoản và gửi qua mục Liên hệ để nhân viên duyệt thủ công đơn hàng cho bạn nhé.', 'HoatDong', '2026-04-13 12:55:00'),
(73, 'bình giữ nhiệt bị đổ mồ hôi,đọng nước ngoài vỏ,ly giữ nhiệt không lạnh', 'Dạ, bình hoặc ly giữ nhiệt cao cấp thường hút chân không rất kín nên sẽ KHÔNG có hiện tượng \"đổ mồ hôi\" (đọng nước) bên ngoài vỏ. Nếu bạn gặp tình trạng này thì có thể lớp chân không đã bị hỏng do va đập mạnh, bạn liên hệ shop để được hỗ trợ kiểm tra nhé.', 'HoatDong', '2026-04-13 12:55:00'),
(74, 'hộp đựng đồ ăn bị hôi,nắp silicon lỏng,vệ sinh hộp nhựa,ám mùi thức ăn', '💡 **Mẹo khử mùi hộp nhựa/thuỷ tinh:**\nĐể khử mùi thức ăn bám lâu ngày, bạn có thể ngâm hộp với một chút nước ấm pha bã cà phê hoặc baking soda qua đêm. Sáng hôm sau rửa lại bằng nước rửa bát là mùi hôi sẽ biến mất hoàn toàn ạ.', 'HoatDong', '2026-04-13 12:55:00'),
(75, 'đĩa thủy tinh bị vỡ,khay quay không xoay,lồng xoay bị kẹt', 'Dạ, nếu phần đĩa thủy tinh hoặc trục xoay bên trong thiết bị vi sóng/nướng của bạn không hoạt động, có thể do bánh xe phía dưới bị trượt khỏi rãnh hoặc kẹt cặn bẩn. Bạn thử tháo khay ra, rửa sạch và đặt lại cho khớp ngàm nhé!', 'HoatDong', '2026-04-13 12:55:00'),
(76, 'dây điện bị nóng,phích cắm lỏng,chấu cắm 3 chân,ổ cắm bị xẹt lửa', '⚠️ **Lưu ý điện áp an toàn:**\nĐối với các thiết bị gia dụng có công suất lớn, bạn nên cắm trực tiếp vào ổ cắm cố định trên tường. Tuyệt đối hạn chế dùng chung ổ cắm nối dài với nhiều thiết bị khác cùng lúc để tránh quá tải, gây nóng dây hoặc chập cháy nhé.', 'HoatDong', '2026-04-13 12:55:00'),
(77, 'đánh giá 5 sao,review được quà,feedback,nhận xét,đánh giá đơn', 'Dạ, COZY CORNER rất trân trọng những đánh giá chân thực từ bạn! Sau khi nhận hàng, nếu bạn chụp ảnh/quay video trải nghiệm thực tế và để lại đánh giá 5 sao, hệ thống sẽ tự động gửi tặng bạn một bất ngờ nhỏ qua email cho lần mua sắm tiếp theo đó nha!', 'HoatDong', '2026-04-13 12:55:00'),
(78, 'shopee,lazada,tiktok shop,có bán trên sàn không,link shopee', 'Dạ, để mang lại mức giá tốt nhất, ổn định nhất và không bị độn phí sàn, hiện tại COZY CORNER chỉ phân phối trực tiếp qua Website chính thức này thôi ạ. Giao diện trực quan, bảo mật cao và đặt hàng cũng cực kỳ dễ dàng luôn!', 'HoatDong', '2026-04-13 12:55:00'),
(79, 'đặt trước,pre-order,hàng sắp về,hết hàng,bao lâu có lại,thông báo khi có hàng', 'Dạ, với các mặt hàng đang tạm hết, bạn có thể bấm vào nút \"Nhận thông báo khi có hàng\" hoặc nhắn trực tiếp qua Zalo cho shop. Ngay khi đợt hàng mới cập bến, COZY CORNER sẽ ưu tiên báo tin cho bạn đầu tiên luôn ạ!', 'HoatDong', '2026-04-13 12:55:00'),
(80, 'xin lỗi,nhầm,gõ sai,gõ lộn,bỏ qua', 'Dạ không sao đâu ạ! Bạn cứ gõ lại nội dung cần hỗ trợ nhé, Cozy Bot vẫn luôn ở đây lắng nghe và sẵn sàng giải đáp mọi thắc mắc của bạn 24/7.', 'HoatDong', '2026-04-13 12:55:00'),
(81, 'bảo mật,thông tin cá nhân,bị lộ thông tin,spam,tin nhắn rác,hack', 'Dạ, COZY CORNER cam kết bảo mật 100% thông tin cá nhân của bạn theo tiêu chuẩn SSL. Dữ liệu chỉ được dùng để hỗ trợ giao hàng và bảo hành. Shop tuyệt đối không bán hoặc chia sẻ thông tin cho bên thứ 3 nên bạn cứ yên tâm mua sắm nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(82, 'sách hướng dẫn,mất hdsd,xin file hướng dẫn,video lắp ráp,cách sử dụng,file pdf', 'Dạ, nếu bạn lỡ làm mất sách hướng dẫn giấy, đừng lo nhé! Bạn hãy nhắn mã model thiết bị qua Zalo Hotline, đội ngũ kỹ thuật của COZY CORNER sẽ gửi ngay cho bạn file PDF hướng dẫn sử dụng tiếng Việt hoặc video thao tác chi tiết ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(83, 'tổng đài,số điện thoại cskh,chat với nhân viên,gặp người thật,cần tư vấn viên,nhân viên hỗ trợ', 'Dạ, Cozy Bot tuy học hỏi rất nhanh nhưng đôi khi vẫn chưa hiểu hết ý bạn. Để kết nối trực tiếp với nhân viên Chăm sóc khách hàng, bạn vui lòng gọi Hotline **0888 888 888** (Giờ hành chính) hoặc nhắn tin qua Zalo OA của COZY CORNER nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(84, 'hoàn về thẻ,bao lâu nhận lại tiền,tiền hoàn,thời gian hoàn tiền,refund qua thẻ', 'Dạ, nếu bạn thanh toán bằng Thẻ tín dụng/Visa/Mastercard và phát sinh hủy/hoàn tiền, giao dịch sẽ được hoàn tự động về thẻ của bạn trong khoảng 5 - 7 ngày làm việc (tùy thuộc vào quy trình của ngân hàng phát hành thẻ) ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(85, 'hao điện,tiết kiệm điện,nhãn năng lượng,tốn điện,chế độ eco,inverter', '💡 **Mẹo tiết kiệm điện gia đình:**\nPhần lớn thiết bị điện tại COZY CORNER đều dán nhãn năng lượng 4-5 sao hoặc tích hợp công nghệ Inverter. Để tiết kiệm tối đa, bạn nhớ rút phích cắm khi không dùng trong thời gian dài (trừ tủ lạnh) và luôn vệ sinh lưới lọc bụi thường xuyên nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(86, 'robot,hút bụi,lau nhà,kẹt rác,chổi than,vệ sinh hộp bụi,robot chạy vòng tròn', 'Dạ, với các thiết bị hút bụi và lau nhà tự động, nếu thấy thiết bị chạy vòng tròn hoặc hút yếu, thường là do chổi cuốn bị kẹt tóc/sợi chỉ hoặc cảm biến bị bám bụi. Bạn hãy lật ngược thiết bị, gỡ rác ở chổi chính và dùng khăn khô lau nhẹ các mắt cảm biến chống rơi xung quanh nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(87, 'lọc không khí,lõi hepa,màng lọc hepa,vệ sinh màng lọc,đèn báo đỏ,không khí ô nhiễm', 'Dạ, khi màng lọc HEPA bám nhiều bụi, thiết bị sẽ báo đèn đỏ và giảm công suất. Bạn chỉ cần tháo nắp, dùng chổi mềm hoặc vòi hút bụi để làm sạch bề mặt màng lọc (tuyệt đối không rửa màng HEPA bằng nước). Khuyến nghị nên thay màng lọc mới sau 6-8 tháng sử dụng ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(88, 'trả trước,đặt cọc,thanh toán một phần,cọc tiền,ứng trước', 'Dạ, với các giao dịch thông thường, COZY CORNER hỗ trợ bạn thanh toán 100% khi nhận hàng (COD). Tuy nhiên, với một số mặt hàng quá cồng kềnh hoặc thiết kế theo yêu cầu riêng, nhân viên sẽ liên hệ nhờ bạn cọc trước 10-20% giá trị để đảm bảo vận chuyển ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(89, 'thu cũ đổi mới,đổi đồ cũ,tái chế,bán lại,trade in', 'Dạ, hiện tại COZY CORNER chưa triển khai chương trình Thu cũ đổi mới (Trade-in). Tuy nhiên, shop thường xuyên có các chiến dịch \"Tuần lễ xanh\" trợ giá cực sâu để bạn dễ dàng lên đời các thiết bị điện gia dụng thông minh thế hệ mới đó ạ!', 'HoatDong', '2026-04-13 13:15:00'),
(90, 'tiếp thị liên kết,affiliate,ctv,cộng tác viên,bán hàng cùng shop', 'Dạ, COZY CORNER rất hoan nghênh các bạn Cộng tác viên/KOCs tham gia mạng lưới Affiliate. Không cần bỏ vốn nhập hàng, hoa hồng chiết khấu rất hấp dẫn. Bạn hãy liên hệ Email: **Cozy@cv.com.vn** với tiêu đề \"Đăng ký CTV\" để nhận chính sách nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(91, 'gộp mua,mua chung,đặt thêm,thêm món vào giỏ,gom lại,mua nhiều món', 'Dạ, nếu bạn vừa chốt xong 1 kiện hàng nhưng sực nhớ muốn mua thêm món nữa, bạn cứ thao tác đặt tiếp 1 lần nữa trên web nhé. Sau đó nhắn tin ngay cho shop báo \"Gộp kiện\", nhân viên sẽ chủ động gom chung lại để tiết kiệm chi phí vận chuyển tối đa cho bạn ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(92, 'dời ngày nhận,bận đột xuất,không nghe điện thoại,gọi không được,hẹn lại ngày', 'Dạ, nếu Shipper gọi tới nhưng bạn đang bận họp hoặc đi công tác đột xuất, bạn cứ mạnh dạn hẹn lại anh bưu tá: \"Anh vui lòng lưu kho, 2 ngày sau giao lại giúp em nhé\". Bưu tá bên đối tác GHN rất nhiệt tình và hỗ trợ giữ hàng tối đa 3-5 ngày ạ.', 'HoatDong', '2026-04-13 13:15:00'),
(93, 'mua hộ,thanh toán hộ,người khác nhận,gửi tặng bạn,tặng sếp', 'Dạ, thao tác gửi tặng vô cùng dễ dàng! Ở bước thanh toán, phần \"Thông tin người nhận\", bạn chỉ cần nhập tên, số điện thoại và nơi ở của người được tặng. Sau đó bạn chọn hình thức Thanh toán trước (Chuyển khoản/Thẻ) là xong. Shop sẽ lo phần còn lại ạ!', 'HoatDong', '2026-04-13 13:15:00'),
(94, 'góp ý,phản hồi,khen ngợi,chê bai,cải thiện,khiếu nại quản lý', 'Dạ, mọi phản hồi khen chê của bạn đều là tài sản quý giá giúp COZY CORNER ngày càng hoàn thiện hơn. Nếu có điều gì chưa hài lòng, mong bạn đừng vội buồn bực mà hãy nhắn tin thẳng cho Quản lý cửa hàng qua Zalo: 0888 888 888 để được giải quyết triệt để ngay nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(95, 'cối thủy tinh,cối nhựa tritan,nhông,trục xoay,cối xay thịt,vệ sinh cối', '💡 **Lưu ý vệ sinh cối xay:**\nĐối với các loại cối thủy tinh hoặc nhựa cao cấp, sau khi xay xong đồ sống (như thịt, cá), bạn nên tháo rời phần lưỡi dao ra rửa riêng. Dùng một chút chanh hoặc giấm chà nhẹ vào thành cối để khử mùi tanh trước khi rửa lại bằng nước rửa chén nhé!', 'HoatDong', '2026-04-13 13:15:00'),
(96, 'tem bảo hành,rách tem,tem niêm phong,nguyên seal,bóc tem,hàng mới nguyên', 'Dạ, tất cả thiết bị điện gia dụng tại COZY CORNER đều được xuất kho với tem niêm phong chính hãng. Nếu lúc mở hộp bạn thấy tem bị rách hoặc có dấu hiệu cạy mở, hãy chụp ảnh lại ngay và gửi cho shop qua Zalo để được hỗ trợ giải quyết nhé!', 'HoatDong', '2026-04-13 13:30:00'),
(97, 'nhựa an toàn,bpa free,nhựa pp,chất liệu nhựa,có độc không,nhựa chịu nhiệt', 'Dạ, các vật dụng nhà bếp bằng nhựa tại shop (như khay, hộp đựng, cối xay) đều được làm từ nhựa nguyên sinh cao cấp (PP, Tritan) và 100% không chứa BPA, chịu nhiệt cực tốt nên hoàn toàn an toàn cho sức khỏe gia đình và trẻ nhỏ ạ.', 'HoatDong', '2026-04-13 13:30:00'),
(98, 'ship quốc tế,gửi ra nước ngoài,gửi đi mỹ,hỗ trợ gửi hỏa tốc quốc tế,english,chở ra nước ngoài', 'Dạ, hiện tại hệ thống vận chuyển của COZY CORNER chỉ hỗ trợ giao hàng nội địa trong lãnh thổ Việt Nam. Nếu bạn muốn gửi đồ đi nước ngoài, bạn có thể nhận hàng tại VN rồi chủ động gửi qua các đơn vị chuyển phát quốc tế (như DHL, FedEx) nhé.', 'HoatDong', '2026-04-13 13:30:00'),
(99, 'hủy nhận mail,tắt thông báo,không nhận tin nhắn,spam mail,hủy đăng ký,chặn tin nhắn', 'Dạ, nếu bạn không muốn nhận email giới thiệu ưu đãi nữa, bạn chỉ cần kéo xuống cuối email của shop và bấm vào dòng chữ \"Unsubscribe\" (Hủy đăng ký) là xong ạ. Hệ thống sẽ ngừng gửi tin tức ngay lập tức để không làm phiền bạn.', 'HoatDong', '2026-04-13 13:30:00'),
(100, 'làm rơi,vỡ,tự làm hỏng,rớt vô nước,ngập nước,chập điện do nước,tự làm rớt', 'Dạ, theo quy định của hãng, các trường hợp rơi vỡ, móp méo, hoặc để thiết bị điện vô nước do lỗi vô ý của người dùng sẽ bị từ chối bảo hành miễn phí. Tuy nhiên, shop vẫn sẽ nhận lại để chuyển hãng sửa chữa dịch vụ (có tính phí linh kiện) giúp bạn ạ.', 'HoatDong', '2026-04-13 13:30:00'),
(101, 'hết hạn bảo hành,sửa chữa dịch vụ,sửa tính phí,thay linh kiện,quá hạn bảo hành', 'Dạ, nếu thiết bị của bạn đã qua thời hạn bảo hành (quá 12 - 24 tháng), COZY CORNER vẫn luôn đồng hành cùng bạn! Bạn cứ gửi hàng về, kỹ thuật viên sẽ kiểm tra, báo chi phí linh kiện thay thế trước, bạn đồng ý thì shop mới tiến hành sửa chữa nhé.', 'HoatDong', '2026-04-13 13:30:00'),
(102, 'màu sắc,sai màu,đổi màu,màu nhạt hơn hình,thực tế khác hình,màu không giống', 'Dạ, màu sắc thực tế của đồ dùng có thể chênh lệch khoảng 3-5% so với hình ảnh trên website do ánh sáng môi trường chụp hoặc độ phân giải màn hình. Tuy nhiên, shop cam kết kiểu dáng và chất lượng chuẩn 100% như thông tin mô tả ạ!', 'HoatDong', '2026-04-13 13:30:00'),
(103, 'giao chủ nhật,giao ngày lễ,nghỉ tết,lịch giao hàng tết,thứ 7 có giao không', 'Dạ, đối tác giao hàng của shop (GHN) vẫn làm việc và đi phát hàng vào cả Thứ 7 và Chủ Nhật. Riêng các dịp Lễ lớn hoặc Tết Nguyên Đán, lịch nghỉ cụ thể sẽ được COZY CORNER thông báo trước bằng banner ngay trên trang chủ website ạ!', 'HoatDong', '2026-04-13 13:30:00'),
(104, 'xin hình ảnh,lấy ảnh đăng bài,dropship,ảnh không logo,mượn hình,bán hàng order', 'Dạ, toàn bộ hình ảnh trên website là hình ảnh bản quyền. Nếu bạn là Cộng tác viên (Affiliate) chính thức của COZY CORNER, bạn sẽ được cấp quyền truy cập vào kho dữ liệu hình ảnh chất lượng cao gốc (không chèn logo) để thoải mái đăng bài bán hàng ạ.', 'HoatDong', '2026-04-13 13:30:00'),
(105, 'pin sạc,chai pin,sạc không vào,sạc qua đêm,thiết bị dùng pin,sạc mau hết', '💡 **Lưu ý bảo vệ pin:** \nVới các thiết bị điện cầm tay dùng pin sạc, bạn nên sạc đầy rồi rút ra, tránh cắm sạc qua đêm liên tục. Nếu thời gian dài không dùng đến, hãy sạc khoảng 50% pin trước khi cất kho để tránh tình trạng pin bị kiệt và chai nhé!', 'HoatDong', '2026-04-13 13:30:00'),
(106, 'buồn ngủ,đói bụng,mệt,kể chuyện,hát,làm thơ,chán,tâm sự', 'Hihi, bạn đang mệt hả? Nghỉ ngơi xíu đi nè, uống một cốc nước ấm hoặc pha một tách trà hoa cúc cho thư giãn nha. Cozy Bot không biết hát, nhưng mình luôn ở đây trực website 24/7 để phụ bạn mua sắm cho xả stress đó! ❤️', 'HoatDong', '2026-04-13 13:30:00'),
(107, 'khen bot,bot thông minh,yêu bot,bot dễ thương,bot xịn,giỏi quá', 'Aww, Cozy Bot vui quá chừng! Cảm ơn bạn đã khen nha. Mình là trợ lý AI nên vẫn đang học hỏi mỗi ngày từ các câu hỏi của khách hàng để phục vụ tốt hơn. Nếu cần hỗ trợ gì cứ gõ vào đây, mình cân được hết! 😎', 'HoatDong', '2026-04-13 13:30:00'),
(108, 'chửi bậy,ngu,dở,tệ hại,bot dốt,bot ngốc,bot vô dụng', 'Dạ, Cozy Bot vô cùng xin lỗi nếu chưa hiểu đúng ý hoặc làm bạn phiền lòng ạ 😥. Thuật toán của mình vẫn đang được đội ngũ kỹ thuật hoàn thiện thêm. Bạn có thể gọi trực tiếp Hotline 0888 888 888 để được các anh chị nhân viên hỗ trợ nhanh nhất nhé!', 'HoatDong', '2026-04-13 13:30:00'),
(109, 'facebook,instagram,tiktok,hội nhóm,group review,mạng xã hội,fanpage,fb,ins,tóp tóp', 'Dạ, để cập nhật các tips chăm sóc nhà cửa hay ho và mini-game nhận quà hàng tuần, bạn hãy follow ngay Fanpage Facebook và kênh TikTok chính thức của \"COZY CORNER\" nhé. Nút liên kết nằm ở ngay dưới cùng (footer) của website đó ạ!', 'HoatDong', '2026-04-13 13:30:00'),
(110, 'lâu không dùng,cất kho,bảo quản lâu dài,không sử dụng,đi vắng', '💡 **Mẹo cất giữ đồ gia dụng:** \nNếu bạn đi xa hoặc ít dùng đến thiết bị, hãy rửa thật sạch, lau khô ráo hoàn toàn (tránh ẩm mốc), quấn gọn dây điện và cho vào túi nilon hoặc thùng carton trước khi cất vào tủ để tránh gián, chuột cắn đứt dây điện nhé.', 'HoatDong', '2026-04-13 13:30:00'),
(111, 'yêu thích,lưu lại,thả tim,wishlist,xem sau,đánh dấu', 'Dạ, tính năng \"Danh sách yêu thích\" (Thả tim) trên hệ thống hoàn toàn mở. Bạn không cần bắt buộc phải đăng nhập tài khoản vẫn có thể dễ dàng lưu lại những món đồ ưng ý để xem lại sau cực kỳ tiện lợi ạ!', 'HoatDong', '2026-04-13 13:45:00'),
(112, 'quần áo,mỹ phẩm,giày dép,túi xách,bán gì khác không', 'Dạ, COZY CORNER là nền tảng chuyên biệt và tập trung 100% vào thiết bị điện gia dụng, đồ dùng nhà bếp cao cấp. Shop không kinh doanh các mặt hàng thời trang, mỹ phẩm hay bách hóa tổng hợp ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(113, 'giỏ hàng bị mất,lưu giỏ hàng,để lâu trong giỏ,tự xóa giỏ hàng', 'Dạ, các món đồ bạn thêm vào giỏ hàng sẽ được hệ thống tự động lưu trữ trong 7 ngày. Tuy nhiên, để tránh trường hợp kho hết tồn hoặc kết thúc ưu đãi, bạn nên tiến hành thanh toán sớm nhé!', 'HoatDong', '2026-04-13 13:45:00'),
(114, 'gửi bảo vệ,gửi lễ tân,nhờ người nhận hộ,bỏ tủ locker', 'Dạ, bưu tá bên GHN hoàn toàn có thể gửi bưu kiện tại quầy lễ tân hoặc bảo vệ chung cư theo yêu cầu của bạn. Tuy nhiên, bạn vui lòng hoàn tất chuyển khoản trước vì bưu tá không thể thu hộ tiền mặt (COD) từ bảo vệ được ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(115, 'mua nhiều,thanh toán tiền mặt số lượng lớn,giới hạn cod', 'Dạ, với những kiện hàng lớn hoặc tổng giá trị vượt mức 10 triệu đồng, đối tác vận chuyển có thể từ chối thu hộ (COD). Trong trường hợp này, nhân viên COZY CORNER sẽ liên hệ nhờ bạn chuyển khoản cọc trước một phần để hệ thống lên bill thành công ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(116, 'không nhận được mã otp,lỗi đăng nhập,sai số điện thoại,đăng ký lỗi', 'Dạ, nếu bạn không nhận được mã OTP xác thực, hãy kiểm tra lại xem số điện thoại nhập đã đúng chưa, hoặc thử đổi sang nhận mã qua Email. Nếu mạng nghẽn, bạn vui lòng chờ khoảng 60 giây rồi ấn \"Gửi lại mã\" nhé!', 'HoatDong', '2026-04-13 13:45:00'),
(117, 'màng lọc hút mùi,lưới lọc dầu mỡ,rửa lưới lọc,vệ sinh hút mùi', '💡 **Mẹo làm sạch lưới lọc dầu mỡ:**\nBạn hãy tháo tấm lưới nhôm của thiết bị hút mùi ra, ngâm vào nước nóng pha bột baking soda khoảng 20-30 phút để mỡ mềm. Sau đó dùng bàn chải chà nhẹ và rửa sạch lại là xong ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(118, 'khử mùi tủ lạnh,tủ lạnh có mùi hôi,làm thơm tủ lạnh,mùi thức ăn trong tủ', '💡 **Khử mùi không gian đông lạnh:**\nĐể tránh bị ám mùi chéo, bạn nên bọc kín đồ ăn bằng màng bọc thực phẩm hoặc hộp có nắp. Ngoài ra, đặt một chén bã cà phê ở góc tủ sẽ giúp hút mùi hôi cực kỳ hiệu quả ạ!', 'HoatDong', '2026-04-13 13:45:00'),
(119, 'khay gang bị rỉ,vỉ nướng gang,tôi dầu khay gang,bảo quản đồ gang,gang gỉ sét', '💡 **Cách bảo quản khay/vỉ nướng gang:**\nGang thô rất dễ bị rỉ sét nếu để đọng nước. Sau khi rửa sạch, bạn bắt buộc phải lau thật khô, thoa một lớp dầu ăn mỏng lên toàn bộ bề mặt và cất ở nơi khô ráo để duy trì độ bền nhé!', 'HoatDong', '2026-04-13 13:45:00'),
(120, 'muỗng silicon,sạn silicon,xẻng silicon,silicon bị xước,silicon có chảy không', 'Dạ, các loại muôi, xẻng lật bằng vật liệu Silicone cao cấp tại shop có thể chịu nhiệt lên tới 230 độ C, không bị chảy nhựa khi chiên xào và đặc biệt là chống trầy xước tuyệt đối cho các lớp chống dính ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(121, 'mất phụ kiện,gửi bảo hành thiếu đồ,không có dây nguồn,gửi sửa chữa', 'Dạ, khi gửi thiết bị điện về trung tâm để kiểm tra kỹ thuật, bạn chỉ cần đóng gói phần thân thiết bị chính. Vui lòng KHÔNG gửi kèm các phụ kiện tháo rời (như dây điện rời, khay đựng) để tránh bị thất lạc trong quá trình vận chuyển qua lại nhé.', 'HoatDong', '2026-04-13 13:45:00'),
(122, 'lọc giá,sắp xếp theo giá,tìm đồ rẻ nhất,lọc từ thấp đến cao,lọc thương hiệu', 'Dạ, để tìm kiếm nhanh chóng, bạn có thể sử dụng bộ \"Lọc\" hiển thị trên màn hình. Tại đây, bạn dễ dàng tùy chỉnh khoảng giá, thương hiệu, hoặc sắp xếp hiển thị từ mức giá thấp đến cao cực kỳ trực quan ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(123, 'quạt hơi nước,quạt điều hòa chảy nước,thêm đá vào quạt,vệ sinh tấm làm mát', '💡 **Sử dụng quạt điều hòa hơi nước:**\nĐể làm mát sâu hơn, bạn có thể cho thêm đá lạnh hoặc khay đá gel vào bình chứa. Nhớ thường xuyên tháo tấm làm mát phía sau ra xịt rửa mỗi 2-3 tuần để tránh bị nghẹt cặn nhé!', 'HoatDong', '2026-04-13 13:45:00'),
(124, 'đổi size,đổi màu sau khi đặt,nhầm màu,đặt nhầm phân loại', 'Dạ, nếu lỡ chọn nhầm phân loại màu sắc hoặc kích thước, bạn vui lòng vào mục Lịch sử để thao tác \"Hủy\" (nếu trạng thái là Chờ xác nhận), sau đó lên lại bill mới giúp shop nhé. Trợ lý Bot không thể sửa đổi trực tiếp phân loại trên hệ thống ạ.', 'HoatDong', '2026-04-13 13:45:00'),
(125, 'thêm vào giỏ không được,không bấm mua được,báo lỗi hết tồn kho,nút mua bị mờ', 'Dạ, nếu nút \"Thêm vào giỏ\" bị mờ hoặc hệ thống báo không đủ tồn kho, nghĩa là mặt hàng đó đã được khách khác đặt hết. Bạn vui lòng giảm bớt số lượng xuống hoặc tham khảo sang các mẫu mã khác thay thế nhé.', 'HoatDong', '2026-04-13 13:45:00');

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
(184, 5, 'glb1lecf5ulnikoq0pg412a1au', 'bot', 'Chào bạn Đào Công Anh Minh, thành viên Kim Cương của Cozy Corner! 😊\n\nDạ, các mã giảm giá đang áp dụng tại Cozy Corner hôm nay là:\n\n*   **Mã TET2026**: Giảm ngay 5% cho đơn hàng từ 20.000đ.\n*   **Mã TET**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **Mã XUAN**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nBạn nhớ áp dụng mã khi thanh toán để nhận ưu đãi nhé! Chúc bạn mua sắm vui vẻ ạ! ✨', 1, '2026-04-03 13:22:57'),
(185, 5, 'lone63s78hs9j48aqjibrkgjtg', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-04-07 03:25:45'),
(186, 5, 'lone63s78hs9j48aqjibrkgjtg', 'bot', 'Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!', 1, '2026-04-07 03:25:45'),
(187, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Đơn hàng của tôi đâu?', 1, '2026-04-13 11:07:45'),
(188, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!', 1, '2026-04-13 11:07:45'),
(189, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Chính sách bảo hành', 1, '2026-04-13 11:08:02'),
(190, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 1, '2026-04-13 11:08:02'),
(191, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-04-13 11:08:07'),
(192, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-13 11:08:07'),
(193, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Mã giảm giá hôm nay', 1, '2026-04-13 11:08:30'),
(194, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Chào bạn Đào Công Anh Minh, Cozy Bot xin gửi bạn các mã giảm giá đang áp dụng tại Cozy Corner đây ạ:\n\n*   **TET2026**: Giảm 5% cho đơn hàng từ 20.000đ.\n*   **TET**: Giảm 2.000đ cho đơn hàng từ 10.000đ.\n*   **XUAN**: Giảm 5.000đ cho đơn hàng từ 30.000đ.\n\nBạn có thể áp dụng các mã này khi thanh toán nhé! Chúc bạn mua sắm vui vẻ ạ! 😊', 1, '2026-04-13 11:08:30'),
(195, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'giá cái thớt là bao nhiêu', 1, '2026-04-13 11:11:41'),
(196, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 1, '2026-04-13 11:11:41'),
(197, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi tới cửa hàng mua được không', 1, '2026-04-13 11:30:58'),
(198, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-13 11:30:58'),
(199, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi tới cửa hàng mua được không', 1, '2026-04-13 11:31:05'),
(200, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-13 11:31:05'),
(201, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'chào cậu', 1, '2026-04-13 11:31:29'),
(202, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 1, '2026-04-13 11:31:29'),
(203, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Chào bạn', 1, '2026-04-13 11:49:36'),
(204, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Xin chào 👋 Mình là **Cozy Bot** – trợ lý AI của COZY CORNER. Mình có thể kiểm tra đơn hàng, tìm voucher, giới thiệu sản phẩm. Mình giúp gì được cho bạn ạ?', 1, '2026-04-13 11:49:36'),
(205, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Shop có bán những gì', 1, '2026-04-13 11:50:02'),
(206, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-04-13 11:50:02'),
(207, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'mấy giờ rồi', 1, '2026-04-13 11:58:56'),
(208, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Ôi, xin lỗi bạn Đào Công Anh Minh nhé! Là một trợ lý AI, mình không thể biết chính xác bây giờ là mấy giờ được ạ. Bạn có thể xem trên thiết bị của mình nha! 😊', 1, '2026-04-13 11:58:56'),
(209, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Giao hàng bằng bên nào', 1, '2026-04-13 11:59:08');
INSERT INTO `chat_messages` (`id`, `user_id`, `session_id`, `role`, `content`, `is_cleared`, `created_at`) VALUES
(210, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, shop giao hàng toàn quốc qua đối tác Giao Hàng Nhanh (GHN):\n- **Thời gian:** 1-2 ngày (Nội thành HCM), 3-5 ngày (Tỉnh thành khác).\n- **Phí ship:** Được tính tự động tại trang thanh toán. Đừng quên săn mã Freeship của shop nhé!', 1, '2026-04-13 11:59:08'),
(211, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'mua sỉ', 1, '2026-04-13 11:59:59'),
(212, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER luôn có chính sách chiết khấu (Discount) cực kỳ ưu đãi dành cho Khách hàng mua sỉ, đại lý hoặc doanh nghiệp mua số lượng lớn làm quà tặng. Bạn vui lòng liên hệ trực tiếp Hotline: **0888 888 888** để nhận bảng báo giá chi tiết nhé!', 1, '2026-04-13 11:59:59'),
(213, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'cách vệ sinh chảo chống dính', 1, '2026-04-13 12:05:42'),
(214, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', '💡 **Mẹo bảo quản chảo chống dính:**\nĐể chảo bền lâu, bạn KHÔNG nên rửa chảo khi đang nóng (gây sốc nhiệt làm tróc lớp chống dính). Hãy đợi chảo nguội hẳn, dùng mút mềm để rửa (không dùng cước sắt). Khi nấu chỉ nên dùng muôi/sạn bằng gỗ hoặc silicone nhé!', 1, '2026-04-13 12:05:42'),
(215, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'cách vệ sinh chảo gang', 1, '2026-04-13 12:05:48'),
(216, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', '💡 **Mẹo bảo quản chảo chống dính:**\nĐể chảo bền lâu, bạn KHÔNG nên rửa chảo khi đang nóng (gây sốc nhiệt làm tróc lớp chống dính). Hãy đợi chảo nguội hẳn, dùng mút mềm để rửa (không dùng cước sắt). Khi nấu chỉ nên dùng muôi/sạn bằng gỗ hoặc silicone nhé!', 1, '2026-04-13 12:05:48'),
(217, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Địa chỉ shop ở đâu?', 1, '2026-04-13 12:06:20'),
(218, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-13 12:06:20'),
(219, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'dao gãy thì có được hoàn tiền khôgn', 1, '2026-04-13 12:08:36'),
(220, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER có chính sách **1 ĐỔI 1 TRONG VÒNG 7 NGÀY** (miễn phí ship) nếu:\n- Sản phẩm lỗi do nhà sản xuất.\n- Hàng bể vỡ do vận chuyển.\nBạn vui lòng chụp ảnh/quay video lúc mở hàng và gửi cho shop qua mục Liên hệ để được xử lý ngay lập tức ạ!', 1, '2026-04-13 12:08:36'),
(221, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'đơn hàng của tôi', 1, '2026-04-13 12:09:54'),
(222, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, bạn vui lòng cho mình xin mã đơn hàng (ví dụ: ORD00036) để mình kiểm tra nhé!', 1, '2026-04-13 12:09:54'),
(223, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'o36', 1, '2026-04-13 12:10:01'),
(224, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, đơn hàng **ORD00036** (tạo ngày 29/03/2026) có tổng giá trị **27.900đ** hiện đang ở trạng thái: **HoanThanh**.', 1, '2026-04-13 12:10:01'),
(225, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'nồi inox bị ố', 1, '2026-04-13 12:15:06'),
(226, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', '💡 **Làm sạch nồi Inox:**\nHiện tượng đáy nồi inox xuất hiện vệt màu cầu vồng hoặc ố vàng nhẹ là do \"sốc nhiệt\" khi đun nấu, hoàn toàn bình thường và an toàn. Bạn chỉ cần dùng một chút giấm trắng hoặc chanh chà nhẹ bề mặt, sau đó rửa lại là sạch bong ạ!', 1, '2026-04-13 12:15:06'),
(227, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'nồi inox bị ố', 1, '2026-04-13 12:15:19'),
(228, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Hiện tượng đáy nồi inox xuất hiện vệt màu cầu vồng hoặc ố vàng nhẹ là do \"sốc nhiệt\" khi đun nấu, hoàn toàn bình thường và an toàn. Bạn chỉ cần dùng một chút giấm trắng hoặc chanh chà nhẹ bề mặt, sau đó rửa lại là sạch bong ạ!', 1, '2026-04-13 12:15:19'),
(229, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'cách mài dao', 1, '2026-04-13 12:15:58'),
(230, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', '💡 **Bảo quản dao luôn sắc bén:**\nĐối với dao bếp (đặc biệt là dao thép Carbon), sau khi thái xong bạn nên rửa ngay và **lau thật khô** bằng khăn sạch trước khi cất lên giá/hộp cắm dao. Tuyệt đối không ngâm dao lâu trong bồn rửa để tránh bị rỉ sét bề mặt nhé.', 1, '2026-04-13 12:15:58'),
(231, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Shop có bán những gì', 1, '2026-04-13 12:18:04'),
(232, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện đang kinh doanh các danh mục sản phẩm sau ạ:\n- [Chảo](http://localhost:8080/cozycorner/index.php?url=product&category=ch-o)\n- [Nồi](http://localhost:8080/cozycorner/index.php?url=product&category=n-i)\n- [Đồ Điện](http://localhost:8080/cozycorner/index.php?url=product&category=-i-n)\n- [Chén](http://localhost:8080/cozycorner/index.php?url=product&category=ch-n)\n- [Thớt](http://localhost:8080/cozycorner/index.php?url=product&category=th-t)\n- [Dao](http://localhost:8080/cozycorner/index.php?url=product&category=dao)\n\nBạn muốn xem danh mục nào ạ?', 1, '2026-04-13 12:18:04'),
(233, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi có thể mua làm quà tặng được không', 1, '2026-04-13 12:39:40'),
(234, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ tuyệt vời quá! Nếu bạn đặt để tặng người thân, bạn hãy thanh toán Chuyển khoản trước, sau đó ghi chú vào đơn hàng: *\"Đơn quà tặng, vui lòng không in biên lai có giá tiền\"*. Shop sẽ đóng gói thật đẹp và gửi đi như một món quà bất ngờ giúp bạn nhé!', 1, '2026-04-13 12:39:40'),
(235, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Chính sách bảo hành', 1, '2026-04-13 12:47:09'),
(236, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, các sản phẩm điện gia dụng tại shop đều được bảo hành chính hãng từ 12 - 24 tháng. Bạn chỉ cần giữ lại hóa đơn hoặc cung cấp SĐT đặt hàng là được ạ.', 1, '2026-04-13 12:47:09'),
(237, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'xin địa chỉ shop', 1, '2026-04-13 12:47:32'),
(238, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, COZY CORNER hiện có địa chỉ tại:\n- **Cửa hàng:** Hoàng Hoa Thám, P. 7, Q. Bình Thạnh, TP. Hồ Chí Minh\n- **Hotline:** 0888 888 888\n- **Email:** Cozy@cv.com.vn', 1, '2026-04-13 12:47:32'),
(239, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'Giờ tôi đặt thì bao lâu nhận được hàng', 1, '2026-04-13 12:59:51'),
(240, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, shop giao hàng toàn quốc qua đối tác Giao Hàng Nhanh (GHN):\n- **Thời gian:** 1-2 ngày (Nội thành HCM), 3-5 ngày (Tỉnh thành khác).\n- **Phí ship:** Được tính tự động tại trang thanh toán. Đừng quên săn mã Freeship của shop nhé!', 1, '2026-04-13 12:59:51'),
(241, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi lỡ quên thanh toán rồi giờ làm sao', 1, '2026-04-13 13:00:03'),
(242, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, shop hiện hỗ trợ các hình thức:\n- Nhận hàng thanh toán tiền mặt (COD).\n- Chuyển khoản ngân hàng (Quét mã QR tự động qua SePay).', 1, '2026-04-13 13:00:03'),
(243, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi chuyền thừa tiền rồi thì làm sao', 1, '2026-04-13 13:01:08'),
(244, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, nếu bạn lỡ chuyển khoản dư số tiền so với giá trị cần thanh toán, đừng lo lắng nhé! Bạn hãy nhắn ngay biên lai cho Zalo Hotline, kế toán bên shop sẽ đối soát và hoàn lại phần tiền thừa cho bạn ngay trong ngày làm việc ạ.', 1, '2026-04-13 13:01:08'),
(245, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'tôi lỡ boom hàng rồi có sao không', 1, '2026-04-13 13:01:17'),
(246, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, nếu thay đổi ý định, mong bạn tự hủy trên website trước khi shop đóng gói. Nếu hàng đã đến nơi mà bạn từ chối nhận (không do lỗi sản phẩm), hệ thống sẽ ghi nhận lịch sử giao hàng thất bại, và tài khoản của bạn có thể bị hạn chế tính năng thanh toán COD cho các lần mua sau ạ.', 1, '2026-04-13 13:01:17'),
(247, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'user', 'bạn có người iu chưa', 1, '2026-04-13 13:01:33'),
(248, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', 'bot', 'Dạ, em là trợ lý AI của Cozy Corner nên không có người yêu đâu ạ! Em chỉ ở đây để giúp bạn giải đáp các thắc mắc về sản phẩm và dịch vụ của Cozy Corner thôi ạ. 😊\n\nBạn có cần em hỗ trợ gì khác về các sản phẩm của shop không ạ?', 1, '2026-04-13 13:01:33');

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
('::1', '2026-03-31', 11, 1774963243),
('::1', '2026-04-13', 2, 1776081515);

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
(2, 1, 'Mẹo Bảo Quản Dụng Cụ Nhà Bếp Hiệu Quả', 'm-o-b-o-qu-n-d-ng-c-nh-b-p-hi-u-qu--1774693302', 'Gian bếp là nơi lưu giữ những bữa cơm ấm cúng, là không gian gắn kết yêu thương trong mỗi gia đình Việt. Nhưng sau những phút giây nấu nướng, nếu không biết cách bảo quản, dụng cụ nhà bếp dễ xuống cấp, kém vệ sinh và nhanh hỏng.\r\n\r\nĐể căn bếp luôn sạch đẹp, đồ dùng luôn bền như mới, dưới đây là những mẹo đơn giản mà người nội trợ nào cũng nên biết:\r\n\r\n1. Lau khô hoàn toàn sau khi rửa\r\nĐừng để các dụng cụ ướt tự khô trong không khí. Đặc biệt với dụng cụ inox, gỗ, chống dính – nếu còn đọng nước, chúng rất dễ bị ố màu, hoen gỉ, nứt nẻ hoặc bong lớp phủ.\r\n👉 Sau khi rửa, hãy dùng khăn mềm lau khô và để ở nơi thoáng khí trước khi cất đi.\r\n\r\n2. Không ngâm đồ gỗ hoặc dao quá lâu trong nước\r\nNgâm lâu khiến gỗ hút nước, nhanh mục và biến dạng, còn dao thì nhanh cùn, dễ gỉ lưỡi. Với các vật dụng này, hãy rửa ngay sau khi dùng, lau khô kỹ và cất đúng nơi quy định.\r\n\r\n3. Cất đồ đúng cách – tránh trầy xước, va đập\r\nXếp chồng chéo chảo chống dính hoặc nồi inox có thể khiến bề mặt bị trầy xước, bong lớp chống dính. Hãy lót khăn mỏng, vải nỉ hoặc sử dụng giá treo riêng biệt để bảo vệ sản phẩm tốt hơn.\r\n\r\n4. Làm sạch định kỳ các thiết bị điện nhỏ\r\nMáy xay, máy ép, nồi chiên… nếu không được làm sạch thường xuyên có thể tích tụ cặn bẩn, dầu mỡ và gây mùi khó chịu.\r\n👉 Hãy tháo rời và vệ sinh đúng cách sau mỗi lần sử dụng, đồng thời kiểm tra các chi tiết như gioăng, nắp, khe thoát hơi để đảm bảo thiết bị vận hành ổn định.\r\n\r\n5. Ưu tiên sản phẩm chất lượng – dễ vệ sinh, an toàn\r\nĐầu tư ban đầu vào dụng cụ nhà bếp đạt chuẩn Châu Âu, dễ làm sạch, chống oxy hóa tốt và an toàn cho sức khỏe sẽ giúp tiết kiệm lâu dài về sau.\r\nVà đừng quên, Elmich luôn đồng hành cùng bạn với các sản phẩm nhà bếp bền đẹp, tiện dụng, đạt chuẩn Châu Âu.\r\n\r\nMột căn bếp sạch là khởi nguồn của những bữa ăn ngon – Một dụng cụ bền là người bạn đồng hành tin cậy trong mỗi lần vào bếp.\r\nHãy bắt đầu từ những điều nhỏ nhất để gian bếp luôn là nơi truyền cảm hứng mỗi ngày.', 'Mẹo vặt', '1774693302_news_img-tintuc1.png', 6, 'HienThi', '2026-03-28 10:21:42'),
(3, 1, 'Top 5 Sản Phẩm Gia Dụng Không Thể Thiếu Cho Mỗi Gia Đình', 'top-5-s-n-ph-m-gia-d-ng-kh-ng-th-thi-u-cho-m-i-gia-nh-1774693687', 'Trong bối cảnh cuộc sống hiện đại ngày càng bận rộn, các sản phẩm gia dụng đóng vai trò quan trọng trong việc tối ưu hóa thời gian và nâng cao chất lượng sinh hoạt. Thực tế cho thấy, nhu cầu sử dụng đồ gia dụng tại Việt Nam ngày càng đa dạng với nhiều nhóm sản phẩm phục vụ từ nấu nướng, bảo quản thực phẩm đến chăm sóc sức khỏe gia đình .\r\n\r\nDưới đây là những sản phẩm thiết yếu mà hầu hết các gia đình nên trang bị để đảm bảo sự tiện nghi và hiệu quả trong sinh hoạt hàng ngày.\r\n\r\n1. Nồi chiên không dầu\r\n\r\nNồi chiên không dầu là một trong những thiết bị nhà bếp phổ biến nhất hiện nay nhờ khả năng chế biến thực phẩm với lượng dầu tối thiểu. Thiết bị này giúp giảm chất béo trong món ăn, đồng thời vẫn giữ được hương vị và độ giòn cần thiết.\r\n\r\nNgoài chức năng chiên, nhiều dòng sản phẩm còn tích hợp nướng, sấy hoặc hâm nóng, đáp ứng đa dạng nhu cầu nấu ăn trong gia đình.\r\n\r\n2. Máy xay sinh tố\r\n\r\nMáy xay sinh tố là thiết bị hỗ trợ chế biến thực phẩm nhanh chóng, đặc biệt phù hợp với nhu cầu bổ sung dinh dưỡng hằng ngày. Từ sinh tố, nước ép đến cháo hoặc súp, thiết bị này giúp tiết kiệm đáng kể thời gian chuẩn bị.\r\n\r\nĐây cũng là sản phẩm gần như không thể thiếu trong các gia đình có trẻ nhỏ hoặc người cao tuổi.\r\n\r\n3. Bộ nồi chảo chống dính\r\n\r\nBộ nồi chảo chất lượng cao giúp việc nấu ăn trở nên thuận tiện hơn, hạn chế tình trạng thức ăn bám dính và dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nHiện nay, các sản phẩm nồi chảo được sản xuất với nhiều chất liệu như inox, nhôm phủ chống dính hoặc hợp kim cao cấp, đáp ứng nhu cầu đa dạng của người tiêu dùng. Những sản phẩm này không chỉ phục vụ nấu nướng mà còn góp phần nâng cao trải nghiệm bếp núc hàng ngày.\r\n\r\n4. Ấm siêu tốc\r\n\r\nẤm siêu tốc là thiết bị quen thuộc trong hầu hết các gia đình nhờ khả năng đun nước nhanh chóng và tiện lợi. Chỉ trong vài phút, người dùng có thể chuẩn bị nước nóng để pha trà, cà phê hoặc phục vụ các nhu cầu sinh hoạt khác.\r\n\r\nVới thiết kế ngày càng cải tiến về độ an toàn và tiết kiệm điện, ấm siêu tốc trở thành một trong những thiết bị thiết yếu trong không gian bếp hiện đại.\r\n\r\n5. Hộp đựng thực phẩm\r\n\r\nHộp đựng thực phẩm đóng vai trò quan trọng trong việc bảo quản thức ăn và giữ vệ sinh cho tủ lạnh. Các sản phẩm hiện nay thường được thiết kế kín khí, giúp hạn chế mùi và ngăn vi khuẩn phát triển.\r\n\r\nTheo xu hướng tiêu dùng, các loại hộp bảo quản thực phẩm đang ngày càng được ưa chuộng nhờ tính tiện lợi và khả năng sử dụng trong nhiều môi trường như tủ lạnh hoặc lò vi sóng .\r\n\r\nKết luận\r\n\r\nViệc lựa chọn và trang bị các sản phẩm gia dụng phù hợp không chỉ giúp tối ưu hóa công việc nội trợ mà còn góp phần nâng cao chất lượng cuộc sống. Trong bối cảnh thị trường gia dụng ngày càng phong phú với nhiều mẫu mã và phân khúc khác nhau , người tiêu dùng nên ưu tiên những sản phẩm có chất lượng tốt, an toàn và đáp ứng đúng nhu cầu sử dụng lâu dài.\r\n\r\nMột không gian bếp tiện nghi, được trang bị đầy đủ những thiết bị cần thiết sẽ là nền tảng cho những bữa ăn trọn vẹn và sự gắn kết trong mỗi gia đình.', 'Sản phẩm', '1774693687_news_img-tintuc2.png', 6, 'HienThi', '2026-03-28 10:28:07'),
(4, 1, 'Công Nghệ Hiện Đại Trong Thiết Bị Nhà Bếp', 'c-ng-ngh-hi-n-i-trong-thi-t-b-nh-b-p-1774693942', 'Sự phát triển của công nghệ đang làm thay đổi đáng kể thói quen nấu nướng và sinh hoạt trong gia đình. Nếu như trước đây, các thiết bị nhà bếp chỉ dừng lại ở chức năng cơ bản, thì ngày nay, nhiều sản phẩm đã được tích hợp công nghệ hiện đại nhằm tối ưu hiệu suất, tiết kiệm thời gian và nâng cao trải nghiệm người dùng.\r\n\r\nNhững cải tiến này không chỉ giúp việc nội trợ trở nên đơn giản hơn mà còn góp phần xây dựng một không gian bếp tiện nghi, thông minh và an toàn.\r\n\r\n1.Thiết bị nhà bếp thông minh kết nối IoT\r\n\r\nMột trong những xu hướng nổi bật là sự xuất hiện của các thiết bị nhà bếp thông minh có khả năng kết nối Internet (IoT). Người dùng có thể điều khiển nồi cơm điện, lò nướng hoặc máy pha cà phê từ xa thông qua điện thoại di động.\r\n\r\nViệc theo dõi và điều chỉnh quá trình nấu nướng theo thời gian thực giúp hạn chế rủi ro và đảm bảo món ăn đạt chất lượng ổn định. Đây là bước tiến quan trọng trong việc tự động hóa không gian bếp hiện đại.\r\n\r\n2.Công nghệ tiết kiệm năng lượng\r\n\r\nCác thiết bị gia dụng ngày nay được chú trọng cải tiến nhằm giảm thiểu mức tiêu thụ điện năng. Công nghệ inverter, cảm biến nhiệt thông minh hay chế độ tự ngắt khi không sử dụng giúp tiết kiệm chi phí điện và tăng độ bền cho sản phẩm.\r\n\r\nKhông chỉ mang lại lợi ích kinh tế, xu hướng này còn phù hợp với định hướng sử dụng năng lượng bền vững và thân thiện với môi trường.\r\n\r\n3.Vật liệu cao cấp và an toàn cho sức khỏe\r\n\r\nSự đổi mới không chỉ nằm ở công nghệ mà còn ở chất liệu sản phẩm. Nhiều thiết bị nhà bếp hiện nay sử dụng inox cao cấp, hợp kim nhôm phủ chống dính an toàn hoặc nhựa không chứa BPA.\r\n\r\nCác vật liệu này giúp hạn chế phản ứng hóa học trong quá trình nấu nướng, đồng thời tăng khả năng chịu nhiệt và kéo dài tuổi thọ sản phẩm.\r\n\r\n4.Tích hợp đa chức năng\r\n\r\nXu hướng tích hợp nhiều chức năng trong một thiết bị đang ngày càng phổ biến. Một chiếc nồi chiên không dầu có thể kết hợp chiên, nướng, sấy; hay máy xay đa năng có thể xay thực phẩm, ép trái cây và nghiền đá.\r\n\r\nĐiều này giúp tiết kiệm không gian bếp và giảm chi phí đầu tư cho nhiều thiết bị riêng lẻ.\r\n\r\n5.Tối ưu trải nghiệm người dùng\r\n\r\nCác nhà sản xuất ngày càng chú trọng đến thiết kế và trải nghiệm sử dụng. Bảng điều khiển cảm ứng, màn hình hiển thị rõ ràng, chế độ cài đặt sẵn và hệ thống cảnh báo an toàn giúp người dùng dễ dàng thao tác, kể cả với những người ít kinh nghiệm nấu ăn.\r\n\r\nNgoài ra, yếu tố thẩm mỹ cũng được nâng cao, góp phần tạo nên không gian bếp hiện đại và hài hòa hơn.\r\n\r\nKết luận\r\n\r\nCông nghệ hiện đại đang từng bước thay đổi cách con người tiếp cận việc nấu nướng và quản lý không gian bếp. Việc lựa chọn các thiết bị gia dụng tích hợp công nghệ tiên tiến không chỉ mang lại sự tiện lợi mà còn góp phần nâng cao chất lượng cuộc sống.\r\n\r\nTrong bối cảnh thị trường ngày càng đa dạng, người tiêu dùng cần cân nhắc kỹ về nhu cầu sử dụng, tính năng và độ an toàn để đưa ra lựa chọn phù hợp. Một gian bếp được trang bị đúng cách sẽ không chỉ phục vụ tốt cho sinh hoạt hàng ngày mà còn trở thành không gian truyền cảm hứng cho mỗi gia đình.', 'Thiết bị', '1774693942_news_img-tintuc3.png', 5, 'HienThi', '2026-03-28 10:32:22'),
(5, 1, 'Làm Sao Để Chọn Dụng Cụ Bếp An Toàn Cho Sức Khỏe', 'l-m-sao-ch-n-d-ng-c-b-p-an-to-n-cho-s-c-kh-e-1774694160', 'Dụng cụ nhà bếp là những vật dụng tiếp xúc trực tiếp với thực phẩm mỗi ngày, vì vậy yếu tố an toàn luôn được đặt lên hàng đầu. Tuy nhiên, trên thị trường hiện nay có rất nhiều sản phẩm với chất liệu và mức giá khác nhau, khiến người tiêu dùng gặp khó khăn trong việc lựa chọn.\r\n\r\nViệc trang bị đúng dụng cụ bếp không chỉ giúp nâng cao hiệu quả nấu nướng mà còn góp phần bảo vệ sức khỏe cho cả gia đình trong thời gian dài.\r\n\r\n1. Ưu tiên chất liệu an toàn\r\n\r\nChất liệu là yếu tố quan trọng nhất khi lựa chọn dụng cụ nhà bếp. Các sản phẩm làm từ inox 304, thủy tinh chịu nhiệt, gốm sứ cao cấp hoặc nhựa an toàn không chứa BPA thường được đánh giá cao về độ an toàn.\r\n\r\nNgược lại, các sản phẩm kém chất lượng có thể chứa tạp chất hoặc giải phóng chất độc hại khi tiếp xúc với nhiệt độ cao, ảnh hưởng trực tiếp đến sức khỏe người sử dụng.\r\n\r\n2. Lựa chọn sản phẩm có nguồn gốc rõ ràng\r\n\r\nNgười tiêu dùng nên ưu tiên các sản phẩm có thương hiệu, xuất xứ minh bạch và đạt các tiêu chuẩn an toàn. Những sản phẩm này thường được kiểm định chất lượng trước khi đưa ra thị trường, đảm bảo an toàn khi sử dụng lâu dài.\r\n\r\nTránh mua các sản phẩm trôi nổi, không nhãn mác hoặc có giá quá rẻ so với mặt bằng chung, vì tiềm ẩn nhiều rủi ro.\r\n\r\n3. Chú ý đến khả năng chịu nhiệt và độ bền\r\n\r\nDụng cụ nhà bếp cần có khả năng chịu nhiệt tốt và không bị biến dạng trong quá trình sử dụng. Đặc biệt, với các sản phẩm như nồi, chảo hoặc hộp đựng thực phẩm, khả năng chịu nhiệt sẽ quyết định độ an toàn khi nấu nướng.\r\n\r\nNgoài ra, sản phẩm có độ bền cao sẽ hạn chế tình trạng bong tróc lớp phủ hoặc nứt vỡ, từ đó giảm nguy cơ ảnh hưởng đến thực phẩm.\r\n\r\n4. Dễ vệ sinh và bảo quản\r\n\r\nMột tiêu chí quan trọng khác là khả năng vệ sinh sau khi sử dụng. Dụng cụ bếp dễ làm sạch sẽ giúp hạn chế vi khuẩn tích tụ, đảm bảo an toàn vệ sinh thực phẩm.\r\n\r\nNgười dùng nên lựa chọn các sản phẩm có bề mặt trơn, ít bám bẩn và thiết kế thuận tiện cho việc lau rửa cũng như bảo quản.\r\n\r\nKết luận\r\n\r\nLựa chọn dụng cụ bếp an toàn không chỉ là vấn đề tiện ích mà còn liên quan trực tiếp đến sức khỏe của cả gia đình. Việc ưu tiên chất liệu tốt, nguồn gốc rõ ràng và tính năng phù hợp sẽ giúp người tiêu dùng yên tâm hơn trong quá trình sử dụng.\r\n\r\nMột gian bếp an toàn, sạch sẽ chính là nền tảng quan trọng để tạo nên những bữa ăn chất lượng và cuộc sống bền vững.', 'Sức khỏe', '1774694160_news_img-tintuc4.png', 12, 'HienThi', '2026-03-28 10:36:00'),
(6, 1, 'Mẹo Vệ Sinh Nhà Bếp Nhanh Chóng Và Hiệu Quả', 'm-o-v-sinh-nh-b-p-nhanh-ch-ng-v-hi-u-qu-1774695243', 'Trong quá trình nấu nướng hàng ngày, nhà bếp là khu vực dễ tích tụ dầu mỡ, vi khuẩn và mùi thực phẩm. Nếu không được vệ sinh đúng cách, không gian bếp không chỉ mất thẩm mỹ mà còn ảnh hưởng trực tiếp đến sức khỏe của các thành viên trong gia đình.\r\n\r\nViệc duy trì thói quen vệ sinh khoa học sẽ giúp không gian bếp luôn sạch sẽ, an toàn và tạo cảm hứng trong quá trình sử dụng.\r\n\r\n1. Vệ sinh ngay sau khi nấu ăn\r\n\r\nSau mỗi lần chế biến, nên lau sạch bề mặt bếp, bàn và khu vực xung quanh để tránh dầu mỡ bám lâu ngày. Việc làm sạch ngay từ đầu giúp hạn chế vết bẩn cứng đầu và tiết kiệm thời gian dọn dẹp.\r\n\r\n2. Sử dụng nguyên liệu làm sạch an toàn\r\n\r\nCác nguyên liệu tự nhiên như giấm, chanh hoặc baking soda có khả năng làm sạch hiệu quả mà vẫn đảm bảo an toàn. Đây là giải pháp phù hợp để khử mùi và loại bỏ dầu mỡ trong không gian bếp.\r\n\r\n3. Làm sạch định kỳ các thiết bị\r\n\r\nCác thiết bị như bếp nấu, lò vi sóng, máy hút mùi hoặc tủ lạnh cần được vệ sinh định kỳ để đảm bảo hoạt động ổn định. Việc tích tụ cặn bẩn lâu ngày có thể làm giảm hiệu suất và gây mùi khó chịu.\r\n\r\n4. Giữ không gian bếp khô ráo và gọn gàng\r\n\r\nĐộ ẩm cao là điều kiện thuận lợi cho vi khuẩn phát triển. Vì vậy, cần đảm bảo khu vực bếp luôn thông thoáng, sạch sẽ và được sắp xếp hợp lý để dễ dàng vệ sinh.\r\n\r\nKết luận\r\n\r\nVệ sinh nhà bếp không chỉ là công việc hàng ngày mà còn là yếu tố quan trọng giúp bảo vệ sức khỏe gia đình và duy trì không gian sống sạch đẹp. Áp dụng những mẹo đơn giản nhưng hiệu quả sẽ giúp bạn tiết kiệm thời gian và công sức trong quá trình dọn dẹp.\r\n\r\nMột căn bếp sạch sẽ, gọn gàng sẽ luôn là nền tảng cho những bữa ăn ngon và cuộc sống chất lượng hơn.', 'Mẹo vặt', '1774695243_news_dọn-vệ-sinh-nhà-bếp.jpg', 37, 'HienThi', '2026-03-28 10:54:03'),
(7, 1, 'Cách Bảo Quản Dụng Cụ Nhà Bếp Để Sử Dụng Được Dài Lâu', 'c-ch-b-o-qu-n-d-ng-c-nh-b-p-s-d-ng-c-d-i-l-u-1774695344', 'Bên cạnh việc lựa chọn sản phẩm chất lượng, cách bảo quản dụng cụ nhà bếp đóng vai trò quan trọng trong việc duy trì độ bền và hiệu quả sử dụng. Thực tế cho thấy, nhiều thiết bị nhanh hư hỏng không phải do chất lượng kém mà xuất phát từ việc sử dụng và bảo quản chưa đúng cách.\r\n\r\nViệc bảo quản khoa học không chỉ giúp kéo dài tuổi thọ sản phẩm mà còn đảm bảo an toàn trong quá trình sử dụng lâu dài.\r\n\r\n1. Lau khô trước khi cất giữ\r\n\r\nSau khi rửa, các dụng cụ cần được lau khô hoàn toàn trước khi cất vào tủ. Độ ẩm còn lại có thể gây hoen gỉ hoặc ẩm mốc, đặc biệt với các vật dụng bằng kim loại và gỗ.\r\n\r\n2. Tránh xếp chồng gây trầy xước\r\n\r\nCác dụng cụ như nồi, chảo chống dính không nên xếp chồng trực tiếp lên nhau. Điều này có thể làm trầy bề mặt và ảnh hưởng đến chất lượng sử dụng.\r\n\r\n3. Bảo quản đúng vị trí\r\n\r\nMỗi loại dụng cụ nên được đặt ở vị trí phù hợp để tránh va đập hoặc hư hỏng. Dao nên để trong giá riêng, các thiết bị điện nên đặt nơi khô ráo và tránh tiếp xúc với nước.\r\n\r\n4. Kiểm tra và thay thế định kỳ\r\n\r\nTrong quá trình sử dụng, nếu phát hiện sản phẩm có dấu hiệu hư hỏng như bong tróc, nứt vỡ hoặc biến dạng, nên thay thế kịp thời để đảm bảo an toàn.\r\n\r\nKết luận\r\n\r\nBảo quản dụng cụ nhà bếp đúng cách là yếu tố quan trọng giúp duy trì chất lượng và hiệu quả sử dụng lâu dài. Những thói quen nhỏ trong quá trình sử dụng hàng ngày có thể tạo ra sự khác biệt lớn về độ bền của sản phẩm.\r\n\r\nMột không gian bếp được chăm sóc đúng cách không chỉ giúp tiết kiệm chi phí mà còn mang lại sự tiện nghi và an toàn cho cuộc sống gia đình.', 'Mẹo vặt', '1774695344_news_cach-cat-giu-dung-cu-nha-bep-ben-dep-su-dung-lau-de-dang-don-avt-1200x676.jpg', 8, 'HienThi', '2026-03-28 10:55:44');

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
(41, 5, 'LTR89R', 97600.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '123, Xã Vinh Thanh, Huyện Phú Vang, Thừa Thiên Huế', 'Huy', 'COD', '', '2026-04-03 12:41:34', 1900, 'TET', 2000),
(42, 5, 'LTMPV9', 105700.00, 71500.00, 'Đào Công Anh Minh', '0911078383', '123, Xã Văn Môn, Huyện Yên Phong, Bắc Ninh', 'Huy', 'ChuyenKhoan', '', '2026-04-05 09:33:13', 3800, '', 0),
(43, 5, 'LTMPBC', 91500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '1, Thị trấn Mường Khương, Huyện Mường Khương, Lào Cai', 'Huy', 'ChuyenKhoan', '', '2026-04-05 09:45:20', 1000, '', 0),
(44, 5, 'LTE7HR', 91500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '12, Xã Bản Lầu, Huyện Mường Khương, Lào Cai', 'Huy', 'ChuyenKhoan', '', '2026-04-07 03:23:55', 1000, '', 0),
(45, 5, 'LTEGVU', 58500.00, 49500.00, 'Đào Công Anh Minh', '0911078383', '1, Xã Vị Trung, Huyện Vị Thuỷ, Hậu Giang', 'Huy', 'ChuyenKhoan', '', '2026-04-07 04:07:30', 1000, '', 0),
(46, 5, 'LTEGVC', 69500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', '1, Xã Lâm Hải, Huyện Năm Căn, Cà Mau', 'Huy', 'ChuyenKhoan', '', '2026-04-07 04:08:10', 1000, '', 0),
(47, 5, 'LTEGNL', 91500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '1, Xã Thanh Bình, Huyện Mường Khương, Lào Cai', 'Huy', 'ChuyenKhoan', '', '2026-04-07 04:10:48', 1000, '', 0),
(48, 5, 'LTEGNF', 69500.00, 60500.00, 'Đào Công Anh Minh', '0911078383', '1, Phường Thịnh Lang, Thành phố Hòa Bình, Hòa Bình', 'Huy', 'ChuyenKhoan', '', '2026-04-07 04:12:13', 1000, '', 0),
(49, 5, 'LTE6QR', 91500.00, 82500.00, 'Đào Công Anh Minh', '0911078383', '1, Xã Hợp Thịnh, Huyện Hiệp Hòa, Bắc Giang', 'ChoXacNhan', 'COD', '', '2026-04-07 09:22:56', 1000, '', 0),
(50, 5, 'LTE6LV', 80500.00, 71500.00, 'Đào Công Anh Minh', '0911078383', '12, Xã Đồng Ruộng, Huyện Đà Bắc, Hòa Bình', 'HoanThanh', 'COD', '', '2026-04-07 09:23:20', 1000, '', 0),
(51, 5, 'LTE6UQ', 49700.00, 31900.00, 'Đào Công Anh Minh', '0911078383', '12, Phường Đông Hưng Thuận, Quận 12, Hồ Chí Minh', 'Huy', 'ChuyenKhoan', '', '2026-04-07 09:33:37', 2200, 'TET', 2000),
(52, 5, 'LHFF6B', 97600.00, 71500.00, 'Đào Công Anh Minh', '0911078383', '1, Xã Đông Phong, Huyện Yên Phong, Bắc Ninh', 'ChoXacNhan', 'COD', '', '2026-04-13 14:57:15', 2900, '', 0);

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
(41, 41, 75, 'Thớt gỗ đa dụng', NULL, 1, 19000.00),
(42, 42, 75, 'Thớt gỗ đa dụng', NULL, 2, 19000.00),
(43, 43, 36, 'Dao  Nigara Anmon', NULL, 1, 10000.00),
(44, 44, 36, 'Dao  Nigara Anmon', NULL, 1, 10000.00),
(45, 45, 36, 'Dao  Nigara Anmon', NULL, 1, 10000.00),
(46, 46, 37, 'Dao  Shigekatsu ', NULL, 1, 10000.00),
(47, 47, 37, 'Dao  Shigekatsu ', NULL, 1, 10000.00),
(48, 48, 36, 'Dao  Nigara Anmon', NULL, 1, 10000.00),
(49, 49, 72, 'Thớt gỗ', NULL, 1, 10000.00),
(50, 50, 66, 'Bát Kuromi', NULL, 1, 10000.00),
(51, 51, 69, 'Bát Shin', NULL, 1, 12000.00),
(52, 51, 70, 'Bát dễ thương', NULL, 1, 10000.00),
(53, 52, 75, 'Thớt gỗ đa dụng', NULL, 1, 19000.00),
(54, 52, 74, 'Thớt nhựa ', NULL, 1, 10000.00);

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
(36, 'Dao  Nigara Anmon', 'dao-nigara-anmon', 10000.00, 15000.00, 'Dao Nigara Anmon nổi bật với thiết kế cao cấp và độ hoàn thiện tinh xảo, phù hợp cho nhu cầu sử dụng chuyên sâu.\r\n\r\nLưỡi dao sắc bén, bền bỉ giúp xử lý thực phẩm nhanh chóng và chính xác. Sản phẩm không chỉ mang lại hiệu quả sử dụng mà còn tạo điểm nhấn thẩm mỹ cho gian bếp.\r\n\r\nĐây là lựa chọn dành cho người dùng yêu cầu cao về chất lượng và trải nghiệm.', '1773829903_dao1.jpg', 13, 200, 7, 13, 'HienThi', '2026-03-18 10:31:43'),
(37, 'Dao  Shigekatsu ', 'dao-shigekatsu-', 10000.00, 20000.00, 'Dao Shigekatsu là sản phẩm chất lượng cao, mang lại trải nghiệm cắt thái chính xác và hiệu quả.\r\n\r\nLưỡi dao được gia công tỉ mỉ giúp duy trì độ sắc lâu dài. Thiết kế chắc chắn, cân đối giúp người dùng thao tác dễ dàng và an toàn hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự chuyên nghiệp trong nấu nướng.', '1773829999_dao2.jpg', 13, 200, 16, 9, 'HienThi', '2026-03-18 10:33:19'),
(38, 'Dao  Kagahaki', 'dao-kagahaki', 14999.00, 25000.00, 'Dao Kagahaki được thiết kế tinh tế, đáp ứng tốt nhu cầu chế biến thực phẩm hàng ngày.\r\n\r\nLưỡi dao sắc giúp cắt thái nhanh chóng, hạn chế dập nát thực phẩm. Chất liệu bền bỉ giúp sản phẩm sử dụng lâu dài mà vẫn giữ được hiệu quả.\r\n\r\nĐây là lựa chọn phù hợp cho gian bếp gia đình.', '1773830055_dao3.jpg', 13, 200, 100, 0, 'HienThi', '2026-03-18 10:34:15'),
(39, 'Dao  Hamatogi', 'dao-hamatogi', 12000.00, 15000.00, 'Dao Hamatogi mang phong cách hiện đại, phù hợp với nhiều nhu cầu sử dụng khác nhau trong nhà bếp.\r\n\r\nLưỡi dao sắc bén giúp cắt thái nhanh gọn, trong khi tay cầm chắc chắn tạo cảm giác thoải mái khi sử dụng. Sản phẩm có độ bền cao và dễ vệ sinh.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng yêu thích sự tiện dụng.', '1773830130_dao4.jpg', 13, 200, 30, 0, 'HienThi', '2026-03-18 10:35:30'),
(40, 'Dao chặt xương Nhật', 'dao-ch-t-x-ng-nh-t', 19999.00, 30000.00, 'Dao chặt xương Nhật là dụng cụ chuyên dụng với độ bền cao, phù hợp cho việc chặt thực phẩm cứng.\r\n\r\nLưỡi dao dày và chắc giúp xử lý xương hoặc thực phẩm cứng một cách dễ dàng. Thiết kế cân đối giúp giảm lực khi sử dụng và tăng độ an toàn.\r\n\r\nĐây là lựa chọn cần thiết cho gian bếp chuyên nghiệp và gia đình.', '1773830219_dao5.jpg', 13, 200, 10, 0, 'HienThi', '2026-03-18 10:36:59'),
(41, 'Dao thái sashimi', 'dao-th-i-sashimi', 13000.00, 15000.00, 'Dao thái sashimi được thiết kế chuyên biệt để cắt lát mỏng các loại cá sống với độ chính xác cao.\r\n\r\nLưỡi dao dài và sắc giúp tạo ra những lát cắt mịn, không làm nát thực phẩm. Chất liệu cao cấp giúp duy trì độ sắc và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là sản phẩm lý tưởng cho những ai yêu thích ẩm thực Nhật Bản.', '1773830270_dao6.jpg', 13, 200, 40, 0, 'HienThi', '2026-03-18 10:37:50'),
(42, 'Dao thái bản to', 'dao-th-i-b-n-to', 15000.00, 20000.00, 'Dao thái bản to là dụng cụ chuyên dụng giúp cắt thái thực phẩm nhanh chóng và hiệu quả.\r\n\r\nVới bản dao rộng và chắc chắn, sản phẩm phù hợp để thái thịt, chặt nhẹ hoặc sơ chế thực phẩm số lượng lớn. Thiết kế cân đối giúp thao tác ổn định và chính xác hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai thường xuyên nấu ăn và cần sự tiện lợi.', '1773830388_dao7.jpg', 13, 200, 80, 0, 'HienThi', '2026-03-18 10:39:48'),
(43, 'Dao  Shinzu', 'dao-shinzu', 10000.00, 25000.00, 'Dao Shinzu nổi bật với thiết kế tinh tế và khả năng cắt thái linh hoạt trong gian bếp.\r\n\r\nLưỡi dao được gia công sắc bén, giúp xử lý nhiều loại thực phẩm từ rau củ đến thịt cá một cách dễ dàng. Tay cầm chắc chắn giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là sản phẩm không thể thiếu cho công việc nấu nướng hàng ngày.', '1773830466_dao8.jpg', 13, 200, 100, 0, 'HienThi', '2026-03-18 10:41:06'),
(44, 'Dao Kagenkio', 'dao-kagenkio', 10000.00, 15000.00, 'Dao Kagenkio là sản phẩm được thiết kế chuyên dụng cho việc cắt thái thực phẩm với độ chính xác cao.\r\n\r\nLưỡi dao sắc bén giúp thao tác nhanh gọn, hạn chế dập nát thực phẩm. Chất liệu bền chắc giúp duy trì độ sắc lâu dài và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho cả người nội trợ và người yêu thích nấu ăn chuyên nghiệp.', '1773903954_dao9.jpg', 13, 200, 17, 0, 'HienThi', '2026-03-18 10:42:54'),
(45, 'Nồi cơm điện RC86', 'n-i-c-m-i-n-rc86', 20000.00, 30000.00, 'Nồi cơm điện  mang đến giải pháp nấu ăn hiện đại với thiết kế sang trọng và nhiều tính năng tiện ích.\r\n\r\nSản phẩm hỗ trợ nhiều chế độ nấu như cơm, cháo, hấp… giúp đáp ứng đa dạng nhu cầu sử dụng. Lòng nồi bền bỉ, truyền nhiệt tốt giúp cơm chín nhanh và ngon hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai muốn nâng cấp trải nghiệm nấu ăn trong gia đình.', '1776077238_RC86-vuong-13_196c6df6-17ad-4ba7-9333-4e9d8239d787.jpg', 9, 200, 100, 0, 'HienThi', '2026-03-18 10:51:42'),
(46, 'Nồi cơm điện chống dính', 'n-i-c-m-i-n-ch-ng-d-nh', 10000.00, 25000.00, 'Nồi cơm điện chống dính là thiết bị quen thuộc trong mỗi gia đình, giúp nấu cơm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm được trang bị lòng nồi phủ chống dính, giúp cơm không bị bám dính và dễ dàng vệ sinh sau khi sử dụng. Công nghệ gia nhiệt ổn định giúp cơm chín đều, giữ được độ dẻo và hương vị tự nhiên.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần sự tiện lợi và tiết kiệm thời gian trong nấu nướng.', '1776077190_1-noi-com-dien-kalite-krc6012-scaled.jpg', 9, 200, 10, 0, 'HienThi', '2026-03-18 10:53:39'),
(47, 'Nồi áp suất Kalpen', 'n-i-p-su-t-kalpen', 10000.00, 15000.00, 'Nồi áp suất Kalpen giúp rút ngắn thời gian nấu nướng mà vẫn đảm bảo thực phẩm chín mềm và giữ được dinh dưỡng.\r\n\r\nSản phẩm được trang bị các chế độ an toàn cùng khả năng điều chỉnh áp suất linh hoạt. Thiết kế hiện đại giúp việc sử dụng trở nên dễ dàng hơn.\r\n\r\nĐây là thiết bị cần thiết cho những gia đình bận rộn.', '1776077136_noi-ap-suat-kalpen-p5-4.jpg', 9, 200, 25, 0, 'HienThi', '2026-03-18 10:54:52'),
(48, 'Nồi nấu chậm Kalpen', 'n-i-n-u-ch-m-kalpen', 10000.00, 20000.00, 'Nồi nấu chậm Kalpen là thiết bị giúp chế biến các món ăn như hầm, nấu cháo hoặc súp một cách dễ dàng.\r\n\r\nCông nghệ nấu chậm giúp giữ nguyên hương vị và dưỡng chất trong thực phẩm. Thiết kế tiện lợi, dễ sử dụng phù hợp với nhiều nhu cầu nấu ăn khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho những bữa ăn dinh dưỡng.', '1776077047_vn-11134207-820l4-mgpdex6g97v182.jpg', 9, 200, 15, 0, 'HienThi', '2026-03-18 10:55:41'),
(49, 'Nồi ủ chân không ', 'n-i-ch-n-kh-ng-', 20000.00, 25000.00, 'Nồi ủ chân không là thiết bị hỗ trợ nấu ăn tiết kiệm năng lượng, giữ nhiệt lâu và giúp thực phẩm chín mềm tự nhiên.\r\n\r\nSản phẩm hoạt động bằng cách giữ nhiệt sau khi đun sôi, giúp món ăn tiếp tục chín mà không cần sử dụng thêm điện hoặc gas. Điều này giúp giữ lại dưỡng chất trong thực phẩm.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên sự tiện lợi và tiết kiệm.', '1776076991_4107246ae22b5975003a2_27f4878e106847b2b5585869b17293f5_1024x1024.jpg', 9, 200, 20, 0, 'HienThi', '2026-03-18 10:57:00'),
(50, 'Bộ 3 nồi inox ', 'b-3-n-i-inox-', 20000.00, 50000.00, 'Bộ 3 nồi inox là giải pháp tiện lợi cho nhu cầu nấu nướng đa dạng trong gia đình.\r\n\r\nSản phẩm bao gồm nhiều kích thước khác nhau, phù hợp để chế biến nhiều loại món ăn. Chất liệu inox bền bỉ giúp đảm bảo an toàn và dễ vệ sinh.\r\n\r\nĐây là lựa chọn tối ưu giúp tiết kiệm chi phí và không gian.', '1776076896_sg-11134253-825zt-mlfhh8qx2l1k97.jpg', 9, 200, 100, 0, 'HienThi', '2026-03-18 10:58:38'),
(51, 'Nồi inox 304', 'n-i-inox-304', 10000.00, 12000.00, 'Nồi inox 304 được đánh giá cao nhờ chất liệu cao cấp, an toàn cho sức khỏe và độ bền vượt trội.\r\n\r\nSản phẩm có khả năng chống ăn mòn, chịu nhiệt tốt và không phản ứng với thực phẩm trong quá trình nấu. Thiết kế tiện dụng giúp việc nấu ăn trở nên dễ dàng hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho gian bếp hiện đại.', '1776076803_vn-11134207-81ztc-mledm4k0buo374..webp', 9, 200, 10, 0, 'HienThi', '2026-03-18 11:00:02'),
(52, 'Nồi lẩu inox', 'n-i-l-u-inox', 12000.00, 15000.00, 'Nồi lẩu inox là sản phẩm lý tưởng cho những bữa ăn sum họp gia đình và bạn bè.\r\n\r\nVới chất liệu inox bền chắc, nồi có khả năng giữ nhiệt tốt và phân bổ nhiệt đều. Thiết kế rộng rãi giúp chế biến nhiều loại thực phẩm cùng lúc.\r\n\r\nĐây là lựa chọn hoàn hảo cho những bữa ăn ấm cúng.', '1776076687_vn-11134207-7ras8-mcucofifs8yk2f.jpg', 9, 200, 2, 0, 'HienThi', '2026-03-18 11:01:44'),
(53, 'Ấm đun nước inox', '-m-un-n-c-inox', 12000.00, 15000.00, 'Ấm đun nước inox là lựa chọn truyền thống kết hợp với độ bền cao và tính an toàn.\r\n\r\nChất liệu inox giúp chống gỉ sét, chịu nhiệt tốt và dễ dàng vệ sinh. Thiết kế chắc chắn giúp sản phẩm sử dụng ổn định trong thời gian dài.\r\n\r\nĐây là sản phẩm phù hợp cho mọi gia đình.', '1776076551_vn-11134207-81ztc-mllm7hcr7r426c.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:02:52'),
(54, 'Ấm đun nước siêu tốc', '-m-un-n-c-si-u-t-c', 15000.00, 20000.00, 'Ấm đun nước siêu tốc là thiết bị quen thuộc trong mỗi gia đình, giúp đun nước nhanh chóng chỉ trong vài phút.\r\n\r\nSản phẩm được thiết kế tiện lợi, dễ sử dụng với khả năng tự ngắt khi nước sôi, đảm bảo an toàn. Chất liệu bền bỉ giúp duy trì hiệu suất sử dụng lâu dài.\r\n\r\nĐây là giải pháp tiện ích cho nhu cầu sinh hoạt hàng ngày.', '1776076437_sg-11134201-82602-mlz4q434xg5g06.jpg', 10, 200, 25, 0, 'HienThi', '2026-03-18 11:03:38'),
(55, 'Bếp từ ', 'b-p-t-', 10000.00, 15000.00, 'Bếp từ đơn Kalpen mang đến giải pháp nấu nướng hiện đại, an toàn và tiết kiệm điện năng.\r\n\r\nSản phẩm sử dụng công nghệ từ giúp làm nóng nhanh, kiểm soát nhiệt độ chính xác và hạn chế thất thoát nhiệt. Thiết kế nhỏ gọn, phù hợp với nhiều không gian bếp khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho cuộc sống tiện nghi và hiện đại.', '1776076324_vn-11134207-81ztc-mlrgec5sl0xv9e.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:04:35'),
(56, 'Máy xay đa năng', 'm-y-xay-a-n-ng', 10000.00, 15000.00, 'Máy xay sinh tố là thiết bị không thể thiếu trong gian bếp hiện đại, giúp chế biến thực phẩm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm hỗ trợ xay sinh tố, nước ép, cháo hoặc thực phẩm mềm một cách dễ dàng. Lưỡi dao sắc bén cùng công suất ổn định giúp nguyên liệu được xay nhuyễn mịn, giữ trọn dinh dưỡng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình chú trọng đến chế độ ăn uống lành mạnh.', '1776076157_10.jpeg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:05:47'),
(57, 'Máy ép chậm ', 'm-y-p-ch-m-', 10000.00, 15000.00, 'Máy ép chậm Kalpen là thiết bị hỗ trợ ép trái cây và rau củ với hiệu suất cao, giúp giữ lại tối đa dưỡng chất.\r\n\r\nCông nghệ ép chậm hạn chế sinh nhiệt, giúp nước ép giữ được màu sắc và hương vị tự nhiên. Thiết kế hiện đại, dễ vệ sinh và vận hành ổn định.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình quan tâm đến chế độ ăn uống lành mạnh và dinh dưỡng', '1776075977_jsj_550_2_d435ad7b87724f0a88dba9f9895a2908_master.jpg', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:06:25'),
(58, 'Máy vắt cam ', 'm-y-v-t-cam-', 10000.00, 15000.00, 'Máy vắt cam thông minh giúp việc chuẩn bị nước ép trở nên nhanh chóng và tiện lợi hơn.\r\n\r\nThiết kế nhỏ gọn, dễ sử dụng cùng khả năng tách nước hiệu quả giúp giữ trọn hương vị và dưỡng chất từ trái cây. Sản phẩm phù hợp cho nhu cầu sử dụng hàng ngày.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích đồ uống tươi và tốt cho sức khỏe.', '1776076036_may_ep_cam.png', 10, 200, 10, 0, 'HienThi', '2026-03-18 11:07:10'),
(59, 'Nồi chiên không dầu ', 'n-i-chi-n-kh-ng-d-u-', 10000.00, 15000.00, 'Nồi chiên không dầu là thiết bị hiện đại giúp chế biến món ăn với lượng dầu tối thiểu, phù hợp với xu hướng ăn uống lành mạnh.\r\n\r\nSản phẩm có thể chiên, nướng hoặc hâm nóng thực phẩm một cách nhanh chóng. Công nghệ làm nóng giúp thực phẩm chín đều mà vẫn giữ được độ giòn bên ngoài.\r\n\r\nĐây là thiết bị không thể thiếu trong gian bếp hiện đại.', '1776075894_vn-11134207-7ras8-mbhorg7r5bus95@resize_w900_nl.jpg', 10, 200, 15, 0, 'HienThi', '2026-03-18 11:10:13'),
(60, 'Chảo chống dính cao cấp', 'ch-o-ch-ng-d-nh-cao-c-p', 15000.00, 24000.00, 'Chảo chống dính cao cấp mang lại trải nghiệm nấu nướng tối ưu nhờ lớp phủ chống dính chất lượng cao.\r\n\r\nSản phẩm giúp giảm lượng dầu mỡ, hạn chế bám dính và dễ dàng vệ sinh. Thiết kế chắc chắn, tay cầm tiện dụng giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai muốn nâng cấp trải nghiệm nấu ăn.', '1776075808_chao-chong-dinh-kuchen-1-scaled.jpg', 7, 200, 10, 0, 'HienThi', '2026-03-18 11:11:41'),
(61, 'Chảo inox', 'ch-o-inox', 10000.00, 15000.00, 'Chảo inox là sản phẩm bền bỉ, phù hợp với nhiều nhu cầu nấu nướng khác nhau trong gia đình.\r\n\r\nVới chất liệu inox chắc chắn, chảo có khả năng chịu nhiệt tốt và ít bị biến dạng. Sản phẩm giúp phân bổ nhiệt đều, hỗ trợ quá trình nấu ăn hiệu quả hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho việc sử dụng lâu dài.', '1776075656_vn-11134207-7ras8-m1590u6yci2i45.jpg', 7, 200, 10, 0, 'HienThi', '2026-03-18 11:12:24'),
(62, 'Chảo chống dính ceramic', 'ch-o-ch-ng-d-nh-ceramic', 10000.00, 15000.00, 'Chảo chống dính ceramic được đánh giá cao nhờ lớp phủ an toàn, không chứa các chất gây hại khi nấu ở nhiệt độ cao.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, chống bám dính hiệu quả và dễ vệ sinh. Ngoài ra, thiết kế hiện đại giúp tăng tính thẩm mỹ cho không gian bếp.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng quan tâm đến sức khỏe và chất lượng bữa ăn.', '1776075596_vn-11134207-820l4-mizosyvw426cc6.jpg', 7, 200, 15, 0, 'HienThi', '2026-03-18 11:13:31'),
(63, 'Chảo chống dính', 'ch-o-ch-ng-d-nh', 15000.00, 18000.00, 'Chảo chống dính là dụng cụ không thể thiếu trong mỗi gian bếp nhờ tính tiện lợi và dễ sử dụng.\r\n\r\nLớp phủ chống dính giúp hạn chế cháy khét và giữ nguyên hương vị món ăn. Sản phẩm phù hợp với nhiều món như chiên trứng, xào rau hoặc chế biến các món ăn nhanh.\r\n\r\nĐây là lựa chọn cơ bản nhưng cần thiết cho mọi gia đình.', '1776074945_24cm_2_abe0ee9a56764e6ba338a3dfadc69dc9_master.jpg', 7, 200, 10010, 0, 'HienThi', '2026-03-18 11:13:55'),
(64, 'Chảo chống dính sâu lòng', 'ch-o-ch-ng-d-nh-s-u-l-ng', 10000.00, 15000.00, 'Chảo chống dính sâu lòng được thiết kế với lòng chảo rộng và sâu, phù hợp cho nhiều món ăn như chiên, xào hoặc nấu.\r\n\r\nLớp chống dính chất lượng giúp hạn chế thức ăn bám dính, giảm lượng dầu mỡ khi nấu và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp thao tác nấu ăn trở nên linh hoạt hơn.\r\n\r\nSản phẩm là trợ thủ đắc lực cho các bữa ăn gia đình hàng ngày.', '1776075307_chao-chong-dinh-cao-cap-kalpen-lipper-1.jpg', 7, 200, 15, 0, 'HienThi', '2026-03-18 11:14:52'),
(65, 'Chảo inox 304', 'ch-o-inox-304', 10000.00, 25000.00, 'Chảo inox 304 là sản phẩm được ưa chuộng nhờ độ bền cao và khả năng chống ăn mòn tốt. Chất liệu inox 304 giúp đảm bảo an toàn khi tiếp xúc với thực phẩm.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, phân bổ nhiệt đều giúp món ăn chín nhanh và giữ được hương vị tự nhiên. Ngoài ra, chảo dễ vệ sinh và ít bị biến dạng khi sử dụng lâu dài.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên độ bền và tính an toàn trong gian bếp.', '1776075374_5-copy.jpg', 7, 200, 16, 0, 'HienThi', '2026-03-18 11:15:51'),
(66, 'Bát Kuromi', 'b-t-kuromi', 10000.00, 16000.00, 'Bát Kuromi nổi bật với thiết kế dễ thương, lấy cảm hứng từ nhân vật hoạt hình được nhiều người yêu thích. Sản phẩm mang đến cảm giác vui tươi và sinh động cho mỗi bữa ăn.\r\n\r\nĐược làm từ chất liệu an toàn, bề mặt nhẵn mịn và dễ vệ sinh, bát phù hợp để đựng cơm, canh hoặc các món ăn hàng ngày. Kích thước vừa phải giúp người dùng dễ dàng sử dụng cho nhiều đối tượng.\r\n\r\nĐây là lựa chọn lý tưởng để tạo điểm nhấn cho bàn ăn, đặc biệt phù hợp với gia đình có trẻ nhỏ.', '1773832795_20260228_D9xP4YASJQ.jpg', 11, 200, 98, 2, 'HienThi', '2026-03-18 11:19:55'),
(67, 'Dĩa ANM', 'd-a-anm', 12000.00, 14000.00, 'Đĩa ANM có thiết kế đơn giản nhưng hiện đại, phù hợp với nhiều phong cách bàn ăn khác nhau.\r\n\r\nSản phẩm được изготов từ chất liệu bền, an toàn và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp việc bày trí món ăn trở nên gọn gàng và đẹp mắt hơn.\r\n\r\nĐây là lựa chọn phù hợp cho nhu cầu sử dụng hàng ngày trong gia đình.', '1773832834_A-211-Dia-ANM-FLO-26020091.jpg', 11, 200, 10, 0, 'HienThi', '2026-03-18 11:20:34'),
(68, 'Dĩa quả bơ', 'd-a-qu-b-', 10000.00, 15000.00, 'Đĩa quả bơ sở hữu thiết kế sáng tạo, lấy cảm hứng từ hình dáng tự nhiên, mang lại sự mới lạ cho không gian bếp.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bền chắc và dễ vệ sinh. Kích thước phù hợp giúp trình bày món ăn đẹp mắt hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự độc đáo và tinh tế.', '1773832881_A-210-Dia-ANM-26020092-1.jpg', 11, 200, 15, 0, 'HienThi', '2026-03-18 11:21:21'),
(69, 'Bát Shin', 'b-t-shin', 12000.00, 15000.00, 'Bát Shin được thiết kế với họa tiết nhân vật quen thuộc, mang lại cảm giác gần gũi và vui nhộn khi sử dụng. Đây là sản phẩm được nhiều gia đình lựa chọn, đặc biệt là cho trẻ em.\r\n\r\nChất liệu bền, an toàn cho sức khỏe, cùng thiết kế tiện dụng giúp việc sử dụng trở nên dễ dàng hơn. Bát phù hợp để đựng nhiều loại thực phẩm khác nhau.\r\n\r\nSản phẩm không chỉ hữu ích mà còn tạo điểm nhấn thú vị cho bàn ăn.', '1773832928_20260228_wzhA6Th1vM.jpg', 11, 200, 14, 1, 'HienThi', '2026-03-18 11:22:08'),
(70, 'Bát dễ thương', 'b-t-d-th-ng', 10000.00, 15000.00, 'Bát dễ thương là sản phẩm mang phong cách trẻ trung, phù hợp với nhiều không gian bếp hiện đại. Thiết kế nhỏ gọn, tiện lợi giúp người dùng dễ dàng sử dụng trong sinh hoạt hàng ngày.\r\n\r\nChất liệu an toàn, bền bỉ và dễ làm sạch giúp sản phẩm luôn giữ được vẻ ngoài sạch đẹp. Đây là lựa chọn phù hợp cho cả gia đình, đặc biệt là giới trẻ.\r\n\r\nSản phẩm góp phần tạo nên những bữa ăn vui vẻ và ấm cúng.', '1773833246_20260228_pIvBWIZG1e.jpg', 11, 200, 99, 1, 'HienThi', '2026-03-18 11:27:26'),
(71, 'Bát cánh cụt', 'b-t-c-nh-c-t', 10000.00, 15000.00, 'Bát cánh cụt gây ấn tượng với thiết kế đáng yêu, phù hợp cho gia đình có trẻ nhỏ hoặc những ai yêu thích phong cách dễ thương.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bề mặt nhẵn mịn, dễ vệ sinh và sử dụng hàng ngày. Kích thước vừa phải giúp thuận tiện trong việc đựng cơm, canh hoặc các món ăn khác.\r\n\r\nĐây là lựa chọn giúp bữa ăn trở nên sinh động và thú vị hơn.', '1773833394_20260113_iIloUP5722.jpg', 11, 200, 96, 4, 'HienThi', '2026-03-18 11:29:54'),
(72, 'Thớt gỗ', 'th-t-g-', 10000.00, 15000.00, 'Thớt gỗ là dụng cụ nhà bếp truyền thống, được nhiều gia đình tin dùng nhờ độ bền và tính an toàn cao. Sản phẩm phù hợp cho nhiều loại thực phẩm khác nhau.\r\n\r\nVới chất liệu gỗ tự nhiên, thớt có khả năng chịu lực tốt, ít cong vênh và không làm ảnh hưởng đến lưỡi dao khi sử dụng. Ngoài ra, sản phẩm còn dễ vệ sinh và có tuổi thọ lâu dài.\r\n\r\nĐây là lựa chọn đáng tin cậy cho mọi gian bếp.', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 12, 200, 2, 8, 'HienThi', '2026-03-18 11:32:16'),
(73, 'Thớt gỗ tre hình quả táo', 'th-t-g-tre-h-nh-qu-t-o', 10000.00, 15000.00, 'Thớt gỗ tre hình quả táo nổi bật với thiết kế độc đáo, mang lại điểm nhấn thẩm mỹ cho không gian bếp. Sản phẩm không chỉ phục vụ nhu cầu chế biến mà còn có thể dùng để trang trí hoặc bày biện món ăn.\r\n\r\nChất liệu tre tự nhiên thân thiện với môi trường, có độ bền cao và an toàn cho sức khỏe. Bề mặt thớt được xử lý mịn, giúp dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nSản phẩm phù hợp với những ai yêu thích sự sáng tạo và tinh tế trong gian bếp.', '1773833599_thot-go-tre-hinh-qua-tao-30x30cm-9068-1-6597ace803b66fafeb1974af.jpg', 12, 200, 100, 0, 'HienThi', '2026-03-18 11:33:19'),
(74, 'Thớt nhựa ', 'th-t-nh-a-', 10000.00, 15000.00, 'Thớt nhựa là sản phẩm phổ biến nhờ trọng lượng nhẹ và dễ dàng vệ sinh. Với thiết kế hiện đại, sản phẩm phù hợp cho nhiều mục đích sử dụng trong gian bếp hàng ngày.\r\n\r\nChất liệu nhựa an toàn giúp hạn chế bám mùi thực phẩm, đồng thời có khả năng chống thấm nước tốt. Bề mặt thớt được thiết kế chống trượt, giúp thao tác cắt thái an toàn hơn.\r\n\r\nĐây là giải pháp tiện lợi cho những ai ưu tiên sự gọn nhẹ và dễ sử dụng.', '1775988208_vn-11134201-7ras8-m0ztpxprro2nba@resize_w900_nl.jpg', 12, 200, 94, 7, 'HienThi', '2026-03-18 11:34:41'),
(75, 'Thớt gỗ đa dụng', 'th-t-g-a-d-ng', 19000.00, 20000.00, 'Thớt gỗ đa dụng được thiết kế nhằm đáp ứng nhiều nhu cầu sử dụng khác nhau trong nhà bếp như cắt rau củ, thịt cá hay chế biến thực phẩm.\r\n\r\nVới chất liệu gỗ bền chắc, sản phẩm có khả năng chịu lực tốt, hạn chế nứt vỡ và đảm bảo độ an toàn khi sử dụng. Thiết kế tiện lợi giúp người dùng dễ dàng thao tác và vệ sinh sau khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần một sản phẩm linh hoạt và bền bỉ.', '1775988109_z7620342499227_67772ca4f9b43cd6a38fa9b31c052f66.jpg', 12, 200, 91, 15, 'HienThi', '2026-03-18 11:35:25'),
(76, 'Thớt gỗ tròn', 'th-t-g-tr-n', 12000.00, 15000.00, 'Thớt gỗ tròn là lựa chọn phù hợp cho những ai yêu thích sự đơn giản và tiện dụng trong gian bếp. Với thiết kế tròn gọn gàng, sản phẩm giúp thao tác cắt thái trở nên linh hoạt và dễ dàng hơn.\r\n\r\nSản phẩm được làm từ gỗ tự nhiên, bề mặt chắc chắn, hạn chế trầy xước dao và đảm bảo an toàn khi tiếp xúc thực phẩm. Ngoài ra, thớt còn dễ vệ sinh và có độ bền cao khi sử dụng lâu dài.\r\n\r\nĐây là vật dụng không thể thiếu giúp công việc nấu nướng trở nên thuận tiện và hiệu quả hơn.', '1775988466_vn-11134207-81ztc-mlwyfjynjg9b03.jpg', 12, 200, 0, 1, 'HienThi', '2026-03-18 11:36:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_views`
--

CREATE TABLE `product_views` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_views`
--

INSERT INTO `product_views` (`id`, `product_id`, `user_id`, `session_id`, `viewed_at`) VALUES
(1, 66, 5, 'qe5vbp7n942c9jlil7mbv4qmfd', '2026-04-12 11:39:39'),
(2, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 09:22:52'),
(3, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 09:22:56'),
(4, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 09:36:09'),
(5, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 09:36:12'),
(6, 59, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:25:04'),
(7, 58, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:27:44'),
(8, 52, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:38:18'),
(9, 48, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:44:10'),
(10, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:51:20'),
(11, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:51:31'),
(12, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:55:12'),
(13, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:55:14'),
(14, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:59:00'),
(15, 71, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:59:11'),
(16, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:59:24'),
(17, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 10:59:35'),
(18, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:11'),
(19, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:14'),
(20, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:27'),
(21, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:39'),
(22, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:48'),
(23, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:01:52'),
(24, 56, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:02:54'),
(25, 66, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:03:19'),
(26, 64, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:05:05'),
(27, 64, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:05:19'),
(28, 64, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:05:20'),
(29, 66, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:10:12'),
(30, 66, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:14:18'),
(31, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:15:11'),
(32, 71, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:15:15'),
(33, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:15:37'),
(34, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:17:38'),
(35, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:17:58'),
(36, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:18:03'),
(37, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:19:44'),
(38, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:19:54'),
(39, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:20:47'),
(40, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:32:42'),
(41, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:33:14'),
(42, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:40:22'),
(43, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:40:38'),
(44, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:43:02'),
(45, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:43:27'),
(46, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:43:35'),
(47, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:43:41'),
(48, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:43:48'),
(49, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:46:36'),
(50, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:46:37'),
(51, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:52:18'),
(52, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:52:53'),
(53, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:54:15'),
(54, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:56:31'),
(55, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:57:10'),
(56, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 11:57:58'),
(57, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:02:53'),
(58, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:03:22'),
(59, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:03:30'),
(60, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:03:36'),
(61, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:03:43'),
(62, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:03:54'),
(63, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:04:27'),
(64, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:07:29'),
(65, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:07:36'),
(66, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:11:22'),
(67, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:11:55'),
(68, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:12:07'),
(69, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:12:12'),
(70, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 12:12:49'),
(71, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:05:33'),
(72, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:06:09'),
(73, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:06:30'),
(74, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:06:37'),
(75, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:06:44'),
(76, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:06:48'),
(77, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:07:19'),
(78, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:08:44'),
(79, 74, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:08:49'),
(80, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:08:51'),
(81, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:08:57'),
(82, 73, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:08:58'),
(83, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:09:00'),
(84, 73, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:09:03'),
(85, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:09:05'),
(86, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:11:55'),
(87, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:12:01'),
(88, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:12:04'),
(89, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:12:30'),
(90, 74, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:12:39'),
(91, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:13:25'),
(92, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:14:25'),
(93, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:16:17'),
(94, 66, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:16:19'),
(95, 66, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:17:21'),
(96, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:26:23'),
(97, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:26:26'),
(98, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:26:28'),
(99, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:26:30'),
(100, 65, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:26:36'),
(101, 43, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:27:57'),
(102, 43, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:35:16'),
(103, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:35:29'),
(104, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:35:32'),
(105, 71, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:35:37'),
(106, 59, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:35:53'),
(107, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:36:00'),
(108, 37, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:36:02'),
(109, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:36:06'),
(110, 45, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:36:11'),
(111, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:36:47'),
(112, 37, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:37:01'),
(113, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:38:23'),
(114, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:47:47'),
(115, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:47:56'),
(116, 70, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 13:50:43'),
(117, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:03:00'),
(118, 73, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:03:12'),
(119, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:15:48'),
(120, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:32:23'),
(121, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:32:46'),
(122, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 14:39:28'),
(123, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:01:25'),
(124, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:01:47'),
(125, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:02:00'),
(126, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:02:52'),
(127, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:03:34'),
(128, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:06:47'),
(129, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:06:49'),
(130, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:06:56'),
(131, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:07:05'),
(132, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:07:35'),
(133, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:11:30'),
(134, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:14:57'),
(135, 65, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:15:08'),
(136, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:15:15'),
(137, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:15:24'),
(138, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:15:28'),
(139, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:15:54'),
(140, 73, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:16:04'),
(141, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:16:10'),
(142, 74, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:16:13'),
(143, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:16:44'),
(144, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:18:29'),
(145, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:02'),
(146, 36, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:04'),
(147, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:12'),
(148, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:17'),
(149, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:53'),
(150, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:27:55'),
(151, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:28:42'),
(152, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:28:54'),
(153, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:29:08'),
(154, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:29:11'),
(155, 76, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:29:40'),
(156, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:29:42'),
(157, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:30:06'),
(158, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:32:28'),
(159, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:32:44'),
(160, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:32:48'),
(161, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:33:06'),
(162, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:34:15'),
(163, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:34:16'),
(164, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:34:18'),
(165, 69, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:34:23'),
(166, 72, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:38:01'),
(167, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:38:10'),
(168, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:38:53'),
(169, 75, 5, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:39:41'),
(170, 75, NULL, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:46:19'),
(171, 75, NULL, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:52:35'),
(172, 75, NULL, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 15:54:10'),
(173, 75, NULL, 'o13kq76dbpf3gs8o3uab9p2i7h', '2026-04-13 16:00:06');

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
(15, 72, 5, 5, 'Xịn', '2026-04-03 12:43:07'),
(16, 69, 5, 5, 'Chén siêu đẹp', '2026-04-07 09:13:45'),
(17, 69, 5, 5, 'Recommend nên mua nha', '2026-04-07 09:14:06'),
(223, 36, 4, 5, 'Dao rất bén, thái thịt mỏng cực kỳ mượt.', '2026-04-08 02:12:00'),
(224, 36, 5, 5, 'Thiết kế đẹp, cầm đầm tay, đóng gói cẩn thận.', '2026-04-09 07:30:00'),
(225, 36, 4, 4, 'Giá hơi cao nhưng chất lượng tương xứng.', '2026-04-10 03:15:00'),
(226, 36, 5, 5, 'Shop giao nhanh, dao sáng bóng không tì vết.', '2026-04-11 04:00:00'),
(227, 36, 4, 4, 'Dùng khá ok, để xem thời gian dài có gỉ không.', '2026-04-12 09:45:00'),
(228, 37, 5, 5, 'Hàng xịn, lưỡi dao sắc lẹm, đáng đồng tiền.', '2026-04-08 03:20:00'),
(229, 37, 4, 5, 'Đóng gói kỹ, dao xài rất thích.', '2026-04-08 08:40:00'),
(230, 37, 5, 3, 'Giao hàng hơi chậm, dao dùng ổn.', '2026-04-09 01:15:00'),
(231, 37, 4, 5, 'Rất ưng ý, mua về mẹ mình khen suốt.', '2026-04-10 12:30:00'),
(232, 37, 5, 4, 'Tốt trong tầm giá, nên mua nha mọi người.', '2026-04-11 14:10:00'),
(233, 38, 4, 5, 'Chất lượng tuyệt vời, dao cắt rau củ dứt khoát.', '2026-04-07 02:00:00'),
(234, 38, 5, 5, 'Mới nhận hàng, test thử thấy rất sắc bén.', '2026-04-08 04:22:00'),
(235, 38, 4, 4, 'Hơi nhẹ so với mình tưởng tượng nhưng xài ok.', '2026-04-09 06:45:00'),
(236, 38, 5, 5, 'Giao hàng hỏa tốc, sản phẩm đẹp xuất sắc.', '2026-04-10 13:15:00'),
(237, 38, 4, 5, '10 điểm không có nhưng.', '2026-04-12 01:30:00'),
(238, 39, 4, 5, 'Dao đẹp, bén, làm bếp nhàn hơn hẳn.', '2026-04-08 00:10:00'),
(239, 39, 5, 4, 'Giá hợp lý, chất lượng ok.', '2026-04-09 02:20:00'),
(240, 39, 4, 5, 'Sẽ ủng hộ shop thêm các sản phẩm khác.', '2026-04-10 07:10:00'),
(241, 39, 5, 3, 'Đóng gói hộp hơi móp nhưng dao không sao.', '2026-04-11 03:05:00'),
(242, 39, 4, 5, 'Hàng chuẩn như mô tả, rất hài lòng.', '2026-04-12 04:50:00'),
(243, 40, 5, 5, 'Dao nặng, chặt xương sườn bao ngọt, không bị mẻ.', '2026-04-07 09:30:00'),
(244, 40, 4, 5, 'Cầm rất chắc tay, đáng tiền lắm.', '2026-04-08 11:45:00'),
(245, 40, 5, 5, 'Thiết kế đẹp, chặt gà vịt một nhát là đứt.', '2026-04-09 13:00:00'),
(246, 40, 4, 4, 'Hơi to so với tay vợ mình nhưng chặt rất sướng.', '2026-04-11 02:15:00'),
(247, 40, 5, 5, 'Sản phẩm tốt, shop tư vấn nhiệt tình.', '2026-04-12 08:20:00'),
(248, 41, 5, 5, 'Dao siêu dài và sắc, thái cá hồi mượt vô cùng.', '2026-04-08 04:11:00'),
(249, 41, 4, 5, 'Chuẩn phong cách Nhật, lưỡi dao sáng bóng.', '2026-04-09 06:25:00'),
(250, 41, 5, 4, 'Lưỡi hơi mỏng nhưng dùng thái cá thì hợp lý.', '2026-04-10 09:40:00'),
(251, 41, 4, 5, 'Rất đáng mua cho ai thích làm đồ sống.', '2026-04-11 11:55:00'),
(252, 41, 5, 5, 'Gói hàng cẩn thận 3 lớp chống sốc, tuyệt vời.', '2026-04-12 14:10:00'),
(253, 42, 4, 5, 'Thái rau hay đập tỏi cực kỳ tiện lợi.', '2026-04-08 01:30:00'),
(254, 42, 5, 4, 'Dao to, đầm tay, xài thích.', '2026-04-09 03:45:00'),
(255, 42, 4, 5, 'Sản phẩm y hình, chất lượng tốt.', '2026-04-10 05:00:00'),
(256, 42, 5, 5, 'Nên mua nhé mọi người, giá quá rẻ so với chất lượng.', '2026-04-11 07:15:00'),
(257, 42, 4, 3, 'Giao hàng lâu, nhưng dao xài ổn.', '2026-04-12 02:05:00'),
(258, 43, 4, 5, 'Nhỏ gọn, cắt gọt trái cây rất êm.', '2026-04-08 05:20:00'),
(259, 43, 5, 5, 'Sắc bén, dễ vệ sinh, không bám bẩn.', '2026-04-09 08:35:00'),
(260, 43, 4, 4, 'Sản phẩm khá ổn, cầm nhẹ tay.', '2026-04-10 10:50:00'),
(261, 43, 5, 5, 'Shop đóng gói kỹ, hàng chuẩn.', '2026-04-11 13:05:00'),
(262, 43, 4, 5, 'Tuyệt vời, sẽ giới thiệu cho bạn bè.', '2026-04-12 15:15:00'),
(263, 44, 4, 5, 'Dao nhìn sang trọng, sắc lẹm.', '2026-04-08 07:10:00'),
(264, 44, 5, 4, 'Chất lượng tốt, giá hơi nhỉnh nhưng xứng đáng.', '2026-04-09 09:25:00'),
(265, 44, 4, 5, 'Cầm rất sướng tay, gọt đồ mượt.', '2026-04-10 11:40:00'),
(266, 44, 5, 5, 'Rất chim ưng, 5 sao cho shop.', '2026-04-11 04:30:00'),
(267, 44, 4, 3, 'Hàng tạm được, không sắc như kỳ vọng.', '2026-04-12 06:45:00'),
(268, 45, 5, 5, 'Nồi nấu cơm chín đều, hạt cơm dẻo và rất ngon.', '2026-04-08 03:05:00'),
(269, 45, 4, 5, 'Thiết kế hiện đại, để trong bếp nhìn rất sang.', '2026-04-09 05:20:00'),
(270, 45, 5, 4, 'Nồi giữ ấm tốt, nấu nhanh.', '2026-04-10 07:35:00'),
(271, 45, 4, 5, 'Dễ sử dụng, màn hình hiển thị rõ ràng.', '2026-04-11 09:50:00'),
(272, 45, 5, 5, 'Rất đáng tiền, khuyên mọi người nên mua.', '2026-04-12 12:05:00'),
(273, 46, 4, 5, 'Chống dính tốt thật sự, rửa cực kỳ nhàn.', '2026-04-08 02:15:00'),
(274, 46, 5, 4, 'Giá rẻ, nấu cơm cho sinh viên hoặc gia đình nhỏ thì hợp.', '2026-04-09 04:30:00'),
(275, 46, 4, 5, 'Cơm không bị cháy đáy, thiết kế nhỏ gọn.', '2026-04-10 06:45:00'),
(276, 46, 5, 3, 'Nút bấm có vẻ hơi lỏng nhưng vẫn nấu bình thường.', '2026-04-11 08:00:00'),
(277, 46, 4, 5, 'Chất lượng vượt xa tầm giá.', '2026-04-12 10:15:00'),
(278, 47, 4, 5, 'Ninh xương, hầm thịt bò siêu nhanh mềm.', '2026-04-08 09:20:00'),
(279, 47, 5, 5, 'Rất an toàn, van xả thiết kế thông minh.', '2026-04-09 11:35:00'),
(280, 47, 4, 4, 'Nồi chắc chắn, nắp đóng mở nhẹ nhàng.', '2026-04-10 13:50:00'),
(281, 47, 5, 5, 'Dung tích vừa vặn, hầm đồ cho cả nhà ăn thoải mái.', '2026-04-11 01:05:00'),
(282, 47, 4, 5, 'Đóng gói chắc chắn, giao hàng siêu nhanh.', '2026-04-12 03:20:00'),
(283, 48, 5, 5, 'Nấu cháo cho bé ăn dặm cực kỳ tiện, không lo trào.', '2026-04-08 04:40:00'),
(284, 48, 4, 5, 'Giữ nguyên hương vị món ăn, hầm gà ác siêu ngon.', '2026-04-09 06:55:00'),
(285, 48, 5, 4, 'Nấu hơi lâu nhưng đúng tính chất nồi nấu chậm, kết quả tuyệt vời.', '2026-04-10 09:10:00'),
(286, 48, 4, 5, 'Lòng sứ dễ rửa, an toàn.', '2026-04-11 11:25:00'),
(287, 48, 5, 3, 'Shop giao thiếu muỗng tặng kèm, nhưng chất lượng nồi tốt.', '2026-04-12 13:40:00'),
(288, 49, 4, 5, 'Tiết kiệm gas/điện kinh khủng, ủ từ sáng đến trưa vẫn nóng hổi.', '2026-04-08 07:50:00'),
(289, 49, 5, 5, 'Làm bò sốt vang hay nấu phở thì đỉnh của chóp.', '2026-04-09 10:05:00'),
(290, 49, 4, 4, 'Thiết kế đẹp, quai xách tiện lợi.', '2026-04-10 12:20:00'),
(291, 49, 5, 5, 'Chất liệu inox sáng bóng, dễ vệ sinh.', '2026-04-11 14:35:00'),
(292, 49, 4, 5, 'Sản phẩm thông minh, nên có trong bếp.', '2026-04-12 02:50:00'),
(293, 50, 4, 5, 'Bộ nồi dày dặn, cầm nặng tay, nấu bếp từ nhận nhanh.', '2026-04-08 03:30:00'),
(294, 50, 5, 4, 'Size nồi đa dạng, đủ dùng cho gia đình 4 người.', '2026-04-09 05:45:00'),
(295, 50, 4, 5, 'Quai nồi chống nóng tốt, nắp kính trong suốt dễ quan sát.', '2026-04-10 08:00:00'),
(296, 50, 5, 5, 'Bề mặt inox xước phay nhìn rất sang.', '2026-04-11 10:15:00'),
(297, 50, 4, 3, 'Hàng bị trầy nhẹ ở đáy 1 nồi, dùng tạm vậy.', '2026-04-12 12:30:00'),
(298, 51, 5, 5, 'Inox 304 xịn, đun không bị ố vàng hay ra ten.', '2026-04-08 01:40:00'),
(299, 51, 4, 5, 'Dùng luộc gà bao sướng, size to vừa vặn.', '2026-04-09 03:55:00'),
(300, 51, 5, 4, 'Truyền nhiệt tốt, đun nhanh sôi.', '2026-04-10 06:10:00'),
(301, 51, 4, 5, 'Đáng đồng tiền bát gạo, mua xài cả đời không hỏng.', '2026-04-11 08:25:00'),
(302, 51, 5, 5, 'Gói hàng cẩn thận, không móp méo.', '2026-04-12 10:40:00'),
(303, 52, 4, 5, 'Nồi nông vừa phải, ăn lẩu gắp đồ rất dễ.', '2026-04-08 10:15:00'),
(304, 52, 5, 5, 'Bắt từ siêu nhạy, sôi sùng sục.', '2026-04-09 12:30:00'),
(305, 52, 4, 4, 'Chất liệu sáng bóng, rửa sạch dầu mỡ rất nhanh.', '2026-04-10 14:45:00'),
(306, 52, 5, 5, 'Cuối tuần ăn lẩu gia đình thì cái này là chân ái.', '2026-04-11 01:00:00'),
(307, 52, 4, 4, 'Nắp kính có vẻ mỏng nhưng nhìn chung ổn.', '2026-04-12 03:15:00'),
(308, 53, 5, 5, 'Ấm reo to, đun nước nhanh.', '2026-04-08 05:25:00'),
(309, 53, 4, 4, 'Dày dặn, không bị rỉ sét.', '2026-04-09 07:40:00'),
(310, 53, 5, 5, 'Dung tích lớn, phù hợp nhà đông người.', '2026-04-10 09:55:00'),
(311, 53, 4, 5, 'Quai cầm không bị nóng, rất an toàn.', '2026-04-11 12:10:00'),
(312, 53, 5, 5, 'Shop đóng gói siêu có tâm.', '2026-04-12 14:25:00'),
(313, 54, 4, 5, 'Đun sôi cực nhanh, tự ngắt chuẩn xác.', '2026-04-08 02:35:00'),
(314, 54, 5, 5, 'Nhựa không bị hôi mùi lúc mới đun, rất ưng.', '2026-04-09 04:50:00'),
(315, 54, 4, 4, 'Màu sắc đẹp, sang trọng.', '2026-04-10 07:05:00'),
(316, 54, 5, 5, 'Giá rẻ mà chất lượng xịn xò.', '2026-04-11 09:20:00'),
(317, 54, 4, 3, 'Dây cắm hơi ngắn, phải kéo ổ cắm lại gần.', '2026-04-12 11:35:00'),
(318, 55, 4, 5, 'Làm nóng nhanh kinh khủng, phím cảm ứng nhạy.', '2026-04-08 08:45:00'),
(319, 55, 5, 5, 'Mua về ăn lẩu, bếp chạy êm ít tiếng ồn.', '2026-04-09 11:00:00'),
(320, 55, 4, 4, 'Thiết kế mỏng gọn, cất giữ dễ dàng.', '2026-04-10 13:15:00'),
(321, 55, 5, 5, 'Mặt kính dễ lau chùi, vệ sinh nhanh.', '2026-04-11 15:30:00'),
(322, 55, 4, 5, 'Tốt trong tầm giá, bảo hành đầy đủ.', '2026-04-12 01:45:00'),
(323, 56, 5, 5, 'Xay thịt, xay sinh tố đều nhuyễn mịn.', '2026-04-08 04:55:00'),
(324, 56, 4, 5, 'Cối thủy tinh dày, dao 4 lưỡi xay cực khỏe.', '2026-04-09 07:10:00'),
(325, 56, 5, 4, 'Máy chạy hơi ồn xíu nhưng hiệu năng cao.', '2026-04-10 09:25:00'),
(326, 56, 4, 5, 'Dễ tháo lắp và vệ sinh.', '2026-04-11 11:40:00'),
(327, 56, 5, 5, 'Shop giao đúng màu, hỗ trợ nhiệt tình.', '2026-04-12 13:55:00'),
(328, 57, 4, 5, 'Ép kiệt nước bã khô ran, nước ép ngon không bị tách lớp.', '2026-04-08 11:05:00'),
(329, 57, 5, 5, 'Tháo lắp rửa dễ hơn các dòng máy ép khác mình từng dùng.', '2026-04-09 13:20:00'),
(330, 57, 4, 4, 'Ép cần tây, cà rốt rất mượt.', '2026-04-10 01:35:00'),
(331, 57, 5, 5, 'Vận hành êm ái, ít tiếng ồn.', '2026-04-11 03:50:00'),
(332, 57, 4, 3, 'Giá hơi cao nhưng tiền nào của nấy.', '2026-04-12 06:05:00'),
(333, 58, 4, 5, 'Vắt kiệt nước mà không bị đắng vỏ.', '2026-04-08 01:50:00'),
(334, 58, 5, 5, 'Thiết kế thông minh, tự đảo chiều khi vắt.', '2026-04-09 04:05:00'),
(335, 58, 4, 4, 'Chất liệu nhựa an toàn, dễ rửa.', '2026-04-10 06:20:00'),
(336, 58, 5, 5, 'Làm một ly cam vắt mỗi sáng nhanh gọn lẹ.', '2026-04-11 08:35:00'),
(337, 58, 4, 5, 'Đáng mua nha mọi người.', '2026-04-12 10:50:00'),
(338, 59, 4, 5, 'Chiên đùi gà giòn rụm bên ngoài, mềm bên trong.', '2026-04-08 06:00:00'),
(339, 59, 5, 5, 'Dung tích siêu to, nướng nguyên con gà thoải mái.', '2026-04-09 08:15:00'),
(340, 59, 4, 4, 'Lớp chống dính tốt, rửa rất nhanh.', '2026-04-10 10:30:00'),
(341, 59, 5, 5, 'Thao tác núm vặn cơ bản dễ xài cho người lớn tuổi.', '2026-04-11 12:45:00'),
(342, 59, 4, 4, 'Hơi mùi nhựa ở lần đầu đun không, sau đó hết.', '2026-04-12 15:00:00'),
(343, 60, 5, 5, 'Chiên trứng không cần dầu luôn, xịn thật.', '2026-04-08 03:15:00'),
(344, 60, 4, 5, 'Chảo nặng đầm tay, nướng thịt bò bít tết cháy xém ngon.', '2026-04-09 05:30:00'),
(345, 60, 5, 4, 'Màu sắc sang trọng, lớp chống dính sần đẹp.', '2026-04-10 07:45:00'),
(346, 60, 4, 5, 'Đáy từ bắt nhiệt nhanh và đều.', '2026-04-11 10:00:00'),
(347, 60, 5, 3, 'Tay cầm hơi trơn nhưng cách nhiệt tốt.', '2026-04-12 12:15:00'),
(348, 61, 4, 5, 'Xào rau muống xanh rờn, lửa bùng rất sướng.', '2026-04-08 09:30:00'),
(349, 61, 5, 5, 'Inox sáng bóng, dùng chùi rửa chà nồi thoải mái không sợ tróc.', '2026-04-09 11:45:00'),
(350, 61, 4, 4, 'Cần biết cách tôi dầu thì chiên không bị dính.', '2026-04-10 14:00:00'),
(351, 61, 5, 5, 'Sản phẩm bền bỉ, an toàn sức khỏe.', '2026-04-11 02:15:00'),
(352, 61, 4, 5, 'Hàng xịn, đáng mua.', '2026-04-12 04:30:00'),
(353, 62, 5, 5, 'Màu pastel cực xinh, decor bếp tuyệt vời.', '2026-04-08 04:45:00'),
(354, 62, 4, 5, 'Lớp men gốm chống dính tốt, an toàn không độc hại.', '2026-04-09 07:00:00'),
(355, 62, 5, 4, 'Chảo nhẹ tay, dễ hất thức ăn khi xào.', '2026-04-10 09:15:00'),
(356, 62, 4, 5, 'Dễ vệ sinh, lau nhẹ là sạch.', '2026-04-11 11:30:00'),
(357, 62, 5, 3, 'Giá hơi đắt nhưng đẹp.', '2026-04-12 13:45:00'),
(358, 63, 4, 5, 'Chảo dùng ổn định, chiên cá không nát.', '2026-04-08 02:00:00'),
(359, 63, 5, 4, 'Chất lượng đi đôi với giá tiền.', '2026-04-09 04:15:00'),
(360, 63, 4, 5, 'Chảo quốc dân, nhà nào cũng nên có.', '2026-04-10 06:30:00'),
(361, 63, 5, 5, 'Nhẹ nhàng, dễ thao tác.', '2026-04-11 08:45:00'),
(362, 63, 4, 4, 'Hàng y hình, gói cẩn thận.', '2026-04-12 11:00:00'),
(363, 64, 4, 5, 'Sâu lòng xào đồ không bị văng ra ngoài, chiên ngập dầu cũng tiện.', '2026-04-08 07:15:00'),
(364, 64, 5, 5, 'Cực kỳ tiện dụng, mua 1 được 2 (vừa chiên vừa xào).', '2026-04-09 09:30:00'),
(365, 64, 4, 4, 'Đáy chảo dày dặn, không bị lồi giữa.', '2026-04-10 11:45:00'),
(366, 64, 5, 5, 'Lớp chống dính kim cương nhìn xịn xò.', '2026-04-11 14:00:00'),
(367, 64, 4, 5, 'Giao nhanh, anh shipper nhiệt tình.', '2026-04-12 03:15:00'),
(368, 65, 5, 5, 'Dùng chảo này chiên cơm rang cháy cạnh ngon tuyệt.', '2026-04-08 05:30:00'),
(369, 65, 4, 5, 'Chảo bền, sáng bóng, không hoen gỉ.', '2026-04-09 07:45:00'),
(370, 65, 5, 4, 'Nặng tay, chất liệu inox 304 an toàn.', '2026-04-10 10:00:00'),
(371, 65, 4, 5, 'Cần tôi dầu trước khi chiên rán, xào thì vô tư.', '2026-04-11 12:15:00'),
(372, 65, 5, 3, 'Hàng bị cấn nhẹ do vận chuyển nhưng không ảnh hưởng.', '2026-04-12 14:30:00'),
(373, 66, 4, 5, 'Bát siêu cute, bé nhà mình thích mê, ăn cơm ngoan hẳn.', '2026-04-08 02:45:00'),
(374, 66, 5, 5, 'Chất gốm sứ dày dặn, in hình sắc nét không bong.', '2026-04-09 05:00:00'),
(375, 66, 4, 4, 'Nhỏ xinh, phù hợp cho bé hoặc decor.', '2026-04-10 07:15:00'),
(376, 66, 5, 5, 'Gói hàng siêu kỹ, quấn bong bóng mấy lớp liền.', '2026-04-11 09:30:00'),
(377, 66, 4, 5, 'Sẽ mua thêm trọn bộ sưu tập.', '2026-04-12 11:45:00'),
(378, 67, 4, 5, 'Dĩa sang, phong cách tối giản bày đồ ăn rất nổi.', '2026-04-08 08:00:00'),
(379, 67, 5, 4, 'Men sứ mịn, dễ rửa.', '2026-04-09 10:15:00'),
(380, 67, 4, 5, 'Rẻ mà đẹp, mua chục cái về dùng dần.', '2026-04-10 12:30:00'),
(381, 67, 5, 5, 'Kích thước vừa vặn ăn cơm gia đình.', '2026-04-11 14:45:00'),
(382, 67, 4, 3, 'Màu trắng hơi ngà chút chứ không trắng tinh.', '2026-04-12 04:00:00'),
(383, 68, 5, 5, 'Hình dáng độc lạ, chụp hình đồ ăn sống ảo cực chất.', '2026-04-08 03:15:00'),
(384, 68, 4, 5, 'Đáng yêu xỉu, chất liệu gốm nhám sờ thích tay.', '2026-04-09 05:30:00'),
(385, 68, 5, 4, 'Hơi nhỏ xíu xíu nhưng bày hạt/trái cây thì hợp.', '2026-04-10 07:45:00'),
(386, 68, 4, 5, 'Mình mua tặng bạn, bạn khen lắm.', '2026-04-11 10:00:00'),
(387, 68, 5, 5, 'Màu sắc y hình, không bị lem màu.', '2026-04-12 12:15:00'),
(388, 69, 4, 5, 'Bát to chà bá, ăn mì tôm ăn cơm trộn đều đã.', '2026-04-08 09:30:00'),
(389, 69, 5, 5, 'Họa tiết cu Shin buồn cười, nhìn là muốn ăn.', '2026-04-09 11:45:00'),
(390, 69, 4, 4, 'Sứ tốt, cho vào lò vi sóng không nứt.', '2026-04-10 14:00:00'),
(391, 69, 5, 5, 'Quá rẻ so với chất lượng, recommend 100%.', '2026-04-11 02:15:00'),
(392, 69, 4, 5, 'Shop rep tin nhắn dễ thương.', '2026-04-12 04:30:00'),
(393, 70, 5, 5, 'Họa tiết hoa nhí xinh xắn, cầm chắc tay.', '2026-04-08 04:45:00'),
(394, 70, 4, 5, 'Làm tô canh hay trộn salad đều vừa vặn.', '2026-04-09 07:00:00'),
(395, 70, 5, 4, 'Màu pastel nhã nhặn, đẹp mắt.', '2026-04-10 09:15:00'),
(396, 70, 4, 5, 'Giao hàng không bị sứt mẻ tí nào.', '2026-04-11 11:30:00'),
(397, 70, 5, 5, 'Chất lượng gốm tốt, gõ nghe tiếng thanh.', '2026-04-12 13:45:00'),
(398, 71, 4, 5, 'Trời ơi cute muốn xỉu, để trên bàn làm việc ăn vặt cũng vui.', '2026-04-08 02:00:00'),
(399, 71, 5, 5, 'Mua cho con trai, bé đòi ăn hoài bằng bát này.', '2026-04-09 04:15:00'),
(400, 71, 4, 4, 'Chi tiết hoàn thiện tốt, không bị sắc cạnh.', '2026-04-10 06:30:00'),
(401, 71, 5, 5, 'Hình chim cánh cụt in rõ ràng, rửa không bay.', '2026-04-11 08:45:00'),
(402, 71, 4, 3, 'Hàng ship đi tỉnh hơi lâu.', '2026-04-12 11:00:00'),
(403, 72, 5, 5, 'Thớt gỗ tự nhiên, vân gỗ đẹp, băm thịt không bị lõm.', '2026-04-08 07:15:00'),
(404, 72, 4, 5, 'Dày dặn chắc chắn, xài rất yên tâm.', '2026-04-09 09:30:00'),
(405, 72, 5, 4, 'Hơi nặng nhưng chặt gà vịt thì phải thế mới đầm.', '2026-04-10 11:45:00'),
(406, 72, 4, 5, 'Không bị lên mùn cưa, rất an toàn.', '2026-04-11 14:00:00'),
(407, 72, 5, 5, 'Shop giao nhanh, thớt bọc màng co cẩn thận.', '2026-04-12 03:15:00'),
(408, 73, 4, 5, 'Gỗ tre ép cứng, hình quả táo treo lên bếp nhìn rất xinh.', '2026-04-08 05:30:00'),
(409, 73, 5, 5, 'Thái trái cây, cắt bánh mì tiện lợi.', '2026-04-09 07:45:00'),
(410, 73, 4, 4, 'Chống thấm nước tốt, rửa xong mau khô.', '2026-04-10 10:00:00'),
(411, 73, 5, 5, 'Decor bàn ăn hay decor chụp hình đều tuyệt.', '2026-04-11 12:15:00'),
(412, 73, 4, 4, 'Mỏng nhẹ, dùng cho dao thái ok.', '2026-04-12 14:30:00'),
(413, 74, 4, 5, 'Nhựa dẻo dai, nhám bề mặt chống trơn trượt đồ ăn.', '2026-04-08 02:45:00'),
(414, 74, 5, 5, 'Dễ rửa, không bám mùi hành tỏi.', '2026-04-09 05:00:00'),
(415, 74, 4, 4, 'Màu sắc sạch sẽ, có rãnh hứng nước tiện.', '2026-04-10 07:15:00'),
(416, 74, 5, 5, 'Rẻ mà có võ, mua 2 cái thái đồ sống chín riêng.', '2026-04-11 09:30:00'),
(417, 74, 4, 3, 'Bị xước nhẹ sau vài lần cắt mạnh.', '2026-04-12 11:45:00'),
(418, 75, 5, 5, 'Đúng như tên gọi, cắt thái băm đều chiến được hết.', '2026-04-08 08:00:00'),
(419, 75, 4, 5, 'Kích thước to rộng rãi, sơ chế đồ ăn thoải mái.', '2026-04-09 10:15:00'),
(420, 75, 5, 4, 'Gỗ xử lý sấy kỹ, chưa thấy có dấu hiệu mốc.', '2026-04-10 12:30:00'),
(421, 75, 4, 5, 'Chất lượng xuất sắc so với giá.', '2026-04-11 14:45:00'),
(422, 75, 5, 5, 'Giao hàng hỏa tốc trong ngày.', '2026-04-12 04:00:00'),
(423, 76, 4, 5, 'Kiểu dáng tròn cổ điển nhưng cực kỳ tiện băm chặt.', '2026-04-08 03:15:00'),
(424, 76, 5, 4, 'Gỗ cứng, mặt thớt phẳng lỳ.', '2026-04-09 05:30:00'),
(425, 76, 4, 5, 'Viền bo tròn mài nhẵn mịn tay.', '2026-04-10 07:45:00'),
(426, 76, 5, 5, 'Mua cho mẹ mẹ ưng lắm, thớt dày dặn.', '2026-04-11 10:00:00'),
(427, 76, 4, 3, 'Hàng bị giao nhầm size nhưng shop đổi trả nhanh.', '2026-04-12 12:15:00');

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
(5, 'Đào Công Anh Minh', 'daoconganhminh1902@gmail.com', '100715689387117212188', '$2y$10$28hBcsBgAAxfrsdimRpMq.28Ij8EbH8i2sAW4xT1I/lqKqFbOibDS', '0911078383', 'Đà Lạt', 'Nam', 'Kim Cương', 'HoatDong', '2026-02-26', 'uploads/1774333586_default-avatar.png', '2026-03-22 11:32:22', NULL, NULL, 55, '2026-04-13');

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
(3, 'TET2026', 'PhanTram', 5, 5000, 20000, 24, 2, '2026-03-29 14:41:00', '2026-05-24 14:41:00', 'HoatDong'),
(4, 'TET', 'TienMat', 2000, 0, 10000, 20, 5, '2026-03-20 15:00:00', '2026-06-07 15:03:00', 'HoatDong'),
(5, 'XUAN', 'TienMat', 5000, 0, 30000, 6, 0, '2026-03-20 15:01:00', '2026-05-30 15:01:00', 'HoatDong'),
(6, 'FREESHIP', 'FreeShip', 10000, 0, 30000, 9, 0, '2026-03-29 15:02:00', '2026-05-31 15:02:00', 'HoatDong'),
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
-- Chỉ mục cho bảng `product_views`
--
ALTER TABLE `product_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `chatbot_faq`
--
ALTER TABLE `chatbot_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT cho bảng `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
-- AUTO_INCREMENT cho bảng `product_views`
--
ALTER TABLE `product_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

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
