-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 12, 2023 at 03:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shopthoitrang`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `level` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `level`, `created`) VALUES
(1, 'admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 0, 1641509311);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `sort_order` tinyint(4) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `description`, `parent_id`, `sort_order`, `created`) VALUES
(1, 'Thời trang1', '', 0, 1, '2023-12-04 05:35:21'),
(2, 'Bán chạy', '', 0, 2, '2023-12-04 05:35:48'),
(3, 'Khuyến mại', '', 0, 3, '2023-12-04 05:35:59'),
(4, 'Tin tức', '', 0, 4, '2023-12-04 05:36:13'),
(5, 'Giỏ hàng', '', 0, 6, '2023-12-04 05:36:49'),
(6, 'Liên hệ', '', 0, 5, '2023-12-04 09:33:45'),
(7, 'Thời trang nam', '', 1, 1, '2023-12-04 05:37:23'),
(8, 'Thời trang nữ', '', 1, 2, '2023-12-04 05:37:36'),
(9, 'Thời trang trẻ em', 'trẻ em', 1, 4, '2023-12-04 00:00:00'),
(10, 'Áo Hoodie, Áo Len , Áo Nỉ', '', 7, 1, '2023-12-04 09:08:19'),
(11, 'Áo sơ mi nam', '', 7, 2, '2023-12-04 09:08:36'),
(12, 'Quần Jeans Nam', '', 7, 3, '2023-12-04 09:09:01'),
(14, 'Quần Short', '', 7, 5, '2023-12-04 09:09:31'),
(15, 'Áo thun nữ', '', 8, 1, '2023-12-04 09:09:46'),
(16, 'Áo khoác, Áo choàng , Vest', '', 8, 2, '2023-12-04 09:10:10'),
(17, 'Đầm, váy', '', 8, 3, '2023-12-04 09:23:39'),
(18, 'Áo công sở', '', 8, 4, '2023-12-04 00:53:25'),
(19, 'Áo thun nam', '', 7, 1, '2023-12-06 15:10:34'),
(20, 'Quần Jeans Nữ', '', 8, 3, '2023-12-06 15:24:34');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `product_id`, `name`, `content`, `date`, `reply`) VALUES
(3, 25, 'Nga', 'Vải xịn!', '2023-12-05 12:44:25', NULL),
(4, 27, 'nga', 'đẹp!', '2023-12-05 14:37:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `transaction_id` int(100) NOT NULL,
  `product_id` int(100) NOT NULL,
  `qty` int(100) NOT NULL DEFAULT 0,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` int(11) NOT NULL DEFAULT 0,
  `size_id` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(255) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` int(11) DEFAULT 0,
  `image_link` varchar(100) NOT NULL,
  `image_list` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `view` int(11) NOT NULL DEFAULT 0,
  `buyed` int(255) NOT NULL,
  `rate_total` int(255) NOT NULL DEFAULT 4,
  `rate_count` int(255) NOT NULL DEFAULT 1,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `catalog_id`, `name`, `content`, `price`, `discount`, `image_link`, `image_list`, `view`, `buyed`, `rate_total`, `rate_count`, `created`) VALUES
(1, 8, 'Áo len cổ tròn nữ dáng đẹp', '<p><strong>Th&ocirc;ng tin sản phẩm:</strong></p>\r\n\r\n<p>K&iacute;ch thước: M L XL 2XL</p>\r\n\r\n<p>M&ocirc; h&igrave;nh: Phim hoạt h&igrave;nh</p>\r\n\r\n<p>Loại cổ &aacute;o: Cổ tr&ograve;n</p>\r\n\r\n<p>Độ d&agrave;y sợi: Sợi th&ocirc;ng thường (10 kim, 12 kim)</p>\r\n\r\n<p>M&agrave;u sắc: Hồng đỏ xanh trắng</p>\r\n\r\n<p>Loại tay &aacute;o: Thường xuy&ecirc;n</p>\r\n\r\n<p><strong>M&ocirc; tả:</strong></p>\r\n\r\n<p>M&ugrave;a &aacute;p dụng: M&ugrave;a đ&ocirc;ng</p>\r\n\r\n<p>Chiều d&agrave;i tay &aacute;o: D&agrave;i tay</p>\r\n\r\n<p>Phi&ecirc;n bản: Loose</p>\r\n\r\n<p>Đối tượng &aacute;p dụng: Thanh ni&ecirc;n</p>\r\n\r\n<p>Phong c&aacute;ch: &Aacute;o chui đầu</p>\r\n\r\n<p>Th&agrave;nh phần nguy&ecirc;n liệu: 100% Cotton</p>\r\n\r\n<p>- Kh&ocirc;ng sử dụng chất tẩy, kh&ocirc;ng ng&acirc;m sản phẩm. Sử dụng x&agrave; ph&ograve;ng trung t&iacute;nh, kh&ocirc;ng sử dụng x&agrave; ph&ograve;ng c&oacute; chất tẩy mạnh.</p>\r\n\r\n<p>- Bảo quản nơi kh&ocirc; r&aacute;o, tho&aacute;ng m&aacute;t.</p>\r\n', 250000.00, 50000, 'sp1_1.jpg', '[\"sp1_2.jpg\",\"sp1_3.jpg\",\"sp1_4.jpg\"]', 27, 6, 10, 2, '2023-12-04 06:36:16'),
(2, 16, 'Áo len nữ form rộng dài tay dáng dài họa tiết kẻ caro', '<p>⭕<strong> Th&ocirc;ng tin sản ph&acirc;̉m:</strong></p>\r\n\r\n<p>- Xu&acirc;́t xứ: Quảng Ch&acirc;u</p>\r\n\r\n<p>- Giới tính: Nữ</p>\r\n\r\n<p>- Kích Thước &Aacute;o len nữ form rộng d&agrave;i tay dành cho các bạn &lt; 65kg</p>\r\n\r\n<p>- Chi&ecirc;̀u Dài: 68cm</p>\r\n\r\n<p>- Ngực Áo: 118cm</p>\r\n\r\n<p>- Màu Sắc: Đen caro</p>\r\n\r\n<p>⭕&nbsp; <strong>M&ocirc; tả:</strong></p>\r\n\r\n<p>Chất liệu Áo Len Cardigan, Gile,: Đa số c&aacute;c &aacute;o len được l&agrave;m bằng len truyền thống d&ugrave;ng để kho&aacute;c l&uacute;c thời tiết chuyển sang thu/đ&ocirc;ng.Hầu hết c&aacute;c mẫu &aacute;o Gile sẽ kh&ocirc;ng c&oacute; phần khuy c&agrave;i ở ph&iacute;a trước mặc choàng đ&acirc;̀u.Tuy nhi&ecirc;n cũng c&oacute; một số mẫu sẽ c&oacute; th&ecirc;m phần khuy &aacute;o để tiện cho người sử dụng</p>\r\n\r\n<p>- Ch&acirc;́t Li&ecirc;̣u: Khoác Cardigan Len thì Sợi len sẽ dày dặn hơn các m&acirc;̃u Gile và được thi&ecirc;́t k&ecirc;́ theo ki&ecirc;̉u dáng hàn qu&ocirc;́c khoác ngoài năng đ&ocirc;̣ng, đa ph&acirc;̀n các m&acirc;̃u sẽ có kèm cúc</p>\r\n\r\n<p>- Thiết kế Gile Len: trẻ trung, năng động, m&agrave;u sắc bắt mắt c&ugrave;ng c&aacute;c họa tiết n&ocirc;̉i b&acirc;̣t cá tính</p>\r\n\r\n<p>C&aacute;ch phối đồ với Áo Len, Gile Len, Cardigan Len: Áo Len l&agrave; item kh&ocirc;ng thể thiếu trong tủ đồ của mỗi chàng trai hay m&ocirc;̃i c&ocirc; gái. Bạn h&atilde;y phối &aacute;o kho&aacute;c nỉ với quần jeans, qu&acirc;̀n kaki c&ugrave;ng c&aacute;c phụ kiện như t&uacute;i, mũ sẽ tăng th&ecirc;m phần trẻ trung, năng động. các bạn nữ cũng c&oacute; thể mix th&ecirc;m c&ugrave;ng ch&acirc;n v&aacute;y, đầm liền th&acirc;n thanh lịch.</p>\r\n', 235000.00, 0, 'sp2_1.jpg', '[\"sp2_2.jpg\",\"sp2_3.jpg\"]', 5, 0, 5, 1, '2023-12-04 06:36:16'),
(3, 10, 'Áo Nỉ Hoodzip BOO Dáng Oversize Harry Potter BOOZILLA', '<p>BOO rất h&acirc;n hạnh l&agrave; nh&atilde;n thời trang đầu ti&ecirc;n v&agrave; duy nhất sở hữu bản quyền thương hiệu Harry Potter tại Việt Nam khi ch&iacute;nh thức cho ra mắt Bộ sưu tập BOO x Harry Potter</p>\r\n\r\n<p>- &Aacute;o kho&aacute;c nỉ Hoodzip th&ecirc;u Harry Potter trước &aacute;o</p>\r\n\r\n<p>- Mặt sau &aacute;o in họa tiết Hogwarts, c&ugrave;ng logo của 4 nh&agrave; đầy nổi bật</p>\r\n\r\n<p>- D&aacute;ng &aacute;o oversized th&iacute;ch hợp cho cả nam v&agrave; nữ</p>\r\n\r\n<p>- Chất liệu : Nỉ</p>\r\n\r\n<p>- Size mẫu mặc : M - fit 65g</p>\r\n\r\n<p><strong>BẢO QUẢN SẢN PHẨM:</strong></p>\r\n\r\n<p>- Kh&ocirc;ng ng&acirc;m trong chất tẩy rửa qu&aacute; 10 ph&uacute;t.</p>\r\n\r\n<p>- Giặt ở nhiệt độ nước kh&ocirc;ng qu&aacute; 30&deg;C.</p>\r\n\r\n<p>- Ủi ở nhiệt độ kh&ocirc;ng qu&aacute; 150&deg;C.</p>\r\n\r\n<p>- Kh&ocirc;ng d&ugrave;ng thuốc tẩy.</p>\r\n\r\n<p>- Kh&ocirc;ng phơi trực tiếp dưới &aacute;nh s&aacute;ng mặt trời.</p>\r\n', 200000.00, 20000, 'sp3_1.jpg', '[\"sp3_2.jpg\",\"sp3_3.jpg\"]', 51, 4, 5, 1, '2023-12-04 06:36:16'),
(4, 16, 'Áo Khoác Cardigan nam nữ phong cách Hàn Quốc', '<p><strong>TH&Ocirc;NG TIN SẢN PHẨM</strong></p>\r\n\r\n<p>- Chất liệu: Nỉ b&ocirc;ng</p>\r\n\r\n<p>- Form: from rộng</p>\r\n\r\n<p>- M&agrave;u sắc: Kem phối n&acirc;u</p>\r\n\r\n<p>- Thiết&nbsp;kế: In lụa cao cấp</p>\r\n\r\n<p>Kh&ocirc;ng chỉ l&agrave; thời trang, TEELAB c&ograve;n l&agrave; &ldquo;ph&ograve;ng th&iacute; nghiệm&rdquo; của tuổi trẻ - nơi nghi&ecirc;n cứu v&agrave; cho ra đời nguồn năng lượng mang t&ecirc;n &ldquo;Youth&rdquo;. Ch&uacute;ng m&igrave;nh lu&ocirc;n muốn tạo n&ecirc;n những trải nghiệm vui vẻ, năng động v&agrave; trẻ trung. Lấy cảm hứng từ giới trẻ, s&aacute;ng tạo li&ecirc;n tục, bắt kịp xu hướng v&agrave; ph&aacute;t triển đa dạng c&aacute;c d&ograve;ng sản phẩm l&agrave; c&aacute;ch m&agrave; ch&uacute;ng m&igrave;nh hoạt động để tạo n&ecirc;n phong c&aacute;ch sống hằng ng&agrave;y của bạn. Mục ti&ecirc;u của TEELAB l&agrave; cung cấp c&aacute;c sản phẩm thời trang chất lượng cao với gi&aacute; th&agrave;nh hợp l&yacute;. Chẳng c&ograve;n thời gian để loay hoay nữa đ&acirc;u youngers ơi! H&atilde;y nhanh ch&acirc;n bắt lấy những những khoảnh khắc tuyệt vời của tuổi trẻ. TEELAB đ&atilde; sẵn s&agrave;ng trải nghiệm c&ugrave;ng bạn!</p>\r\n\r\n<p>_____________________________________</p>\r\n\r\n<p><strong>Hướng dẫn sử dụng sản phẩm Teelab:</strong></p>\r\n\r\n<p>- Giặt &Aacute;o Kho&aacute;c Cardigan ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.&nbsp;</p>\r\n\r\n<p>- &Aacute;o Kho&aacute;c Cardigan Kh&ocirc;ng d&ugrave;ng h&oacute;a chất tẩy.</p>\r\n\r\n<p>- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi (nếu c&oacute;) th&igrave; ở nhiệt độ th&iacute;ch hợp.</p>\r\n\r\n<p>_____________________________________</p>\r\n', 250000.00, 100000, 'sp4_1.jpg', '[\"sp4_2.jpg\",\"sp4_3.jpg\"]', 23, 2, 5, 1, '2023-12-04 06:36:16'),
(5, 7, 'Quần Nỉ Jogger BOO Unisex Entry Oversized', '<p><strong>M&Ocirc; TẢ SẢN PHẨM</strong></p>\r\n\r\n<p>- Form d&aacute;ng: Quần rộng, d&agrave;i, bo chun. Quần khi mặc c&oacute; độ thụng kh&aacute; nhiều, rộng r&atilde;i, thoải m&aacute;i cử động. Ph&ugrave; hợp với kh&aacute;ch h&agrave;ng ưu ti&ecirc;n sự thoải m&aacute;i, th&iacute;ch mặc kiểu thụng, c&oacute; thể mix c&ugrave;ng c&aacute;c kiểu croptop tạo cảm gi&aacute;c tiny top, big bottom; hoặc mặc c&ugrave;ng c&aacute;c sản phẩm &aacute;o nỉ OVS kiểu matching set để đảm bảo sự thoải m&aacute;i nhất.</p>\r\n\r\n<p>- Mẫu nam: 1m80 - 70kg - Size M</p>\r\n\r\n<p>- Mẫu nữ: 1m58 - 47kg - Size S</p>\r\n\r\n<p>_____________________________________</p>\r\n\r\n<p><strong>BẢO QUẢN SẢN PHẨM</strong></p>\r\n\r\n<p>- Lộn tr&aacute;i sản phẩm khi giặt, kh&ocirc;ng giặt chung sản phẩm trắng với quần &aacute;o tối m&agrave;u.</p>\r\n\r\n<p>- Kh&ocirc;ng sử dụng chất tẩy, kh&ocirc;ng ng&acirc;m sản phẩm. Sử dụng x&agrave; ph&ograve;ng trung t&iacute;nh, kh&ocirc;ng sử dụng x&agrave; ph&ograve;ng c&oacute; chất tẩy mạnh.</p>\r\n\r\n<p>- Bảo quản nơi kh&ocirc; r&aacute;o, tho&aacute;ng m&aacute;t.</p>\r\n\r\n<p>_____________________________________</p>\r\n', 200000.00, 0, 'sp5_1.jpg', '[\"sp5_2.jpg\",\"sp5_3.jpg\",\"sp5_4.jpg\"]', 28, 0, 5, 1, '2023-12-04 06:36:16'),
(6, 14, 'Quần Short Nỉ Nam BOO Dáng Bermuda', '<p><strong>M&Ocirc; TẢ SẢN PHẨM:</strong></p>\r\n\r\n<p>Chất liệu: 65% l&agrave; sợi polyester v&agrave; 35% l&agrave; sợi b&ocirc;ng tự nhi&ecirc;n. Chất nỉ d&agrave;y dặn giữ nhiệt tốt, kh&ocirc;ng x&ugrave; v&agrave; c&oacute; độ đứng form nhất định</p>\r\n\r\n<p>M&agrave;u sắc: Be/N&acirc;u/Đen/Xanh l&aacute;</p>\r\n\r\n<p>Size: XS-L</p>\r\n\r\n<p>Brand: BOO</p>\r\n\r\n<p>Họa tiết: Logo BOO in to bản dọc th&acirc;n quần</p>\r\n\r\n<p>Mẫu nam: 1m85 - 70kg - Size L Mẫu nữ: 1m58 - 47kg - Size S</p>\r\n\r\n<p>--------------------------------------</p>\r\n\r\n<p><strong>BẢO QUẢN SẢN PHẨM:</strong></p>\r\n\r\n<p>- Lộn tr&aacute;i sản phẩm khi giặt, kh&ocirc;ng giặt chung sản phẩm trắng với quần &aacute;o tối m&agrave;u.</p>\r\n\r\n<p>- Kh&ocirc;ng sử dụng chất tẩy, kh&ocirc;ng ng&acirc;m sản phẩm. Sử dụng x&agrave; ph&ograve;ng trung t&iacute;nh, kh&ocirc;ng sử dụng x&agrave; ph&ograve;ng c&oacute; chất tẩy mạnh.</p>\r\n\r\n<p>- Bảo quản nơi kh&ocirc; r&aacute;o, tho&aacute;ng m&aacute;t.</p>\r\n\r\n<p>--------------------------------------</p>\r\n', 179000.00, 20000, 'sp6_1.jpg', '[\"sp6_2.jpg\",\"sp6_3.jpg\"]', 7, 5, 9, 2, '2023-12-04 06:36:16'),
(7, 16, 'Áo Khoác Cardigan Teelab Local Brand Unisex', '<p><strong>Th&ocirc;ng tin sản phẩm:</strong></p>\r\n\r\n<p>- Chất liệu: Len</p>\r\n\r\n<p>- Form: Oversize</p>\r\n\r\n<p>- M&agrave;u sắc: Kem</p>\r\n\r\n<p><strong>????</strong> &Aacute;o được l&agrave;m từ chất liệu nỉ b&ocirc;ng mềm mịn</p>\r\n\r\n<p><strong>????</strong> Đặc biệt &aacute;o c&oacute; chi tiết th&ecirc;u chữ trước ngực gi&uacute;p &aacute;o trở n&ecirc;n độc lạ hơn</p>\r\n\r\n<p><strong>????</strong> Thiết kế mũ/n&oacute;n bảo vệ bạn khỏi gi&oacute; lạnh v&agrave; mưa nhẹ, c&oacute; thể điều chỉnh mũ/n&oacute;n bằng d&acirc;y r&uacute;t để tạo sự vừa vặn tốt nhất</p>\r\n\r\n<p><strong>????</strong> &Aacute;o c&oacute; t&uacute;i trước lớn, gi&uacute;p bạn cất giữ điện thoại, v&iacute; tiền, hoặc tay ấm trong những ng&agrave;y se lạnh.</p>\r\n\r\n<p><strong>????</strong> &Aacute;o hoodie n&agrave;y c&oacute; thiết kế đơn giản với m&agrave;u sắc trơn, dễ d&agrave;ng kết hợp với nhiều trang phục kh&aacute;c nhau.</p>\r\n\r\n<p><strong>????</strong> &Aacute;o c&oacute; thể giặt m&aacute;y v&agrave; chất liệu kh&ocirc;ng nhăn, gi&uacute;p bạn tiết kiệm thời gian chăm s&oacute;c</p>\r\n\r\n<p><strong>Hướng dẫn sử dụng sản phẩm Teelab:</strong></p>\r\n\r\n<p>- Ng&acirc;m &aacute;o v&agrave;o NƯỚC LẠNH c&oacute; pha giấm hoặc ph&egrave;n chua từ trong 2 tiếng đồng hồ</p>\r\n\r\n<p>- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.</p>\r\n\r\n<p>- Kh&ocirc;ng d&ugrave;ng h&oacute;a chất tẩy.</p>\r\n\r\n<p>- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi (nếu c&oacute;) th&igrave; ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 300000.00, 0, 'sp7_1.jpg', '[\"sp7_2.jpg\",\"sp7_3.jpg\",\"sp7_4.jpg\"]', 0, 0, 4, 1, '2023-12-05 08:16:03'),
(8, 16, 'Áo Hoodie Teelab Local Brand Unisex', '<p><strong>???? TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>- Chất liệu: Nỉ b&ocirc;ng 360gsm</p>\r\n\r\n<p>- Form: Oversize</p>\r\n\r\n<p>- M&agrave;u sắc: Kem</p>\r\n\r\n<p>- Thiết kế: In lụa</p>\r\n\r\n<p><strong>????&nbsp;M&Ocirc; TẢ CHI TIẾT SẢN PHẨM</strong>&nbsp;</p>\r\n\r\n<p>- &Aacute;o được l&agrave;m từ chất liệu nỉ b&ocirc;ng mềm mịn</p>\r\n\r\n<p>- Đặc biệt &aacute;o c&oacute; chi tiết th&ecirc;u chữ trước ngực gi&uacute;p &aacute;o trở n&ecirc;n độc lạ hơn</p>\r\n\r\n<p>- Thiết kế mũ/n&oacute;n bảo vệ bạn khỏi gi&oacute; lạnh v&agrave; mưa nhẹ, c&oacute; thể điều chỉnh mũ/n&oacute;n bằng d&acirc;y r&uacute;t để tạo sự vừa vặn tốt nhất</p>\r\n\r\n<p>- &Aacute;o c&oacute; t&uacute;i trước lớn, gi&uacute;p bạn cất giữ điện thoại, v&iacute; tiền, hoặc tay ấm trong những ng&agrave;y se lạnh.</p>\r\n\r\n<p>- &Aacute;o hoodie n&agrave;y c&oacute; thiết kế đơn giản với m&agrave;u sắc trơn, dễ d&agrave;ng kết hợp với nhiều trang phục kh&aacute;c nhau.</p>\r\n\r\n<p>- &Aacute;o c&oacute; thể giặt m&aacute;y v&agrave; chất liệu kh&ocirc;ng nhăn, gi&uacute;p bạn tiết kiệm thời gian chăm s&oacute;c</p>\r\n\r\n<p><strong>Hướng dẫn sử dụng sản phẩm Teelab:</strong></p>\r\n\r\n<p>- Ng&acirc;m &aacute;o v&agrave;o NƯỚC LẠNH c&oacute; pha giấm hoặc ph&egrave;n chua từ trong 2 tiếng đồng hồ</p>\r\n\r\n<p>- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.</p>\r\n\r\n<p>- Kh&ocirc;ng d&ugrave;ng h&oacute;a chất tẩy.</p>\r\n\r\n<p>- Hạn chế sử dụng m&aacute;y sấy v&agrave; ủi (nếu c&oacute;) th&igrave; ở nhiệt độ th&iacute;ch hợp.</p>\r\n', 500000.00, 0, 'sp8_1.jpg', '[\"sp8_2.jpg\"]', 0, 0, 4, 1, '2023-12-04 08:21:12'),
(9, 19, 'Adidas Phong cách sống Áo Thun 3 Sọc Classics Adicolor Nam', '<p>C&ugrave;ng ch&agrave;o đ&oacute;n chiếc &aacute;o thun y&ecirc;u th&iacute;ch mới của bạn. Chiếc &aacute;o thun adidas classic n&agrave;y c&oacute; d&aacute;ng &ocirc;m v&agrave; viền &aacute;o tương phản đậm chất vintage tinh tế. Kết hợp chiếc &aacute;o n&agrave;y với chiếc quần denim tối m&agrave;u ưa th&iacute;ch, bạn sẽ dễ d&agrave;ng c&oacute; được một outfit classic. &Aacute;o l&agrave;m từ chất vải cotton si&ecirc;u mềm mại gi&uacute;p bạn lu&ocirc;n thoải m&aacute;i.</p>\r\n\r\n<p>C&aacute;c sản phẩm cotton của ch&uacute;ng t&ocirc;i hỗ trợ ng&agrave;nh trồng b&ocirc;ng bền vững hơn.</p>\r\n\r\n<p>- D&aacute;ng slim fit</p>\r\n\r\n<p>- Cổ tr&ograve;n bo g&acirc;n</p>\r\n\r\n<p>- Vải single jersey l&agrave;m từ 100% cotton</p>\r\n\r\n<p>- Viền tay &aacute;o bo g&acirc;n</p>\r\n', 125000.00, 10000, 'sp9_1.jpg', '[\"sp9_2.jpg\",\"sp9_3.jpg\"]', 4, 0, 4, 1, '2023-12-04 06:36:16'),
(10, 19, 'Adidas Bóng đá Áo Đấu Sân Khách Manchester United 22/23', '<p>Họ nổi tiếng với m&agrave;u &aacute;o đỏ. Nhưng Manchester United cũng đ&atilde; c&oacute; biết bao đ&ecirc;m thi đấu huy ho&agrave;ng trong sắc &aacute;o trắng. Với họa tiết tinh tế phủ to&agrave;n bộ &aacute;o, huy hiệu chiếc khi&ecirc;n c&ugrave;ng 3 Sọc đỏ v&agrave; đen, chiếc &aacute;o đấu b&oacute;ng đ&aacute; s&acirc;n kh&aacute;ch adidas n&agrave;y g&oacute;p phần v&agrave;o bề d&agrave;y di sản ấy. C&ocirc;ng nghệ AEROREADY tho&aacute;t ẩm v&agrave; c&aacute;c mảng phối lưới mang đến cảm gi&aacute;c thoải m&aacute;i cho người h&acirc;m mộ.</p>\r\n\r\n<p>L&agrave;m từ 100% chất liệu t&aacute;i chế, sản phẩm n&agrave;y đại diện cho một trong số rất nhiều c&aacute;c giải ph&aacute;p của ch&uacute;ng t&ocirc;i hướng tới chấm dứt r&aacute;c thải nhựa.</p>\r\n\r\n<p>- D&aacute;ng regular fit</p>\r\n\r\n<p>- Cổ chữ V c&oacute; g&acirc;n sọc</p>\r\n\r\n<p>- Vải dệt interlock l&agrave;m từ 100% polyester t&aacute;i chế</p>\r\n\r\n<p>- C&ocirc;ng nghệ AEROREADY thấm h&uacute;t ẩm</p>\r\n\r\n<p>- C&aacute;c mảng lưới dưới c&aacute;nh tay</p>\r\n\r\n<p>- Viền tay &aacute;o bo g&acirc;n</p>\r\n', 130000.00, 0, 'sp10_1.jpg', '[\"sp10_2.jpg\",\"sp10_3.jpg\"]', 37, 3, 4, 1, '2023-12-04 06:36:16'),
(11, 20, 'Quần jean nữ dài cạp cao ống suông', '<p><strong>TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>- T&ecirc;n sản phẩm: Quần jean nữ d&agrave;i cạp cao ống su&ocirc;ng</p>\r\n\r\n<p>-&nbsp;Chất liệu:&nbsp; kaki/jean d&agrave;y dặn co gi&atilde;n nhẹ thoải m&aacute;i</p>\r\n\r\n<p>- 2 M&agrave;u sắc: Xanh, đen</p>\r\n\r\n<p>- Th&ocirc;ng số sản phẩm:</p>\r\n\r\n<p>+ Size S: nặng 40 - 45 kg ( cao 1,50 - 1,65 m&eacute;t)</p>\r\n\r\n<p>+ Size M: nặng 46 - 50 kg (cao 1,50 - 1,65 m&eacute;t)</p>\r\n\r\n<p>+ Size L: nặng 51 - 55 kg ( cao 1,50 - 1,65 m&eacute;t)</p>\r\n\r\n<p>+ Size XL: nặng 56- 60 kg (cao 1,50 - 1,65 m&eacute;t)</p>\r\n\r\n<p>- Xuất xứ: Việt Nam</p>\r\n\r\n<p><strong>HƯỚNG DẪN SỬ DỤNG:</strong></p>\r\n\r\n<p>-&nbsp; N&ecirc;n giặt m&aacute;y ở chế độ m&aacute;y nhẹ nh&agrave;ng hoặc giặt tay</p>\r\n', 200000.00, 30000, 'sp11_1.jpg', '[\"sp11_2.jpg\",\"sp11_3.jpg\"]', 8, 2, 5, 1, '2023-12-04 06:36:16'),
(12, 12, 'Quần Jean Ống Rộng Nam WASH', '<p>Quần jean unisex nam nữ hiphop UNISEX quần jean su&ocirc;ng rộng CẠP CAO 2023</p>\r\n\r\n<p><strong>Ưu điểm:</strong> Quần jean ống rộng unisex nam nữ ph&ugrave; hợp với m&ocirc;i trường đi l&agrave;m, đi chơi, dự tiệc, sinh nhật,quần jean unisex nam nữ cạp cao ống rộng T023 c&oacute; độ d&agrave;i vừa phải tạo d&aacute;ng vẻ dễ thương nhưng kh&ocirc;ng k&eacute;m phần thanh lịch. sản phẩm được thiết kế tỉ mỉ từng đường kim mũi chỉ đạt ti&ecirc;u chuẩn xuất khẩu.</p>\r\n\r\n<p>+ S 38-45kg eo dưới 66cm</p>\r\n\r\n<p>+ M 45-50kg eo dưới 70cm</p>\r\n\r\n<p>+ L 50-60kg eo dưới 75cm</p>\r\n\r\n<p>+ XL 60-70kg eo dưới 80cm</p>\r\n\r\n<p>+ 2XL 70-90kg eo dưới 90cm</p>\r\n', 330000.00, 50000, 'sp12_1.jpg', '[\"sp12_2.jpg\",\"sp12_3.jpg\"]', 5, 0, 5, 1, '2023-12-04 06:36:16'),
(13, 11, 'Áo sơ mi sọc BoizClub Premium nam nữ form rộng hàn quốc', '<p><strong>???? Th&ocirc;ng tin sản phẩm:</strong></p>\r\n\r\n<p>- Chất liệu: Vải cotton cao cấp d&agrave;y dặn chống nhăn</p>\r\n\r\n<p>- Đường may tỉ mỉ, chắc chắn.</p>\r\n\r\n<p>- Thiết kế hiện đại, trẻ trung, năng động, dễ phối đồ.</p>\r\n\r\n<p>- Đủ size: M - L - XL.</p>\r\n\r\n<p><strong>???? Cam kết:</strong></p>\r\n\r\n<p>- Sản phẩm &Aacute;o sơ mi kẻ sọc BOIZCLUB 100% giống m&ocirc; tả. H&igrave;nh ảnh sản phẩm ch&acirc;n thật ,đầy đủ tem, m&aacute;c, bao b&igrave; cao cấp.</p>\r\n\r\n<p>- H&igrave;nh ảnh sản phẩm l&agrave; ảnh thật do shop tự chụp v&agrave; giữ bản quyền h&igrave;nh ảnh</p>\r\n\r\n<p>- Đảm bảo vải chất lượng chuẩn xuất khẩu.</p>\r\n\r\n<p>- &Aacute;o được kiểm tra kỹ c&agrave;ng, cẩn thận v&agrave; tư vấn nhiệt t&igrave;nh trước khi g&oacute;i h&agrave;ng giao cho Qu&yacute; Kh&aacute;ch</p>\r\n\r\n<p>- H&agrave;ng c&oacute; sẵn, giao h&agrave;ng ngay khi nhận được đơn</p>\r\n\r\n<p>- Ho&agrave;n tiền nếu sản phẩm kh&ocirc;ng giống với m&ocirc; tả</p>\r\n\r\n<p>- Chấp nhận đổi h&agrave;ng khi size kh&ocirc;ng vừa (vui l&ograve;ng nhắn tin ri&ecirc;ng cho shop)</p>\r\n\r\n<p>- Hỗ trợ đổi trả theo quy định của Shopee</p>\r\n', 150000.00, 0, 'sp13_1.jpg', '[\"sp13_2.jpg\",\"sp13_3.jpg\"]', 5, 0, 5, 1, '2023-12-04 06:36:16'),
(14, 17, 'Váy Nữ Giả 2 Món, Phong Cách Mới, Váy Ngắn Mùa Thu', '<p><strong>???? TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>Chất Liệu: Trượt H&agrave;n Mềm Mịn, chất vải đanh, mặc đứng d&aacute;ng, chống nhăn, c&oacute; độ tho&aacute;ng khi mặc, thấm h&uacute;t mồ h&ocirc;i ️</p>\r\n\r\n<p>Thiết kế basic, đơn giản dễ mặc v&agrave; sử dụng, dễ phối với c&aacute;c trang phục kh&aacute;c ️</p>\r\n\r\n<p>Size: S, M, L, l=&gt; ( S-44Kg đến 4XL-70Kg)</p>\r\n\r\n<p>HƯỚNG DẪN CHỌN SIZE Size c&oacute; thể thay đổi t&ugrave;y v&agrave;o chiều cao mỗi người kh&aacute;c nhau n&ecirc;n kh&aacute;ch đừng vội chọn SIZE theo đ&aacute;nh gi&aacute; của kh&aacute;ch h&agrave;ng nh&eacute;!</p>\r\n\r\n<p>Nếu kh&oacute; chọn SIZE hoặc c&ograve;n đang ph&acirc;n v&acirc;n đừng ngại ngần cứ chat với Shop để tư vấn chọn SIZE chuẩn nhất ạ!</p>\r\n\r\n<p><strong>???? BẢNG SIZE:</strong></p>\r\n\r\n<p>S: 3kg đến 53kg&nbsp;</p>\r\n\r\n<p>M:54kg đến 62kg&nbsp;</p>\r\n\r\n<p>L: 62kg đến 69kg&nbsp;</p>\r\n\r\n<p><strong>???? CAM KẾT:</strong></p>\r\n\r\n<p>- Kh&ocirc;ng b&aacute;n h&agrave;ng k&eacute;m chất lượng.</p>\r\n\r\n<p>- &Aacute;o sơ mi 100% giống m&ocirc; tả</p>\r\n\r\n<p>- Tư vấn nhiệt t&igrave;nh, chu đ&aacute;o lu&ocirc;n lắng nghe kh&aacute;ch h&agrave;ng để phục vụ tốt.</p>\r\n\r\n<p>- Giao h&agrave;ng nhanh đ&uacute;ng tiến độ kh&ocirc;ng phải để qu&yacute; kh&aacute;ch chờ đợi l&acirc;u để nhận h&agrave;ng.</p>\r\n', 275000.00, 10000, 'sp14_1.jpg', '[\"sp14_2.jpg\",\"sp14_3.jpg\"]', 4, 0, 5, 3, '2023-12-04 06:36:16'),
(15, 17, 'Chân váy tennis ngắn xếp ly thời trang nữ Hàn Quốc', '<p><strong>TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>Xuất xứ: Tỉnh Quảng Đ&ocirc;ng</p>\r\n\r\n<p>Phong c&aacute;ch: Đi lại đơn giản / Phi&ecirc;n bản H&agrave;n Quốc</p>\r\n\r\n<p>C&aacute;c yếu tố phổ biến: D&acirc;y k&eacute;o</p>\r\n\r\n<p>Phong c&aacute;ch: quần ph&ugrave; hợp</p>\r\n\r\n<p>Chiều d&agrave;i tay &aacute;o: Kh&ocirc;ng tay</p>\r\n\r\n<p>Vải / chất liệu: Denim / Cotton</p>\r\n\r\n<p>Nội dung th&agrave;nh phần: 30% trở xuống</p>\r\n\r\n<p>Độ tuổi &aacute;p dụng: Thanh ni&ecirc;n (18-25 tuổi)</p>\r\n\r\n<p>C&oacute; th&ecirc;m nhung hay kh&ocirc;ng: Kh&ocirc;ng c&oacute; nhung</p>\r\n\r\n<p>M&ugrave;a ni&ecirc;m yết thời gian: M&ugrave;a h&egrave; 2023</p>\r\n', 250000.00, 36000, 'sp15_1.jpg', '[\"sp15_2.jpg\",\"sp15_3.jpg\"]', 37, 1, 5, 4, '2023-12-04 06:36:16'),
(16, 17, 'Đầm Nhung Hai Dây Xòe Tầng Phối Nơ TIBU', '<p>Duy tr&igrave; sự chỉn chu trong chất liệu v&agrave; đường may, lắng nghe tận t&acirc;m từng đ&oacute;ng g&oacute;p của kh&aacute;ch h&agrave;ng. ĐẸP - TRENDY - GI&Aacute; RẺ - DỊCH VỤ TỐI ƯU lu&ocirc;n l&agrave; kim chỉ nam trong tư duy kinh doanh nh&agrave; TIBU.&nbsp;&nbsp;</p>\r\n\r\n<p>Đến với ch&uacute;ng m&igrave;nh, n&agrave;ng kh&ocirc;ng chỉ trở th&agrave;nh những &quot;C&ocirc; em trendy&quot; với c&aacute;c items bắt trend cực nhanh, kh&ocirc;ng trộn lẫn, được ra mắt đều đặn v&agrave;o mỗi th&aacute;ng, đi k&egrave;m mức gi&aacute; hợp t&uacute;i tiền. M&agrave; c&ograve;n ko cần phải đắn đo lựa chọn bởi ch&uacute;ng m&igrave;nh lu&ocirc;n c&oacute; đa dạng mẫu m&atilde; cho n&agrave;ng. Đ&oacute; c&oacute; thể l&agrave; một item gi&uacute;p bạn khoe body sexy hết cỡ, cũng c&oacute; thể l&agrave; thiết kế mang đến sự thoải m&aacute;i, thanh lịch, tạo n&ecirc;n kh&iacute; chất v&agrave; n&eacute;t cuốn h&uacute;t ri&ecirc;ng.&nbsp;</p>\r\n\r\n<p>Với TIBU, ch&uacute;ng m&igrave;nh lu&ocirc;n mong muốn trở th&agrave;nh BẠN ĐỒNG H&Agrave;NH khiến N&Agrave;NG l&agrave; phi&ecirc;n bản ĐẸP nhất của ch&iacute;nh m&igrave;nh <strong>????</strong></p>\r\n', 170000.00, 0, 'sp16_1.jpg', '[\"sp16_2.jpg\"]', 2, 1, 5, 1, '2023-12-04 06:36:16'),
(17, 8, 'Sét Váy Dạ 3 Món Áo Dạ Phối Cổ Sơ Mi 2 Lớp Có Đệm Vai', '<p><strong>TH&Ocirc;NG TIN SẢN PHẨM&nbsp;</strong></p>\r\n\r\n<p>✨Cảm ơn bạn đ&atilde; v&agrave;o cửa h&agrave;ng của t&ocirc;i!T&ocirc;i c&oacute; mục đ&iacute;ch mua bất cứ thứ g&igrave; hoặc chỉ t&igrave;m kiếm ti&ecirc;u d&ugrave;ng, bởi v&igrave; chỉ những thương gia mới c&oacute; thể thực hiện những đặc điểm của anh ấy v&agrave; cung cấp cho bạn dịch vụ h&oacute;a học, v&igrave; vậy t&ocirc;i cũng muốn mang lại đề xuất n&agrave;y cho mọi kh&aacute;ch h&agrave;ng, h&atilde;y chọn, h&atilde;y chọn cao- Dịch vụ chăm s&oacute;c chất lượng, ️ Theo d&otilde;i cửa h&agrave;ng n&agrave;y</p>\r\n\r\n<p><strong>SET DẠ HOT 3 M&Oacute;N PHỐI CỔ TAY K&Egrave;M ĐAI DA</strong></p>\r\n\r\n<p><strong>????</strong>&Aacute;o phối kẻ si&ecirc;u đẹp, chất dạ text 2 lớp l&ecirc;n form đứng d&aacute;ng lắm ạ</p>\r\n\r\n<p>Ch&acirc;n v&aacute;y xếp ly liền quần thoải m&aacute;i vận động kh&ocirc;ng sợ lộ nha</p>\r\n\r\n<p>➖Tặng k&egrave;m th&ecirc;m đai da sịn s&ograve;</p>\r\n\r\n<p><strong>---------------------------------------</strong></p>\r\n\r\n<p>Chất liệu: Dạ</p>\r\n\r\n<p>Size: S, M, L</p>\r\n\r\n<p><strong>???? Bảng size tham khảo :</strong></p>\r\n\r\n<p>Size S dưới 47kg</p>\r\n\r\n<p>Size M từ 48-54kg</p>\r\n\r\n<p>Size L từ&nbsp; 55-58kg (t&ugrave;y chiều cao nh&eacute;)</p>\r\n', 549000.00, 20000, 'sp17_1.jpg', '[\"sp17_2.jpg\",\"sp17_3.jpg\",\"sp17_4.jpg\"]', 4, 1, 5, 1, '2023-12-04 06:36:16'),
(18, 12, 'Quần Jean Ống Suông Thời Trang Đường Phố Mỹ Cá Tính', '<p>️✨&nbsp;<strong>Ưu Điểm:</strong> Quần kaki ống loe unisex nam nữ gấu phối c&uacute;c bấm XMAX mang phong c&aacute;ch trẻ trung năng động &quot;BadBoy&quot; được sẵn đ&oacute;n rất nhiều trong thời điểm hiện tại.</p>\r\n\r\n<p>- Quần kaki ống loe unisex nam nữ gấu phối c&uacute;c bấm được thiết kế nhiều c&uacute;c với nhiều k&iacute;ch thước bằng nhau tạo phong c&aacute;ch thời trang đặc biệt được giới trẻ t&igrave;m kiếm rất nhiều v&agrave; được biệt c&aacute;c bạn th&iacute;ch phong c&aacute;ch đường phố hiphop.</p>\r\n\r\n<p>- Nếu bạn kh&ocirc;ng tự tin v&igrave; m&igrave;nh c&oacute; một đ&ocirc;i ch&acirc;n cong hoặc chiều cao c&oacute; hạn th&igrave; bạn y&ecirc;n t&acirc;m với chiếc Quần Buttons Pants ống su&ocirc;ng nam nh&agrave; Xmax được thiết kế với d&aacute;ng quần su&ocirc;ng ống rộng sẽ gi&uacute;p bạn giải quyết những vấn đề tr&ecirc;n. V&agrave; gi&uacute;p bạn tự tin hơn với chiếc quần kaki nam phối gấu c&uacute;c bấm.</p>\r\n\r\n<p>- Quần kaki ống loe unisex nam nữ gấu phối c&uacute;c bấm kết hơp với &aacute;o ph&ocirc;ng, &aacute;o Polo trẻ trung năng động thoải m&aacute;i hoặc kế hợp với &aacute;o sơ mi ngắn tay mang đến cho bạn một vẻ ngo&agrave;i thanh lịch v&agrave; lịch sự kết hợp c&ugrave;ng với đ&ocirc;i gi&agrave;y Sneaker l&agrave; một sư kết hợp v&ocirc; c&ugrave;ng ho&agrave;n hảo đối với chiếc Quần kaki ống rộng unisex nam nữ gấu phối c&uacute;c bấm nh&agrave; XMAX.</p>\r\n\r\n<p>✨&nbsp;<strong>TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>- Kiểu D&aacute;ng: Quần Buttons Pants ống loe nam phong c&aacute;ch hiphop ph&aacute; c&aacute;ch</p>\r\n\r\n<p>- M&agrave;u Sắc: Đen, trắng</p>\r\n\r\n<p>- Chất liệu:&nbsp; Kaki cao cấp</p>\r\n\r\n<p>- Số lượng : H&agrave;ng đủ size, xuất khẩu</p>\r\n\r\n<p>- Gồm c&oacute; đủ&nbsp; size: từ Size S -&gt; Size XL</p>\r\n', 308000.00, 60000, 'sp18_1.jpg', '[\"sp18_2.jpg\",\"sp18_3.jpg\",\"sp18_4.jpg\"]', 32, 4, 5, 1, '2023-12-04 06:36:16'),
(19, 12, 'Quần Jean Nam Form SLIM FIT H-Zet - BLUE WASH', '<p><strong>⚡️TH&Ocirc;NG TIN SẢN PHẨM⚡️</strong></p>\r\n\r\n<p>✔ Vải Denim cao cấp co gi&atilde;n tốt, tạo cảm gi&aacute;c thoải m&aacute;i khi mặc</p>\r\n\r\n<p>✔ Với thiết kế form quần SLIM FIT thon gọn, vừa với cơ thể người mặc, kh&ocirc;ng &ocirc;m s&aacute;t cũng kh&ocirc;ng qu&aacute; rộng, l&agrave; form quần phổ biến nhất hiện nay m&agrave; trong tủ đồ ai cũng n&ecirc;n c&oacute; một v&agrave;i chiếc.</p>\r\n\r\n<p>✔ Size M {40 kg-55 kg}</p>\r\n\r\n<p>✔&nbsp;Size L {56kg-65kg}</p>\r\n\r\n<p>✔&nbsp;Size XL {66kg-82kg}</p>\r\n', 219000.00, 35000, 'sp19_1.jpg', '[\"sp19_2.jpg\"]', 0, 2, 5, 1, '2023-12-04 06:36:16'),
(20, 11, 'Áo Sơ Mi Kẻ Sọc Xám Dài Tay Chất Cotton Lụa 100% Cao Cấp', '<p><strong>M&Ocirc; TẢ SẢN PHẨM:</strong></p>\r\n\r\n<p>✔️ Xuất xứ: Việt Nam</p>\r\n\r\n<p>✔️ Chất liệu: Vải Cotton</p>\r\n\r\n<p><strong>HƯỚNG DẪN CHỌN SIZE:</strong></p>\r\n\r\n<p>Bảng Size:</p>\r\n\r\n<p>- Size M: 1m40-160/45-55kg</p>\r\n\r\n<p>- Size L : 1m60-1m70/55kg-65kg</p>\r\n\r\n<p>- Size XL: 1m70-1m78/66kg-75kg</p>\r\n\r\n<p><strong>HƯỚNG DẪN SỬ DỤNG:</strong></p>\r\n\r\n<p>- Khuyến kh&iacute;ch giặt tay với nước ở nhiệt độ thường, hạn chế để sản phẩm tiếp x&uacute;c với chất tẩy hoặc nước giặt c&oacute; độ tẩy mạnh.</p>\r\n\r\n<p>- Nếu giặt m&aacute;y, sản phẩm n&ecirc;n được lộn tr&aacute;i v&agrave; cho v&agrave;o t&uacute;i giặt.</p>\r\n\r\n<p>- Phơi ở nơi b&oacute;ng r&acirc;m, tr&aacute;nh &aacute;nh nắng trực tiếp.</p>\r\n', 250000.00, 0, 'sp20_1.jpg', '[\"sp20_2.jpg\",\"sp20_3.jpg\"]', 1, 3, 5, 1, '2023-12-04 06:36:16'),
(21, 12, 'Quần jean baggy nam Xanh RETRO ống rộng xuông cạp cao', '<p><strong>✔️</strong><strong> ƯU ĐIỂM:</strong>&nbsp;</p>\r\n\r\n<p>- Cực k&igrave; dễ phối đồ.</p>\r\n\r\n<p>- Chất lượng: Chất vải jean CH&Iacute;NH PHẨM gồm 95% cotton ( thấm h&uacute;t, vải mềm) v&agrave; 5% spandex ( độ co d&atilde;n).</p>\r\n\r\n<p>- Gi&aacute; cả : Ch&uacute;ng t&ocirc;i trực tiếp nhập QCCC với số lượng lớn. N&ecirc;n so với c&aacute;c quần c&ugrave;ng chất lượng gi&aacute; cả của chiếc quần jean baggy th&igrave; gi&aacute; tốt nhất cho bạn</p>\r\n\r\n<p><strong>✔️</strong> <strong>TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>- T&ecirc;n sản phẩm: Quần jean baggy nam Xanh RETRO ống rộng xu&ocirc;ng cạp cao Quần b&ograve; nam d&aacute;ng su&ocirc;ng xu hướng</p>\r\n\r\n<p>- Size: 27-36</p>\r\n\r\n<p>- Chất liệu: Jean cao cấp</p>\r\n\r\n<p><strong>✔️&nbsp;</strong><strong>TH&Ocirc;NG SỐ SẢN PHẨM:</strong></p>\r\n\r\n<p>Quần jean baggy nam Xanh RETRO ống rộng xu&ocirc;ng cạp cao Quần b&ograve; nam d&aacute;ng su&ocirc;ng xu hướng Sogeum</p>\r\n\r\n<p><em><strong>HƯỚNG DẪN CHỌN SIZE:</strong></em></p>\r\n\r\n<p>- Bảng Size:</p>\r\n\r\n<p>- Size M: 1m40-160/45-55kg</p>\r\n\r\n<p>- Size L : 1m60-1m70/55kg-65kg</p>\r\n\r\n<p>- Size XL: 1m70-1m78/66kg-75kg</p>\r\n', 275000.00, 0, 'sp21_1.jpg', '[\"sp21_2.jpg\",\"sp21_3.jpg\"]', 23, 11, 5, 5, '2023-12-04 06:36:16'),
(22, 18, 'Áo sơ mi tay dài vải oxford sợi cotton thêu TH', '<p>⏩ <strong>M&ocirc; tả sản phẩm:</strong></p>\r\n\r\n<p>- Sản phẩm: &Aacute;o sơ mi tay d&agrave;i vải oxford sợi cotton th&ecirc;u TH</p>\r\n\r\n<p>- Xuất xứ: Việt Nam</p>\r\n\r\n<p>- Chất liệu: Vải oxford</p>\r\n\r\n<p>- Size: S | M | L</p>\r\n\r\n<p>- M&agrave;u sắc: Trắng | Xanh</p>\r\n\r\n<p>https://cf.shopee.vn/file/vn-11134208-7r98o-lmaal1lrmuanfe</p>\r\n\r\n<p>(Sai số đo c&oacute; thể &plusmn; 2cm do phương &aacute;n đo nhưng kh&ocirc;ng đ&aacute;ng kể)</p>\r\n', 260000.00, 10000, 'sp22_1.jpg', '[\"sp22_2.jpg\",\"sp22_3.jpg\"]', 38, 2, 5, 2, '2023-12-04 06:36:16'),
(23, 18, 'Áo sơ mi nữ MONOTALK trơn dài tay công sở chất thô ít nhăn', '<p><strong>1. M&ocirc; tả sản phẩm:&nbsp;</strong></p>\r\n\r\n<p>✪ Kiểu d&aacute;ng: Sơ mi d&agrave;i tay vai vừa</p>\r\n\r\n<p>✪ Chi tiết: Chần chỉ trang tr&iacute; quanh cổ &aacute;o</p>\r\n\r\n<p>✪ Chất liệu: Th&ocirc;</p>\r\n\r\n<p><em>Lưu &yacute;: M&agrave;u sắc sản phẩm khi xem qua m&agrave;n h&igrave;nh m&aacute;y t&iacute;nh/điện thoại c&oacute; thể sẽ hơi kh&aacute;c so với thực tế do điều kiện &aacute;nh s&aacute;ng khi chụp ảnh.</em></p>\r\n\r\n<p>----------------------------------</p>\r\n\r\n<p><strong>2. Th&ocirc;ng số sản phẩm:</strong>&nbsp;</p>\r\n\r\n<p>Vai / Ngực/ Chiều d&agrave;i</p>\r\n\r\n<p>S: 36 (35-38)/ 86/ 68</p>\r\n\r\n<p>M: 38 (38-40)/ 90/ 70</p>\r\n\r\n<p><em>Lưu &yacute;: Số đo sản phẩm c&oacute; thể ch&ecirc;nh lệch 2-4cm t&ugrave;y theo chất liệu, kiểu d&aacute;ng. Li&ecirc;n hệ nh&acirc;n vi&ecirc;n tư vấn để được hỗ trợ tốt nhất.</em></p>\r\n', 280000.00, 10000, 'sp23_1.jpg', '[\"sp23_2.jpg\",\"sp23_3.jpg\"]', 4, 0, 5, 2, '2023-12-04 06:36:16'),
(24, 8, 'Áo sơ mi nữ dài tay phom rộng KH U BY CQ Kyla', '<p><strong>TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>- Chiều d&agrave;i khoảng 70cm.</p>\r\n\r\n<p>- Size: Freesize</p>\r\n\r\n<p>- M&agrave;u sắc: Xanh sọc trắng, Đen, Trắng, X&aacute;m, Xanh nhạt sọc trắng, Trắng sọc xanh đậm, Sọc xanh l&aacute;</p>\r\n\r\n<p>- Chất liệu:</p>\r\n\r\n<p>+ Xanh sọc trắng, Hồng sọc trắng, Xanh nhạt sọc trắng, Trắng sọc xanh đậm, Sọc xanh l&aacute;: Kate th&ocirc; Nhật, &iacute;t nhăn, giặt tay kh&ocirc;ng cần ủi, đứng phom (Kh&aacute;ch h&agrave;ng c&acirc;n nhắc mua nếu sử dụng chủ yếu trong m&ocirc;i trường kh&ocirc;ng m&aacute;y lạnh)</p>\r\n\r\n<p>+ Đen, trắng: katesilk (chất mềm)</p>\r\n\r\n<p>- Giặt tay, kh&ocirc;ng giặt chung với quần &aacute;o c&oacute; m&agrave;u.</p>\r\n\r\n<p>- &Aacute;o c&oacute; thể mặc kho&aacute;c hoặc phối với &aacute;o/quần/ch&acirc;n v&aacute;y</p>\r\n', 289000.00, 20000, 'sp24_1.jpg', '[\"sp24_2.jpg\",\"sp24_3.jpg\",\"sp24_4.jpg\"]', 16, 5, 5, 2, '2023-12-04 06:36:16'),
(25, 7, 'Áo Polo nam ROVE LEEVUS màu trắng phối raglan đen xanh', '<p>⏩<strong> M&Ocirc; TẢ SẢN PHẨM:</strong></p>\r\n\r\n<p>+ Chiều d&agrave;i tay &aacute;o: Tay ngắn</p>\r\n\r\n<p>+ Chất liệu: Cotton</p>\r\n\r\n<p>+ Mẫu: Trơn</p>\r\n\r\n<p>LEEVUS l&agrave; một thương hiệu thời trang được tạo ra bởi THE BASIS hướng đến phong c&aacute;ch tối giản &amp; thanh lịch. Lấy cảm hứng từ sự thanh lịch của người đ&agrave;n &ocirc;ng hiện đại, LEEVUS đ&atilde; th&agrave;nh c&ocirc;ng trong việc tạo ra &aacute;o Polo nam ROVE&nbsp; - sự kết hợp ho&agrave;n hảo giữa kiểu d&aacute;ng tối giản c&ugrave;ng những gam m&agrave;u thời thượng v&agrave; đường n&eacute;t tinh tế.</p>\r\n\r\n<p>&Aacute;o Polo nam ROVE kh&ocirc;ng phải chỉ l&agrave; chiếc &aacute;o d&agrave;nh cho m&ocirc;i trường c&ocirc;ng sở m&agrave; c&oacute; thể đồng h&agrave;nh c&ugrave;ng bạn trong phong c&aacute;ch ăn mặc h&agrave;ng ng&agrave;y.</p>\r\n\r\n<p>⏩<strong> TH&Ocirc;NG TIN SẢN PHẨM:</strong></p>\r\n\r\n<p>+ Chất CVC c&aacute; sấu 4 chiều cho độ co gi&atilde;n v&agrave; bền m&agrave;u tốt hơn.</p>\r\n\r\n<p>+ Phom Regular-fit t&ocirc;n d&aacute;ng, khả năng co gi&atilde;n 4 chiều thoải m&aacute;i.</p>\r\n\r\n<p>+ Kiểu dệt c&aacute; sấu gi&uacute;p &aacute;o c&oacute; độ tho&aacute;ng kh&iacute; tốt hơn.</p>\r\n\r\n<p>⏩<strong> HƯỚNG DẪN BẢO QUẢN:</strong></p>\r\n\r\n<p>+ Hạn chế giặt chung đồ trắng với đồ m&agrave;u.</p>\r\n\r\n<p>+ Kh&ocirc;ng n&ecirc;n ng&acirc;m &aacute;o trong bột giặt qu&aacute; l&acirc;u.</p>\r\n\r\n<p>+ Lộn mặt tr&aacute;i khi phơi v&agrave; ủi để giữ &aacute;o được bền m&agrave;u hơn.</p>\r\n', 358000.00, 50000, 'sp25_1.jpg', '[\"sp25_2.jpg\",\"sp25_3.jpg\"]', 16, 7, 5, 1, '2023-12-04 06:36:16'),
(26, 7, 'Áo Polo nam cao cấp Thêu đẹp SIXMEN FAVOR vải cá sấu', '<p>⏩ <strong>M&Ocirc; TẢ:</strong></p>\r\n\r\n<p>SIXMEN l&agrave; một thương hiệu thời trang cao cấp hướng đến phong c&aacute;ch tối giản v&agrave; thanh lịch. Sự kết hợp ho&agrave;n hảo giữa chất liệu tuyển chọn c&ugrave;ng với thiết kế độc quyền nh&agrave; SIXMEN đ&atilde; tạo n&ecirc;n những sản phẩm Luxury cao cấp</p>\r\n\r\n<p>Cam kết tất cả th&ocirc;ng tin b&ecirc;n dưới ho&agrave;n to&agrave;n ch&iacute;nh x&aacute;c, được BẢO H&Agrave;NH v&agrave; đổi trả trong 30 ng&agrave;y</p>\r\n\r\n<p>⏩&nbsp;<strong>CHẤT LƯỢNG &Aacute;O:</strong></p>\r\n\r\n<p>- Đặc Biệt: Giặt m&aacute;y thoải m&aacute;i kh&ocirc;ng lo ảnh hưởng đến độ bền &aacute;o</p>\r\n\r\n<p>- Vải CVC cotton dệt c&ocirc;ng nghệ thấm h&uacute;t nhanh, tho&aacute;ng m&aacute;t v&agrave; bền vải</p>\r\n\r\n<p>- Độ bền m&agrave;u VƯỢT TRỘI, kh&ocirc;ng sợ ra m&agrave;u hay phai m&agrave;u</p>\r\n\r\n<p>- Chống Nhăn với c&ocirc;ng nghệ Easy Care - Kh&ocirc;ng cần tốn thời gian ủi &aacute;o</p>\r\n\r\n<p>- Phom &aacute;o t&ocirc;n d&aacute;ng, mặc l&ecirc;n l&agrave; đẹp ph&ugrave; hợp với người Việt Nam.</p>\r\n\r\n<p>- Form &aacute;o regular thoải m&aacute;i kh&ocirc;ng g&ograve; b&oacute; khi vận động, di chuyển</p>\r\n\r\n<p>⏩&nbsp;<strong>CAM KẾT CỦA SIXMEN TEAM:</strong></p>\r\n\r\n<p>- Cam kết chất lượng v&agrave; mẫu m&atilde; sản phẩm giống với h&igrave;nh ảnh</p>\r\n\r\n<p>- Cam kết được đổi trả h&agrave;ng trong v&ograve;ng 30 ng&agrave;y.</p>\r\n\r\n<p>⏩&nbsp;<strong>HƯỚNG DẪN SỬ DỤNG V&Agrave; BẢO QUẢN:</strong></p>\r\n\r\n<p>- Giặt ở nhiệt độ b&igrave;nh thường, với đồ c&oacute; m&agrave;u tương tự.</p>\r\n\r\n<p>- Kh&ocirc;ng được d&ugrave;ng h&oacute;a chất tẩy.</p>\r\n', 350000.00, 0, 'sp26_1.jpg', '[\"sp26_2.jpg\",\"sp26_3.jpg\"]', 31, 6, 5, 18, '2023-04-11 06:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `id_province` int(11) NOT NULL,
  `id_district` int(11) NOT NULL,
  `name_province` varchar(200) NOT NULL,
  `name_district` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `name`, `id_province`, `id_district`, `name_province`, `name_district`) VALUES
(1, 'GHN-Giao Hàng Nhanh', 260, 2206, 'Phú Yên', 'Huyện Sông Hinh');

-- --------------------------------------------------------

--
-- Table structure for table `sizedetail`
--

CREATE TABLE `sizedetail` (
  `id` int(11) NOT NULL,
  `product_id` int(255) NOT NULL,
  `size_id` varchar(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizedetail`
