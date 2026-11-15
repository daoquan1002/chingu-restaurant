-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: chingu-restaurant
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'bbq','Thịt Nướng K-BBQ Than Hoa','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(2,'hotpot','Lẩu Hàn Quốc Nghi Ngút Khói','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(3,'pocha','Gà Rán Giòn & Món Nhậu K-Pocha','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(4,'drinks','Đồ Uống, Rượu Soju & Bia Tươi','active','2026-11-15 12:41:52','2026-11-15 12:41:52');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'staff',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,'admin','$2y$10$e8cM9g1QYyT.m0eS/T4uYeD9kGkL0R2oP.C1x7yL.GvV.JqZqO0lS','Quản Trị Viên Chingu','admin','2026-11-15 12:41:52','2026-11-15 12:41:52'),(2,'staff','$2y$10$e8cM9g1QYyT.m0eS/T4uYeD9kGkL0R2oP.C1x7yL.GvV.JqZqO0lS','Nhân Viên Thu Ngân','staff','2026-11-15 12:41:52','2026-11-15 12:41:52');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_detail_order` (`order_id`),
  KEY `fk_detail_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_details`
--

LOCK TABLES `order_details` WRITE;
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(50) NOT NULL,
  `table_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'cash',
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_code` (`order_code`),
  KEY `fk_order_table` (`table_id`),
  KEY `fk_order_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `korean_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `image` text DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_product_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Ba Chỉ Bò Mỹ Sốt Galbi','우삼겹 갈비구이','Thịt ba chỉ bò Mỹ vân mỡ đều tăm tắp, ướp đẫm sốt Galbi truyền thống từ quả lê và mật ong hoa rừng.',289000.00,'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=700&q=80','Best Seller','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(2,1,'Dẻ Sườn Bò Chosun','조선 소갈비살','Phần dẻ sườn cao cấp thơm nức mũi khi nướng xèo xèo, thịt mềm ngọt đậm đà cuốn cùng lá mè và kimchi.',349000.00,'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?auto=format&fit=crop&w=700&q=80','Signature','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(3,1,'Nạc Vai Heo Nướng Chum','항아리 목살구이','Thịt heo ủ trong chum sành đất 48 tiếng, nướng giòn bì mềm thịt, chấm ngập sốt ớt cay Ssamjang.',229000.00,'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&w=700&q=80','Yêu Thích','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(4,1,'Bạch Tuộc Nướng Cay','매운 낙지구이','Bạch tuộc đại dương tươi giòn sần sật tẩm sốt ớt Gochujang siêu cay bốc khói nghi ngút trên vỉ nướng.',269000.00,'https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&w=700&q=80','Cay Nồng','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(5,2,'Lẩu Kimchi Bò Mỹ & Hải Sản','김치 해물 전골','Nước dùng ninh xương 12h kết hợp kim chi lên men 21 ngày, topping ngập tràn tôm, mực tươi và bò Mỹ.',399000.00,'https://images.unsplash.com/photo-1547928576-a4a33237cbc3?auto=format&fit=crop&w=700&q=80','Món Chính','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(6,2,'Lẩu Tokbokki Phô Mai Kéo Sợi','치즈 떡볶이 전골','Bánh gạo dẻo mềm, chả cá Busan, xúc xích và lớp phô mai Mozzarella béo ngậy tan chảy thơm lừng.',329000.00,'https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=700&q=80','Hot Trend','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(7,2,'Lẩu Quân Đội Budae Jjigae','부대찌개 전골','Món lẩu trứ danh với giăm bông, xúc xích hun khói, đậu hũ non, nấm kim châm và mì ramen dai ngon.',359000.00,'https://images.unsplash.com/photo-1590301157890-4810ed352733?auto=format&fit=crop&w=700&q=80','Đặc Sắc','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(8,3,'Gà Rán Sốt Yangnyeom','양념치킨','Da gà chiên giòn rụm 2 lần, đẫm sốt ớt đỏ chua ngọt tỏi mật ong thơm phức, rắc mè rang vàng óng.',199000.00,'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?auto=format&fit=crop&w=700&q=80','Best Seller','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(9,3,'Bạch Tuộc Xào Cay Nakji','낙지볶음','Bạch tuộc xào lửa lớn cùng ớt bột Hàn Quốc và rau củ giòn ngọt, mồi nhậu số một bên bàn rượu Soju.',219000.00,'https://images.unsplash.com/photo-1617093727343-374698b1b08d?auto=format&fit=crop&w=700&q=80','Siêu Cay','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(10,3,'Canh Chả Cá Xiên Odeng','부산 어묵탕','Chả cá Busan xiên que nấu trong nước dùng củ cải ngọt thanh, làm ấm bụng trong những ngày se lạnh.',149000.00,'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=700&q=80','Thanh Nhẹ','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(11,3,'Miến Trộn Japchae','궁중 잡채','Sợi miến khoai lang dai dai trộn dầu mè thơm ngát, thịt bò áp chảo cùng rau củ ngũ sắc bắt mắt.',169000.00,'https://images.unsplash.com/photo-1582878826629-29b7ad1cdc43?auto=format&fit=crop&w=700&q=80','Thanh Đạm','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(12,4,'Rượu Soju Jinro Chamisul','참이슬 소주 (Chai 360ml)','Rượu Soju truyền thống nguyên bản tinh khiết, hương thơm dịu nhẹ, cay êm nồng nàn nâng ly cùng bạn bè.',120000.00,'https://images.unsplash.com/photo-1560512823-829485b8bf24?auto=format&fit=crop&w=700&q=80','Quốc Dân','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(13,4,'Soju Hoa Quả (Nho Xanh / Đào)','과일 소주 (Chai 360ml)','Vị ngọt thanh dịu từ trái cây tươi hòa quyện cùng nồng độ cồn nhẹ nhàng, cực kỳ dễ uống và bắt vị.',135000.00,'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=700&q=80','Nữ Tính & Dễ Uống','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(14,4,'Rượu Gạo Lên Men Makgeolli','생 막걸리 (Bình 750ml)','Rượu gạo sữa truyền thống lên men tự nhiên, vị béo chua ngọt thanh thanh, uống trong bát đồng chuẩn Hàn.',180000.00,'https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&w=700&q=80','Truyền Thống','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(15,4,'Bia Tươi Hàn Quốc Cass Fresh','카스 프레시 맥주 (Chai 500ml)','Bia vàng ướp lạnh mát rượi với bọt bia mịn màng, sự kết hợp hoàn hảo cùng các món nướng than hoa.',65000.00,'https://images.unsplash.com/photo-1528615141309-53f2564d3be8?auto=format&fit=crop&w=700&q=80','Sảng Khoái','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(16,4,'Trà Chanh Leo Mật Ong & Sâm','인삼 유자차 (Ly lớn)','Hương vị chua ngọt mát lạnh từ chanh dây tươi và mật ong sâm bổ dưỡng, giúp thanh lọc cơ thể cực tốt.',55000.00,'https://images.unsplash.com/photo-1556881286-fc6915169721?auto=format&fit=crop&w=700&q=80','Thanh Nhiệt','active','2026-11-15 12:41:52','2026-11-15 12:41:52'),(17,4,'Nước Gạo Rang Woongjin','아침햇살 (Chai 500ml)','Thức uống dinh dưỡng nổi tiếng Hàn Quốc từ gạo rang thơm bùi, ngọt thanh êm dịu thích hợp cho mọi lứa tuổi.',45000.00,'https://images.unsplash.com/photo-1527661591475-527312dd65f5?auto=format&fit=crop&w=700&q=80','Dinh Dưỡng','active','2026-11-15 12:41:52','2026-11-15 12:41:52');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_number` varchar(50) NOT NULL,
  `capacity` int(11) NOT NULL DEFAULT 4,
  `status` varchar(50) NOT NULL DEFAULT 'available',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `table_number` (`table_number`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,'Bàn 01',4,'available','2026-11-15 12:41:52','2026-11-15 16:35:01'),(2,'Bàn 02',4,'available','2026-11-15 12:41:52','2026-11-15 17:38:25'),(3,'Bàn 03',6,'available','2026-11-15 12:41:52','2026-11-15 17:38:25'),(4,'Bàn 04',6,'available','2026-11-15 12:41:52','2026-11-15 15:44:55'),(5,'Bàn 05',8,'available','2026-11-15 12:41:52','2026-11-15 17:38:25'),(6,'Bàn 06',4,'available','2026-11-15 12:41:52','2026-11-15 17:36:28'),(7,'Bàn 07',2,'available','2026-11-15 12:41:52','2026-11-15 12:41:52'),(8,'Bàn 08',4,'available','2026-11-15 12:41:52','2026-11-15 12:41:52');
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-15 17:38:36
