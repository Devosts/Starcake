-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: starcak_dump_tmp
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Star Cake Admin','admin@starcake.com','$2y$12$hCIKH8f1TL1hScKowSKPkuUNWSWRb4bFAsiWoafRNmoYXZ9/UFvn2','superadmin',1,'fSbyhuOI7eQOrLu0U5BjC8w8VVWWLAnCV3geY8KZQhCgURiJrTVAXZnQhQCz','2026-08-09 12:58:46','2026-08-09 12:58:46');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Kue Kering','kue-kering',NULL,'Kue kering renyah dan tahan lama, cocok untuk oleh-oleh.',1,0,'2026-08-09 12:58:46','2026-08-09 12:58:46'),(2,'Kue Basah','kue-basah',NULL,'Kue basah lembut, manis, dan lembut.',1,0,'2026-08-09 12:58:46','2026-08-09 12:58:46'),(3,'Kue Ulang Tahun','kue-ulang-tahun',NULL,'Kue spesial untuk perayaan ulang tahun.',1,0,'2026-08-09 12:58:46','2026-08-09 12:58:46'),(4,'Kue Lebaran','kue-lebaran',NULL,'Kue tradisional ketika hari raya.',1,0,'2026-08-09 12:58:46','2026-08-09 12:58:46'),(5,'Snack & Camilan','snack-camilan',NULL,'Camilan ringan pendamping minum.',1,0,'2026-08-09 12:58:46','2026-08-09 12:58:46');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `user_unread_count` int unsigned NOT NULL DEFAULT '0',
  `admin_unread_count` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conversations_user_id_unique` (`user_id`),
  CONSTRAINT `conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `conversation_id` bigint unsigned NOT NULL,
  `sender_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_conversation_id_created_at_index` (`conversation_id`,`created_at`),
  KEY `messages_sender_type_sender_id_index` (`sender_type`,`sender_id`),
  CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_02_000000_create_admins_table',1),(5,'2024_01_03_000000_create_categories_table',1),(6,'2024_01_04_000000_create_products_table',1),(7,'2024_01_05_000000_create_reviews_table',1),(8,'2024_01_06_000000_create_orders_table',1),(9,'2024_01_07_000000_create_order_items_table',1),(10,'2024_01_08_000000_create_order_histories_table',1),(11,'2024_01_09_000000_create_settings_table',1),(13,'2026_10_18_100000_create_conversations_table',1),(14,'2026_10_18_100001_create_messages_table',1),(15,'2026_08_15_000000_drop_recipe_from_products_table',3),(16,'2026_10_18_120000_drop_contact_messages_and_emails_tables',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

--
-- Table structure for table `order_histories`
--

DROP TABLE IF EXISTS `order_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_histories_order_id_foreign` (`order_id`),
  CONSTRAINT `order_histories_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_histories`
--

