-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 22, 2023 lúc 10:24 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `fruitshop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8mb4 NOT NULL,
  `date_cmt` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `order_id`, `pro_id`, `pro_name`, `price`, `quantity`, `total`) VALUES
(32, 2, 102, 'Nho Pháp thượng hạng (kg)', 150000, 48, 7200000),
(31, 2, 95, 'Dưa leo Ấn Độ (kg)', 50000, 1, 50000),
(30, 1, 98, 'Dâu tây đỏ ngọt (kg)', 100000, 1, 100000),
(29, 1, 97, 'Bánh kem Táo Hàn Quốc', 550000, 2, 1100000),
(28, 1, 102, 'Nho Pháp thượng hạng (kg)', 150000, 1, 150000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lastName` text CHARACTER SET utf8 NOT NULL,
  `firstName` text CHARACTER SET utf8 NOT NULL,
  `phone` bigint(20) NOT NULL,
  `total` float NOT NULL DEFAULT 0,
  `note` text CHARACTER SET utf8 NOT NULL,
  `date_create` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `lastName`, `firstName`, `phone`, `total`, `note`, `date_create`, `status`) VALUES
(1, 32, 'Le', 'Hai Duong', 357570455, 1350000, 'oce', '2023-03-21 17:00:00', '0'),
(2, 32, 'Le', 'Hai Duong', 357570455, 7250000, 'oce', '2023-03-21 17:00:00', '0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `type_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `promotion` float NOT NULL,
  `pro_image` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `type_id`, `price`, `promotion`, `pro_image`, `quantity`, `description`, `created_at`) VALUES
