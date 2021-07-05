-- MySQL dump 10.13  Distrib 8.0.22, for macos10.15 (x86_64)
--
-- Host: localhost    Database: libon
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `book_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_category`
--

LOCK TABLES `book_category` WRITE;
/*!40000 ALTER TABLE `book_category` DISABLE KEYS */;
INSERT INTO `book_category` VALUES (12,1,5,'2021-05-06 08:01:30','2021-05-06 08:01:30'),(13,3,5,'2021-05-06 08:01:30','2021-05-06 08:01:30'),(14,1,6,'2021-05-06 08:04:43','2021-05-06 08:04:43'),(17,6,7,'2021-05-06 19:00:26','2021-05-06 19:00:26'),(18,6,8,'2021-05-06 19:01:19','2021-05-06 19:01:19'),(19,8,9,'2021-05-06 19:02:26','2021-05-06 19:02:26'),(20,3,10,'2021-05-06 19:03:27','2021-05-06 19:03:27'),(21,7,10,'2021-05-06 19:03:27','2021-05-06 19:03:27'),(22,3,11,'2021-05-06 19:05:38','2021-05-06 19:05:38'),(23,7,11,'2021-05-06 19:05:38','2021-05-06 19:05:38'),(24,4,12,'2021-05-06 19:06:25','2021-05-06 19:06:25'),(26,4,14,'2021-05-06 19:08:59','2021-05-06 19:08:59'),(27,3,15,'2021-05-07 04:24:12','2021-05-07 04:24:12'),(28,4,15,'2021-05-07 04:24:12','2021-05-07 04:24:12');
/*!40000 ALTER TABLE `book_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher_id` bigint unsigned NOT NULL,
  `page_number` int NOT NULL,
  `content_summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_borrow` tinyint NOT NULL DEFAULT '0',
  `quantity` int NOT NULL DEFAULT '0',
  `borrowed` int NOT NULL DEFAULT '0',
  `pic_link` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (5,'Giáo trình tin học đại cương (2016)',1,245,'Trình bày những kiến thức căn bản về tin học và máy tính. Giải quyết một số bài toán biểu diễn thuật toán và các thuật toán thông dụng. Giới thiệu kiến thức nền tảng của ngôn ngữ lập trình C.','Trần Đình Khang (chủ biên)',0,0,0,'[\"\\/img\\/books\\/_7fc78a4ac31155f0.png\",\"\\/img\\/books\\/_5a7da2c7d1fe41f1.png\",null,null,\"\\/img\\/books\\/_7fc78a4ac31155f4.png\"]',NULL,'2021-05-06 08:02:00'),(6,'Bài tập tin học đại cương',1,101,'Bố cục sách gồm có phần câu hỏi trắc nghiệm và phần bài tập tự luận. Phần trắc nghiệm gồm các phần: tin học căn bản, giải quyết bài toán và lập trình. Phần bài tập tự luận gồm bài tập lập trình và một số bài tập có lời giải và một số bài người đọc tự giải.','Trần Đình Khang (chủ biên)',0,0,0,'[\"\\/img\\/books\\/_b8e74c9fa2bba240.png\",null,null,null,null]',NULL,'2021-05-06 08:05:45'),(7,'Kỹ thuật điện tử (2014)',4,271,'Giới thiệu một cách hệ thống những kiến thức cơ bản và hiện đại của ngành Kỹ thuật điện tử về các vấn đề: các thông số của mạch điện, tín hiệu điện, các cấu kiện dụng cụ điện tử có hiệu ứng chỉnh lưu và khuếch đại, kĩ thuật xung- số, biến đổi điện áp và dòng điện, hệ thống vi xử lý công nghiệp...','Đỗ Xuân Thụ (chủ biên)',0,0,0,'[\"\\/img\\/books\\/_fb388f65e8867890.png\",null,null,null,null]',NULL,NULL),(8,'Bài tập kỹ thuật điện tử (2009)',4,187,'Giới thiệu tóm tắt các vấn đề cơ bản của lý thuyết và các bài tập có lời giải trong đó có các bài tập liên quan tới kỹ thuật xung - số (kỹ thuật digital).','Đỗ Xuân Thụ, Nguyễn Viết Nguyên',0,0,0,'[\"\\/img\\/books\\/_e9e472369c5d2350.png\",null,null,null,null]',NULL,NULL),(9,'Cấu trúc dữ liệu và giải thuật (2010)',3,308,'Trình bày mối quan hệ giữa cấu trúc dữ liệu và giải thuật, vấn đề thiết kế, phân tích giải thuật và giải thuật đệ qui; một số cấu trúc dữ liệu, giải thuật xử lý chúng, vài ứng dụng điển hình; các kinh nghiệm về thiết kế, cài đặt, sắp xếp và tìm kiếm.','Đỗ Xuân Lôi',0,0,0,'[\"\\/img\\/books\\/_19be5d809e3a6380.png\",null,null,null,null]',NULL,NULL),(10,'Toán học cao cấp Tập 1 (2017)',4,390,'Toán học cao cấp Tập 1: Đại số và hình học giải tích \r\nTrình bày các khái niệm về toán học cao cấp: tập hợp và ánh xạ, cấu trúc đại số-số phức đa thức và phân thức hữu tỉ, định thức ma trận hệ phương trình tuyến tính đại số véctơ và hình học giải tích, không gian véctơ, không gian enclid, ánh xạ tuyến tính, tự riêng và véctơ riêng đạng toàn phương, số thực, hàm số một biến số thực, giới hạn và sự liên tục của hàm số một biến, đạo hàm và vi phân của hàm số một biến số, các định lý về giá trị trung bình, nguyên hàm và tích phân bất định, tích phân xác định chuỗi, hàm số nhiều biến số, ứng dụng của phép tính vi phân trong hình học, tích phân bội, tích phân đường, tích phân mặt, phương trình vi phân.','Nguyễn Đình Trí (chủ biên)',0,0,0,'[\"\\/img\\/books\\/_99d33de597aec990.png\",null,null,null,null]',NULL,NULL),(11,'Toán học cao cấp Tập 2 (2015)',4,423,'Toán học cao cấp Tập 2: Giải tích\r\nTrình bày về phép tính giải tích của hàm một biến và hàm nhiều biến.','Nguyễn Đình Trí (chủ biên)',0,1,1,'[\"\\/img\\/books\\/_41a0804bc3297680.png\",null,null,null,null]',NULL,'2021-05-09 21:05:28'),(12,'Vật lý đại cương Tập 1 (2011)',4,267,'Vật lý đại cương Tập 1: Cơ - Nhiệt \r\nPhần cơ học: động học chất điểm, động lực học chất điểm, động lực học hệ chất điểm động lực học vật rắn, năng lượng, trường hấp dẫn, cơ học chất lưu, thuyết tương đối hẹp Anhxtanh. Phần nhiệt học: nguyên lý thứ nhất của nhiệt động học, nguyên lý thứ hai của nhiệt động học, khí thực, chất lỏng, vật lí thống kê cổ điển.','Lương Duyên Bình (chủ biên)',0,2,2,'[\"\\/img\\/books\\/_796ea59bec71d280.png\",null,null,null,null]',NULL,'2021-05-09 21:05:21'),(14,'Bài tập vật lý đại cương Tập 1 (2012)',4,195,'Bài tập vật lý đại cương Tập 1: Cơ nhiệt\r\nHướng dẫn phương pháp giải bài tập vật lý đại cương, cơ học, nhiệt học. Một số công thức và định luật, các bài tập ví dụ và đề bài tập tự giải.','Lương Duyên Bình (chủ biên)',1,3,1,'[\"\\/img\\/books\\/_2a678ea68aac71e0.png\",null,null,null,null]',NULL,'2021-05-09 20:51:49'),(15,'Vật lý đại cương Tập 2 (2011)',4,339,'Vật lý đại cương Tập 2: Điện - Dao động - Sóng\r\nTrình bày về trường tĩnh điện, vật dẫn, điện môi. Định luật cơ bản của dòng điện, từ trường không đổi, hiện tượng cảm ứng điện từ, vật liệu từ, trường điện từ: dao động, sóng cơ, sóng điện từ','Lương Duyên Bình (chủ biên)',1,2,1,'[\"\\/img\\/books\\/_95209cb84c7b0010.png\",null,null,null,null]',NULL,'2021-05-09 20:50:24');
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `books_in_orders`
--

DROP TABLE IF EXISTS `books_in_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `books_in_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `the_book_id` bigint unsigned DEFAULT NULL,
  `book_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books_in_orders`
--

LOCK TABLES `books_in_orders` WRITE;
/*!40000 ALTER TABLE `books_in_orders` DISABLE KEYS */;
INSERT INTO `books_in_orders` VALUES (1,1,NULL,15,'2021-05-07 06:01:24','2021-05-07 06:01:24'),(2,1,NULL,14,'2021-05-07 06:01:24','2021-05-07 06:01:24'),(3,9,24,14,NULL,NULL),(4,9,23,15,NULL,NULL),(5,10,26,12,NULL,NULL),(6,11,27,12,'2021-05-09 21:04:55',NULL),(7,11,28,11,'2021-05-09 21:04:55',NULL);
/*!40000 ALTER TABLE `books_in_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Tin học cơ sở','2021-05-06 04:48:40','2021-05-06 04:48:40'),(3,'Khoa học kỹ thuật','2021-05-06 04:49:25','2021-05-06 04:49:25'),(4,'Vật lý','2021-05-06 08:06:10','2021-05-06 08:06:10'),(5,'Giáo trình','2021-05-06 18:48:57','2021-05-06 18:48:57'),(6,'Điện','2021-05-06 18:54:09','2021-05-06 18:54:09'),(7,'Toán cao cấp','2021-05-06 18:54:23','2021-05-06 18:54:23'),(8,'Tin học cao cấp','2021-05-06 18:54:47','2021-05-06 18:54:47');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_user`
--

DROP TABLE IF EXISTS `group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `group_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_user`
--

LOCK TABLES `group_user` WRITE;
/*!40000 ALTER TABLE `group_user` DISABLE KEYS */;
INSERT INTO `group_user` VALUES (1,1,1,'2021-05-03 07:45:31','2021-05-03 07:45:31',NULL),(2,2,2,'2021-05-07 05:29:36','2021-05-07 05:29:36',NULL),(3,3,2,'2021-05-09 02:17:51','2021-05-09 02:17:51',NULL);
/*!40000 ALTER TABLE `group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','2021-05-03 07:45:31','2021-05-03 07:45:31',NULL),(2,'user','2021-05-07 05:29:35','2021-05-07 05:29:35',NULL);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (20,'2021_04_23_085002_create_books_table',3),(21,'2021_04_23_090802_create_categories_table',3),(22,'2021_04_23_091006_create_publishers_table',3),(23,'2021_05_03_135730_edit_categories_table',3),(24,'2021_05_07_023620_create_the_books_table',4),(27,'2021_04_24_024502_create_orders_table',5),(28,'2021_04_24_025958_add_user_info_to_orders_table',5),(29,'2021_05_07_123831_edit_orders_table',5),(30,'2021_05_07_124342_create_books_in_orders_table',5),(31,'2021_05_08_023504_edit_users_table',6),(32,'2021_05_10_035613_edit_books_in_orders_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint NOT NULL DEFAULT '1',
  `restore_deadline` timestamp NULL DEFAULT NULL,
  `pick_time` timestamp NULL DEFAULT NULL,
  `restore_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'2021-05-10 06:01:24',NULL,NULL,'2021-05-07 06:01:24','2021-05-07 06:01:24',2),(9,2,'2021-07-08 17:00:00','2021-05-09 04:39:07',NULL,'2021-05-09 04:39:07',NULL,3),(10,2,'2021-07-09 17:00:00','2021-05-09 21:01:43',NULL,'2021-05-09 21:01:43',NULL,1),(11,2,'2021-07-09 17:00:00','2021-05-09 21:04:55',NULL,'2021-05-09 21:04:55',NULL,2);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publishers`
--

DROP TABLE IF EXISTS `publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publishers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publishers_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` VALUES (1,'Bách khoa Hà Nội','2021-05-06 04:44:36','2021-05-06 04:44:36'),(3,'Đại học Quốc gia Hà Nội','2021-05-06 04:44:52','2021-05-06 04:44:52'),(4,'Giáo dục Việt Nam','2021-05-06 08:06:30','2021-05-06 08:06:30');
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,'2021-05-03 07:45:31','2021-05-03 07:45:31',NULL),(2,2,2,'2021-05-07 05:29:36','2021-05-07 05:29:36',NULL),(3,3,2,'2021-05-09 02:17:51','2021-05-09 02:17:51',NULL);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2021-05-03 07:45:31','2021-05-03 07:45:31',NULL),(2,'user','2021-05-07 05:29:36','2021-05-07 05:29:36',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `the_books`
--

DROP TABLE IF EXISTS `the_books`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `the_books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `book_id` bigint unsigned NOT NULL,
  `barcode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `publishing_year` year DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `the_books_barcode_unique` (`barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `the_books`
--

LOCK TABLES `the_books` WRITE;
/*!40000 ALTER TABLE `the_books` DISABLE KEYS */;
INSERT INTO `the_books` VALUES (2,14,'00897',0,NULL,NULL,'2021-05-07 02:02:17'),(21,14,'00079',1,2017,NULL,NULL),(23,15,'00231',0,2011,NULL,'2021-05-09 04:39:07'),(24,14,'00223',0,2014,NULL,'2021-05-09 04:39:07'),(25,15,'00931',1,NULL,NULL,NULL),(26,12,'00111',0,NULL,NULL,'2021-05-09 21:01:43'),(27,12,'00222',0,NULL,NULL,'2021-05-09 21:04:55'),(28,11,'00333',0,NULL,NULL,'2021-05-09 21:04:56');
/*!40000 ALTER TABLE `the_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin` tinyint NOT NULL,
  `id_card` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL DEFAULT '1990-01-01',
  `gender` tinyint NOT NULL DEFAULT '0',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint unsigned NOT NULL,
  `career` tinyint NOT NULL,
  `id_staff_student` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referral_source` tinyint NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_id_card_unique` (`id_card`),
  UNIQUE KEY `users_id_staff_student_unique` (`id_staff_student`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'031731429','Nguyen Manh Tien','admin@admin.com','$2y$10$Y5RpS/oyInnfCv6Q0kSOT.w8Sc2XlWdctXoh8mkavu1yc3eY7KssS','1990-01-01',0,'0945391533',1,1,'20164069',1,NULL,NULL,NULL,'2021-05-03 07:45:31','2021-05-03 07:45:31',NULL),(2,0,'031970067','Nguyen Manh Tien','tiennguyenbka198@gmail.com','$2y$10$9xNJwuFOdPU8Jij7BP44lOtaFiPxHaFyRThamrxnu9VDMxb4APWom','1990-01-01',0,'0945391533',1,1,'20164068',1,NULL,NULL,NULL,'2021-05-07 05:29:36','2021-05-07 05:29:36',NULL),(3,0,'031222333','Nguyen Trong Nghia','tonytit@gmail.com','$2y$10$mL4R409WBiieXTKmevkpHek6Os2vanhNBz/YcjH0wvuxtYcbc2hEC','1990-01-01',0,'0945391222',1,1,'20164000',1,NULL,NULL,NULL,'2021-05-09 02:16:03','2021-05-09 02:16:03',NULL);
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

-- Dump completed on 2021-05-10 11:06:43
