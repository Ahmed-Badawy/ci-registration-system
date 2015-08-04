-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2015 at 09:37 PM
-- Server version: 5.6.20-log
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `courtaks_ci-regsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `created_at` varchar(255) NOT NULL,
  `updated_at` varchar(255) DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `last_seen` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_locked` tinyint(4) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `created_at`, `updated_at`, `last_login`, `last_seen`, `is_admin`, `is_confirmed`, `is_deleted`, `is_locked`) VALUES
(8, 'ahmed2', 'courtaks2@yahoo.com', '$2y$10$xcRNxBkEe4LRC.g94y6Tf.BN1h06be9FtZBHOezIfs.ZbzIIGNNIi', 'default.jpg', '2015-08-4 20:54:00', '2015-08-4 20:54:00', '2015-08-4 21:12:55', '2015-08-4 21:12:55', 0, 1, 0, 0),
(9, 'ahmed3', 'courtaks3@yahoo.com', '$2y$10$5yKjoM5sZTyMB53eb621zOa/a3Tomi2wfVswxtSzM2jH3YUHioZfq', 'default.jpg', '2015-08-4 21:13:24', '2015-08-4 21:13:24', '2015-08-4 21:14:10', '2015-08-4 21:14:10', 0, 1, 0, 0),
(10, 'ahmedbadawy2', 'courtaks33@yahoo.com', '$2y$10$20MLCxYr7ayjDLHldpFZTu4nDNG.7HbkykBIo6YdNBevVqrGIOt5e', 'default.jpg', '2015-08-4 21:15:15', '2015-08-4 21:15:15', NULL, NULL, 0, 0, 0, 0),
(11, 'ahmedbadawy23', 'courtaks333@yahoo.com', '$2y$10$154gf6hBxPJxPvN8qK0ikeBNktTQzzm.v2S.7qIR9AYL0XS3Nv9xS', 'default.jpg', '2015-08-4 21:15:41', '2015-08-4 21:15:41', NULL, NULL, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