/*!40000 ALTER TABLE `order_histories` DISABLE KEYS */;
INSERT INTO `order_histories` VALUES (1,1,'pending','Pesanan Diterima','Pesanan baru saja diterima.','guest','2026-08-09 14:23:26','2026-08-09 14:23:26'),(2,1,'processing','Sedang Diproses','Diproses oleh admin','Star Cake Admin','2026-08-09 14:50:48','2026-08-09 14:50:48');
/*!40000 ALTER TABLE `order_histories` ENABLE KEYS */;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,'Brownie Kukus Coklat',65000.00,2,130000.00,NULL,'2026-08-09 14:23:26','2026-08-09 14:23:26');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `order_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','processing','completed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` enum('bank_transfer','ewallet','qris','cod') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bank_transfer',
  `payment_status` enum('unpaid','paid','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_type` enum('pickup','delivery') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'delivery',
  `delivery_fee` decimal(12,2) NOT NULL DEFAULT '0.00',
  `subtotal` decimal(12,2) NOT NULL,
  `tax` decimal(12,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `currency` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IDR',
  `scheduled_date` date DEFAULT NULL,
  `scheduled_time_slot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_status_created_at_index` (`status`,`created_at`),
  KEY `orders_order_number_index` (`order_number`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,'STR-260809-0001','processing','cod','unpaid','Budi Santoso','budi@example.com','08123456789','Jl. Melati No.5, Jakarta Selatan','delivery',15000.00,130000.00,0.00,0.00,145000.00,'IDR','2026-08-10','13.00-16.00','Kirim pagi hari','2026-08-09 14:23:26','2026-08-09 14:50:48');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery` json DEFAULT NULL,
  `unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pcs',
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(12,2) NOT NULL,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `is_sale` tinyint(1) NOT NULL DEFAULT '0',
  `badge` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Brownie Kukus Coklat','brownie-kukus-coklat','BK001','https://picsum.photos/seed/brownie/600/600','[\"https://picsum.photos/seed/brownie-1/600/600\", \"https://picsum.photos/seed/brownie-2/600/600\"]','pcs',28,75000.00,65000.00,1,'best',1,1,0,'Brownie kukus lembut dengan tekstur empuk dan coklat yang kaya.','{\"weight\": \"450 g\", \"calories\": \"380 kkcal\", \"servings\": \"8\", \"dimensions\": \"18x18x5 cm\"}','2026-08-09 12:58:46','2026-08-09 14:23:26'),(2,1,'Kue Lapis Legit','kue-lapis-legit','BK002','https://picsum.photos/seed/lapis/600/600','[\"https://picsum.photos/seed/lapis-1/600/600\"]','pcs',20,95000.00,85000.00,1,'best',1,1,0,'Kue lapis legit klasik dengan lapisan telur yang kecoklatan.','{\"weight\": \"550 g\", \"calories\": \"420 kkcal\", \"servings\": \"10\", \"dimensions\": \"20x20x6 cm\"}','2026-08-09 12:58:46','2026-08-09 12:58:46'),(3,1,'Kue Kering Kacang Rolade','kue-kering-kacang-rolade','KK001','https://picsum.photos/seed/rolade/600/600','[]','pcs',50,45000.00,NULL,0,'new',1,1,0,'Kue kering kacang dengan tekstur renyah, cocok untuk oleh-oleh.','{\"weight\": \"100 g (5 pcs)\", \"calories\": \"120 kkcal\", \"servings\": \"1\", \"dimensions\": \"-\"}','2026-08-09 12:58:46','2026-08-09 12:58:46'),(4,1,'Kue Birthday Karakter','kue-birthday-karakter','KK002','https://picsum.photos/seed/birthday/600/600','[]','pcs',8,350000.00,NULL,0,'sale',1,1,0,'Kue ulang tahun custom karakter, cocok untuk si kecil.','{\"weight\": \"1500 g\", \"calories\": \"500 kkcal\", \"servings\": \"15\", \"dimensions\": \"30x30x12 cm\"}','2026-08-09 12:58:46','2026-08-09 12:58:46'),(5,1,'Lemper Ayam','lemper-ayam','KS001','https://picsum.photos/seed/lemper/600/600','[]','pcs',40,12000.00,NULL,0,'new',0,1,0,'Lemper isi ayam kecap pedas, kulitnya kenyal dan gurih.','{\"weight\": \"80 g\", \"calories\": \"220 kkcal\", \"servings\": \"1\", \"dimensions\": \"10x5x3 cm\"}','2026-08-09 12:58:46','2026-08-09 12:58:46'),(6,1,'Kue Kering Coklat Chip','kue-kering-coklat-chip','KK003','https://picsum.photos/seed/chip/600/600','[]','pcs',35,55000.00,NULL,0,'best',0,1,0,'Cookie coklat chip dengan tepung komplek.','{\"weight\": \"120 g (4 pcs)\", \"calories\": \"180 kkcal\", \"servings\": \"1\", \"dimensions\": \"-\"}','2026-08-09 12:58:46','2026-08-09 12:58:46'),(7,1,'Kue Lapis Surabaya','kue-lapis-surabaya-unylv','KLS-001','products/placeholder.png','[]','box',20,175000.00,NULL,0,'best',1,1,0,'Kue lapis premium','{\"weight\": \"1 kg\", \"calories\": \"350\", \"servings\": \"8\", \"seo_title\": \"Kue Lapis Surabaya Star Cake\", \"dimensions\": \"22cm\", \"seo_description\": \"Lapis premium\"}','2026-08-09 14:49:49','2026-08-09 14:49:49');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `rating` tinyint unsigned NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,2,5,'Enak banget, lembut dan manis pas!',1,'2026-08-09 14:55:40','2026-08-09 14:58:21');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0iuT8MIo0D9DXLfyI1qTNwd496GVWDXPsGeP0aqF',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidHhXVFppbTFOa1lmVnJ0bURzQWM3SDQxTHdGMUZkdmhIMDc4dmZnMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786286136),('1cgTIXAHXG2nuOndpDq2KOZ3hjs0haLUzuPkFIHv',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTJENk5lSERjN1VuU1dDSVRQTWJ1NnhEZmdhVHp4WWNKWmVxRzVCSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786285876),('2PvZrg8XGm8sOTWQVNGuSaoTmHtf4ynC8L2wlyAo',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUxScGQ4STBnYjBxUGZvR203dmVFbVo4YkhEN3hUQTFzYUFXT0g1UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786285849),('2VQpzJLUyewYy1R90nnHmDxEmxE3SCLLDiJbQyTp',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidWFLSHhzem1wSEdyWjcyVDRid2M3V3Q2OXZTZ0ZxbjRVbXB3S2lKbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZXJhbmphbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786286138),('3LUJPQjsy7TAIb77BroRrsaOCQWL0iWIO1VENJdu',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV296MTY5SFdqdkhTV2VsMDZHS3luOUc5NEd6dEh3QXNBa1JCUzRNcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282639),('5FWHJ2it2KDEjNakSDqRmS0mFXwtpKNZCAInbcFC',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUlAyQ05PeXdMa295YVpwU3Z3ZXNGTnJLVGZjekZKaDVMc24zemh6ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1786284387),('6GOnUYJtKpQbj6KyDSK9djHriIO5Cd8raXfayAt4',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXVCT0NqY3UycW9ZOVo0a0xFUUNhV1lOdXVYRFA2cXY1SWZRRkxFaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786285849),('6iHjPkDH4QM6oQblT0wYkYcGyQrDQEhJtNjrFoZa',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiRk9USndsbFJsMzBmV3RiWXVHNFk1dElTZXNLWjZnbGlrZzltbEpGRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcC9rdWUtbGFwaXMtc3VyYWJheWEtdW55bHYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786287020),('7s3VtrKL8ThH6USWJCeKUAFsNldQeJZ7AwnZBkgU',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiV3hzMEZPd21CdHVLUTVkTUdIOVZJNmJLTmZIOWVLWUE1MEY4VEluUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786285850),('83Tw3KIJsefyG07t6F8IAL8rmgbDZ0kYRJ7bwyNs',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoicnMyanNBQ1hjU0dBSXpXZWZobVpsaU4wYXZ3eG1Fcms1Y3ZySjRjSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsva3VlLWxhcGlzLXN1cmFiYXlhLXVueWx2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786287020),('aXI8tHbjxzro23jsAUXxKYcOE84bYjv5kNamoSQq',2,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUUpBSDZxenBvOG5sY0VuTndyOWc0ZWRIcU8zd1BXaEVtZjJ1RzBadyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsvYnJvd25pZS1rdWt1cy1jb2tsYXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6Nzoic3VjY2VzcyI7czo1NjoiVGVyaW1hIGthc2loISBSZXZpZXcgQW5kYSBha2FuIGRpdGluamF1IHRlcmxlYmloIGRhaHVsdS4iO30=',1786287340),('BhjXQF4XkZzoNjxBnEEn5ShedSG0NqAheFAPdoLv',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGZ6ekh1UXRhSHUzbkprN1FDQ1Q4MDdpQkJLUlp6bGFsNnR1UEhySCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcC9icm93bmllLWt1a3VzLWNva2xhdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786285850),('bjQsWQGICiRCyqTTzqBGjje19wulWWUrj4Nkw9ya',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibFA4RFdQeGw5cmp6TDRYVTJzYkFaVXRqM1lKMmJyQ0oybERoYUtrTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rb250YWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786283306),('bqQbADa70xoHD9CCOeMMcUOBf3aXYZYuCCbbpCmT',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmZpOFdTTWtIRks5ZEp3ZnNjcVpPcFBJc2JFNzh5NjZUQmdxUXlSQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rb250YWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786287353),('c0qg71tPFzXdMR2BL6MDWVlv6fIleLp8kbGyt4DB',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidG5rbTg5ZjdacXFlb0RKMjM2YzVSOFRkWFdHTVBFZHhtVzJJTlN3cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786285061),('cGUUcGr6tErZaFN6OLa6pruZjhyTAytXRp4UoJ8Y',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVFzSVpxcVBlQWJrYlphakk3N0J6eWJqaDB2WXZ5Q1hpYnNtSXFNaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283330),('cZTaUhW3lbCKeNp5ScbICiIpGfOmMozNkzTVynC7',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibXdFM0p3N0pvTlNMZkRlZjgwc2RZMDJRbzMxMkdERE9HeXpuWUtQSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283031),('DDpuRNHnOPQ7WdXKrRyemRcRDADxsLojThApaFWi',1,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVm9od2w0UUF6RVJiV1M0bmtRbU14bVBnTzBWNEs5dFFzZzNoaGQ2cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1786287061),('dXkL5qK9DKxO0hAP9B4fUrksfFnkmX4nk9kirBIm',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2FHOWI0VmJTMUs5cEtKQ0pMRHcyZWx6RzdjRTJNdUFNYjRaekthcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFja2luZz9vcmRlcl9udW1iZXI9U1RSLTI2MDgwOS0wMDAxIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786285459),('f2ULFXu3b8cWKOHZaJt6VnFsai6zrejtU05m65Pp',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEMwTXY3Sm9TSGRsazU2dWFCcWQ0SzBNYk53QTJwTGVzVGhWbU5zaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786286137),('fC5CQQ7pBV03Yrk1Jkkx7aFmsg8gpg7BopRgL73z',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjVIMThDVXNCaTJUNkZBcWs3VkhXeG85NkZ6cHQyT1pxbzRSWHJybCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786282669),('hTWf1Mi6idssGyM7nj064j5sRzb73PyIOC4jhnWq',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVHNXdDlMN0RzUTZTOGZXZ0liWnhXeWlCNktpTFQ1ZVJua0I0SXByaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZW50YW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786282668),('IcMjY35htjrGvRkrMzAil6fCJkOFx86dYSMxycX4',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzNBU0U4bkhTYlZzbWlIVXpvdmxHR09FdGljb1F4UEJhWWt4RHdJSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90ZW50YW5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786283305),('ixIMP9Ke6J6c39r1BW3ntVeTQkvEoTkH0rwzaVGj',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYmNUUWY3Rms1N1BDeFZSdVdSNkg0TTJVaUZ6VjlhMzFUb2R1cnNYTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786282982),('Jgu7SZHDuzJaKwAGayObEaDHZgPPECUe6rd9v93G',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNEhiOHpMTDZjNEVVTXFabVVFN3c1Qnl0OGVvNHlJT2RvaDJ4TWtjUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283838),('JMF8ffmt52SBShOMPrpQ2wNVKhcg4p5dP9SMIwC2',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieEJVaHc0WDVNZDc0NkJLdVhiV2Zoc0FEYlY1TFgyT2R2OENWSTVDTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC90cmFja2luZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282982),('JWxN5kD0GAbVqF5Awl26GZ15KWJ4HvqlV6JEtHh6',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ09FVmgzbXBIbE5td1o0Z0M0aWZ5TFFFQWNQNjYzdm5NcDgxenJ0QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786283274),('K8EBqF8PAhWALkJjT47DZXP2hu4JFmgEiARKvAmx',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWmRvbGo0cTh4VWY5aHdBaE9Qd3FFaDVlYVEwOHdIMGd6VE95M1lGNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282384),('kqs40GNMN2PHQdlfDSsIKT5h89L7g1emT1QV1PKg',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEc4VkhMaHZhWU5TSmgxcnBlVlQ1bnIzNGhHQ0xxdXJlZGJyR1k5RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51P3NlYXJjaD1icm93bmllIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786286005),('l1F7Dk8BfQjn7AvVdPqbF2KG7QF5Mz4QOCuAfyHP',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVp5cFZPVEt1cktHbTI4TDdPeWZPOHJ3UTh4NEp6bVMzUlhSb0pjRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRlZ29yaS9rdWUtYmFzYWgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786286004),('L1LhH68yOYjORdQ9e14zisDRwEtSi8wsOAMZBaDg',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFM2dnAzQldra3c5MHc0bUw1enVLRG16WFFIQjVxRk1Iek9Xak4zciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsvYnJvd25pZS1rdWt1cy1jb2tsYXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786287501),('L5WE08KKdMLJCb9J2qkvbF7Q1mJchDResx1FJNLE',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoic0gzenBEMGZHS1NFdFJYVWh1UlZtTDhtN1h4am5mWWlVN0xSeXlSSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283272),('L9GcODken5dAJ8aaMycnCf5FkRmXCBGYmXz8RdfI',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1VnaEVQWnhKVHNlRm9FbFR0bHVubmF1dDE3SDVkRHk4d3dOVk5YaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282591),('Li4GaLxknRjyGYWWL161TmUQA94UyoGnWCqT6nlU',NULL,'127.0.0.1','curl/8.21.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoieUZheFNMcVFlMWRkTkNyd3NlOUd0a3NFaEVWZnBnNmE3OVZIMFIyZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXZpZXdzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MTp7aTowO3M6Nzoic3VjY2VzcyI7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czoxOToiVWxhc2FuIGRpdGFtcGlsa2FuLiI7fQ==',1786287501),('MiMogeVwG9rGCzGYYMUuqlQ4NvbdwnJJwCv9Y9DO',NULL,'127.0.0.1','curl/8.21.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWV5RTRvNlZ5dFRKcWJaQ2dMM0ZGTWpVeEpKcmRDejV0UEZHdlhhNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rb250YWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjc6InN1Y2Nlc3MiO3M6NTU6IlBlc2FuIEFuZGEgdGVya2lyaW0hIEthbWkgYWthbiBtZW5naHVidW5naSBBbmRhIHNlZ2VyYS4iO30=',1786287362),('MJ6Syz7WDTKdiSfatnSLC50KEjF0J5gtAcQ4TyMq',NULL,'127.0.0.1','curl/8.21.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoibENLRjBEeUtOTm9aQjc4dHh5MldXMHdDTTMweTM4UlFhTlJxZmc1YSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786287353),('Mp1FIdlaXJvlAxkgtBc1fwKtaRSr4hEHUi8UxMh7',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ09YTDd1UXBUbWMxcGJKNmxIZWlrZWRQWmJrRTI1SkVGR2VXYnVRbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786286138),('NAOjH1x0MTWNc7cXDvEoo3yNHZ5KBKdluAZxDf8Y',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQktCamhGQUFXSjFnb0pMZUpvejhDSVhzejNsdVFxaWdTWVVHblFnSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZXJhbmphbmcvanVtbGFoIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786283306),('Nza9lNQGdT0fVZpyWjvQ2RkfkIuLNvdCETC8Bwh0',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGJ0N0NBSHNMbEVMUERTMmRORmRZeTFsRFAwTWtSRVJWZUF3bXYxRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282987),('p3ZdD4zJN1I0VR9M1ozPXJSU1G8nbPV497SRgJlz',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXdGU2RTZDJ3THk1ODZuY2RHVjFOb25wU0JIeGFmc2VIaEY5VDlOVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZXJhbmphbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786282670),('PamYIbjRurpIA5t8rQDecwpYs4bhWPp07X0QFTS1',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTgwMGh1SUhtellVOE5FRWtJUndiQjg3bWVlUGd4NXFkS0RSN3dEVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283017),('qQOT8sDET5tsc4dpXDgy6zDfvATfRatBwsYtWTGV',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZnpYU3ZRcHd3T0xFb3poSnI3N1RWZTltdnRlWjZUb1dNVUI3eTRTcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282669),('QrbAVh5hblWmUdZgxgOLfTlKB82ynoLuL9pCsHQN',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoibVVDQ1NFRTFvTmJoNm9EeW51VFZvcWpJOHRtY2RmN2hlbHhtNUZ6TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282446),('R2wMrLdf375i3dRhTjEJy9mZlaCRCnAWyH1n0gv6',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMDFDQ09ScjhPaFJJMkRocTM5dElhdVBwRE5KNWhoRXp6Y3VBam41TSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rb250YWsiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786282667),('rQbsEDbPYhOtoC4K9IIxAAUAVubaUQ0YQsF13xFJ',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjlmdHpJQkRHTFFCdDdYZzlvRjFhV2h5NEhkb3lGT0taTWg2SU9UWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282666),('rZJLMI9NgKGxymMolx7ybZmmGxCr2VnfEiX7l5DG',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmg3V1BOdVlLdDQxb05RN1FadFN5WUdMR2N0eTcxT1BYSGhONmFUSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282983),('S5mSUD1tYsKJxWyUN9raVM6m7lAv5HM00Tn4h6CD',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ0t1Q1ZDcW5yWDBaUFJBN2E2dW5HVWtDR2YwdXpUM0lyS2I3OXFzMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51P2NhdGVnb3J5PWt1ZS1iYXNhaCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786286004),('sQwLBFQVRaxf5N4CZfAg2bxS003JrDo1e9Ntrf8K',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidzBvZXI5UnIwWkhGZ3RPYko2bkttUVlKOU1HWkw1MVUwMnJqbWlXbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsvYnJvd25pZS1rdWt1cy1jb2tsYXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786287485),('Tpug7U8SWwt6alxbMFSbIjaBR7RCcgr6bayTsl9L',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUJLUXRFWmduZ1o1VTN3Y0J5ZjhXNThCWWhJZUZrV01BUkp2ZEV4WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786286138),('TRTGSuqgdj6u0wavJnKtcTZ1bYBwgJoMRZrzOpNj',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoieVRQMVo2d3U3djc2a0Y3M29VUjR5OVdXSlhxaVp4cnpZUEt3N3hDOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsvYnJvd25pZS1rdWt1cy1jb2tsYXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786283304),('TuTztptsLRKi2mE8YtvrRKAe3BD0TpMVbiM8bfBn',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidWJUWDRKcENPYnF2aGFrUmFzbGZhenVTdXRoRXNhb1FIQnk1S05yZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282671),('uIDBPwWZFWCBBFMECMSP28OtAIGiYWeLCzOuX6AR',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWdkMk9oUHdvUlZtaUpnWkhJY1NRejZYd2ZLczQzc3N6c2dvZVdFQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWsva3VlLWxhcGlzLXN1cmFiYXlhLXVueWx2Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786287020),('UNyxWi3HodJCRrOcCGWMZX7lnMsdzlphJzzWxXy0',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzdOZldORmRiUXpuMThQa2tueWtCeDBRclNzZDN2MjBaWVgwOVIzWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282984),('uodXkvqrxk0dt4adLy4qwQSvTTKTO8ivVvfQAIRq',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMzdZNGVsdG83akFmMlhtcmttZTJvTEdZVUw2blU5bDdoVGxVUzNUaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jaGVja291dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283306),('W5TklKBFOp0GUJdsVLyKAtPhrVORezIxZ0FrhzC6',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoidFU0U0l0eDBOUlhBTkhIc0ZRaEhCRnNGRVBWOEFLRUZIZU5qMEhsWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXNlcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283304),('WdnS3IpbfbLlLUqhBYgqx4MUdqOLCgt71W7pnuxk',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWRSZEI3bmdUZmN4U2NMSnBDS1FwN05zd09hdGFZY0l3cktralRCTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283272),('whwMpCz5CecVy80sQZHIJUeA7bsc8GXSaCt3Efpx',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiODFkY2pubEU0M0pQMDg5UUlweWphb01NQm5QN0RXWTIzT3dDVGo0RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXRlZ29yaS9rdWUtYmFzYWgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1786285876),('XgH1MW5BIPwWfPUWMnkNkBhlWJhubrfpgWUZMJ3o',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzY5dmpNQ251c1Fab0J0bGNMM0kydG9pTkhJSmV2ZGNTVmkxWnZFMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786283017),('z7eSoym6Z3VnBk93Ck67I66q1GPsqWQjamXN4tXw',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWsyMnlZUDI1SXkyRnJWVjJaQlRyR0I3T0poaXcyRDJOUXpVR1lwTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282256),('zIN7XulnQs4MfrAllyCLy7YebWYWfa2tke2sJg1G',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmlxdEFyQzZPTTdHQnZvdjBZSTU4QlF5YzFxY1Y5d3l6a0FpM0pmUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786283770),('ZmuWGYOC70KmdXw82iiP4cHcnIxm1Xq5VfGBxCJZ',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjA2dWtINmw1ZUVNN05uajZXUjFMSmNrNDk2dWxiNW51RTJIY0dBSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786286137),('ZQU0EKIVcxuS92mFADOwxd30q1QpuhYYYpU5TruT',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNzRkZENMa1JlOFdvbjVmSFpyT2k3V1lrSTFxbHpKNDV4aENWejNlYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZW51Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1786283302),('ZUo0YsAWIMZR4LfIswQ9BmK3krQ9OnTo2pz5obk9',NULL,'127.0.0.1','curl/8.21.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiMmxWNUJFT0NnZzRIQW5yNDBlanZJTW4wdXFPWWlEcThCWGd4WUxPYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1786282378);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site','site_name','Star Cake','text','Nama Situs'),(2,'general','site_tagline','Kue Enak Hati Senang','text','Tagline'),(3,'site','site_logo','images/logo.png','image','Logo'),(4,'site','favicon','images/logo.png','image','Favicon'),(5,'contact','phone','0812-3456-7890','text','No. Telepon'),(6,'contact','whatsapp_number','6281234567890','text','Nomor WhatsApp'),(7,'contact','email','order@starcake.com','text','Email'),(8,'contact','address','Jl. Kue Indah No. 1, Jakarta 10340','textarea','Alamat'),(9,'contact','operating_hours','SeninΓÇôMinggu, 08.00 ΓÇô 20.00','text','Jam Operasional'),(10,'social','instagram_url','https://instagram.com/starcake','text','Instagram'),(11,'social','facebook_url','https://facebook.com/starcake','text','Facebook'),(12,'delivery','free_delivery_min','150000','number','Minimum Gratis Ongkir'),(13,'delivery','delivery_fee','15000','number','Biaya Ongkir'),(14,'general','site_whatsapp','0812345678','text',NULL),(15,'delivery','tax_rate','0','number','Pajak (%)');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Siti Aminah','siti@example.com',NULL,NULL,NULL,NULL,'$2y$12$VFDnjeuzR24UgbOzr7pnD.fvT/DCOrkvYFa/R6696D4AFZ6GhUYBe',NULL,'2026-08-09 14:51:01','2026-08-09 14:51:01'),(2,'Dewi Lestari Sari','dewi@example.com',NULL,'081299887766','Jl. Anggrek No.12, Jakarta Timur',NULL,'$2y$12$XZBNV5b4oLV92uDqVXZpzesbBnuhUD7xFTWSOnhwqBgMvf/dar//a',NULL,'2026-08-09 14:52:14','2026-08-09 14:53:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-09 22:35:35
