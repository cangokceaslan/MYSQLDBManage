-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 24 Haz 2019, 08:27:09
-- Sunucu sürümü: 5.7.21
-- PHP Sürümü: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Veritabanı: `example`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `images`
--

CREATE TABLE `images` (
  `id` int(30) NOT NULL,
  `product_id` int(20) NOT NULL,
  `image` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `images`
--

INSERT INTO `images` (`id`, `product_id`, `image`) VALUES
(1, 1, 'https://cangokceaslan.com/'),
(2, 1, 'https://cangokceaslan.com/cangokceaslan');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `person`
--

CREATE TABLE `person` (
  `id` int(20) NOT NULL,
  `name` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `surname` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `number` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `person`
--

INSERT INTO `person` (`id`, `name`, `surname`, `number`, `date`) VALUES
(1, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(2, 'Cancan', 'Gokceaslan', '05230000000', '2019-06-29'),
(3, 'Can', 'Gokceaslan', '05442342523', '2019-10-11'),
(5, 'Can', 'Gokceaslan', '05230000000', '2019-06-29'),
(6, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(7, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(8, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(9, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(10, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(21, 'Can', 'Gokceaslan', '05444850586', '2019-09-12'),
(120, 'Can', 'Gokceaslan', '05444850586', '2019-09-12');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `price` int(30) NOT NULL,
  `image` text COLLATE utf8_turkish_ci NOT NULL,
  `description` text COLLATE utf8_turkish_ci NOT NULL,
  `stock` int(6) NOT NULL,
  `color` varchar(15) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `stock`, `color`) VALUES
(1, 'Basketball Ball', 100, 'https://www.spalding.com/dw/image/v2/ABAH_PRD/on/demandware.static/-/Sites-masterCatalog_SPALDING/default/dwe4dbdbfc/images/hi-res/74876E_FRONT.jpg', 'Very Good Basketball', 20, 'orange'),
(2, 'Tenis Ball', 20, 'https://5.imimg.com/data5/IG/NB/MY-42435728/tennis-ball-500x500.jpg', 'Very Good Tennis Ball', 30, 'green');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `id` (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `images`
--
ALTER TABLE `images`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `person`
--
ALTER TABLE `person`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
