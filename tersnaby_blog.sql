-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2014 at 05:11 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
`comment_id` int(11) unsigned NOT NULL,
  `comment_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned DEFAULT '0',
  `user_mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'guest',
  `post_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_content`, `comment_date`, `user_id`, `user_mail`, `user_name`, `post_id`) VALUES
(15, 'test', '2014-08-26 18:04:07', 0, '', 'guest', 40),
(16, 'breh', '2014-08-26 18:04:45', 0, 'franz_dimitrov@hotmail.com', 'guest', 40),
(17, 'ythgaskjdhkasjhdkasjhdksajhds', '2014-08-26 18:06:12', 0, 'prince_of_persia@abv.bg', 'DND17', 40);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) unsigned NOT NULL,
  `post_count` int(10) NOT NULL DEFAULT '0',
  `post_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_desc` text COLLATE utf8_unicode_ci,
  `post_cont` text COLLATE utf8_unicode_ci,
  `post_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `post_tags` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_count`, `post_title`, `post_desc`, `post_cont`, `post_date`, `user_id`, `post_tags`) VALUES
(35, 0, 'kljhkhkj', 'khlfkgjlgkggkgk', 'lkjflkgjlgkj', '2014-08-26 13:18:48', 0, ' 12 13'),
(36, 1, 'hdfzhzf', 'zdvhzhhh', 'dfhnvdnv', '2014-08-26 13:19:01', 0, ' 13 12 14'),
(37, 0, 'dwaa', 'dawawd', 'dawdawawa', '2014-08-26 13:47:30', 0, ' 1 2 3'),
(38, 0, 'dawdwada', 'dawdwaw', 'dawdawwd', '2014-08-26 13:47:41', 0, ' 3 2 1'),
(39, 0, 'a dano', 'lhlklk', 'kjlkdjfkdf', '2014-08-26 15:23:38', 0, ' 1 2 test2'),
(40, 0, 'hhhhh', 'lllll', 'khjhjhjh', '2014-08-26 15:24:42', 0, ' test1 test2 3 4 5');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`tag_id` int(11) unsigned NOT NULL,
  `tag_count` int(11) unsigned NOT NULL DEFAULT '1',
  `tag_title` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=116 ;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_count`, `tag_title`) VALUES
(97, 2, '12'),
(98, 2, '13'),
(101, 1, '14'),
(102, 3, '1'),
(103, 3, '2'),
(104, 3, '3'),
(110, 2, 'test2'),
(111, 1, 'test1'),
(114, 1, '4'),
(115, 1, '5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(11) unsigned NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_mail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_pass` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_rights` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_mail`, `user_pass`, `user_rights`) VALUES
(0, 'guest', NULL, NULL, NULL),
(1, 'Mitko', 'mitko@abv.bg', '123456', 'admin'),
(2, 'DND17', 'prince_of_persia@abv.bg', '$2a$12$HnuV.tlkfbde7m.23SkeM.h9BOQgWsRyuVfIEUpeGhTHYC9NEOChy', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
 ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`tag_id`), ADD UNIQUE KEY `tag_title` (`tag_title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
MODIFY `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `tag_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
