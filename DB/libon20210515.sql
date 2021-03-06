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
INSERT INTO `books` VALUES (5,'Gi??o tr??nh tin h???c ?????i c????ng (2016)',1,245,'Tr??nh b??y nh???ng ki???n th???c c??n b???n v??? tin h???c v?? m??y t??nh. Gi???i quy???t m???t s??? b??i to??n bi???u di???n thu???t to??n v?? c??c thu???t to??n th??ng d???ng. Gi???i thi???u ki???n th???c n???n t???ng c???a ng??n ng??? l???p tr??nh C.','Tr???n ????nh Khang (ch??? bi??n)',0,0,0,'[\"\\/img\\/books\\/_7fc78a4ac31155f0.png\",\"\\/img\\/books\\/_5a7da2c7d1fe41f1.png\",null,null,\"\\/img\\/books\\/_7fc78a4ac31155f4.png\"]',NULL,'2021-05-06 08:02:00'),(6,'B??i t???p tin h???c ?????i c????ng',1,101,'B??? c???c s??ch g???m c?? ph???n c??u h???i tr???c nghi???m v?? ph???n b??i t???p t??? lu???n. Ph???n tr???c nghi???m g???m c??c ph???n: tin h???c c??n b???n, gi???i quy???t b??i to??n v?? l???p tr??nh. Ph???n b??i t???p t??? lu???n g???m b??i t???p l???p tr??nh v?? m???t s??? b??i t???p c?? l???i gi???i v?? m???t s??? b??i ng?????i ?????c t??? gi???i.','Tr???n ????nh Khang (ch??? bi??n)',0,0,0,'[\"\\/img\\/books\\/_b8e74c9fa2bba240.png\",null,null,null,null]',NULL,'2021-05-06 08:05:45'),(7,'K??? thu???t ??i???n t??? (2014)',4,271,'Gi???i thi???u m???t c??ch h??? th???ng nh???ng ki???n th???c c?? b???n v?? hi???n ?????i c???a ng??nh K??? thu???t ??i???n t??? v??? c??c v???n ?????: c??c th??ng s??? c???a m???ch ??i???n, t??n hi???u ??i???n, c??c c???u ki???n d???ng c??? ??i???n t??? c?? hi???u ???ng ch???nh l??u v?? khu???ch ?????i, k?? thu???t xung- s???, bi???n ?????i ??i???n ??p v?? d??ng ??i???n, h??? th???ng vi x??? l?? c??ng nghi???p...','????? Xu??n Th??? (ch??? bi??n)',0,0,0,'[\"\\/img\\/books\\/_fb388f65e8867890.png\",null,null,null,null]',NULL,NULL),(8,'B??i t???p k??? thu???t ??i???n t??? (2009)',4,187,'Gi???i thi???u t??m t???t c??c v???n ????? c?? b???n c???a l?? thuy???t v?? c??c b??i t???p c?? l???i gi???i trong ???? c?? c??c b??i t???p li??n quan t???i k??? thu???t xung - s??? (k??? thu???t digital).','????? Xu??n Th???, Nguy???n Vi???t Nguy??n',0,0,0,'[\"\\/img\\/books\\/_e9e472369c5d2350.png\",null,null,null,null]',NULL,NULL),(9,'C???u tr??c d??? li???u v?? gi???i thu???t (2010)',3,308,'Tr??nh b??y m???i quan h??? gi???a c???u tr??c d??? li???u v?? gi???i thu???t, v???n ????? thi???t k???, ph??n t??ch gi???i thu???t v?? gi???i thu???t ????? qui; m???t s??? c???u tr??c d??? li???u, gi???i thu???t x??? l?? ch??ng, v??i ???ng d???ng ??i???n h??nh; c??c kinh nghi???m v??? thi???t k???, c??i ?????t, s???p x???p v?? t??m ki???m.','????? Xu??n L??i',0,0,0,'[\"\\/img\\/books\\/_19be5d809e3a6380.png\",null,null,null,null]',NULL,NULL),(10,'To??n h???c cao c???p T???p 1 (2017)',4,390,'To??n h???c cao c???p T???p 1: ?????i s??? v?? h??nh h???c gi???i t??ch \r\nTr??nh b??y c??c kh??i ni???m v??? to??n h???c cao c???p: t???p h???p v?? ??nh x???, c???u tr??c ?????i s???-s??? ph???c ??a th???c v?? ph??n th???c h???u t???, ?????nh th???c ma tr???n h??? ph????ng tr??nh tuy???n t??nh ?????i s??? v??ct?? v?? h??nh h???c gi???i t??ch, kh??ng gian v??ct??, kh??ng gian enclid, ??nh x??? tuy???n t??nh, t??? ri??ng v?? v??ct?? ri??ng ?????ng to??n ph????ng, s??? th???c, h??m s??? m???t bi???n s??? th???c, gi???i h???n v?? s??? li??n t???c c???a h??m s??? m???t bi???n, ?????o h??m v?? vi ph??n c???a h??m s??? m???t bi???n s???, c??c ?????nh l?? v??? gi?? tr??? trung b??nh, nguy??n h??m v?? t??ch ph??n b???t ?????nh, t??ch ph??n x??c ?????nh chu???i, h??m s??? nhi???u bi???n s???, ???ng d???ng c???a ph??p t??nh vi ph??n trong h??nh h???c, t??ch ph??n b???i, t??ch ph??n ???????ng, t??ch ph??n m???t, ph????ng tr??nh vi ph??n.','Nguy???n ????nh Tr?? (ch??? bi??n)',0,0,0,'[\"\\/img\\/books\\/_99d33de597aec990.png\",null,null,null,null]',NULL,NULL),(11,'To??n h???c cao c???p T???p 2 (2015)',4,423,'To??n h???c cao c???p T???p 2: Gi???i t??ch\r\nTr??nh b??y v??? ph??p t??nh gi???i t??ch c???a h??m m???t bi???n v?? h??m nhi???u bi???n.','Nguy???n ????nh Tr?? (ch??? bi??n)',1,2,1,'[\"\\/img\\/books\\/_41a0804bc3297680.png\",null,null,null,null]',NULL,'2021-05-11 02:38:19'),(12,'V???t l?? ?????i c????ng T???p 1 (2011)',4,267,'V???t l?? ?????i c????ng T???p 1: C?? - Nhi???t \r\nPh???n c?? h???c: ?????ng h???c ch???t ??i???m, ?????ng l???c h???c ch???t ??i???m, ?????ng l???c h???c h??? ch???t ??i???m ?????ng l???c h???c v???t r???n, n??ng l?????ng, tr?????ng h???p d???n, c?? h???c ch???t l??u, thuy???t t????ng ?????i h???p Anhxtanh. Ph???n nhi???t h???c: nguy??n l?? th??? nh???t c???a nhi???t ?????ng h???c, nguy??n l?? th??? hai c???a nhi???t ?????ng h???c, kh?? th???c, ch???t l???ng, v???t l?? th???ng k?? c??? ??i???n.','L????ng Duy??n B??nh (ch??? bi??n)',1,3,2,'[\"\\/img\\/books\\/_796ea59bec71d280.png\",null,null,null,null]',NULL,'2021-05-10 07:52:15'),(14,'B??i t???p v???t l?? ?????i c????ng T???p 1 (2012)',4,195,'B??i t???p v???t l?? ?????i c????ng T???p 1: C?? nhi???t\r\nH?????ng d???n ph????ng ph??p gi???i b??i t???p v???t l?? ?????i c????ng, c?? h???c, nhi???t h???c. M???t s??? c??ng th???c v?? ?????nh lu???t, c??c b??i t???p v?? d??? v?? ????? b??i t???p t??? gi???i.','L????ng Duy??n B??nh (ch??? bi??n)',1,4,1,'[\"\\/img\\/books\\/_2a678ea68aac71e0.png\",null,null,null,null]',NULL,'2021-05-11 03:22:58'),(15,'V???t l?? ?????i c????ng T???p 2 (2011)',4,339,'V???t l?? ?????i c????ng T???p 2: ??i???n - Dao ?????ng - S??ng\r\nTr??nh b??y v??? tr?????ng t??nh ??i???n, v???t d???n, ??i???n m??i. ?????nh lu???t c?? b???n c???a d??ng ??i???n, t??? tr?????ng kh??ng ?????i, hi???n t?????ng c???m ???ng ??i???n t???, v???t li???u t???, tr?????ng ??i???n t???: dao ?????ng, s??ng c??, s??ng ??i???n t???','L????ng Duy??n B??nh (ch??? bi??n)',1,3,1,'[\"\\/img\\/books\\/_95209cb84c7b0010.png\",null,null,null,null]',NULL,'2021-05-11 09:55:13');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `books_in_orders`
--

