-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2014 at 01:59 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quickapps2`
--

-- --------------------------------------------------------

--
-- Table structure for table `field_data`
--

CREATE TABLE IF NOT EXISTS `field_data` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `field_instance_id` int(10) NOT NULL,
  `entity_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `entity` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `field_data`
--

INSERT INTO `field_data` (`id`, `field_instance_id`, `entity_id`, `entity`, `data`) VALUES
(1, 1, '1', 'nodes_article', 'Lorem ipsum dolor sit amet');

-- --------------------------------------------------------

--
-- Table structure for table `field_instances`
--

CREATE TABLE IF NOT EXISTS `field_instances` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Machine name, must be unique',
  `entity` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name of the entity to which this field belongs to. eg: comment, node_article. Must be unique',
  `plugin` varchar(80) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name of plugin handler',
  `label` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Human readble name, used in views. eg: `First Name` (for a textbox)',
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `settings` text COLLATE utf8_unicode_ci COMMENT 'Serialized information',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `entity` (`entity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `field_instances`
--

INSERT INTO `field_instances` (`id`, `slug`, `entity`, `plugin`, `label`, `description`, `required`, `settings`) VALUES
(1, 'article_introduction', 'nodes_article', 'FieldText', 'Introduction', 'Brief description', 0, NULL),
(3, 'article_body', 'nodes_article', 'FieldText', 'Body', 'Long version', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_type_id` int(11) NOT NULL,
  `node_type_slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` bigint(20) NOT NULL,
  `modified` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `node_type_id`, `node_type_slug`, `slug`, `title`, `status`, `created`, `modified`) VALUES
(1, 1, 'article', 'my-first-article', 'My First Article!', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `node_types`
--

CREATE TABLE IF NOT EXISTS `node_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'human-readable name',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `node_types`
--

INSERT INTO `node_types` (`id`, `slug`, `name`) VALUES
(1, 'article', 'Article');

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

CREATE TABLE IF NOT EXISTS `plugins` (
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `settings` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ordering` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`name`, `settings`, `status`, `ordering`) VALUES
('Field', '', 1, 0),
('Node', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `variables`
--

CREATE TABLE IF NOT EXISTS `variables` (
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
