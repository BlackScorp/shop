SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `delivery_adresses`;
CREATE TABLE `delivery_adresses` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `recipient` text NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `streetNumber` varchar(50) NOT NULL,
  `zipCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `orderDate` date NOT NULL DEFAULT '0000-00-00',
  `deliveryDate` date NOT NULL DEFAULT '0000-00-00',
  `status` enum('new','canceled','payed','sent','delivered') NOT NULL DEFAULT 'new',
  `userId` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `order_adresses`;
CREATE TABLE `order_adresses` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `recipient` mediumtext NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `streetNumber` varchar(50) NOT NULL,
  `zipCode` varchar(50) NOT NULL,
  `type` enum('both','delivery','invoice') DEFAULT 'both'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE `order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(50) NOT NULL DEFAULT '',
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `taxInPercent` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `orderId` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `slug` varchar(140) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `products` (`id`, `title`, `description`, `price`, `slug`) VALUES
(1, 'Produkt 1', 'Tolles Produkt', 166, 'produkt-1'),
(2, 'Produkt 2', 'Anderes Produkt', 1337, 'produkt-2'),
(3, 'Produkt 3', 'Noch mehr Produkte', 42, 'produkt-3'),
(4, 'Produkt 4', 'Alle guten Dinge sind 4', 2020, 'produkt-4');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(191) NOT NULL DEFAULT '0',
  `password` varchar(191) NOT NULL DEFAULT '0',
  `email` varchar(512) NOT NULL DEFAULT '0',
  `activationKey` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id_user_id` (`product_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `delivery_adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_delivery_addresses` (`user_id`);

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderDate` (`orderDate`),
  ADD KEY `status` (`status`),
  ADD KEY `userId` (`userId`);

ALTER TABLE `order_adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ORDER_ADRESS` (`order_id`),
  ADD KEY `type` (`type`);

ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ODERS_TO_ORDER_PRODUCTS` (`orderId`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `activationKey` (`username`,`activationKey`) USING BTREE;


ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `delivery_adresses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_adresses`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `delivery_adresses`
  ADD CONSTRAINT `FK_user_delivery_addresses` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `orders`
  ADD CONSTRAINT `FK_ORDER_TO_USER` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `order_adresses`
  ADD CONSTRAINT `FK_ORDER_ADRESS` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `order_products`
  ADD CONSTRAINT `FK_ODERS_TO_ORDER_PRODUCTS` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