--

INSERT INTO `sizedetail` (`id`, `product_id`, `size_id`, `quantity`) VALUES
(1, 1, '02', 8),
(2, 1, '01', 6),
(3, 2, '04', 30),
(4, 2, '03', 5),
(5, 2, '02', 10),
(6, 3, '04', 12),
(7, 3, '03', 9),
(8, 3, '02', 20),
(9, 3, '01', 7),
(10, 4, '03', 20),
(11, 4, '02', 10),
(12, 4, '01', 8),
(13, 5, '04', 20),
(14, 5, '03', 20),
(15, 5, '02', 20),
(16, 5, '01', 10),
(17, 6, '04', 10),
(18, 6, '03', 28),
(19, 6, '02', 14),
(20, 6, '01', 9),
(27, 9, '04', 10),
(28, 9, '03', 10),
(29, 9, '02', 20),
(30, 9, '01', 10),
(31, 10, '03', 20),
(32, 10, '02', 10),
(33, 10, '01', 7),
(34, 11, '04', 20),
(35, 11, '03', 10),
(36, 11, '02', 20),
(37, 11, '01', 8),
(38, 12, '02', 20),
(39, 12, '01', 20),
(40, 13, '03', 10),
(41, 13, '02', 20),
(42, 13, '01', 10),
(43, 14, '03', 20),
(44, 14, '02', 20),
(45, 14, '01', 20),
(46, 15, '04', 10),
(47, 15, '03', 10),
(48, 15, '02', 20),
(49, 15, '01', 19),
(50, 16, '03', 20),
(51, 16, '02', 19),
(52, 16, '01', 15),
(53, 17, '04', 10),
(54, 17, '03', 10),
(55, 17, '02', 10),
(56, 17, '01', 9),
(57, 18, '03', 10),
(58, 18, '02', 10),
(59, 18, '01', 6),
(60, 19, '04', 20),
(61, 19, '03', 20),
(62, 19, '02', 18),
(63, 19, '01', 20),
(64, 20, '04', 15),
(65, 20, '03', 9),
(66, 20, '02', 8),
(67, 21, '03', 20),
(68, 21, '02', 15),
(69, 21, '01', 14),
(70, 22, '03', 20),
(71, 22, '02', 19),
(72, 22, '01', 19),
(73, 23, '02', 20),
(74, 23, '01', 20),
(75, 24, '02', 19),
(76, 24, '01', 16),
(77, 25, '04', 10),
(78, 25, '03', 17),
(79, 25, '02', 9),
(80, 25, '01', 7),
(81, 26, '03', 10),
(82, 26, '02', 10),
(83, 26, '01', 14),
(87, 2, '01', 15),
(88, 7, '01', 20),
(89, 7, '02', 10),
(90, 7, '03', 15),
(91, 7, '04', 5),
(92, 8, '01', 12),
(93, 8, '02', 20),
(94, 8, '03', 8);

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` varchar(11) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
('01', 'S'),
('02', 'M'),
('03', 'L'),
('04', 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `payment` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `phone`, `address`, `created`) VALUES
(1, 'Hoàng Thị Mai', 'mai.swiftie@gmail.com', '71bcd0e29a5f708fe86977644d5ff9c6', '0337680255', '', '2023-12-05 18:02:04'),
(2, 'Chu Thị Hồng Nhung', 'chunhung1252003@gmail.com', 'a51d57a5011529dce85b5e73fd697bfa', '0129845722', '', '2023-12-05 18:02:19'),
(3, 'Đỗ Văn Long', ' longdovan203@gmail.com', '7f75432528e6d1c4eee98152e251d07e', '0338587882', '', '2023-12-05 18:02:35'),
(4, 'Hoàng Thị Quỳnh Nga', 'sokieu88@gmail.com', 'beb595ca18d94a24ce828550403e8dcb', '0339888943', '', '2023-12-05 18:02:48'),
(5, 'Nguyễn Thị Hồng Cúc', 'nt.hongcuc03@gmail.com', 'b2b9301f1b987aeecceaf3c1f2715e73', '0984802197', '', '2023-12-05 18:03:06'),
(6, 'Nguyễn Yến Linh', 'yenlinh03911xh@gmail.com', '114b67dacdfc175d1cc0826e4b83f040', '0167534497', '', '2023-12-05 18:03:21'),
(15, 'Hoàng Mai', 'maimaimai@gmail.com', '$2y$10$qbiuRufM09caIrGLPjJx2OuglG/o1PcjUm/yad3MUuD', '0974363422', '', '2023-12-06 17:20:03'),
(16, '55_Hoang Thi Mai', 'mai.swiftie@gmail.com1', '$2y$10$wSRIHh3PTGfR7qaeVNwXJeVVCveQngI3LtFhoipWk.D', '+84974363422', '', '2023-12-06 17:23:36'),
(17, 'Mai Hoang', 'mai.swiftie@gmail.com2', '$2y$10$43EzdCcg7zFYkbyjLRrxCOctT9ybRgRE7emKGYEIVpO', '+84974363422', '', '2023-12-06 17:27:39'),
(19, '123', '123', '$2y$10$40aNjSrW5rBqhye7Gxii2OhQKY6FpsVhdO7Fl7rR66l', '123', '', '2023-12-06 17:53:14'),
(20, '345', '345', '$2y$10$YrdiYQO42L/5fb16v7.WX.KTqxslfMR0ZNPMN/ORq6ZfV.wmGh/ES', '345', '', '2023-12-07 02:47:19'),
(21, 'mai', 'mai', '$2y$10$68GzHtuT/Eu/hqxecZdd.ewZST6Yqa70IC51chf2RCfZvausMhd1i', '123', '', '2023-12-11 08:10:40'),
(22, 'mai1', 'mai1', '$2y$10$dE3IFu7ieFQMbdyJiA4.P.VuY41Rt5s7Y5wnFF0OKWcs4P/PVx1xu', 'mai1', 'mai1', '2023-12-11 09:26:35'),
(23, 'mai2', 'mai2', '$2y$10$9xSF6TTPe1vIhEq.LmRIj.oh1.3pGHxp.QiYZ0mhHUfI1gbv2zlUq', 'mai2', 'mai2', '2023-12-11 09:30:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product` (`product_id`),
  ADD KEY `fk_size` (`size_id`) USING BTREE,
  ADD KEY `fk_transation` (`transaction_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_catalog` (`catalog_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizedetail`
--
ALTER TABLE `sizedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sizes` (`size_id`),
  ADD KEY `fk_sizedelta_product` (`product_id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sizedetail`
--
ALTER TABLE `sizedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_size` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`),
  ADD CONSTRAINT `fk_transation` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_catalog_product` FOREIGN KEY (`catalog_id`) REFERENCES `catalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sizedetail`
--
ALTER TABLE `sizedetail`
  ADD CONSTRAINT `fk_sizedelta_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sizes` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
