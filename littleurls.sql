-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 18, 2018 at 11:34 AM
-- Server version: 5.6.38
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `littleurl`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('admin', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `mapped_urls`
--

CREATE TABLE `mapped_urls` (
  `id` int(11) NOT NULL,
  `longurl` text NOT NULL,
  `shorturl` text NOT NULL,
  `customized_word` text NOT NULL,
  `date_created` date NOT NULL,
  `clicks` int(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mapped_urls`
--

INSERT INTO `mapped_urls` (`id`, `longurl`, `shorturl`, `customized_word`, `date_created`, `clicks`) VALUES
(6, 'https://docs.google.com/forms/d/e/1FAIpQLScHevqkDQeorRZ-8geJy6IpEtigr8gjrLncL8fydrHFQcLX0g/viewform?usp=sf_link', 'http://localhost:8080/littleurl/index.php/akhil', 'akhil', '2018-11-17', 0),
(15, 'teammeraki.org', 'http://localhost:8080/littleurl/index.php/teammeraki', 'teammeraki', '2018-11-17', 0),
(20, 'www.yahoo.com', 'http://localhost:8080/littleurl/index.php/yahoo', 'yahoo', '2018-11-17', 0),
(21, 'www.google.com', 'http://localhost:8080/littleurl/index.php/google', 'google', '2018-11-17', 0),
(26, 'www.facebook.com', 'http://localhost:8080/littleurl/index.php/fb', 'fb', '2018-11-17', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mapped_urls`
--
ALTER TABLE `mapped_urls`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mapped_urls`
--
ALTER TABLE `mapped_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
