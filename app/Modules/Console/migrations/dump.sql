/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `auth_assignment` (
                                                    `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                                    `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                                    `created_at` int(11) DEFAULT NULL,
                                                    PRIMARY KEY (`item_name`,`user_id`),
                                                    CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES (1,3,1597410077);

CREATE TABLE IF NOT EXISTS `auth_item` (
                                              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                              `type` int(11) NOT NULL,
                                              `description` text COLLATE utf8_unicode_ci,
                                              `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
                                              `data` text COLLATE utf8_unicode_ci,
                                              `created_at` int(11) DEFAULT NULL,
                                              `updated_at` int(11) DEFAULT NULL,
                                              PRIMARY KEY (`name`),
                                              KEY `rule_name` (`rule_name`),
                                              KEY `idx-auth_item-type` (`type`),
                                              CONSTRAINT `cpa_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `auth_item` (`name`, `type`, `created_at`, `updated_at`) VALUES
(1,1,1598004861,1598004861),
(2,1,1598004861,1598004861)
;

CREATE TABLE IF NOT EXISTS `auth_item_child` (
                                                    `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                                    `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                                    PRIMARY KEY (`parent`,`child`),
                                                    KEY `child` (`child`),
                                                    CONSTRAINT `cpa_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
                                                    CONSTRAINT `cpa_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `auth_rule` (
                                              `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
                                              `data` text COLLATE utf8_unicode_ci,
                                              `created_at` int(11) DEFAULT NULL,
                                              `updated_at` int(11) DEFAULT NULL,
                                              PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;