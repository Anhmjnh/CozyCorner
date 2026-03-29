-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 29, 2026 lúc 12:43 PM
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
(5, 'staff', '$2y$10$b1iYNTLF8kWgU3tUbQoL4OZmCf6idwoNeLD9eEzgMLdJrLevdID3S', 'Staff', 'HoatDong', 'Đào Công Anh Minh', 'staff123@gmail.com', '012344234', 'hà nội', 'Nam', '2026-03-14', '2026-03-22 11:25:29', '1774178825_admin_A-210-Dia-ANM-26020092-1.jpg');

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
(47, NULL, 'iv2v9r899gp84npar8ca7uf9v2', '2026-03-26 15:36:03');

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
(146, 8, 36, 1, '2026-03-29 06:46:13');

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
(9, 'Đào Công Anh Minh', 'daoconganhminh1902@gmail.com', '0911078383', '123', '123', 'ChuaDoc', '2026-03-29 06:20:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
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

INSERT INTO `news` (`id`, `tieu_de`, `slug`, `noi_dung`, `danh_muc`, `anh`, `luot_xem`, `trang_thai`, `created_at`) VALUES
(2, 'Mẹo Bảo Quản Dụng Cụ Nhà Bếp Hiệu Quả', 'm-o-b-o-qu-n-d-ng-c-nh-b-p-hi-u-qu--1774693302', 'Gian bếp là nơi lưu giữ những bữa cơm ấm cúng, là không gian gắn kết yêu thương trong mỗi gia đình Việt. Nhưng sau những phút giây nấu nướng, nếu không biết cách bảo quản, dụng cụ nhà bếp dễ xuống cấp, kém vệ sinh và nhanh hỏng.\r\n\r\nĐể căn bếp luôn sạch đẹp, đồ dùng luôn bền như mới, dưới đây là những mẹo đơn giản mà người nội trợ nào cũng nên biết:\r\n\r\n1. Lau khô hoàn toàn sau khi rửa\r\nĐừng để các dụng cụ ướt tự khô trong không khí. Đặc biệt với dụng cụ inox, gỗ, chống dính – nếu còn đọng nước, chúng rất dễ bị ố màu, hoen gỉ, nứt nẻ hoặc bong lớp phủ.\r\n👉 Sau khi rửa, hãy dùng khăn mềm lau khô và để ở nơi thoáng khí trước khi cất đi.\r\n\r\n2. Không ngâm đồ gỗ hoặc dao quá lâu trong nước\r\nNgâm lâu khiến gỗ hút nước, nhanh mục và biến dạng, còn dao thì nhanh cùn, dễ gỉ lưỡi. Với các vật dụng này, hãy rửa ngay sau khi dùng, lau khô kỹ và cất đúng nơi quy định.\r\n\r\n3. Cất đồ đúng cách – tránh trầy xước, va đập\r\nXếp chồng chéo chảo chống dính hoặc nồi inox có thể khiến bề mặt bị trầy xước, bong lớp chống dính. Hãy lót khăn mỏng, vải nỉ hoặc sử dụng giá treo riêng biệt để bảo vệ sản phẩm tốt hơn.\r\n\r\n4. Làm sạch định kỳ các thiết bị điện nhỏ\r\nMáy xay, máy ép, nồi chiên… nếu không được làm sạch thường xuyên có thể tích tụ cặn bẩn, dầu mỡ và gây mùi khó chịu.\r\n👉 Hãy tháo rời và vệ sinh đúng cách sau mỗi lần sử dụng, đồng thời kiểm tra các chi tiết như gioăng, nắp, khe thoát hơi để đảm bảo thiết bị vận hành ổn định.\r\n\r\n5. Ưu tiên sản phẩm chất lượng – dễ vệ sinh, an toàn\r\nĐầu tư ban đầu vào dụng cụ nhà bếp đạt chuẩn Châu Âu, dễ làm sạch, chống oxy hóa tốt và an toàn cho sức khỏe sẽ giúp tiết kiệm lâu dài về sau.\r\nVà đừng quên, Elmich luôn đồng hành cùng bạn với các sản phẩm nhà bếp bền đẹp, tiện dụng, đạt chuẩn Châu Âu.\r\n\r\nMột căn bếp sạch là khởi nguồn của những bữa ăn ngon – Một dụng cụ bền là người bạn đồng hành tin cậy trong mỗi lần vào bếp.\r\nHãy bắt đầu từ những điều nhỏ nhất để gian bếp luôn là nơi truyền cảm hứng mỗi ngày.', 'Mẹo vặt', '1774693302_news_img-tintuc1.png', 3, 'HienThi', '2026-03-28 10:21:42'),
(3, 'Top 5 Sản Phẩm Gia Dụng Không Thể Thiếu Cho Mỗi Gia Đình', 'top-5-s-n-ph-m-gia-d-ng-kh-ng-th-thi-u-cho-m-i-gia-nh-1774693687', 'Trong bối cảnh cuộc sống hiện đại ngày càng bận rộn, các sản phẩm gia dụng đóng vai trò quan trọng trong việc tối ưu hóa thời gian và nâng cao chất lượng sinh hoạt. Thực tế cho thấy, nhu cầu sử dụng đồ gia dụng tại Việt Nam ngày càng đa dạng với nhiều nhóm sản phẩm phục vụ từ nấu nướng, bảo quản thực phẩm đến chăm sóc sức khỏe gia đình .\r\n\r\nDưới đây là những sản phẩm thiết yếu mà hầu hết các gia đình nên trang bị để đảm bảo sự tiện nghi và hiệu quả trong sinh hoạt hàng ngày.\r\n\r\n1. Nồi chiên không dầu\r\n\r\nNồi chiên không dầu là một trong những thiết bị nhà bếp phổ biến nhất hiện nay nhờ khả năng chế biến thực phẩm với lượng dầu tối thiểu. Thiết bị này giúp giảm chất béo trong món ăn, đồng thời vẫn giữ được hương vị và độ giòn cần thiết.\r\n\r\nNgoài chức năng chiên, nhiều dòng sản phẩm còn tích hợp nướng, sấy hoặc hâm nóng, đáp ứng đa dạng nhu cầu nấu ăn trong gia đình.\r\n\r\n2. Máy xay sinh tố\r\n\r\nMáy xay sinh tố là thiết bị hỗ trợ chế biến thực phẩm nhanh chóng, đặc biệt phù hợp với nhu cầu bổ sung dinh dưỡng hằng ngày. Từ sinh tố, nước ép đến cháo hoặc súp, thiết bị này giúp tiết kiệm đáng kể thời gian chuẩn bị.\r\n\r\nĐây cũng là sản phẩm gần như không thể thiếu trong các gia đình có trẻ nhỏ hoặc người cao tuổi.\r\n\r\n3. Bộ nồi chảo chống dính\r\n\r\nBộ nồi chảo chất lượng cao giúp việc nấu ăn trở nên thuận tiện hơn, hạn chế tình trạng thức ăn bám dính và dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nHiện nay, các sản phẩm nồi chảo được sản xuất với nhiều chất liệu như inox, nhôm phủ chống dính hoặc hợp kim cao cấp, đáp ứng nhu cầu đa dạng của người tiêu dùng. Những sản phẩm này không chỉ phục vụ nấu nướng mà còn góp phần nâng cao trải nghiệm bếp núc hàng ngày.\r\n\r\n4. Ấm siêu tốc\r\n\r\nẤm siêu tốc là thiết bị quen thuộc trong hầu hết các gia đình nhờ khả năng đun nước nhanh chóng và tiện lợi. Chỉ trong vài phút, người dùng có thể chuẩn bị nước nóng để pha trà, cà phê hoặc phục vụ các nhu cầu sinh hoạt khác.\r\n\r\nVới thiết kế ngày càng cải tiến về độ an toàn và tiết kiệm điện, ấm siêu tốc trở thành một trong những thiết bị thiết yếu trong không gian bếp hiện đại.\r\n\r\n5. Hộp đựng thực phẩm\r\n\r\nHộp đựng thực phẩm đóng vai trò quan trọng trong việc bảo quản thức ăn và giữ vệ sinh cho tủ lạnh. Các sản phẩm hiện nay thường được thiết kế kín khí, giúp hạn chế mùi và ngăn vi khuẩn phát triển.\r\n\r\nTheo xu hướng tiêu dùng, các loại hộp bảo quản thực phẩm đang ngày càng được ưa chuộng nhờ tính tiện lợi và khả năng sử dụng trong nhiều môi trường như tủ lạnh hoặc lò vi sóng .\r\n\r\nKết luận\r\n\r\nViệc lựa chọn và trang bị các sản phẩm gia dụng phù hợp không chỉ giúp tối ưu hóa công việc nội trợ mà còn góp phần nâng cao chất lượng cuộc sống. Trong bối cảnh thị trường gia dụng ngày càng phong phú với nhiều mẫu mã và phân khúc khác nhau , người tiêu dùng nên ưu tiên những sản phẩm có chất lượng tốt, an toàn và đáp ứng đúng nhu cầu sử dụng lâu dài.\r\n\r\nMột không gian bếp tiện nghi, được trang bị đầy đủ những thiết bị cần thiết sẽ là nền tảng cho những bữa ăn trọn vẹn và sự gắn kết trong mỗi gia đình.', 'Sản phẩm', '1774693687_news_img-tintuc2.png', 6, 'HienThi', '2026-03-28 10:28:07'),
(4, 'Công Nghệ Hiện Đại Trong Thiết Bị Nhà Bếp', 'c-ng-ngh-hi-n-i-trong-thi-t-b-nh-b-p-1774693942', 'Sự phát triển của công nghệ đang làm thay đổi đáng kể thói quen nấu nướng và sinh hoạt trong gia đình. Nếu như trước đây, các thiết bị nhà bếp chỉ dừng lại ở chức năng cơ bản, thì ngày nay, nhiều sản phẩm đã được tích hợp công nghệ hiện đại nhằm tối ưu hiệu suất, tiết kiệm thời gian và nâng cao trải nghiệm người dùng.\r\n\r\nNhững cải tiến này không chỉ giúp việc nội trợ trở nên đơn giản hơn mà còn góp phần xây dựng một không gian bếp tiện nghi, thông minh và an toàn.\r\n\r\n1.Thiết bị nhà bếp thông minh kết nối IoT\r\n\r\nMột trong những xu hướng nổi bật là sự xuất hiện của các thiết bị nhà bếp thông minh có khả năng kết nối Internet (IoT). Người dùng có thể điều khiển nồi cơm điện, lò nướng hoặc máy pha cà phê từ xa thông qua điện thoại di động.\r\n\r\nViệc theo dõi và điều chỉnh quá trình nấu nướng theo thời gian thực giúp hạn chế rủi ro và đảm bảo món ăn đạt chất lượng ổn định. Đây là bước tiến quan trọng trong việc tự động hóa không gian bếp hiện đại.\r\n\r\n2.Công nghệ tiết kiệm năng lượng\r\n\r\nCác thiết bị gia dụng ngày nay được chú trọng cải tiến nhằm giảm thiểu mức tiêu thụ điện năng. Công nghệ inverter, cảm biến nhiệt thông minh hay chế độ tự ngắt khi không sử dụng giúp tiết kiệm chi phí điện và tăng độ bền cho sản phẩm.\r\n\r\nKhông chỉ mang lại lợi ích kinh tế, xu hướng này còn phù hợp với định hướng sử dụng năng lượng bền vững và thân thiện với môi trường.\r\n\r\n3.Vật liệu cao cấp và an toàn cho sức khỏe\r\n\r\nSự đổi mới không chỉ nằm ở công nghệ mà còn ở chất liệu sản phẩm. Nhiều thiết bị nhà bếp hiện nay sử dụng inox cao cấp, hợp kim nhôm phủ chống dính an toàn hoặc nhựa không chứa BPA.\r\n\r\nCác vật liệu này giúp hạn chế phản ứng hóa học trong quá trình nấu nướng, đồng thời tăng khả năng chịu nhiệt và kéo dài tuổi thọ sản phẩm.\r\n\r\n4.Tích hợp đa chức năng\r\n\r\nXu hướng tích hợp nhiều chức năng trong một thiết bị đang ngày càng phổ biến. Một chiếc nồi chiên không dầu có thể kết hợp chiên, nướng, sấy; hay máy xay đa năng có thể xay thực phẩm, ép trái cây và nghiền đá.\r\n\r\nĐiều này giúp tiết kiệm không gian bếp và giảm chi phí đầu tư cho nhiều thiết bị riêng lẻ.\r\n\r\n5.Tối ưu trải nghiệm người dùng\r\n\r\nCác nhà sản xuất ngày càng chú trọng đến thiết kế và trải nghiệm sử dụng. Bảng điều khiển cảm ứng, màn hình hiển thị rõ ràng, chế độ cài đặt sẵn và hệ thống cảnh báo an toàn giúp người dùng dễ dàng thao tác, kể cả với những người ít kinh nghiệm nấu ăn.\r\n\r\nNgoài ra, yếu tố thẩm mỹ cũng được nâng cao, góp phần tạo nên không gian bếp hiện đại và hài hòa hơn.\r\n\r\nKết luận\r\n\r\nCông nghệ hiện đại đang từng bước thay đổi cách con người tiếp cận việc nấu nướng và quản lý không gian bếp. Việc lựa chọn các thiết bị gia dụng tích hợp công nghệ tiên tiến không chỉ mang lại sự tiện lợi mà còn góp phần nâng cao chất lượng cuộc sống.\r\n\r\nTrong bối cảnh thị trường ngày càng đa dạng, người tiêu dùng cần cân nhắc kỹ về nhu cầu sử dụng, tính năng và độ an toàn để đưa ra lựa chọn phù hợp. Một gian bếp được trang bị đúng cách sẽ không chỉ phục vụ tốt cho sinh hoạt hàng ngày mà còn trở thành không gian truyền cảm hứng cho mỗi gia đình.', 'Thiết bị', '1774693942_news_img-tintuc3.png', 1, 'HienThi', '2026-03-28 10:32:22'),
(5, 'Làm Sao Để Chọn Dụng Cụ Bếp An Toàn Cho Sức Khỏe', 'l-m-sao-ch-n-d-ng-c-b-p-an-to-n-cho-s-c-kh-e-1774694160', 'Dụng cụ nhà bếp là những vật dụng tiếp xúc trực tiếp với thực phẩm mỗi ngày, vì vậy yếu tố an toàn luôn được đặt lên hàng đầu. Tuy nhiên, trên thị trường hiện nay có rất nhiều sản phẩm với chất liệu và mức giá khác nhau, khiến người tiêu dùng gặp khó khăn trong việc lựa chọn.\r\n\r\nViệc trang bị đúng dụng cụ bếp không chỉ giúp nâng cao hiệu quả nấu nướng mà còn góp phần bảo vệ sức khỏe cho cả gia đình trong thời gian dài.\r\n\r\n1. Ưu tiên chất liệu an toàn\r\n\r\nChất liệu là yếu tố quan trọng nhất khi lựa chọn dụng cụ nhà bếp. Các sản phẩm làm từ inox 304, thủy tinh chịu nhiệt, gốm sứ cao cấp hoặc nhựa an toàn không chứa BPA thường được đánh giá cao về độ an toàn.\r\n\r\nNgược lại, các sản phẩm kém chất lượng có thể chứa tạp chất hoặc giải phóng chất độc hại khi tiếp xúc với nhiệt độ cao, ảnh hưởng trực tiếp đến sức khỏe người sử dụng.\r\n\r\n2. Lựa chọn sản phẩm có nguồn gốc rõ ràng\r\n\r\nNgười tiêu dùng nên ưu tiên các sản phẩm có thương hiệu, xuất xứ minh bạch và đạt các tiêu chuẩn an toàn. Những sản phẩm này thường được kiểm định chất lượng trước khi đưa ra thị trường, đảm bảo an toàn khi sử dụng lâu dài.\r\n\r\nTránh mua các sản phẩm trôi nổi, không nhãn mác hoặc có giá quá rẻ so với mặt bằng chung, vì tiềm ẩn nhiều rủi ro.\r\n\r\n3. Chú ý đến khả năng chịu nhiệt và độ bền\r\n\r\nDụng cụ nhà bếp cần có khả năng chịu nhiệt tốt và không bị biến dạng trong quá trình sử dụng. Đặc biệt, với các sản phẩm như nồi, chảo hoặc hộp đựng thực phẩm, khả năng chịu nhiệt sẽ quyết định độ an toàn khi nấu nướng.\r\n\r\nNgoài ra, sản phẩm có độ bền cao sẽ hạn chế tình trạng bong tróc lớp phủ hoặc nứt vỡ, từ đó giảm nguy cơ ảnh hưởng đến thực phẩm.\r\n\r\n4. Dễ vệ sinh và bảo quản\r\n\r\nMột tiêu chí quan trọng khác là khả năng vệ sinh sau khi sử dụng. Dụng cụ bếp dễ làm sạch sẽ giúp hạn chế vi khuẩn tích tụ, đảm bảo an toàn vệ sinh thực phẩm.\r\n\r\nNgười dùng nên lựa chọn các sản phẩm có bề mặt trơn, ít bám bẩn và thiết kế thuận tiện cho việc lau rửa cũng như bảo quản.\r\n\r\nKết luận\r\n\r\nLựa chọn dụng cụ bếp an toàn không chỉ là vấn đề tiện ích mà còn liên quan trực tiếp đến sức khỏe của cả gia đình. Việc ưu tiên chất liệu tốt, nguồn gốc rõ ràng và tính năng phù hợp sẽ giúp người tiêu dùng yên tâm hơn trong quá trình sử dụng.\r\n\r\nMột gian bếp an toàn, sạch sẽ chính là nền tảng quan trọng để tạo nên những bữa ăn chất lượng và cuộc sống bền vững.', 'Sức khỏe', '1774694160_news_img-tintuc4.png', 2, 'HienThi', '2026-03-28 10:36:00'),
(6, 'Mẹo Vệ Sinh Nhà Bếp Nhanh Chóng Và Hiệu Quả', 'm-o-v-sinh-nh-b-p-nhanh-ch-ng-v-hi-u-qu-1774695243', 'Trong quá trình nấu nướng hàng ngày, nhà bếp là khu vực dễ tích tụ dầu mỡ, vi khuẩn và mùi thực phẩm. Nếu không được vệ sinh đúng cách, không gian bếp không chỉ mất thẩm mỹ mà còn ảnh hưởng trực tiếp đến sức khỏe của các thành viên trong gia đình.\r\n\r\nViệc duy trì thói quen vệ sinh khoa học sẽ giúp không gian bếp luôn sạch sẽ, an toàn và tạo cảm hứng trong quá trình sử dụng.\r\n\r\n1. Vệ sinh ngay sau khi nấu ăn\r\n\r\nSau mỗi lần chế biến, nên lau sạch bề mặt bếp, bàn và khu vực xung quanh để tránh dầu mỡ bám lâu ngày. Việc làm sạch ngay từ đầu giúp hạn chế vết bẩn cứng đầu và tiết kiệm thời gian dọn dẹp.\r\n\r\n2. Sử dụng nguyên liệu làm sạch an toàn\r\n\r\nCác nguyên liệu tự nhiên như giấm, chanh hoặc baking soda có khả năng làm sạch hiệu quả mà vẫn đảm bảo an toàn. Đây là giải pháp phù hợp để khử mùi và loại bỏ dầu mỡ trong không gian bếp.\r\n\r\n3. Làm sạch định kỳ các thiết bị\r\n\r\nCác thiết bị như bếp nấu, lò vi sóng, máy hút mùi hoặc tủ lạnh cần được vệ sinh định kỳ để đảm bảo hoạt động ổn định. Việc tích tụ cặn bẩn lâu ngày có thể làm giảm hiệu suất và gây mùi khó chịu.\r\n\r\n4. Giữ không gian bếp khô ráo và gọn gàng\r\n\r\nĐộ ẩm cao là điều kiện thuận lợi cho vi khuẩn phát triển. Vì vậy, cần đảm bảo khu vực bếp luôn thông thoáng, sạch sẽ và được sắp xếp hợp lý để dễ dàng vệ sinh.\r\n\r\nKết luận\r\n\r\nVệ sinh nhà bếp không chỉ là công việc hàng ngày mà còn là yếu tố quan trọng giúp bảo vệ sức khỏe gia đình và duy trì không gian sống sạch đẹp. Áp dụng những mẹo đơn giản nhưng hiệu quả sẽ giúp bạn tiết kiệm thời gian và công sức trong quá trình dọn dẹp.\r\n\r\nMột căn bếp sạch sẽ, gọn gàng sẽ luôn là nền tảng cho những bữa ăn ngon và cuộc sống chất lượng hơn.', 'Mẹo vặt', '1774695243_news_dọn-vệ-sinh-nhà-bếp.jpg', 12, 'HienThi', '2026-03-28 10:54:03'),
(7, 'Cách Bảo Quản Dụng Cụ Nhà Bếp Để Sử Dụng Được Dài Lâu', 'c-ch-b-o-qu-n-d-ng-c-nh-b-p-s-d-ng-c-d-i-l-u-1774695344', 'Bên cạnh việc lựa chọn sản phẩm chất lượng, cách bảo quản dụng cụ nhà bếp đóng vai trò quan trọng trong việc duy trì độ bền và hiệu quả sử dụng. Thực tế cho thấy, nhiều thiết bị nhanh hư hỏng không phải do chất lượng kém mà xuất phát từ việc sử dụng và bảo quản chưa đúng cách.\r\n\r\nViệc bảo quản khoa học không chỉ giúp kéo dài tuổi thọ sản phẩm mà còn đảm bảo an toàn trong quá trình sử dụng lâu dài.\r\n\r\n1. Lau khô trước khi cất giữ\r\n\r\nSau khi rửa, các dụng cụ cần được lau khô hoàn toàn trước khi cất vào tủ. Độ ẩm còn lại có thể gây hoen gỉ hoặc ẩm mốc, đặc biệt với các vật dụng bằng kim loại và gỗ.\r\n\r\n2. Tránh xếp chồng gây trầy xước\r\n\r\nCác dụng cụ như nồi, chảo chống dính không nên xếp chồng trực tiếp lên nhau. Điều này có thể làm trầy bề mặt và ảnh hưởng đến chất lượng sử dụng.\r\n\r\n3. Bảo quản đúng vị trí\r\n\r\nMỗi loại dụng cụ nên được đặt ở vị trí phù hợp để tránh va đập hoặc hư hỏng. Dao nên để trong giá riêng, các thiết bị điện nên đặt nơi khô ráo và tránh tiếp xúc với nước.\r\n\r\n4. Kiểm tra và thay thế định kỳ\r\n\r\nTrong quá trình sử dụng, nếu phát hiện sản phẩm có dấu hiệu hư hỏng như bong tróc, nứt vỡ hoặc biến dạng, nên thay thế kịp thời để đảm bảo an toàn.\r\n\r\nKết luận\r\n\r\nBảo quản dụng cụ nhà bếp đúng cách là yếu tố quan trọng giúp duy trì chất lượng và hiệu quả sử dụng lâu dài. Những thói quen nhỏ trong quá trình sử dụng hàng ngày có thể tạo ra sự khác biệt lớn về độ bền của sản phẩm.\r\n\r\nMột không gian bếp được chăm sóc đúng cách không chỉ giúp tiết kiệm chi phí mà còn mang lại sự tiện nghi và an toàn cho cuộc sống gia đình.', 'Mẹo vặt', '1774695344_news_cach-cat-giu-dung-cu-nha-bep-ben-dep-su-dung-lau-de-dang-don-avt-1200x676.jpg', 2, 'HienThi', '2026-03-28 10:55:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ghn_order_code` varchar(50) DEFAULT NULL COMMENT 'Mã vận đơn của GHN',
  `tong_tien` decimal(12,2) NOT NULL,
  `phi_van_chuyen` decimal(12,2) NOT NULL DEFAULT 0.00,
  `dia_chi_giao` text NOT NULL,
  `trang_thai` enum('ChoXacNhan','DangGiao','HoanThanh','Huy') DEFAULT 'ChoXacNhan',
  `phuong_thuc_thanh_toan` varchar(50) DEFAULT 'COD',
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `giam_gia_thanh_vien` int(11) DEFAULT 0,
  `ma_voucher` varchar(50) DEFAULT NULL,
  `giam_gia_voucher` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `ghn_order_code`, `tong_tien`, `phi_van_chuyen`, `dia_chi_giao`, `trang_thai`, `phuong_thuc_thanh_toan`, `ghi_chu`, `created_at`, `giam_gia_thanh_vien`, `ma_voucher`, `giam_gia_voucher`) VALUES
(1, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 11:21:37', 0, NULL, 0),
(2, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:22:32', 0, NULL, 0),
(3, 5, NULL, 49000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 11:23:09', 0, NULL, 0),
(4, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:27:20', 0, NULL, 0),
(5, 5, NULL, 49000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'Huy', 'COD', 'Phương thức: COD', '2026-03-23 11:32:56', 0, NULL, 0),
(6, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'Huy', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 11:33:05', 0, NULL, 0),
(7, 5, NULL, 49000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:04:21', 0, NULL, 0),
(8, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:12:13', 0, NULL, 0),
(9, 5, NULL, 49000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:29:10', 0, NULL, 0),
(10, 5, NULL, 42000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:33:05', 0, NULL, 0),
(11, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-23 12:34:09', 0, NULL, 0),
(12, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Hà Nội', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-23 12:34:18', 0, NULL, 0),
(13, 5, NULL, 49000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Đà Lạt', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-24 06:27:32', 0, NULL, 0),
(14, 5, NULL, 40000.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: Đà Lạt', 'HoanThanh', 'COD', 'Phương thức: ChuyenKhoan', '2026-03-24 06:28:19', 0, NULL, 0),
(15, 5, NULL, 30900.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 2, Quận 10, Hồ Chí Minh', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-25 07:54:16', 0, NULL, 0),
(16, 5, NULL, 92500.00, 0.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Thị Trấn Si Ma Cai, Huyện Si Ma Cai, Lào Cai', 'HoanThanh', 'COD', 'Phương thức: COD', '2026-03-26 08:04:21', 0, NULL, 0),
(17, 5, 'LTXTTT', 48500.00, 38500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 1, Thành phố Cà Mau, Cà Mau', 'HoanThanh', 'COD', '', '2026-03-26 08:27:56', 0, NULL, 0),
(18, 5, 'LTXT86', 10000.00, 82500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Chiềng Lương, Huyện Mai Sơn, Sơn La', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-26 08:41:01', 0, NULL, 0),
(19, 5, 'LTXT8N', 10000.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường Thái Bình, Thành phố Hòa Bình, Hòa Bình', 'Huy', 'ChuyenKhoan', '', '2026-03-26 08:41:22', 0, NULL, 0),
(20, 5, 'LTXHLL', 70500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường Khắc Niệm, Thành phố Bắc Ninh, Bắc Ninh', 'HoanThanh', 'ChuyenKhoan', '', '2026-03-26 08:50:30', 0, NULL, 0),
(21, 5, 'LTXAG9', 39900.00, 20900.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường 10, Quận Tân Bình, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-26 11:40:27', 0, NULL, 0),
(22, 5, 'LTXAVB', 70500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 12, Phường Hiến Nam, Thành phố Hưng Yên, Hưng Yên', 'Huy', 'COD', '', '2026-03-26 11:49:48', 0, NULL, 0),
(23, 5, 'LTAXW9', 81500.00, 71500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Đồng Thanh, Huyện Kim Động, Hưng Yên', 'Huy', 'COD', '', '2026-03-28 12:41:18', 0, NULL, 0),
(24, 5, 'LTAXTR', 79500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường Chiềng An, Thành phố Sơn La, Sơn La', 'Huy', 'COD', '', '2026-03-28 12:44:12', 0, NULL, 0),
(25, 5, 'LTAXME', 92500.00, 82500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Chiềng Mung, Huyện Mai Sơn, Sơn La', 'Huy', 'ChuyenKhoan', '', '2026-03-28 13:04:57', 0, NULL, 0),
(26, 5, 'LTAEFX', 30900.00, 20900.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 10, Quận Tân Bình, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-29 06:18:49', 0, NULL, 0),
(27, 5, 'LTAEFA', 70500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường Thịnh Lang, Thành phố Hòa Bình, Hòa Bình', 'HoanThanh', 'COD', '', '2026-03-29 06:19:57', 0, NULL, 0),
(28, 5, 'LTAE6Y', 69500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Tân Thành, Thành phố Ngã Bảy, Hậu Giang', 'ChoXacNhan', 'COD', '', '2026-03-29 06:47:01', 1000, '', 0),
(29, 5, 'LTAEBD', 69500.00, 60500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Tân Lộc Đông, Huyện Thới Bình, Cà Mau', 'ChoXacNhan', 'ChuyenKhoan', '', '2026-03-29 06:56:37', 1000, '', 0),
(30, 5, 'LTAEB3', 91500.00, 82500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Xã Quỳnh Hoa, Huyện Quỳnh Phụ, Thái Bình', 'Huy', 'ChuyenKhoan', '', '2026-03-29 06:57:43', 1000, '', 0),
(31, 5, 'LTAEX3', 79500.00, 71500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Xã Hiên Vân, Huyện Tiên Du, Bắc Ninh', 'ChoXacNhan', 'COD', '', '2026-03-29 07:27:03', 2000, 'TET2025', 10000),
(32, 5, 'LT8QGB', 114800.00, 82500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: a, Xã Nậm Mười, Huyện Văn Chấn, Yên Bái', 'HoanThanh', 'COD', '', '2026-03-29 07:55:33', 3800, 'TET2026', 1900),
(33, 5, 'LT8QCD', 45500.00, 38500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường IV, Thành phố Vị Thanh, Hậu Giang', 'ChoXacNhan', 'COD', '', '2026-03-29 08:10:54', 1000, 'TET', 2000),
(34, 5, 'LT8QVC', 88600.00, 71500.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 8, Xã Thanh Khương, Thị xã Thuận Thành, Bắc Ninh', 'ChoXacNhan', 'COD', '', '2026-03-29 08:14:12', 1900, '', 0),
(35, 5, 'LT8QV9', 37900.00, 20900.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 123, Phường 2, Quận Tân Bình, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-29 08:15:18', 2000, 'TET2026', 1000),
(36, 5, 'LT8QV6', 27900.00, 20900.00, 'Người nhận: Đào Công Anh Minh | SĐT: 0911078383 | Địa chỉ: 1, Phường 3, Quận Phú Nhuận, Hồ Chí Minh', 'DangGiao', 'ChuyenKhoan', '', '2026-03-29 08:19:03', 1000, 'TET', 2000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `so_luong` int(11) NOT NULL,
  `gia` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `so_luong`, `gia`) VALUES
(1, 1, 37, 1, 10000.00),
(2, 2, 36, 1, 10000.00),
(3, 3, 75, 1, 19000.00),
(4, 4, 37, 1, 10000.00),
(5, 5, 75, 1, 19000.00),
(6, 6, 72, 1, 10000.00),
(7, 7, 75, 1, 19000.00),
(8, 8, 37, 1, 10000.00),
(9, 9, 75, 1, 19000.00),
(10, 10, 76, 1, 12000.00),
(11, 11, 36, 1, 10000.00),
(12, 12, 71, 1, 10000.00),
(13, 13, 75, 1, 19000.00),
(14, 14, 72, 1, 10000.00),
(15, 15, 36, 1, 10000.00),
(16, 16, 36, 1, 10000.00),
(17, 17, 71, 1, 10000.00),
(18, 18, 71, 1, 10000.00),
(19, 19, 74, 1, 10000.00),
(20, 20, 37, 1, 10000.00),
(21, 21, 75, 1, 19000.00),
(22, 22, 36, 1, 10000.00),
(23, 23, 36, 1, 10000.00),
(24, 24, 75, 1, 19000.00),
(25, 25, 36, 1, 10000.00),
(26, 26, 36, 1, 10000.00),
(27, 27, 72, 1, 10000.00),
(28, 28, 37, 1, 10000.00),
(29, 29, 71, 1, 10000.00),
(30, 30, 37, 1, 10000.00),
(31, 31, 72, 2, 10000.00),
(32, 32, 75, 2, 19000.00),
(33, 33, 36, 1, 10000.00),
(34, 34, 75, 1, 19000.00),
(35, 35, 74, 2, 10000.00),
(36, 36, 37, 1, 10000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `ten_sp` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `gia` decimal(12,2) NOT NULL,
  `gia_cu` decimal(12,2) DEFAULT NULL,
  `mo_ta` text DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `danh_muc` varchar(255) DEFAULT NULL,
  `weight` int(11) NOT NULL DEFAULT 200 COMMENT 'Cân nặng tính bằng gram',
  `so_luong_ton` int(11) DEFAULT 100,
  `luot_ban` int(11) DEFAULT 0,
  `trang_thai` enum('HienThi','An','HetHang') DEFAULT 'HienThi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `ten_sp`, `slug`, `gia`, `gia_cu`, `mo_ta`, `anh`, `danh_muc`, `weight`, `so_luong_ton`, `luot_ban`, `trang_thai`, `created_at`) VALUES
(36, 'Dao  Nigara Anmon', 'dao-nigara-anmon', 10000.00, 15000.00, 'Dao Nigara Anmon nổi bật với thiết kế cao cấp và độ hoàn thiện tinh xảo, phù hợp cho nhu cầu sử dụng chuyên sâu.\r\n\r\nLưỡi dao sắc bén, bền bỉ giúp xử lý thực phẩm nhanh chóng và chính xác. Sản phẩm không chỉ mang lại hiệu quả sử dụng mà còn tạo điểm nhấn thẩm mỹ cho gian bếp.\r\n\r\nĐây là lựa chọn dành cho người dùng yêu cầu cao về chất lượng và trải nghiệm.', '1773829903_dao1.jpg', 'Dao', 200, 11, 9, 'HienThi', '2026-03-18 10:31:43'),
(37, 'Dao  Shigekatsu ', 'dao-shigekatsu-', 10000.00, 20000.00, 'Dao Shigekatsu là sản phẩm chất lượng cao, mang lại trải nghiệm cắt thái chính xác và hiệu quả.\r\n\r\nLưỡi dao được gia công tỉ mỉ giúp duy trì độ sắc lâu dài. Thiết kế chắc chắn, cân đối giúp người dùng thao tác dễ dàng và an toàn hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự chuyên nghiệp trong nấu nướng.', '1773829999_dao2.jpg', 'Dao', 200, 18, 7, 'HienThi', '2026-03-18 10:33:19'),
(38, 'Dao  Kagahaki', 'dao-kagahaki', 14999.00, 25000.00, 'Dao Kagahaki được thiết kế tinh tế, đáp ứng tốt nhu cầu chế biến thực phẩm hàng ngày.\r\n\r\nLưỡi dao sắc giúp cắt thái nhanh chóng, hạn chế dập nát thực phẩm. Chất liệu bền bỉ giúp sản phẩm sử dụng lâu dài mà vẫn giữ được hiệu quả.\r\n\r\nĐây là lựa chọn phù hợp cho gian bếp gia đình.', '1773830055_dao3.jpg', 'Dao', 200, 100, 0, 'HienThi', '2026-03-18 10:34:15'),
(39, 'Dao  Hamatogi', 'dao-hamatogi', 12000.00, 15000.00, 'Dao Hamatogi mang phong cách hiện đại, phù hợp với nhiều nhu cầu sử dụng khác nhau trong nhà bếp.\r\n\r\nLưỡi dao sắc bén giúp cắt thái nhanh gọn, trong khi tay cầm chắc chắn tạo cảm giác thoải mái khi sử dụng. Sản phẩm có độ bền cao và dễ vệ sinh.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng yêu thích sự tiện dụng.', '1773830130_dao4.jpg', 'Dao', 200, 30, 0, 'HienThi', '2026-03-18 10:35:30'),
(40, 'Dao chặt xương Nhật', 'dao-ch-t-x-ng-nh-t', 19999.00, 30000.00, 'Dao chặt xương Nhật là dụng cụ chuyên dụng với độ bền cao, phù hợp cho việc chặt thực phẩm cứng.\r\n\r\nLưỡi dao dày và chắc giúp xử lý xương hoặc thực phẩm cứng một cách dễ dàng. Thiết kế cân đối giúp giảm lực khi sử dụng và tăng độ an toàn.\r\n\r\nĐây là lựa chọn cần thiết cho gian bếp chuyên nghiệp và gia đình.', '1773830219_dao5.jpg', 'Dao', 200, 10, 0, 'HienThi', '2026-03-18 10:36:59'),
(41, 'Dao thái sashimi', 'dao-th-i-sashimi', 13000.00, 15000.00, 'Dao thái sashimi được thiết kế chuyên biệt để cắt lát mỏng các loại cá sống với độ chính xác cao.\r\n\r\nLưỡi dao dài và sắc giúp tạo ra những lát cắt mịn, không làm nát thực phẩm. Chất liệu cao cấp giúp duy trì độ sắc và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là sản phẩm lý tưởng cho những ai yêu thích ẩm thực Nhật Bản.', '1773830270_dao6.jpg', 'Dao', 200, 40, 0, 'HienThi', '2026-03-18 10:37:50'),
(42, 'Dao thái bản to', 'dao-th-i-b-n-to', 15000.00, 20000.00, 'Dao thái bản to là dụng cụ chuyên dụng giúp cắt thái thực phẩm nhanh chóng và hiệu quả.\r\n\r\nVới bản dao rộng và chắc chắn, sản phẩm phù hợp để thái thịt, chặt nhẹ hoặc sơ chế thực phẩm số lượng lớn. Thiết kế cân đối giúp thao tác ổn định và chính xác hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai thường xuyên nấu ăn và cần sự tiện lợi.', '1773830388_dao7.jpg', 'Dao', 200, 80, 0, 'HienThi', '2026-03-18 10:39:48'),
(43, 'Dao  Shinzu', 'dao-shinzu', 10000.00, 25000.00, 'Dao Shinzu nổi bật với thiết kế tinh tế và khả năng cắt thái linh hoạt trong gian bếp.\r\n\r\nLưỡi dao được gia công sắc bén, giúp xử lý nhiều loại thực phẩm từ rau củ đến thịt cá một cách dễ dàng. Tay cầm chắc chắn giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là sản phẩm không thể thiếu cho công việc nấu nướng hàng ngày.', '1773830466_dao8.jpg', 'Dao', 200, 100, 0, 'HienThi', '2026-03-18 10:41:06'),
(44, 'Dao Kagenkio', 'dao-kagenkio', 10000.00, 15000.00, 'Dao Kagenkio là sản phẩm được thiết kế chuyên dụng cho việc cắt thái thực phẩm với độ chính xác cao.\r\n\r\nLưỡi dao sắc bén giúp thao tác nhanh gọn, hạn chế dập nát thực phẩm. Chất liệu bền chắc giúp duy trì độ sắc lâu dài và đảm bảo an toàn khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho cả người nội trợ và người yêu thích nấu ăn chuyên nghiệp.', '1773903954_dao9.jpg', 'Dao', 200, 17, 0, 'HienThi', '2026-03-18 10:42:54'),
(45, 'Nồi cơm điện Kalpen', 'n-i-c-m-i-n-kalpen', 20000.00, 30000.00, 'Nồi cơm điện Kalpen mang đến giải pháp nấu ăn hiện đại với thiết kế sang trọng và nhiều tính năng tiện ích.\r\n\r\nSản phẩm hỗ trợ nhiều chế độ nấu như cơm, cháo, hấp… giúp đáp ứng đa dạng nhu cầu sử dụng. Lòng nồi bền bỉ, truyền nhiệt tốt giúp cơm chín nhanh và ngon hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai muốn nâng cấp trải nghiệm nấu ăn trong gia đình.', '1773831102_noicomdien.jpg', 'Nồi', 200, 100, 0, 'HienThi', '2026-03-18 10:51:42'),
(46, 'Nồi cơm điện chống dính', 'n-i-c-m-i-n-ch-ng-d-nh', 10000.00, 25000.00, 'Nồi cơm điện chống dính là thiết bị quen thuộc trong mỗi gia đình, giúp nấu cơm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm được trang bị lòng nồi phủ chống dính, giúp cơm không bị bám dính và dễ dàng vệ sinh sau khi sử dụng. Công nghệ gia nhiệt ổn định giúp cơm chín đều, giữ được độ dẻo và hương vị tự nhiên.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần sự tiện lợi và tiết kiệm thời gian trong nấu nướng.', '1773831219_noi-com-r3-2.jpg', 'Nồi', 200, 10, 0, 'HienThi', '2026-03-18 10:53:39'),
(47, 'Nồi áp suất Kalpen', 'n-i-p-su-t-kalpen', 10000.00, 15000.00, 'Nồi áp suất Kalpen giúp rút ngắn thời gian nấu nướng mà vẫn đảm bảo thực phẩm chín mềm và giữ được dinh dưỡng.\r\n\r\nSản phẩm được trang bị các chế độ an toàn cùng khả năng điều chỉnh áp suất linh hoạt. Thiết kế hiện đại giúp việc sử dụng trở nên dễ dàng hơn.\r\n\r\nĐây là thiết bị cần thiết cho những gia đình bận rộn.', '1773831292_noi-ap-suat-kalpen-p4.jpg', 'Nồi', 200, 25, 0, 'HienThi', '2026-03-18 10:54:52'),
(48, 'Nồi nấu chậm Kalpen', 'n-i-n-u-ch-m-kalpen', 10000.00, 20000.00, 'Nồi nấu chậm Kalpen là thiết bị giúp chế biến các món ăn như hầm, nấu cháo hoặc súp một cách dễ dàng.\r\n\r\nCông nghệ nấu chậm giúp giữ nguyên hương vị và dưỡng chất trong thực phẩm. Thiết kế tiện lợi, dễ sử dụng phù hợp với nhiều nhu cầu nấu ăn khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho những bữa ăn dinh dưỡng.', '1773831341_noi-nau-cham-sk2.jpg', 'Nồi', 200, 15, 0, 'HienThi', '2026-03-18 10:55:41'),
(49, 'Nồi ủ chân không ', 'n-i-ch-n-kh-ng-', 20000.00, 25000.00, 'Nồi ủ chân không là thiết bị hỗ trợ nấu ăn tiết kiệm năng lượng, giữ nhiệt lâu và giúp thực phẩm chín mềm tự nhiên.\r\n\r\nSản phẩm hoạt động bằng cách giữ nhiệt sau khi đun sôi, giúp món ăn tiếp tục chín mà không cần sử dụng thêm điện hoặc gas. Điều này giúp giữ lại dưỡng chất trong thực phẩm.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên sự tiện lợi và tiết kiệm.', '1773831420_noi-u-e13-6.jpg', 'Nồi', 200, 20, 0, 'HienThi', '2026-03-18 10:57:00'),
(50, 'Bộ 3 nồi inox ', 'b-3-n-i-inox-', 20000.00, 50000.00, 'Bộ 3 nồi inox là giải pháp tiện lợi cho nhu cầu nấu nướng đa dạng trong gia đình.\r\n\r\nSản phẩm bao gồm nhiều kích thước khác nhau, phù hợp để chế biến nhiều loại món ăn. Chất liệu inox bền bỉ giúp đảm bảo an toàn và dễ vệ sinh.\r\n\r\nĐây là lựa chọn tối ưu giúp tiết kiệm chi phí và không gian.', '1773831518_bo-noi-inox-kalpen-gl1.jpg', 'Nồi', 200, 100, 0, 'HienThi', '2026-03-18 10:58:38'),
(51, 'Nồi inox 304', 'n-i-inox-304', 10000.00, 12000.00, 'Nồi inox 304 được đánh giá cao nhờ chất liệu cao cấp, an toàn cho sức khỏe và độ bền vượt trội.\r\n\r\nSản phẩm có khả năng chống ăn mòn, chịu nhiệt tốt và không phản ứng với thực phẩm trong quá trình nấu. Thiết kế tiện dụng giúp việc nấu ăn trở nên dễ dàng hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho gian bếp hiện đại.', '1773831602_noi.jpg', 'Nồi', 200, 10, 0, 'HienThi', '2026-03-18 11:00:02'),
(52, 'Nồi lẩu inox', 'n-i-l-u-inox', 12000.00, 15000.00, 'Nồi lẩu inox là sản phẩm lý tưởng cho những bữa ăn sum họp gia đình và bạn bè.\r\n\r\nVới chất liệu inox bền chắc, nồi có khả năng giữ nhiệt tốt và phân bổ nhiệt đều. Thiết kế rộng rãi giúp chế biến nhiều loại thực phẩm cùng lúc.\r\n\r\nĐây là lựa chọn hoàn hảo cho những bữa ăn ấm cúng.', '1773831704_noilau.jpg', 'Nồi', 200, 2, 0, 'HienThi', '2026-03-18 11:01:44'),
(53, 'Ấm đun nước inox', '-m-un-n-c-inox', 12000.00, 15000.00, 'Ấm đun nước inox là lựa chọn truyền thống kết hợp với độ bền cao và tính an toàn.\r\n\r\nChất liệu inox giúp chống gỉ sét, chịu nhiệt tốt và dễ dàng vệ sinh. Thiết kế chắc chắn giúp sản phẩm sử dụng ổn định trong thời gian dài.\r\n\r\nĐây là sản phẩm phù hợp cho mọi gia đình.', '1773831772_am-dun-nuoc-inox-2-5l.jpg', 'Đồ Điện', 200, 10, 0, 'HienThi', '2026-03-18 11:02:52'),
(54, 'Ấm đun nước siêu tốc', '-m-un-n-c-si-u-t-c', 15000.00, 20000.00, 'Ấm đun nước siêu tốc là thiết bị quen thuộc trong mỗi gia đình, giúp đun nước nhanh chóng chỉ trong vài phút.\r\n\r\nSản phẩm được thiết kế tiện lợi, dễ sử dụng với khả năng tự ngắt khi nước sôi, đảm bảo an toàn. Chất liệu bền bỉ giúp duy trì hiệu suất sử dụng lâu dài.\r\n\r\nĐây là giải pháp tiện ích cho nhu cầu sinh hoạt hàng ngày.', '1773831818_am-dun-sieu-toc-hai-lop-kalpen-ar49-1-8l.jpg', 'Đồ Điện', 200, 25, 0, 'HienThi', '2026-03-18 11:03:38'),
(55, 'Bếp từ đơn Kalpen', 'b-p-t-n-kalpen', 10000.00, 15000.00, 'Bếp từ đơn Kalpen mang đến giải pháp nấu nướng hiện đại, an toàn và tiết kiệm điện năng.\r\n\r\nSản phẩm sử dụng công nghệ từ giúp làm nóng nhanh, kiểm soát nhiệt độ chính xác và hạn chế thất thoát nhiệt. Thiết kế nhỏ gọn, phù hợp với nhiều không gian bếp khác nhau.\r\n\r\nĐây là lựa chọn lý tưởng cho cuộc sống tiện nghi và hiện đại.', '1773831875_ik2.jpg', 'Đồ Điện', 200, 10, 0, 'HienThi', '2026-03-18 11:04:35'),
(56, 'Máy xay sinh tố ', 'm-y-xay-sinh-t-', 10000.00, 15000.00, 'Máy xay sinh tố là thiết bị không thể thiếu trong gian bếp hiện đại, giúp chế biến thực phẩm nhanh chóng và tiện lợi.\r\n\r\nSản phẩm hỗ trợ xay sinh tố, nước ép, cháo hoặc thực phẩm mềm một cách dễ dàng. Lưỡi dao sắc bén cùng công suất ổn định giúp nguyên liệu được xay nhuyễn mịn, giữ trọn dinh dưỡng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình chú trọng đến chế độ ăn uống lành mạnh.', '1773831947_may-xay-da-nang-3-coi-thuy-tinh-kalpen-b8-500w-1.jpg', 'Đồ Điện', 200, 10, 0, 'HienThi', '2026-03-18 11:05:47'),
(57, 'Máy ép chậm Kalpen', 'm-y-p-ch-m-kalpen', 10000.00, 15000.00, 'Máy ép chậm Kalpen là thiết bị hỗ trợ ép trái cây và rau củ với hiệu suất cao, giúp giữ lại tối đa dưỡng chất.\r\n\r\nCông nghệ ép chậm hạn chế sinh nhiệt, giúp nước ép giữ được màu sắc và hương vị tự nhiên. Thiết kế hiện đại, dễ vệ sinh và vận hành ổn định.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình quan tâm đến chế độ ăn uống lành mạnh và dinh dưỡng', '1773831985_dsc06964.jpg', 'Đồ Điện', 200, 10, 0, 'HienThi', '2026-03-18 11:06:25'),
(58, 'Máy vắt cam thông minh', 'm-y-v-t-cam-th-ng-minh', 10000.00, 15000.00, 'Máy vắt cam thông minh giúp việc chuẩn bị nước ép trở nên nhanh chóng và tiện lợi hơn.\r\n\r\nThiết kế nhỏ gọn, dễ sử dụng cùng khả năng tách nước hiệu quả giúp giữ trọn hương vị và dưỡng chất từ trái cây. Sản phẩm phù hợp cho nhu cầu sử dụng hàng ngày.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích đồ uống tươi và tốt cho sức khỏe.', '1773832030_may-vat-cam-thong-minh-kalpen-1.jpg', 'Đồ Điện', 200, 10, 0, 'HienThi', '2026-03-18 11:07:10'),
(59, 'Nồi chiên không dầu ', 'n-i-chi-n-kh-ng-d-u-', 10000.00, 15000.00, 'Nồi chiên không dầu là thiết bị hiện đại giúp chế biến món ăn với lượng dầu tối thiểu, phù hợp với xu hướng ăn uống lành mạnh.\r\n\r\nSản phẩm có thể chiên, nướng hoặc hâm nóng thực phẩm một cách nhanh chóng. Công nghệ làm nóng giúp thực phẩm chín đều mà vẫn giữ được độ giòn bên ngoài.\r\n\r\nĐây là thiết bị không thể thiếu trong gian bếp hiện đại.', '1773832213_b(151).jpg', 'Đồ Điện', 200, 15, 0, 'HienThi', '2026-03-18 11:10:13'),
(60, 'Chảo chống dính cao cấp', 'ch-o-ch-ng-d-nh-cao-c-p', 15000.00, 24000.00, 'Chảo chống dính cao cấp mang lại trải nghiệm nấu nướng tối ưu nhờ lớp phủ chống dính chất lượng cao.\r\n\r\nSản phẩm giúp giảm lượng dầu mỡ, hạn chế bám dính và dễ dàng vệ sinh. Thiết kế chắc chắn, tay cầm tiện dụng giúp thao tác an toàn và thoải mái hơn.\r\n\r\nĐây là lựa chọn phù hợp cho những ai muốn nâng cấp trải nghiệm nấu ăn.', '1773832301_chao-chong-dinh-cao-cap-kalpen-durker-3.jpg', 'Chảo', 200, 10, 0, 'HienThi', '2026-03-18 11:11:41'),
(61, 'Chảo inox', 'ch-o-inox', 10000.00, 15000.00, 'Chảo inox là sản phẩm bền bỉ, phù hợp với nhiều nhu cầu nấu nướng khác nhau trong gia đình.\r\n\r\nVới chất liệu inox chắc chắn, chảo có khả năng chịu nhiệt tốt và ít bị biến dạng. Sản phẩm giúp phân bổ nhiệt đều, hỗ trợ quá trình nấu ăn hiệu quả hơn.\r\n\r\nĐây là lựa chọn đáng tin cậy cho việc sử dụng lâu dài.', '1773832344_dsc07011.jpg', 'Chảo', 200, 10, 0, 'HienThi', '2026-03-18 11:12:24'),
(62, 'Chảo chống dính ceramic', 'ch-o-ch-ng-d-nh-ceramic', 10000.00, 15000.00, 'Chảo chống dính ceramic được đánh giá cao nhờ lớp phủ an toàn, không chứa các chất gây hại khi nấu ở nhiệt độ cao.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, chống bám dính hiệu quả và dễ vệ sinh. Ngoài ra, thiết kế hiện đại giúp tăng tính thẩm mỹ cho không gian bếp.\r\n\r\nĐây là lựa chọn phù hợp cho người dùng quan tâm đến sức khỏe và chất lượng bữa ăn.', '1773832411_chao-chong-dinh-baby-kalpen-3.jpg', 'Chảo', 200, 15, 0, 'HienThi', '2026-03-18 11:13:31'),
(63, 'Chảo chống dính', 'ch-o-ch-ng-d-nh', 15000.00, 18000.00, 'Chảo chống dính là dụng cụ không thể thiếu trong mỗi gian bếp nhờ tính tiện lợi và dễ sử dụng.\r\n\r\nLớp phủ chống dính giúp hạn chế cháy khét và giữ nguyên hương vị món ăn. Sản phẩm phù hợp với nhiều món như chiên trứng, xào rau hoặc chế biến các món ăn nhanh.\r\n\r\nĐây là lựa chọn cơ bản nhưng cần thiết cho mọi gia đình.', '1773832435_img-chao-size3.png', 'Chảo', 200, 10010, 0, 'HienThi', '2026-03-18 11:13:55'),
(64, 'Chảo chống dính sâu lòng', 'ch-o-ch-ng-d-nh-s-u-l-ng', 10000.00, 15000.00, 'Chảo chống dính sâu lòng được thiết kế với lòng chảo rộng và sâu, phù hợp cho nhiều món ăn như chiên, xào hoặc nấu.\r\n\r\nLớp chống dính chất lượng giúp hạn chế thức ăn bám dính, giảm lượng dầu mỡ khi nấu và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp thao tác nấu ăn trở nên linh hoạt hơn.\r\n\r\nSản phẩm là trợ thủ đắc lực cho các bữa ăn gia đình hàng ngày.', '1773832492_chao-chong-dinh-cao-cap-kalpen-lipper-1.jpg', 'Chảo', 200, 15, 0, 'HienThi', '2026-03-18 11:14:52'),
(65, 'Chảo inox 304', 'ch-o-inox-304', 10000.00, 25000.00, 'Chảo inox 304 là sản phẩm được ưa chuộng nhờ độ bền cao và khả năng chống ăn mòn tốt. Chất liệu inox 304 giúp đảm bảo an toàn khi tiếp xúc với thực phẩm.\r\n\r\nSản phẩm có khả năng chịu nhiệt tốt, phân bổ nhiệt đều giúp món ăn chín nhanh và giữ được hương vị tự nhiên. Ngoài ra, chảo dễ vệ sinh và ít bị biến dạng khi sử dụng lâu dài.\r\n\r\nĐây là lựa chọn phù hợp cho những ai ưu tiên độ bền và tính an toàn trong gian bếp.', '1773832551_chao-inox-lien-khoi-ts26.jpg', 'Chảo', 200, 16, 0, 'HienThi', '2026-03-18 11:15:51'),
(66, 'Bát Kuromi', 'b-t-kuromi', 10000.00, 16000.00, 'Bát Kuromi nổi bật với thiết kế dễ thương, lấy cảm hứng từ nhân vật hoạt hình được nhiều người yêu thích. Sản phẩm mang đến cảm giác vui tươi và sinh động cho mỗi bữa ăn.\r\n\r\nĐược làm từ chất liệu an toàn, bề mặt nhẵn mịn và dễ vệ sinh, bát phù hợp để đựng cơm, canh hoặc các món ăn hàng ngày. Kích thước vừa phải giúp người dùng dễ dàng sử dụng cho nhiều đối tượng.\r\n\r\nĐây là lựa chọn lý tưởng để tạo điểm nhấn cho bàn ăn, đặc biệt phù hợp với gia đình có trẻ nhỏ.', '1773832795_20260228_D9xP4YASJQ.jpg', 'Chén', 200, 100, 0, 'HienThi', '2026-03-18 11:19:55'),
(67, 'Dĩa ANM', 'd-a-anm', 12000.00, 14000.00, 'Đĩa ANM có thiết kế đơn giản nhưng hiện đại, phù hợp với nhiều phong cách bàn ăn khác nhau.\r\n\r\nSản phẩm được изготов từ chất liệu bền, an toàn và dễ dàng vệ sinh sau khi sử dụng. Thiết kế tiện dụng giúp việc bày trí món ăn trở nên gọn gàng và đẹp mắt hơn.\r\n\r\nĐây là lựa chọn phù hợp cho nhu cầu sử dụng hàng ngày trong gia đình.', '1773832834_A-211-Dia-ANM-FLO-26020091.jpg', 'Chén', 200, 10, 0, 'HienThi', '2026-03-18 11:20:34'),
(68, 'Dĩa quả bơ', 'd-a-qu-b-', 10000.00, 15000.00, 'Đĩa quả bơ sở hữu thiết kế sáng tạo, lấy cảm hứng từ hình dáng tự nhiên, mang lại sự mới lạ cho không gian bếp.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bền chắc và dễ vệ sinh. Kích thước phù hợp giúp trình bày món ăn đẹp mắt hơn.\r\n\r\nĐây là lựa chọn lý tưởng cho những ai yêu thích sự độc đáo và tinh tế.', '1773832881_A-210-Dia-ANM-26020092-1.jpg', 'Chén', 200, 15, 0, 'HienThi', '2026-03-18 11:21:21'),
(69, 'Bát Shin', 'b-t-shin', 12000.00, 15000.00, 'Bát Shin được thiết kế với họa tiết nhân vật quen thuộc, mang lại cảm giác gần gũi và vui nhộn khi sử dụng. Đây là sản phẩm được nhiều gia đình lựa chọn, đặc biệt là cho trẻ em.\r\n\r\nChất liệu bền, an toàn cho sức khỏe, cùng thiết kế tiện dụng giúp việc sử dụng trở nên dễ dàng hơn. Bát phù hợp để đựng nhiều loại thực phẩm khác nhau.\r\n\r\nSản phẩm không chỉ hữu ích mà còn tạo điểm nhấn thú vị cho bàn ăn.', '1773832928_20260228_wzhA6Th1vM.jpg', 'Chén', 200, 15, 0, 'HienThi', '2026-03-18 11:22:08'),
(70, 'Bát dễ thương', 'b-t-d-th-ng', 10000.00, 15000.00, 'Bát dễ thương là sản phẩm mang phong cách trẻ trung, phù hợp với nhiều không gian bếp hiện đại. Thiết kế nhỏ gọn, tiện lợi giúp người dùng dễ dàng sử dụng trong sinh hoạt hàng ngày.\r\n\r\nChất liệu an toàn, bền bỉ và dễ làm sạch giúp sản phẩm luôn giữ được vẻ ngoài sạch đẹp. Đây là lựa chọn phù hợp cho cả gia đình, đặc biệt là giới trẻ.\r\n\r\nSản phẩm góp phần tạo nên những bữa ăn vui vẻ và ấm cúng.', '1773833246_20260228_pIvBWIZG1e.jpg', 'Chén', 200, 100, 0, 'HienThi', '2026-03-18 11:27:26'),
(71, 'Bát cánh cụt', 'b-t-c-nh-c-t', 10000.00, 15000.00, 'Bát cánh cụt gây ấn tượng với thiết kế đáng yêu, phù hợp cho gia đình có trẻ nhỏ hoặc những ai yêu thích phong cách dễ thương.\r\n\r\nSản phẩm được làm từ chất liệu an toàn, bề mặt nhẵn mịn, dễ vệ sinh và sử dụng hàng ngày. Kích thước vừa phải giúp thuận tiện trong việc đựng cơm, canh hoặc các món ăn khác.\r\n\r\nĐây là lựa chọn giúp bữa ăn trở nên sinh động và thú vị hơn.', '1773833394_20260113_iIloUP5722.jpg', 'Chén', 200, 96, 4, 'HienThi', '2026-03-18 11:29:54'),
(72, 'Thớt gỗ', 'th-t-g-', 10000.00, 15000.00, 'Thớt gỗ là dụng cụ nhà bếp truyền thống, được nhiều gia đình tin dùng nhờ độ bền và tính an toàn cao. Sản phẩm phù hợp cho nhiều loại thực phẩm khác nhau.\r\n\r\nVới chất liệu gỗ tự nhiên, thớt có khả năng chịu lực tốt, ít cong vênh và không làm ảnh hưởng đến lưỡi dao khi sử dụng. Ngoài ra, sản phẩm còn dễ vệ sinh và có tuổi thọ lâu dài.\r\n\r\nĐây là lựa chọn đáng tin cậy cho mọi gian bếp.', '1773833536_thot-go-teak-ongtre-dang-cap-phong-cach-au-my-9308-0-65a0de8234421e74198d89b4.jpg', 'Thớt', 200, 5, 5, 'HienThi', '2026-03-18 11:32:16'),
(73, 'Thớt gỗ tre hình quả táo', 'th-t-g-tre-h-nh-qu-t-o', 10000.00, 15000.00, 'Thớt gỗ tre hình quả táo nổi bật với thiết kế độc đáo, mang lại điểm nhấn thẩm mỹ cho không gian bếp. Sản phẩm không chỉ phục vụ nhu cầu chế biến mà còn có thể dùng để trang trí hoặc bày biện món ăn.\r\n\r\nChất liệu tre tự nhiên thân thiện với môi trường, có độ bền cao và an toàn cho sức khỏe. Bề mặt thớt được xử lý mịn, giúp dễ dàng vệ sinh sau khi sử dụng.\r\n\r\nSản phẩm phù hợp với những ai yêu thích sự sáng tạo và tinh tế trong gian bếp.', '1773833599_thot-go-tre-hinh-qua-tao-30x30cm-9068-1-6597ace803b66fafeb1974af.jpg', 'Thớt', 200, 100, 0, 'HienThi', '2026-03-18 11:33:19'),
(74, 'Thớt nhựa ', 'th-t-nh-a-', 10000.00, 15000.00, 'Thớt nhựa là sản phẩm phổ biến nhờ trọng lượng nhẹ và dễ dàng vệ sinh. Với thiết kế hiện đại, sản phẩm phù hợp cho nhiều mục đích sử dụng trong gian bếp hàng ngày.\r\n\r\nChất liệu nhựa an toàn giúp hạn chế bám mùi thực phẩm, đồng thời có khả năng chống thấm nước tốt. Bề mặt thớt được thiết kế chống trượt, giúp thao tác cắt thái an toàn hơn.\r\n\r\nĐây là giải pháp tiện lợi cho những ai ưu tiên sự gọn nhẹ và dễ sử dụng.', '1773833681_thot-nhua-khang-khuan-homeselect-tron-30cm-10236-0-65bcc8c4b4eee16ecd576d70.jpg', 'Thớt', 200, 98, 3, 'HienThi', '2026-03-18 11:34:41'),
(75, 'Thớt gỗ đa dụng', 'th-t-g-a-d-ng', 19000.00, 20000.00, 'Thớt gỗ đa dụng được thiết kế nhằm đáp ứng nhiều nhu cầu sử dụng khác nhau trong nhà bếp như cắt rau củ, thịt cá hay chế biến thực phẩm.\r\n\r\nVới chất liệu gỗ bền chắc, sản phẩm có khả năng chịu lực tốt, hạn chế nứt vỡ và đảm bảo độ an toàn khi sử dụng. Thiết kế tiện lợi giúp người dùng dễ dàng thao tác và vệ sinh sau khi sử dụng.\r\n\r\nĐây là lựa chọn phù hợp cho những gia đình cần một sản phẩm linh hoạt và bền bỉ.', '1773833725_thot-go-da-dung-200x300x20mm-moriitalia-thot00009829-10136-0-65bcc87eb4eee16ecd5768bd.jpg', 'Thớt', 200, 96, 10, 'HienThi', '2026-03-18 11:35:25'),
(76, 'Thớt gỗ tròn', 'th-t-g-tr-n', 12000.00, 15000.00, 'Thớt gỗ tròn là lựa chọn phù hợp cho những ai yêu thích sự đơn giản và tiện dụng trong gian bếp. Với thiết kế tròn gọn gàng, sản phẩm giúp thao tác cắt thái trở nên linh hoạt và dễ dàng hơn.\r\n\r\nSản phẩm được làm từ gỗ tự nhiên, bề mặt chắc chắn, hạn chế trầy xước dao và đảm bảo an toàn khi tiếp xúc thực phẩm. Ngoài ra, thớt còn dễ vệ sinh và có độ bền cao khi sử dụng lâu dài.\r\n\r\nĐây là vật dụng không thể thiếu giúp công việc nấu nướng trở nên thuận tiện và hiệu quả hơn.', '1773833790_thot-go-trang-tri-hinh-tron-6572836103997b00cce7174f-1.jpg', 'Thớt', 200, 0, 1, 'HienThi', '2026-03-18 11:36:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(13, 75, 5, 5, 'Quá đẹp', '2026-03-29 09:58:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(20) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL,
  `gioi_tinh` varchar(10) DEFAULT 'Nam',
  `hang` varchar(50) DEFAULT 'Đồng',
  `trang_thai` enum('HoatDong','Khoa') DEFAULT 'HoatDong',
  `ngay_sinh` date DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_expire` datetime DEFAULT NULL
) ;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `dia_chi`, `gioi_tinh`, `hang`, `trang_thai`, `ngay_sinh`, `avatar`, `created_at`, `remember_token`, `remember_expire`) VALUES
(4, 'Đào Công Anh Minh', 'Minhkendy1903@gmail.com', '$2y$10$kDeZ/bc0Ai9WW5jA0Z0eMedyY3DP4remjYLms7YfkOvOJpN2oP2Ri', '0911078381', 'Sài Gòn', 'Nam', 'Đồng', 'HoatDong', '2026-03-20', 'uploads/1773833815_dao1.jpg', '2026-03-16 12:43:44', NULL, NULL),
(5, 'Đào Công Anh Minh', 'daoconganhminh1902@gmail.com', '$2y$10$OgsIdKwxHGWpLChaQtgHKOK/WIyxF9UApcQdbLvFjUc6FmTIqBx66', '0911078383', 'Đà Lạt', 'Nam', 'Kim Cương', 'HoatDong', '2026-02-26', 'uploads/1774333586_default-avatar.png', '2026-03-22 11:32:22', NULL, NULL);

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
(3, 'TET2026', 'PhanTram', 5, 5000, 20000, 5, 2, '2026-03-29 14:41:00', '2026-04-02 14:41:00', 'HoatDong'),
(4, 'TET', 'TienMat', 2000, 0, 10000, 5, 2, '2026-03-20 15:00:00', '2026-04-25 15:03:00', 'HoatDong'),
(5, 'XUAN', 'TienMat', 5000, 0, 30000, 6, 0, '2026-03-20 15:01:00', '2026-04-05 15:01:00', 'HoatDong'),
(6, 'FREESHIP', 'FreeShip', 10000, 0, 30000, 9, 0, '2026-03-29 15:02:00', '2026-05-02 15:02:00', 'HoatDong');

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
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

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
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