LOCK TABLES `books_in_orders` WRITE;
/*!40000 ALTER TABLE `books_in_orders` DISABLE KEYS */;
INSERT INTO `books_in_orders` VALUES (1,1,25,15,'2021-05-07 06:01:24','2021-05-10 20:36:43'),(2,1,32,14,'2021-05-07 06:01:24','2021-05-10 20:36:43'),(3,9,24,14,NULL,NULL),(4,9,23,15,NULL,NULL),(5,10,26,12,NULL,NULL),(6,11,27,12,'2021-05-09 21:04:55',NULL),(7,11,28,11,'2021-05-09 21:04:55',NULL),(8,12,NULL,11,'2021-05-11 09:46:39',NULL),(9,12,NULL,12,'2021-05-11 09:46:39',NULL);
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
INSERT INTO `categories` VALUES (1,'Tin h???c c?? s???','2021-05-06 04:48:40','2021-05-06 04:48:40'),(3,'Khoa h???c k??? thu???t','2021-05-06 04:49:25','2021-05-06 04:49:25'),(4,'V???t l??','2021-05-06 08:06:10','2021-05-06 08:06:10'),(5,'Gi??o tr??nh','2021-05-06 18:48:57','2021-05-06 18:48:57'),(6,'??i???n','2021-05-06 18:54:09','2021-05-06 18:54:09'),(7,'To??n cao c???p','2021-05-06 18:54:23','2021-05-06 18:54:23'),(8,'Tin h???c cao c???p','2021-05-06 18:54:47','2021-05-06 18:54:47');
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (20,'2021_04_23_085002_create_books_table',3),(21,'2021_04_23_090802_create_categories_table',3),(22,'2021_04_23_091006_create_publishers_table',3),(23,'2021_05_03_135730_edit_categories_table',3),(24,'2021_05_07_023620_create_the_books_table',4),(27,'2021_04_24_024502_create_orders_table',5),(28,'2021_04_24_025958_add_user_info_to_orders_table',5),(29,'2021_05_07_123831_edit_orders_table',5),(30,'2021_05_07_124342_create_books_in_orders_table',5),(31,'2021_05_08_023504_edit_users_table',6),(32,'2021_05_10_035613_edit_books_in_orders_table',7),(33,'2021_05_13_145019_edit_users_table',8),(34,'2021_05_15_133408_create_organizations_table',9),(35,'2021_05_15_151944_edit_users_table',10);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,'2021-07-10 17:00:00','2021-05-10 20:36:43','2021-07-15 02:55:09','2021-05-07 06:01:24','2021-05-11 01:55:09',2),(9,2,'2021-07-08 17:00:00','2021-05-09 04:39:07',NULL,'2021-05-09 04:39:07',NULL,3),(10,2,'2021-07-09 17:00:00','2021-05-09 21:01:43',NULL,'2021-05-09 21:01:43',NULL,1),(11,2,'2021-07-09 17:00:00','2021-05-09 21:04:55',NULL,'2021-05-09 21:04:55',NULL,2),(12,0,'2021-05-11 09:45:49',NULL,NULL,'2021-05-11 09:45:29','2021-05-11 03:14:15',3),(13,3,'2021-05-12 03:02:11','2021-05-12 03:02:11',NULL,'2021-05-12 03:02:11',NULL,2),(14,4,'2021-05-12 03:02:11','2021-05-12 03:02:11',NULL,'2021-05-12 03:02:11',NULL,3);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organizations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organizations_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizations`
--

LOCK TABLES `organizations` WRITE;
/*!40000 ALTER TABLE `organizations` DISABLE KEYS */;
INSERT INTO `organizations` VALUES (1,'Tr?????ng ?????i h???c B??ch khoa H?? N???i','2021-05-15 06:38:36','2021-05-15 06:38:36');
/*!40000 ALTER TABLE `organizations` ENABLE KEYS */;
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
INSERT INTO `publishers` VALUES (1,'B??ch khoa H?? N???i','2021-05-06 04:44:36','2021-05-06 04:44:36'),(3,'?????i h???c Qu???c gia H?? N???i','2021-05-06 04:44:52','2021-05-06 04:44:52'),(4,'Gi??o d???c Vi???t Nam','2021-05-06 08:06:30','2021-05-06 08:06:30');
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `the_books`
--

LOCK TABLES `the_books` WRITE;
/*!40000 ALTER TABLE `the_books` DISABLE KEYS */;
INSERT INTO `the_books` VALUES (2,14,'00897',0,NULL,NULL,'2021-05-07 02:02:17'),(21,14,'00079',1,2017,NULL,NULL),(23,15,'00231',0,2011,NULL,'2021-05-09 04:39:07'),(24,14,'00223',0,2014,NULL,'2021-05-09 04:39:07'),(25,15,'00931',1,NULL,NULL,'2021-05-11 01:55:09'),(26,12,'00111',0,NULL,NULL,'2021-05-09 21:01:43'),(27,12,'00222',0,NULL,NULL,'2021-05-09 21:04:55'),(28,11,'00333',0,NULL,NULL,'2021-05-09 21:04:56'),(30,12,'00999',1,NULL,NULL,NULL),(31,11,'00100',1,NULL,NULL,NULL),(32,14,'00080',1,NULL,NULL,'2021-05-11 01:55:09'),(33,15,'00932',1,NULL,NULL,NULL);
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
  `referral_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_id_card_unique` (`id_card`),
  UNIQUE KEY `users_id_staff_student_unique` (`id_staff_student`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'031731429','Nguy???n M???nh Ti???n','admin@admin.com','$2y$10$Y5RpS/oyInnfCv6Q0kSOT.w8Sc2XlWdctXoh8mkavu1yc3eY7KssS','1990-01-01',0,'0945391533',1,1,'20164069','1',NULL,NULL,NULL,'2021-05-03 07:45:31','2021-05-13 09:41:18',NULL,'733bc789cf0b07a07f97dfb8e0a83482f97b3dbf706febaf59ba6527f4630bbc9019b3d9b5e5a35072b628dfd60acda7cdfb64cb3a48e8d3c974053100c945d7'),(2,0,'031970067','Nguyen Manh Tien','tiennguyenbka198@gmail.com','$2y$10$9xNJwuFOdPU8Jij7BP44lOtaFiPxHaFyRThamrxnu9VDMxb4APWom','1990-01-01',0,'0945391533',1,1,'20164068','1',NULL,NULL,NULL,'2021-05-07 05:29:36','2021-05-07 05:29:36',NULL,NULL),(3,0,'031222333','Nguyen Trong Nghia','tonytit@gmail.com','$2y$10$mL4R409WBiieXTKmevkpHek6Os2vanhNBz/YcjH0wvuxtYcbc2hEC','1990-01-01',0,'0945391222',1,1,'20164000','1',NULL,NULL,NULL,'2021-05-09 02:16:03','2021-05-13 08:47:21',NULL,'957bcb57d1b0b939b62beb8fd8f9d22764db8755e7cfbd7d0002bf4b7d663535d087aef8a7e95e508c7769c63882b0ba05dabc2aa6076d60eed3d526be13e260'),(5,0,'031999777','Nguy???n Minh Ti???n','tien@gmail.com','$2y$10$cAF8psqBKyYKQXdvCuEjuef8NiQEzx3OKBO5neON7PR3a1pWpA0Yu','1990-01-01',0,'0945391533',1,1,'20164444',NULL,NULL,NULL,NULL,NULL,'2021-05-15 08:22:19',NULL,'5135b7caef83e78b634a4a093177fb733f312cf4733462e259e2cc19015e3385935069f2e6454c3abfe0d9e635240c933e16a0536ab026d3bafeb8a4e2d47c00');
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

-- Dump completed on 2021-05-15 22:33:53
