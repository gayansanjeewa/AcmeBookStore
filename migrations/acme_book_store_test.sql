-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A33112469DE2` (`category_id`),
  CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `book` (`id`, `category_id`, `name`, `author`, `price`, `uuid`) VALUES
(1,	1,	'Giraffes Can\'t Dance',	'Giles Andreae',	993,	'a67ec143-77f3-4744-a34d-08f87a2815eb'),
(2,	1,	'I Want My Hat Back',	'Jon Klassen',	841,	'7b127b63-91d3-4423-aa75-eb71050c60f9'),
(3,	1,	'Have You Filled A Bucket Today?',	'Carol McCloud',	1046,	'704b9972-4ee4-4f45-b84b-40580a736327'),
(4,	1,	'The Wonderful Things You Will Be',	'Emily Winfield Martin',	2051,	'b564d548-8419-4aa7-98f3-0106452cd4e5'),
(5,	1,	'Don\'t Let the Pigeon Drive the Bus!',	'Mo Willems',	886,	'e36c5b22-0836-4aa8-ad82-09664301a036'),
(6,	2,	'Harry Potter and the Philosopher\'s Stone',	'J. K. Rowling',	1052,	'c68430eb-577b-4525-844e-371516ec08b3'),
(7,	2,	'Sword of Destiny',	'Andrzej Sapkowski',	1027,	'36910ca3-d535-4772-9e52-2b9b1b681e00'),
(8,	2,	'Harry Potter and the Order of the Phoenix',	'J. K. Rowling',	2285,	'a0f3127a-9c0d-4211-b497-3b645863ed1f'),
(9,	2,	'Harry Potter and the Deathly Hallows',	'J. K. Rowling',	1364,	'44afafb8-5228-4a28-8b80-214a8b4b83d2');

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `category` (`id`, `name`, `uuid`) VALUES
(1,	'children',	'b753fe0b-8347-4057-a2d6-e76bf4f7c916'),
(2,	'fiction',	'6f996db6-e1fd-4037-84ec-d7824793eecd');

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200615183158',	'2020-06-16 09:16:33'),
('20200616090644',	'2020-06-16 09:16:34'),
('20200616093308',	'2020-06-16 09:33:40'),
('20200616093548',	'2020-06-16 09:36:06');

-- 2020-06-17 03:27:55