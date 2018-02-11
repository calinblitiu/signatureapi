-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 10, 2018 at 09:23 PM
-- Server version: 5.6.38
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinarko_signature`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company_profile`
--

CREATE TABLE `tbl_company_profile` (
  `com_id` int(11) NOT NULL,
  `com_name` varchar(50) NOT NULL,
  `third_login_url` varchar(1024) NOT NULL,
  `third_account_id` varchar(50) NOT NULL,
  `third_login_email` varchar(50) NOT NULL,
  `third_login_password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_signature`
--

CREATE TABLE `tbl_signature` (
  `sig_id` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `image_url` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `login_email` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `type` enum('admin','driver') DEFAULT NULL,
  `company_profile_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_company_profile`
--
ALTER TABLE `tbl_company_profile`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `tbl_signature`
--
ALTER TABLE `tbl_signature`
  ADD PRIMARY KEY (`sig_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_company_profile`
--
ALTER TABLE `tbl_company_profile`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_signature`
--
ALTER TABLE `tbl_signature`
  MODIFY `sig_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
