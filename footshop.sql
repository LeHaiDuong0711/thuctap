/*
 Navicat Premium Data Transfer

 Source Server         : DataThucTap
 Source Server Type    : MySQL
 Source Server Version : 50651 (5.6.51)
 Source Host           : 192.168.201.117:3306
 Source Schema         : Duong

 Target Server Type    : MySQL
 Target Server Version : 50651 (5.6.51)
 File Encoding         : 65001

 Date: 01/07/2023 17:25:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `userName` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `roleId` int(11) NOT NULL,
  `date_create` date NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'c4fb589a7e63942c9a867bad72ffcc56.jpg', 'haiduong07112k3@gmail.com', 'admin', '0357570455', '25c8de8861dd2092759ae1bb0860c799', 1, '2023-09-04', 'Le Hai Duong');

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `proId` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 50 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of carts
-- ----------------------------

-- ----------------------------
-- Table structure for categorymenu
-- ----------------------------
DROP TABLE IF EXISTS `categorymenu`;
CREATE TABLE `categorymenu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL,
  `dateCreate` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of categorymenu
-- ----------------------------
INSERT INTO `categorymenu` VALUES (1, 0, 'home', 'Trang Chủ', 0, '2023-05-29');
INSERT INTO `categorymenu` VALUES (2, 0, 'products', 'Sản Phẩm', 0, '2023-05-26');
INSERT INTO `categorymenu` VALUES (3, 0, 'contact', 'Liên Hệ', 0, '2023-06-03');
INSERT INTO `categorymenu` VALUES (4, 0, 'about', 'Giới Thiệu', 0, '2023-05-26');
INSERT INTO `categorymenu` VALUES (5, 0, 'news', 'Tin Tức', 0, '2023-05-26');
INSERT INTO `categorymenu` VALUES (6, 5, 'news', 'Tất cả tin tức', 0, '2023-05-29');
INSERT INTO `categorymenu` VALUES (7, 5, 'newsEveryday', 'Tin mới mỗi ngày', 0, '2023-06-07');
INSERT INTO `categorymenu` VALUES (8, 5, 'commodityNews', 'Tin tức về hàng hóa', 0, '2023-06-03');
INSERT INTO `categorymenu` VALUES (9, 5, 'marketNews', 'Tin tức về thị trường', 0, '2023-05-26');
INSERT INTO `categorymenu` VALUES (11, 0, 'test', 'Thử', 1, '2023-06-17');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` char(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `star_rating` int(11) NOT NULL,
  `total_like` int(11) NOT NULL,
  `date_cmt` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 28 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES (25, '5', 36, 'Sản phẩm tốt', 4, 0, '2023-06-16');
INSERT INTO `comments` VALUES (26, '8', 48, 'oce', 4, 1, '2016-01-21');
INSERT INTO `comments` VALUES (27, '6', 36, 'aaaaaaaaaa', 4, 0, '2023-06-26');

-- ----------------------------
-- Table structure for comments_reply
-- ----------------------------
DROP TABLE IF EXISTS `comments_reply`;
CREATE TABLE `comments_reply`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `total_like` int(11) NOT NULL,
  `create_at` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of comments_reply
-- ----------------------------
INSERT INTO `comments_reply` VALUES (15, 33, 25, 'Thật hk fen', 1, '2023-06-16');
INSERT INTO `comments_reply` VALUES (16, 36, 26, 'haha', 0, '2016-01-21');

-- ----------------------------
-- Table structure for like_comments
-- ----------------------------
DROP TABLE IF EXISTS `like_comments`;
CREATE TABLE `like_comments`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `comment_reply_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_at` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 46 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of like_comments
-- ----------------------------
INSERT INTO `like_comments` VALUES (44, 25, 15, 36, '2023-06-16');
INSERT INTO `like_comments` VALUES (45, 26, 0, 48, '2016-01-21');

-- ----------------------------
-- Table structure for news
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCategoryMultiple` int(11) NOT NULL,
  `title` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `status` int(11) NOT NULL,
  `dateCreate` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES (1, 1, 'Kinh nghiệm bỏ túi dưa lưới ngon', 'dualuoi.jpg', 'Với mùi hương đặc biệt, lớp thịt hơi giòn, vị ngọt, nhiều nước, dưa lưới là thứ quả giải khát mùa hè rất hấp dẫn và cực tốt cho sức khoẻ. Nếu chọn được quả chín ăn rất ngọt, ngược lại quả chưa đủ chín, ăn nhạt nhẽo. F5 sẽ chỉ cho bạn bí quyết để không còn lo mua quả mắc mà không ngon nhé.', '<div class=\"post__content typography\">\r\n<p>1. CUỐNG DƯA: cuống rụng tạo chỗ l&otilde;m tự nhi&ecirc;n c&oacute; răng cưa l&agrave; quả h&aacute;i khi đ&atilde; gi&agrave;. Ăn sẽ ngon, ngọt.</p>\r\n<p>2. VỎ QUẢ DƯA: chọn quả c&oacute; nhiều đường g&acirc;n nổi r&otilde;, m&agrave;u vỏ đồng nhất, kh&ocirc;ng đốm n&acirc;u, v&agrave;ng.</p>\r\n<p>&nbsp;</p>\r\n<img style=\"float: none; height: 300px; width: 300px;\" src=\"https://i.imgur.com/9H7XCZH.png\" alt=\"dua luoi\">\r\n<p>&nbsp;</p>\r\n<p>3. LẮC QUẢ DƯA: lắc nhẹ quả dưa, nếu nghe tiếng động l&agrave; dưa đ&atilde; ch&iacute;n, ăn được ngay</p>\r\n<p>4. CHỌN QUẢ NHẸ TAY: v&igrave; quả ch&iacute;n sẽ nhẹ hơn quả chưa ch&iacute;n.</p>\r\n<p>5. DƯA LƯỚI XANH v&agrave; DƯA LƯỚI V&Agrave;NG c&ugrave;ng c&aacute;ch chọn như tr&ecirc;n để c&oacute; quả ngon, ngọt nh&eacute;.</p>\r\n<p>---</p>\r\n<p>5 l&yacute; do bạn n&ecirc;n mua tr&aacute;i c&acirc;y Nhập khẩu ở F5 Fruit shop</p>\r\n<ul>\r\n<li>Nh&agrave; nhập khẩu TRỰC TIẾP từ nh&agrave; vườn uy t&iacute;n ở c&aacute;c nước</li>\r\n<li>Trước mỗi m&ugrave;a vụ đều c&oacute; bộ phận đối ngoại ĐẾN TẬN VƯỜN XEM H&Agrave;NG HO&Aacute;, quy tr&igrave;nh đ&oacute;ng g&oacute;i trước khi nhập về</li>\r\n<li>Gi&aacute; cả CẠNH TRANH</li>\r\n<li>Dịch vụ CHĂM S&Oacute;C SAU B&Aacute;N H&Agrave;NG tốt. Hỗ trợ đổi trả trong 24h</li>\r\n<li>TƯ VẤN TẬN T&Acirc;M</li>\r\n</ul>\r\n</div>', 0, '2023-06-16');
INSERT INTO `news` VALUES (2, 1, 'Cách nhận biết cheery trung quốc và chery mỹ', 'cherry.jpg', 'Quả Cherry (hay còn gọi là quả Anh đào) được nhập khẩu vào Việt Nam rất nhiều trong những năm gần đây. Đây là một loại quả được người dân khắp nơi trên thế giới ưa thích vì vẻ ngoài bóng đẹp, vị ngon giòn khó cưỡng, và một phần ở mức giá “trên trời” của nó làm nó trở thành loại trái cây xa xỉ, sang trọng. Vì thế, sự có mặt của cherry Trung Quốc được tẩm thuốc bảo quản rất nhiều trên thị trường nhằm đáp ứng một phần nhu cầu “muốn thưởng thức loại trái ngon này với mức giá hợp lý nhất”. Hãy cùng F5 nhận dạng và tìm hiểu sự khác biệt giữa cherry nhập khẩu Mỹ và cherry Trung Quốc để tránh mua lầm, tiền mất tật mang nhé.', '<div class=\"post__content typography\">\r\n<h6><strong>1. Đặc điểm b&ecirc;n ngo&agrave;i v&agrave; m&ugrave;i vị:</strong></h6>\r\n<p><strong>Cherry nhập khẩu (Mỹ_&Uacute;c_New Zealand_Canada): </strong>thường c&oacute; m&agrave;u đỏ sẫm hoặc đỏ tươi (tuỳ giống tr&aacute;i), vỏ ngo&agrave;i s&aacute;ng b&oacute;ng, tr&aacute;i chắc, phần cuống xanh, mọng nước nhưng kh&ocirc;ng mềm nhũng. Khi ăn, cảm nhận ngay độ gi&ograve;n, vị ngọt thanh dịu.</p>\r\n<p>K&iacute;ch thước quả anh đ&agrave;o thường từ 26mm trở l&ecirc;n (size 10.5 đối với cherry Mỹ). Tuy nhi&ecirc;n, size tr&aacute;i được nhập về VN nhiều nhất l&agrave; 28mm-32mm, k&iacute;ch thước n&agrave;y vừa phổ biến, gi&aacute; cả vừa phải, tr&aacute;i vừa ngon.</p>\r\n<p><strong>Cherry Trung Quốc:</strong> Tr&aacute;i c&oacute; k&iacute;ch thước nhỏ, m&agrave;u đỏ nhưng nhạt m&agrave;u, vỏ l&aacute;ng b&oacute;ng, tr&aacute;i mềm, tr&aacute;i cứng. Khi cắn v&agrave;o sẽ thấy bị nhũn, chảy nước, tr&aacute;i mềm, xốp, vị hơi chua v&agrave; lợ miệng do được bảo quản nhiều bằng ho&aacute; chất.</p>\r\n<p>&nbsp;</p>\r\n<img style=\"float: none; height: 300px; width: 300px;\" src=\"https://i.imgur.com/zPHzRhT.jpg\" alt=\"cherry TQ\">\r\n<p>&nbsp;</p>\r\n<h6><strong>2. Ph&acirc;n biệt dựa v&agrave;o gi&aacute;:</strong></h6>\r\n<p><strong>Cherry Mỹ</strong>: Do l&agrave; h&agrave;ng nhập khẩu ch&iacute;nh ngạch v&agrave; c&aacute;ch thức bảo quản kh&oacute;, dễ hư n&ecirc;n tỷ lệ b&aacute;n được - phải bỏ đi rất nhiều. V&igrave; thế, gi&aacute; của loại tr&aacute;i c&acirc;y được mệnh danh l&agrave; &ldquo;vi&ecirc;n ngọc đỏ&rdquo; n&agrave;y kh&aacute; cao. Cherry Mỹ h&agrave;ng tươi ngon dao động từ 600.000 đồng/kg đầu vụ xuống khoảng 300.000 đồng khi ch&iacute;n vụ (bắt đầu từ 2019 do vấn đề ch&iacute;nh trị giữa Mỹ v&agrave; Trung Quốc n&ecirc;n cherry Mỹ kh&ocirc;ng nhập v&agrave;o Trung Quốc nhiều như trước kia được, đổ về VN rất nhiều). Trước năm 2019 gi&aacute; b&aacute;n lu&ocirc;n ở mức cao 800.000 - 400.000 đồng.</p>\r\n<p>Tuy nhi&ecirc;n, <strong>cherry Trung Quốc</strong> lu&ocirc;n ở mức từ 100.000 đồng đến 200.000 đồng/kg.</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<h6><strong>3. Ph&acirc;n biệt qua c&aacute;ch thức bảo quản:</strong></h6>\r\n<p>Cherry nhập khẩu từ Mỹ được thu h&aacute;i tại vườn, qua xử l&yacute; bằng nước sạch loại bỏ bụi bẩn rồi được đ&oacute;ng g&oacute;i th&ugrave;ng trực tiếp, bảo quản lạnh (dưới 10 độ C), đi đường m&aacute;y bay hoặc đường biển về Việt Nam n&ecirc;n nếu để b&ecirc;n ngo&agrave;i tầm 10-15 ph&uacute;t, cherry sẽ đổ mồ h&ocirc;i, sau đ&oacute; từ từ bị mềm, nhăn nheo v&agrave; hư nhanh ch&oacute;ng trong v&ograve;ng 1 ng&agrave;y. C&aacute;c cửa h&agrave;ng b&aacute;n Cherry lu&ocirc;n phải bảo quản loại tr&aacute;i c&acirc;y xa xỉ n&agrave;y trong tủ m&aacute;t với độ lạnh th&iacute;ch hợp để đảm bảo sự tươi ngon.</p>\r\n<p>Trong khi đ&oacute;, chery Trung Quốc được b&agrave;y b&aacute;n tr&agrave;n lan dưới c&aacute;i nắng gay gắt 37,38 độ ngo&agrave;i trời, nhưng nh&igrave;n vẫn tươi, ngon, hấp dẫn lấp l&aacute;nh một m&agrave;u đỏ rực. L&yacute; do l&agrave; giống như c&aacute;c loại tr&aacute;i c&acirc;y được nh&uacute;ng thuốc kh&aacute;c, c&agrave;ng được phơi nắng nhiều, thuốc sẽ l&agrave;m tr&aacute;i c&agrave;ng căng b&oacute;ng, nh&igrave;n h&uacute;t mắt hơn.</p>\r\n<p>Việc ph&acirc;n biệt cherry nhập khẩu từ Mỹ, &Uacute;c&hellip; v&agrave; cherry Trung Quốc cũng kh&ocirc;ng c&oacute; g&igrave; qu&aacute; kh&oacute; phải kh&ocirc;ng n&agrave;o? Hy vọng c&aacute;c bạn đừng ham rẻ m&agrave; mua phải những h&agrave;ng k&eacute;m chất lượng ảnh hưởng đến sức khoẻ. V&agrave; cũng kh&ocirc;ng n&ecirc;n đ&aacute;nh đồng gi&aacute; cả của Cherry Mỹ khi gi&aacute; rẻ, v&igrave; khi v&agrave;o ch&iacute;nh vụ, lượng h&agrave;ng được nhập v&agrave;o VN rất nhiều hoặc trong qu&aacute; tr&igrave;nh vận chuyển, cherry bị lỗi về h&igrave;nh d&aacute;ng n&ecirc;n gi&aacute; rẻ hơn. Nhưng kh&ocirc;ng v&igrave; thế m&agrave; ch&uacute;ng ta nghĩ &ldquo;h&agrave;ng rẻ lu&ocirc;n lu&ocirc;n l&agrave; h&agrave;ng Trung Quốc&rdquo; nh&eacute;.</p>\r\n<p>&nbsp;</p>\r\n<p>Ch&uacute; th&iacute;ch ảnh: C&ocirc;ng ty An Minh - F5 Fruit shop nhập trực tiếp cherry từ c&aacute;c nước</p>\r\n<p>----</p>\r\n<p>5 l&yacute; do bạn n&ecirc;n mua Cherry (Quả anh đ&agrave;o) ở F5 Fruit shop</p>\r\n<ul>\r\n<li>1 trong 2 nh&agrave; nhập khẩu cherry LỚN NHẤT Việt Nam (theo thống k&ecirc; sản lượng nhập khẩu 2019 của North West Cherry - Hiệp hội Cherry Mỹ)</li>\r\n<li>Trước mỗi m&ugrave;a vụ đều c&oacute; bộ phận đối ngoại ĐẾN TẬN VƯỜN XEM H&Agrave;NG HO&Aacute;, quy tr&igrave;nh đ&oacute;ng g&oacute;i trước khi nhập về</li>\r\n<li>Gi&aacute; cả CẠNH TRANH</li>\r\n<li>Dịch vụ CHĂM S&Oacute;C SAU B&Aacute;N H&Agrave;NG tốt. Hỗ trợ đổi trả trong 24h</li>\r\n<li>TƯ VẤN TẬN T&Acirc;M</li>\r\n</ul>\r\n</div>', 0, '2023-06-16');
INSERT INTO `news` VALUES (7, 9, '<p>aaaaaaaaaaaaa</p>', 'c4fb589a7e63942c9a867bad72ffcc56.jpg', '<p>bbbbbb</p>', '<p>ccccccc</p>', 1, '2023-06-02');
INSERT INTO `news` VALUES (8, 9, '<p>aaaaaaaaaaa</p>', 'c4fb589a7e63942c9a867bad72ffcc56.jpg', '<p>bbbbbbbbb</p>', '<p>ccccccccc</p>', 1, '2023-06-02');

-- ----------------------------
-- Table structure for orderdetails
-- ----------------------------
DROP TABLE IF EXISTS `orderdetails`;
CREATE TABLE `orderdetails`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `propertyId` int(11) NOT NULL,
  `pro_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 189 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orderdetails
-- ----------------------------
INSERT INTO `orderdetails` VALUES (127, 5, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (126, 5, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (125, 4, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (124, 4, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (123, 4, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (122, 3, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (121, 3, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (120, 3, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (119, 3, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (118, 3, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (117, 2, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (116, 2, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (115, 1, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (114, 1, 152010002, 25, 'Bánh ngọt nè', 150000, 1, 150000);
INSERT INTO `orderdetails` VALUES (113, 1, 152010001, 24, 'Bánh ngọt nè', 120000, 1, 120000);
INSERT INTO `orderdetails` VALUES (112, 1, 152010000, 23, 'Bánh ngọt nè', 100000, 2, 200000);
INSERT INTO `orderdetails` VALUES (128, 5, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (129, 6, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (130, 6, 152010002, 25, 'Bánh ngọt nè', 100000, 2, 200000);
INSERT INTO `orderdetails` VALUES (131, 6, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (132, 7, 5, 0, 'Bánh kem Táo', 100000, 2, 200000);
INSERT INTO `orderdetails` VALUES (133, 7, 7, 0, 'Dưa leo', 8000, 2, 16000);
INSERT INTO `orderdetails` VALUES (134, 7, 6, 0, 'Dâu tây đỏ', 120000, 1, 120000);
INSERT INTO `orderdetails` VALUES (135, 7, 152010001, 24, 'Bánh ngọt nè', 120000, 1, 120000);
INSERT INTO `orderdetails` VALUES (136, 7, 152010002, 25, 'Bánh ngọt nè', 150000, 1, 150000);
INSERT INTO `orderdetails` VALUES (137, 7, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (138, 7, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (139, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (140, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (141, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (142, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (143, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (144, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (145, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (146, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (147, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (148, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (149, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (150, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (151, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (152, 7, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (153, 7, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (154, 8, 6, 0, 'Dâu tây đỏ', 120000, 1, 120000);
INSERT INTO `orderdetails` VALUES (155, 8, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (156, 9, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (157, 9, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (158, 10, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (159, 10, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (171, 11, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (170, 11, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (169, 11, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (168, 11, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (167, 11, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (172, 12, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (173, 12, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (174, 12, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (175, 12, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (176, 12, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (177, 13, 8, 0, 'Chanh dây Nga', 20000, 1, 20000);
INSERT INTO `orderdetails` VALUES (178, 13, 7, 0, 'Dưa leo', 8000, 1, 8000);
INSERT INTO `orderdetails` VALUES (179, 13, 152010000, 23, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (180, 13, 152010002, 25, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (181, 13, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (182, 14, 16, 0, 'Cải thìa', 5000, 13, 65000);
INSERT INTO `orderdetails` VALUES (183, 15, 16, 0, 'Cải thìa', 5000, 13, 65000);
INSERT INTO `orderdetails` VALUES (184, 16, 4, 0, 'Vải thiều', 85000, 1, 85000);
INSERT INTO `orderdetails` VALUES (185, 16, 5, 0, 'Bánh kem Táo', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (186, 16, 152010001, 24, 'Bánh ngọt nè', 120000, 2, 240000);
INSERT INTO `orderdetails` VALUES (187, 17, 152010001, 24, 'Bánh ngọt nè', 100000, 1, 100000);
INSERT INTO `orderdetails` VALUES (188, 18, 152010001, 24, 'Bánh ngọt nè', 120000, 1, 120000);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `total` float NOT NULL DEFAULT 0,
  `intoMoney` float NOT NULL,
  `note` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_create` datetime NULL DEFAULT NULL,
  `delivery_date` datetime NULL DEFAULT NULL,
  `cancellation_date` datetime NULL DEFAULT NULL,
  `reset_date` datetime NULL DEFAULT NULL,
  `received_date` datetime NULL DEFAULT NULL,
  `status` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `hide` int(11) NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`order_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 159 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (5, 36, 357570455, 300000, 300000, 'oce', '2023-06-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (4, 36, 357570455, 300000, 300000, 'hehe', '2023-06-26 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'LEHAIDUONG Hải Dương');
INSERT INTO `orders` VALUES (3, 36, 357570455, 328000, 328000, 'haha', '2023-06-26 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (2, 36, 357570455, 185000, 92500, 'oce', '2023-06-26 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (1, 36, 357570455, 555000, 555000, 'oce ne', '2023-06-26 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (8, 50, 357570455, 128000, 128000, '', '2023-06-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong ');
INSERT INTO `orders` VALUES (9, 50, 357570455, 28000, 28000, '', '2023-06-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong ');
INSERT INTO `orders` VALUES (10, 50, 357570455, 85000, 85000, '', '2023-06-27 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong ');
INSERT INTO `orders` VALUES (12, 36, 357570455, 328000, 328000, 'haha', '2023-06-28 15:11:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (11, 36, 357570455, 328000, 328000, 'haha', '2023-06-28 15:11:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (13, 36, 357570455, 328000, 328000, 'haha', '2023-06-28 15:12:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (14, 52, 9345675411, 65000, 65000, '', '2023-06-30 09:01:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'NguyenTanTai1');
INSERT INTO `orders` VALUES (15, 51, 934567541, 65000, 65000, '', '2023-06-30 09:01:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', 0, 'NguyenTanTai');
INSERT INTO `orders` VALUES (16, 36, 346098854, 425000, 425000, '', '2023-07-01 02:06:35', '2023-07-01 02:44:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', 0, 'Lê Hải Dương');
INSERT INTO `orders` VALUES (17, 36, 357570455, 100000, 100000, 'oce', '2023-07-01 09:28:03', NULL, NULL, NULL, NULL, '0', 0, 'Le Hai Duong');
INSERT INTO `orders` VALUES (18, 36, 346098854, 120000, 120000, 'hehe', '2023-07-01 09:29:25', NULL, NULL, NULL, NULL, '0', 0, 'Lê Hải Dương');

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `promotion` float NOT NULL,
  `pro_image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sup_id` int(11) NOT NULL,
  `date_add` date NOT NULL,
  `expiry` date NOT NULL,
  `created_at` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 153 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 'Bánh kem Matcha', 2, 100000, 0, 'banhkemmatcha.jpg', 0, 'Bánh kem matcha trà xanh, cực kỳ thơm ngon. Được khá nhiều người ưa chuộng', 3, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (2, 'Ớt chuông đỏ', 3, 30000, 0, 'otchuongdo.jpg', 0, 'Ớt chuông đỏ cung cấp nhiều Vitamin D. Loại này ít cay nhưng ngon khi xào chung với Mực', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (3, 'Nho thượng hạng', 1, 60000, 0, 'nho.jpg', 0, 'Loại nho Pháp thượng hạng này được Napoleon cho trồng vào giữa thế kỷ XVII và thịnh hành đến bây giờ. Được mình nhập khẩu chui về bán cho bạn ăn', 1, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (4, 'Vải thiều', 1, 85000, 0, 'vaithieuloaito.jpg', 21, 'Vải thiều loại to, tươi mới mỗi ngày. Cung cấp Vitamin tốt cho sức khỏe', 1, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (5, 'Bánh kem Táo', 2, 100000, 0, 'banhkemtao.jpg', 17, 'Bánh kem táo Hàn Quốc siêu đẹp và ngon', 3, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (6, 'Dâu tây đỏ', 1, 120000, 0, 'dautay.jpg', 34, 'Loại dâu tây này siêu ngọt và thơm. Ăn ngon nhé bạn', 1, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (7, 'Dưa leo', 3, 8000, 0, 'dualeoando.jpg', 36, 'Dưa leo Ấn Độ chỉ được trồng ở Ấn Độ. Không xuất khẩu, nay có ở Việt Nam nhờ tui buôn l*u. Mua ăn đi nhé!!!', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (8, 'Chanh dây Nga', 1, 20000, 0, 'chanhday.jpg', 35, 'Loại chanh dây đặc biệt này chỉ trồng được ở nước Hàn Đới như Nga, nên đừng thắc ắc giá cả. Mua ăn liền đi nhé!!!', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (9, 'Bánh kem Matcha Nho', 2, 100000, 0, 'banhkemnhomatcha.jpg', 46, 'Sản phẩm tốt với giá thành rẻ. Ngon mà đẹp, thích hợp với sinh viên', 3, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (10, 'Hồng đỏ', 1, 65000, 0, 'hongdomy.jpg', 44, 'Hồng đỏ tươi Nam Mỹ, cung cấp nhiều khoáng chất tốt cho cơ thể', 1, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (11, 'Bánh kem dâu', 2, 100000, 0, 'banhkemdau.jpg', 48, 'Xuất xứ từ Ý, du nhập Việt Nam năm 2022. Mới lạ và đang là xu hướng', 3, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (12, 'Cà tím', 3, 12000, 0, 'catim.jpg', 49, 'Loại cà tím Châu Phi này to thì khỏi phải nói :)). Ăn thì cũng ngon, làm ngất ngây bao nhiêu chị em. Mua ăn thử bạn nhé', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (13, 'Chanh tươi', 3, 10000, 8000, 'chanhtuoiirag.jpg', 60, 'Loại tranh xuất xứ từ những anh Iran, Irag đẹp trai. Khủng b*, nên chanh này ăn ngon và hấp dẫn. Tận hưởng những phút giây như bị kh**g bố khi ăn nó', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (14, 'Cà chua', 3, 6000, 0, 'cachua.jpg', 10, 'Do Thiên Hoàng Minh Trị trồng từ thời chiến tranh thế giới thứ 2. Đặc biệt loại này không dính phóng xạ nên ăn bổ lắm nha.', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (15, 'Bánh kem bơ', 2, 100000, 75000, 'banhkembophap.jpg', 90, '<p>Vẫn sở hữu phần cốt b&aacute;nh b&ocirc;ng lan xốp mịn, điều l&agrave;m cho những chiếc b&aacute;nh kem n&agrave;y trở n&ecirc;n đặc biệt v&agrave; cuốn h&uacute;t nằm ở phần kem bơ. Kem bơ Ph&aacute;p được l&agrave;m từ những nguy&ecirc;n liệu gồm l&ograve;ng đỏ trứng, syrup đường v&agrave; bơ lạt. Nhờ sử dụng th&ecirc;m l&ograve;ng đỏ trứng, th&agrave;nh phẩm kem bơ sẽ c&oacute; hương vị cực k&igrave; thơm ngon, mềm mượt v&agrave; tan ngay khi v&agrave;o miệng. Những người thợ t&agrave;i hoa của Grand Castella c&ograve;n tận dụng phần kem bơ n&agrave;y, s&aacute;ng tạo n&ecirc;n những h&igrave;nh ảnh trang tr&iacute; độc đ&aacute;o, gi&uacute;p chiếc b&aacute;nh kem đ&atilde; ngon nay trở n&ecirc;n xinh đẹp hơn.</p>', 3, '2023-05-31', '2023-07-31', '2023-06-03', 0);
INSERT INTO `products` VALUES (16, 'Cải thìa', 3, 7000, 5000, 'caithia.jpg', 0, 'Cải thìa Triều Tiên do ông Kim trồng ăn rất ngon nhé. Mua ăn thử đi biết', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (17, 'Cà rốt', 3, 12000, 10000, 'carot.jpg', 76, 'Cà rốt Bắc Mỹ do ông Donald Trump đích thân trồng tại nông trại. Không qua bất cứ máy móc và hóa chất. Nên rất ngon và đắt', 2, '2023-05-31', '2023-07-31', '0000-00-00', 0);
INSERT INTO `products` VALUES (152, 'Bánh ngọt nè', 2, 150000, 100000, 'banhkemdau.jpg', 99, '<p>ngon lắm nha</p>', 3, '2023-06-25', '2023-07-25', '2023-06-24', 0);

-- ----------------------------
-- Table structure for promotion
-- ----------------------------
DROP TABLE IF EXISTS `promotion`;
CREATE TABLE `promotion`  (
  `id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`(8)) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of promotion
-- ----------------------------
INSERT INTO `promotion` VALUES ('HAIDUONG', 'giảm giá 50%', 0.5);

-- ----------------------------
-- Table structure for propertys
-- ----------------------------
DROP TABLE IF EXISTS `propertys`;
CREATE TABLE `propertys`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `SKU` int(11) NOT NULL,
  `image` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `size` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `price` int(11) NOT NULL,
  `promotion` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_at` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of propertys
-- ----------------------------
INSERT INTO `propertys` VALUES (23, 152, 152010000, 'banhkemtao.jpg', 's', 100000, 0, 40, 0, '2023-06-24');
INSERT INTO `propertys` VALUES (24, 152, 152010001, 'banhkemmatcha.jpg', 'm', 120000, 0, 15, 0, '2023-06-24');
INSERT INTO `propertys` VALUES (25, 152, 152010002, 'banhkemmauhongcute.jpg', 'l', 150000, 0, 6, 0, '2023-06-24');

-- ----------------------------
-- Table structure for protypes
-- ----------------------------
DROP TABLE IF EXISTS `protypes`;
CREATE TABLE `protypes`  (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of protypes
-- ----------------------------
INSERT INTO `protypes` VALUES (1, 'Trái cây tươi');
INSERT INTO `protypes` VALUES (2, 'Bánh ngọt');
INSERT INTO `protypes` VALUES (3, 'Rau củ');

-- ----------------------------
-- Table structure for roleusers
-- ----------------------------
DROP TABLE IF EXISTS `roleusers`;
CREATE TABLE `roleusers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dateCreate` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roleusers
-- ----------------------------
INSERT INTO `roleusers` VALUES (1, 'Cộng tác viên', '2023-05-29');
INSERT INTO `roleusers` VALUES (2, 'Thành viên', '2023-05-29');

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales`  (
  `id` int(11) NOT NULL,
  `Sell_number` int(11) NOT NULL,
  `Import_quantity` int(11) NOT NULL,
  `Import_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of sales
-- ----------------------------
INSERT INTO `sales` VALUES (2, 300, 1200, '2021-11-12 08:41:19');
INSERT INTO `sales` VALUES (3, 1200, 2000, '2021-11-12 08:42:44');
INSERT INTO `sales` VALUES (4, 100, 1000, '2021-11-12 08:43:12');
INSERT INTO `sales` VALUES (5, 700, 1500, '2021-11-12 08:43:38');
INSERT INTO `sales` VALUES (6, 100, 500, '2021-11-12 08:44:04');
INSERT INTO `sales` VALUES (7, 600, 1000, '2021-11-12 08:44:30');
INSERT INTO `sales` VALUES (8, 170, 300, '2021-11-12 08:44:52');
INSERT INTO `sales` VALUES (9, 100, 500, '2021-11-12 08:45:20');
INSERT INTO `sales` VALUES (10, 150, 400, '2021-11-19 19:29:46');
INSERT INTO `sales` VALUES (11, 160, 300, '2021-11-19 19:32:39');
INSERT INTO `sales` VALUES (12, 200, 500, '2021-11-19 19:32:54');
INSERT INTO `sales` VALUES (13, 320, 540, '2021-11-19 19:33:05');
INSERT INTO `sales` VALUES (14, 250, 350, '2021-11-19 19:33:17');
INSERT INTO `sales` VALUES (15, 700, 1000, '2021-11-19 19:33:34');
INSERT INTO `sales` VALUES (16, 300, 600, '2021-11-19 19:33:49');
INSERT INTO `sales` VALUES (17, 100, 200, '2021-11-19 19:34:01');
INSERT INTO `sales` VALUES (18, 500, 1000, '2021-12-14 09:25:29');
INSERT INTO `sales` VALUES (19, 300, 1250, '2021-12-14 09:25:29');
INSERT INTO `sales` VALUES (20, 400, 700, '2021-12-14 09:26:09');
INSERT INTO `sales` VALUES (21, 150, 500, '2021-12-14 09:26:30');
INSERT INTO `sales` VALUES (22, 190, 700, '2021-12-14 09:26:43');
INSERT INTO `sales` VALUES (23, 250, 800, '2021-12-14 09:26:58');
INSERT INTO `sales` VALUES (24, 800, 2000, '2021-12-14 09:27:10');
INSERT INTO `sales` VALUES (25, 300, 750, '2021-12-14 09:27:24');

-- ----------------------------
-- Table structure for suppliers
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO `suppliers` VALUES (1, 'Công Ty nhập khẩu trái cây V-FOOD Việt Nam', '22 Hàng Muối, quận Hoàn Kiếm, Hà Nội', '0944283886');
INSERT INTO `suppliers` VALUES (2, 'Công Ty TNHH MTV Nông Lâm Sản Thành Nam', '168/42 DX006, KP8, P. Phú Mỹ, Thủ Dầu Một, Bình Dương', '0971001003');
INSERT INTO `suppliers` VALUES (3, 'Bánh Ngon Bảo Khánh', '271 Bùi Đình Túy, P.24, Bình Thạnh', '0389399909');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `facebookId` bigint(20) NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_create` date NOT NULL,
  `fullName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 53 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (33, '25119_avatar.jpg', '0357570455', 'haiduong07112k3@gmail.com', 'DuongPro', 0, '25c8de8861dd2092759ae1bb0860c799', 2, 0, '2023-06-23', 'Le Hai Duong');
INSERT INTO `users` VALUES (36, 'c4fb589a7e63942c9a867bad72ffcc56.jpg', '0346098854', '501210803@stu.itc.edu.vn', 'itc', 0, '25c8de8861dd2092759ae1bb0860c799', 2, 0, '2023-05-17', 'Lê Hải Dương');
INSERT INTO `users` VALUES (43, '1525067626.jpg', '0', '', '', 837937047984346, '', 2, 0, '2023-06-03', 'Hải Dương');
INSERT INTO `users` VALUES (44, '7105516259.jpg', '0', '', '', 776660363969389, '', 2, 0, '2023-06-10', 'Dương Dương');
INSERT INTO `users` VALUES (49, 'avatar.jpg', '9345675411', 'taint3112@gmail.com', 'taidn01', 0, 'e10adc3949ba59abbe56e057f20f883e', 2, 0, '2023-06-26', 'Tai Tan');
INSERT INTO `users` VALUES (48, 'avatar.jpg', '357570455', 'haiduong711117@gmail.com', 'haiduong0711', 0, 'e10adc3949ba59abbe56e057f20f883e', 2, 0, '2023-06-23', 'Le Hai Duong');
INSERT INTO `users` VALUES (50, 'avatar.jpg', '357570455', 'haiduonghaha@gmail.com', 'haiduong', 0, 'd0042e45c435c011b00732daeb8b741d', 2, 0, '2023-06-27', 'Le Hai Duong ');
INSERT INTO `users` VALUES (51, 'avatar.jpg', '934567541', 'adm@gmail.com', 'taidn', 0, 'e4dbbe5b5c46d93bf59afde025029b76', 2, 0, '2023-06-30', 'NguyenTanTai');
INSERT INTO `users` VALUES (52, 'avatar.jpg', '9345675411', 'adm1@gmail.com', 'taidn02', 0, 'e4dbbe5b5c46d93bf59afde025029b76', 2, 0, '2023-06-30', 'NguyenTanTai1');

-- ----------------------------
-- Table structure for wishlists
-- ----------------------------
DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE `wishlists`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `create_at` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of wishlists
-- ----------------------------
INSERT INTO `wishlists` VALUES (9, 32, 101, '2023-06-18');
INSERT INTO `wishlists` VALUES (10, 32, 100, '2023-06-18');
INSERT INTO `wishlists` VALUES (11, 32, 102, '2023-06-18');
INSERT INTO `wishlists` VALUES (12, 32, 99, '2023-06-18');
INSERT INTO `wishlists` VALUES (13, 31, 102, '2023-06-18');
INSERT INTO `wishlists` VALUES (14, 36, 1, '2023-06-18');
INSERT INTO `wishlists` VALUES (16, 36, 3, '2023-06-18');
INSERT INTO `wishlists` VALUES (17, 36, 4, '2023-06-18');
INSERT INTO `wishlists` VALUES (18, 36, 5, '2023-06-18');
INSERT INTO `wishlists` VALUES (19, 36, 6, '2023-06-18');
INSERT INTO `wishlists` VALUES (20, 33, 2, '2016-01-19');

SET FOREIGN_KEY_CHECKS = 1;