(100, 'Bánh kem Matcha', 2, 600000, 0, 'banhkemmatcha.jpg', 0, 'Bánh kem matcha trà xanh, cực kỳ thơm ngon. Được khá nhiều người ưa chuộng', '0000-00-00 00:00:00'),
(101, 'Ớt chuông đỏ (kg)', 3, 60000, 0, 'otchuongdo.jpg', 0, 'Ớt chuông đỏ cung cấp nhiều Vitamin D. Loại này ít cay nhưng ngon khi xào chung với Mực', '0000-00-00 00:00:00'),
(102, 'Nho Pháp thượng hạng (kg)', 1, 150000, 0, 'nho.jpg', 1, 'Loại nho Pháp thượng hạng này được Napoleon cho trồng vào giữa thế kỷ XVII và thịnh hành đến bây giờ. Được mình nhập khẩu chui về bán cho bạn ăn', '0000-00-00 00:00:00'),
(99, 'Vải thiều loại to (kg)', 1, 85000, 0, 'vaithieuloaito.jpg', 50, 'Vải thiều loại to, tươi mới mỗi ngày. Cung cấp Vitamin tốt cho sức khỏe', '0000-00-00 00:00:00'),
(97, 'Bánh kem Táo Hàn Quốc', 2, 550000, 0, 'banhkemtao.jpg', 48, 'Bánh kem táo Hàn Quốc siêu đẹp và ngon', '0000-00-00 00:00:00'),
(98, 'Dâu tây đỏ ngọt (kg)', 1, 100000, 0, 'dautay.jpg', 49, 'Loại dâu tây này siêu ngọt và thơm. Ăn ngon nhé bạn', '0000-00-00 00:00:00'),
(95, 'Dưa leo Ấn Độ (kg)', 3, 50000, 0, 'dualeoando.jpg', 49, 'Dưa leo Ấn Độ chỉ được trồng ở Ấn Độ. Không xuất khẩu, nay có ở Việt Nam nhờ tui buôn l*u. Mua ăn đi nhé!!!', '0000-00-00 00:00:00'),
(96, 'Chanh dây Nga tươi (kg)', 1, 120000, 0, 'chanhday.jpg', 49, 'Loại chanh dây đặc biệt này chỉ trồng được ở nước Hàn Đới như Nga, nên đừng thắc ắc giá cả. Mua ăn liền đi nhé!!!', '0000-00-00 00:00:00'),
(94, 'Bánh kem Matcha Nho', 2, 320000, 0, 'banhkemnhomatcha.jpg', 49, 'Sản phẩm tốt với giá thành rẻ. Ngon mà đẹp, thích hợp với sinh viên', '0000-00-00 00:00:00'),
(93, 'Hồng đỏ Nam Mỹ (kg)', 1, 165000, 0, 'hongdomy.jpg', 44, 'Hồng đỏ tươi Nam Mỹ, cung cấp nhiều khoáng chất tốt cho cơ thể', '0000-00-00 00:00:00'),
(91, 'Bánh kem dâu Ý', 2, 1200000, 0, 'banhkemdau.jpg', 49, 'Xuất xứ từ Ý, du nhập Việt Nam năm 2022. Mới lạ và đang là xu hướng', '0000-00-00 00:00:00'),
(92, 'Cà tím Châu Phi (kg)', 3, 120000, 0, 'catim.jpg', 50, 'Loại cà tím Châu Phi này to thì khỏi phải nói :)). Ăn thì cũng ngon, làm ngất ngây bao nhiêu chị em. Mua ăn thử bạn nhé', '0000-00-00 00:00:00'),
(90, 'Chanh tươi Irag (kg)', 3, 250000, 199000, 'chanhtuoiirag.jpg', 60, 'Loại tranh xuất xứ từ những anh Iran, Irag đẹp trai. Khủng b*, nên chanh này ăn ngon và hấp dẫn. Tận hưởng những phút giây như bị kh**g bố khi ăn nó', '0000-00-00 00:00:00'),
(89, 'Cà chua Nhật Bản (kg)', 3, 110000, 0, 'cachua.jpg', 10, 'Do Thiên Hoàng Minh Trị trồng từ thời chiến tranh thế giới thứ 2. Đặc biệt loại này không dính phóng xạ nên ăn bổ lắm nha.', '0000-00-00 00:00:00'),
(86, 'Bánh kem bơ Pháp', 2, 850000, 750000, 'banhkembophap.jpg', 90, '                                                                                                                                            Vẫn sở hữu phần cốt bánh bông lan xốp mịn, điều làm cho những chiếc bánh kem này trở nên đặc biệt và cuốn hút nằm ở phần kem bơ.\r\n\r\nKem bơ Pháp được làm từ những nguyên liệu gồm lòng đỏ trứng, syrup đường và bơ lạt. Nhờ sử dụng thêm lòng đỏ trứng, thành phẩm kem bơ sẽ có hương vị cực kì thơm ngon, mềm mượt và tan ngay khi vào miệng.\r\n\r\nNhững người thợ tài hoa của Grand Castella còn tận dụng phần kem bơ này, sáng tạo nên những hình ảnh trang trí độc đáo, giúp chiếc bánh kem đã ngon nay trở nên xinh đẹp hơn.                                          ', '0000-00-00 00:00:00'),
(87, 'Cải thìa Triều Tiên (kg)', 3, 70000, 65000, 'caithia.jpg', 13, 'Cải thìa Triều Tiên do ông Kim trồng ăn rất ngon nhé. Mua ăn thử đi biết', '0000-00-00 00:00:00'),
(88, 'Cà rốt Bắc Mỹ (kg)', 3, 120000, 115000, 'carot.jpg', 76, 'Cà rốt Bắc Mỹ do ông Donald Trump đích thân trồng tại nông trại. Không qua bất cứ máy móc và hóa chất. Nên rất ngon và đắt', '0000-00-00 00:00:00'),
(103, 'Bánh kem bơ Pháp', 2, 850000, 750000, 'banhkembophap.jpg', 90, '                                                                                                                                            Vẫn sở hữu phần cốt bánh bông lan xốp mịn, điều làm cho những chiếc bánh kem này trở nên đặc biệt và cuốn hút nằm ở phần kem bơ.\r\n\r\nKem bơ Pháp được làm từ những nguyên liệu gồm lòng đỏ trứng, syrup đường và bơ lạt. Nhờ sử dụng thêm lòng đỏ trứng, thành phẩm kem bơ sẽ có hương vị cực kì thơm ngon, mềm mượt và tan ngay khi vào miệng.\r\n\r\nNhững người thợ tài hoa của Grand Castella còn tận dụng phần kem bơ này, sáng tạo nên những hình ảnh trang trí độc đáo, giúp chiếc bánh kem đã ngon nay trở nên xinh đẹp hơn.                                          ', '0000-00-00 00:00:00'),
(104, 'Cải thìa Triều Tiên (kg)', 3, 70000, 65000, 'caithia.jpg', 13, 'Cải thìa Triều Tiên do ông Kim trồng ăn rất ngon nhé. Mua ăn thử đi biết', '0000-00-00 00:00:00'),
(105, 'Cà rốt Bắc Mỹ (kg)', 3, 120000, 115000, 'carot.jpg', 76, 'Cà rốt Bắc Mỹ do ông Donald Trump đích thân trồng tại nông trại. Không qua bất cứ máy móc và hóa chất. Nên rất ngon và đắt', '0000-00-00 00:00:00'),
(106, 'Cà chua Nhật Bản (kg)', 3, 110000, 0, 'cachua.jpg', 10, 'Do Thiên Hoàng Minh Trị trồng từ thời chiến tranh thế giới thứ 2. Đặc biệt loại này không dính phóng xạ nên ăn bổ lắm nha.', '0000-00-00 00:00:00'),
(107, 'Chanh tươi Irag (kg)', 3, 250000, 199000, 'chanhtuoiirag.jpg', 60, 'Loại tranh xuất xứ từ những anh Iran, Irag đẹp trai. Khủng b*, nên chanh này ăn ngon và hấp dẫn. Tận hưởng những phút giây như bị kh**g bố khi ăn nó', '0000-00-00 00:00:00'),
(108, 'Bánh kem dâu Ý', 2, 1200000, 0, 'banhkemdau.jpg', 49, 'Xuất xứ từ Ý, du nhập Việt Nam năm 2022. Mới lạ và đang là xu hướng', '0000-00-00 00:00:00'),
(109, 'Cà tím Châu Phi (kg)', 3, 120000, 0, 'catim.jpg', 50, 'Loại cà tím Châu Phi này to thì khỏi phải nói :)). Ăn thì cũng ngon, làm ngất ngây bao nhiêu chị em. Mua ăn thử bạn nhé', '0000-00-00 00:00:00'),
(110, 'Hồng đỏ Nam Mỹ (kg)', 1, 165000, 0, 'hongdomy.jpg', 44, 'Hồng đỏ tươi Nam Mỹ, cung cấp nhiều khoáng chất tốt cho cơ thể', '0000-00-00 00:00:00'),
(111, 'Bánh kem Matcha Nho', 2, 320000, 0, 'banhkemnhomatcha.jpg', 49, 'Sản phẩm tốt với giá thành rẻ. Ngon mà đẹp, thích hợp với sinh viên', '0000-00-00 00:00:00'),
(112, 'Dưa leo Ấn Độ (kg)', 3, 50000, 0, 'dualeoando.jpg', 50, 'Dưa leo Ấn Độ chỉ được trồng ở Ấn Độ. Không xuất khẩu, nay có ở Việt Nam nhờ tui buôn l*u. Mua ăn đi nhé!!!', '0000-00-00 00:00:00'),
(113, 'Chanh dây Nga tươi (kg)', 1, 120000, 0, 'chanhday.jpg', 49, 'Loại chanh dây đặc biệt này chỉ trồng được ở nước Hàn Đới như Nga, nên đừng thắc ắc giá cả. Mua ăn liền đi nhé!!!', '0000-00-00 00:00:00'),
(114, 'Bánh kem Táo Hàn Quốc', 2, 550000, 0, 'banhkemtao.jpg', 50, 'Bánh kem táo Hàn Quốc siêu đẹp và ngon', '0000-00-00 00:00:00'),
(115, 'Dâu tây đỏ ngọt (kg)', 1, 100000, 0, 'dautay.jpg', 50, 'Loại dâu tây này siêu ngọt và thơm. Ăn ngon nhé bạn', '0000-00-00 00:00:00'),
(116, 'Vải thiều loại to (kg)', 1, 85000, 0, 'vaithieuloaito.jpg', 50, 'Vải thiều loại to, tươi mới mỗi ngày. Cung cấp Vitamin tốt cho sức khỏe', '0000-00-00 00:00:00'),
(117, 'Bánh kem Matcha', 2, 600000, 0, 'banhkemmatcha.jpg', 0, 'Bánh kem matcha trà xanh, cực kỳ thơm ngon. Được khá nhiều người ưa chuộng', '0000-00-00 00:00:00'),
(118, 'Ớt chuông đỏ (kg)', 3, 60000, 0, 'otchuongdo.jpg', 0, 'Ớt chuông đỏ cung cấp nhiều Vitamin D. Loại này ít cay nhưng ngon khi xào chung với Mực', '0000-00-00 00:00:00'),
(119, 'Nho Pháp thượng hạng (kg)', 1, 150000, 0, 'nho.jpg', 50, 'Loại nho Pháp thượng hạng này được Napoleon cho trồng vào giữa thế kỷ XVII và thịnh hành đến bây giờ. Được mình nhập khẩu chui về bán cho bạn ăn', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `protypes`
--

CREATE TABLE `protypes` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `protypes`
--

INSERT INTO `protypes` (`type_id`, `type_name`) VALUES
(1, 'Trái cây tươi'),
(2, 'Bánh ngọt'),
(3, 'Rau củ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'Customer');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `Sell_number` int(11) NOT NULL,
  `Import_quantity` int(11) NOT NULL,
  `Import_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sales`
--

INSERT INTO `sales` (`id`, `Sell_number`, `Import_quantity`, `Import_date`) VALUES
(2, 300, 1200, '2021-11-12 01:41:19'),
(3, 1200, 2000, '2021-11-12 01:42:44'),
(4, 100, 1000, '2021-11-12 01:43:12'),
(5, 700, 1500, '2021-11-12 01:43:38'),
(6, 100, 500, '2021-11-12 01:44:04'),
(7, 600, 1000, '2021-11-12 01:44:30'),
(8, 170, 300, '2021-11-12 01:44:52'),
(9, 100, 500, '2021-11-12 01:45:20'),
(10, 150, 400, '2021-11-19 12:29:46'),
(11, 160, 300, '2021-11-19 12:32:39'),
(12, 200, 500, '2021-11-19 12:32:54'),
(13, 320, 540, '2021-11-19 12:33:05'),
(14, 250, 350, '2021-11-19 12:33:17'),
(15, 700, 1000, '2021-11-19 12:33:34'),
(16, 300, 600, '2021-11-19 12:33:49'),
(17, 100, 200, '2021-11-19 12:34:01'),
(18, 500, 1000, '2021-12-14 02:25:29'),
(19, 300, 1250, '2021-12-14 02:25:29'),
(20, 400, 700, '2021-12-14 02:26:09'),
(21, 150, 500, '2021-12-14 02:26:30'),
(22, 190, 700, '2021-12-14 02:26:43'),
(23, 250, 800, '2021-12-14 02:26:58'),
(24, 800, 2000, '2021-12-14 02:27:10'),
(25, 300, 750, '2021-12-14 02:27:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `First_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `email` text CHARACTER SET utf8 DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `date_create` date NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `image`, `First_name`, `Last_name`, `phone`, `email`, `username`, `password`, `role_id`, `date_create`) VALUES
(31, 'avatar7.png', 'Hai Duong', 'Le', 357570455, 'haiduong07112k3@gmail.com', 'DuongPro', '25c8de8861dd2092759ae1bb0860c799', 2, '0000-00-00'),
(32, 'avatar7.png', 'Hai Duong', 'Le', 357570455, '501210803@stu.itc.edu.vn', 'DuongPro1', '9edc31c13156e9ef86be6bada5f709ec', 1, '2023-03-22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `pro_id`) VALUES
(9, 32, 101),
(10, 32, 100),
(11, 32, 102),
(12, 32, 99);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `protypes`
--
ALTER TABLE `protypes`
  ADD PRIMARY KEY (`type_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Chỉ mục cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT cho bảng `protypes`
--
ALTER TABLE `protypes`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
