-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.20-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Exportiere Struktur von Tabelle shop.cart
DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned DEFAULT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id_user_id` (`product_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle shop.cart: ~2 rows (ungefähr)
DELETE FROM `cart`;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created`) VALUES
	(1, 1, 1, 1, '2020-04-26 14:14:18'),
	(2, 1, 2, 1, '2020-04-26 14:14:20');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle shop.delivery_adresses
DROP TABLE IF EXISTS `delivery_adresses`;
CREATE TABLE IF NOT EXISTS `delivery_adresses` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `recipient` text NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `streetNumber` varchar(50) NOT NULL,
  `zipCode` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_delivery_addresses` (`user_id`),
  CONSTRAINT `FK_user_delivery_addresses` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle shop.delivery_adresses: ~0 rows (ungefähr)
DELETE FROM `delivery_adresses`;
/*!40000 ALTER TABLE `delivery_adresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_adresses` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle shop.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle shop.products: ~4 rows (ungefähr)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `title`, `description`, `price`) VALUES
	(1, 'Produkt 1', 'Tolles Produkt', 166),
	(2, 'Produkt 2', 'Anderes Produkt', 1337),
	(3, 'Produkt 3', 'Noch mehr Produkte', 42),
	(4, 'Produkt 4', 'Alle guten Dinge sind 4', 2020);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Exportiere Struktur von Tabelle shop.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL DEFAULT '0',
  `password` varchar(191) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Exportiere Daten aus Tabelle shop.user: ~1 rows (ungefähr)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`) VALUES
	(1, 'test', '$2y$10$/wFthkyVlBK4fkrCoggdQuHdqLDZrlBRglk2g898Lw/ggrHdJDxwa');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
