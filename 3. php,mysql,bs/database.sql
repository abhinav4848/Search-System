-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2020 at 04:58 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `searchdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `searcher_engines`
--

CREATE TABLE `searcher_engines` (
  `id` int(11) NOT NULL,
  `site name` text NOT NULL,
  `identifier` varchar(30) NOT NULL,
  `hidden` tinyint(1) NOT NULL DEFAULT 0,
  `old-identifier` varchar(30) NOT NULL,
  `url-prefix` text NOT NULL,
  `url-suffix` text NOT NULL,
  `baseurl` text DEFAULT NULL,
  `nsfw` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `searcher_searches`
--

CREATE TABLE `searcher_searches` (
  `id` int(11) NOT NULL,
  `searchTerm` text NOT NULL,
  `engine` text NOT NULL,
  `datetime` datetime NOT NULL,
  `searcher` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `searcher_engines`
--
ALTER TABLE `searcher_engines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `searcher_searches`
--
ALTER TABLE `searcher_searches`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `searcher_engines`
--
ALTER TABLE `searcher_engines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `searcher_searches`
--
ALTER TABLE `searcher_searches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
