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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books`
--

LOCK TABLES `books` WRITE;
/*!40000 ALTER TABLE `books` DISABLE KEYS */;
INSERT INTO `books` VALUES (1,'Giáo trình tin học đại cương (2016)',1,245,'Trình bày những kiến thức căn bản về tin học và máy tính. Giải quyết một số bài toán biểu diễn thuật toán và các thuật toán thông dụng. Giới thiệu kiến thức nền tảng của ngôn ngữ lập trình C.','Trần Đình Khang (chủ biên)',1,50,0,'https://salt.tikicdn.com/ts/product/d8/cf/22/dc3c6a7031a8d2ff80e563cf995b1745.jpg',NULL,NULL),(2,'Bài tập tin học đại cương',1,101,'Bố cục sách gồm có phần câu hỏi trắc nghiệm và phần bài tập tự luận. Phần trắc nghiệm gồm các phần: tin học căn bản, giải quyết bài toán và lập trình. Phần bài tập tự luận gồm bài tập lập trình và một số bài tập có lời giải và một số bài người đọc tự giải.','Trần Đình Khang (chủ biên)',1,50,0,'https://salt.tikicdn.com/ts/product/1c/8d/27/21cd1c85bc9a51377b1202cf77dd8f5f.jpg',NULL,NULL),(3,'Kỹ thuật điện tử (2014)',2,271,'Giới thiệu một cách hệ thống những kiến thức cơ bản và hiện đại của ngành Kỹ thuật điện tử về các vấn đề: các thông số của mạch điện, tín hiệu điện, các cấu kiện dụng cụ điện tử có hiệu ứng chỉnh lưu và khuếch đại, kĩ thuật xung- số, biến đổi điện áp và dòng điện, hệ thống vi xử lý công nghiệp...','Đỗ Xuân Thụ (chủ biên)',1,40,0,'https://i.imgur.com/YOU0pSL.png',NULL,NULL),(4,'Bài tập kỹ thuật điện tử (2009)',2,187,'Giới thiệu tóm tắt các vấn đề cơ bản của lý thuyết và các bài tập có lời giải trong đó có các bài tập liên quan tới kỹ thuật xung - số (kỹ thuật digital).','Đỗ Xuân Thụ, Nguyễn Viết Nguyên',1,40,0,'https://1.bp.blogspot.com/-zNdQsv4oZpE/WGSvYWJBgrI/AAAAAAAALkU/EQN8aVqM0nEuTp99t_gxH2FAqkQv_UZYQCLcB/s1600/ky%2Bthuat%2Bdien%2Btu.png',NULL,NULL),(5,'Cấu trúc dữ liệu và giải thuật (2010)',3,308,'Trình bày mối quan hệ giữa cấu trúc dữ liệu và giải thuật, vấn đề thiết kế, phân tích giải thuật và giải thuật đệ qui; một số cấu trúc dữ liệu, giải thuật xử lý chúng, vài ứng dụng điển hình; các kinh nghiệm về thiết kế, cài đặt, sắp xếp và tìm kiếm.','Đỗ Xuân Lôi',1,35,0,'https://cuuduongthancong.com/ggdimg/cau-truc-du-lieu-va-giai-thuat-do-xuan-loi.pdf/cau-truc-du-lieu-va-giai-thuat-do-xuan-loi.pdf-0.jpg',NULL,NULL),(6,'Toán học cao cấp Tập 1 (2017)',2,390,'Toán học cao cấp Tập 1: Đại số và hình học giải tích \nTrình bày các khái niệm về toán học cao cấp: tập hợp và ánh xạ, cấu trúc đại số-số phức đa thức và phân thức hữu tỉ, định thức ma trận hệ phương trình tuyến tính đại số véctơ và hình học giải tích, không gian véctơ, không gian enclid, ánh xạ tuyến tính, tự riêng và véctơ riêng đạng toàn phương, số thực, hàm số một biến số thực, giới hạn và sự liên tục của hàm số một biến, đạo hàm và vi phân của hàm số một biến số, các định lý về giá trị trung bình, nguyên hàm và tích phân bất định, tích phân xác định chuỗi, hàm số nhiều biến số, ứng dụng của phép tính vi phân trong hình học, tích phân bội, tích phân đường, tích phân mặt, phương trình vi phân.','Nguyễn Đình Trí (chủ biên)',1,20,0,'http://www.nhasachgiaoduc.vn/images/stories/virtuemart/product/03e8874f17beefe0b6af.jpg',NULL,NULL),(7,'Toán học cao cấp Tập 2 (2015)',2,423,'Toán học cao cấp Tập 2: Giải tích\nTrình bày về phép tính giải tích của hàm một biến và hàm nhiều biến.','Nguyễn Đình Trí (chủ biên)',1,25,0,'http://www.nhasachgiaoduc.vn/images/stories/virtuemart/product/06d5507dc08c38d2619d.jpg',NULL,NULL),(8,'Vật lý đại cương Tập 1 (2011)',2,267,'Vật lý đại cương Tập 1: Cơ - Nhiệt \nPhần cơ học: động học chất điểm, động lực học chất điểm, động lực học hệ chất điểm động lực học vật rắn, năng lượng, trường hấp dẫn, cơ học chất lưu, thuyết tương đối hẹp Anhxtanh. Phần nhiệt học: nguyên lý thứ nhất của nhiệt động học, nguyên lý thứ hai của nhiệt động học, khí thực, chất lỏng, vật lí thống kê cổ điển.','Lương Duyên Bình (chủ biên)',1,10,0,'https://davibooks.vn/stores/uploads/b/b4__78206_image2_800_big.jpg',NULL,NULL),(9,'Vật lý đại cương Tập 2 (2011)',2,339,'Vật lý đại cương Tập 2: Điện - Dao động - Sóng\nTrình bày về trường tĩnh điện, vật dẫn, điện môi. Định luật cơ bản của dòng điện, từ trường không đổi, hiện tượng cảm ứng điện từ, vật liệu từ, trường điện từ: dao động, sóng cơ, sóng điện từ','Lương Duyên Bình (chủ biên)',1,15,0,'https://davibooks.vn/stores/uploads/g/b4__34756.jpg',NULL,NULL),(10,'Bài tập vật lý đại cương Tập 1 (2012)',2,195,'Bài tập vật lý đại cương Tập 1: Cơ nhiệt\nHướng dẫn phương pháp giải bài tập vật lý đại cương, cơ học, nhiệt học. Một số công thức và định luật, các bài tập ví dụ và đề bài tập tự giải.','Lương Duyên Bình (chủ biên)',1,5,0,'https://product.hstatic.net/200000122283/product/bai-tap-vat-li-dai-cuong-co-nhiet-0l3y8_4288433864b44782b2b6b59bae23f33c.jpg',NULL,NULL);
/*!40000 ALTER TABLE `books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2021_04_23_085002_create_books_table',1),(2,'2021_04_23_090802_create_categories_table',1),(3,'2021_04_23_091006_create_publishers_table',1),(12,'2021_04_24_024502_create_orders_table',2),(13,'2021_04_24_025958_add_user_info_to_orders_table',2);
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
  `book_id` bigint unsigned NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `restore_deadline` timestamp NULL DEFAULT NULL,
  `pick_time` timestamp NULL DEFAULT NULL,
  `restore_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_info` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
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
-- Table structure for table `publishers`
--

DROP TABLE IF EXISTS `publishers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `publishers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publishers`
--

LOCK TABLES `publishers` WRITE;
/*!40000 ALTER TABLE `publishers` DISABLE KEYS */;
INSERT INTO `publishers` VALUES (1,'BKHN','Bách khoa Hà Nội',NULL,NULL),(2,'GDVN','Giáo dục Việt Nam',NULL,NULL),(3,'DHQGHN','Đại học Quốc gia Hà Nội',NULL,NULL);
/*!40000 ALTER TABLE `publishers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-25 19:51:44
