-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 25, 2017 at 06:33 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mvc`
--
CREATE DATABASE IF NOT EXISTS `mvc` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mvc`;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
`id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `tasks` text,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `email`, `tasks`, `image`, `status`) VALUES
(2, 'TEST #5', 'some@email.com', 'detail hello i am test', 'SUftuu4ud7PC0Zd8Ss59LIRaa65Cvy0n.jpg', 0),
(3, 'Zarif', 'zarif@gmail.com', 'Khulna, Bangladesh', 'm7HskmBuyrHIDvhePnfnp0Xmt14G9nnv.jpg', 0),
(5, 'Tanvir', 'tanvir@bibsun.com', 'Dhaka, Bangladesh', NULL, 0),
(7, 'MAK JOY', 'mak@joy.com', 'Dhaka, Bangladesh', 'CZaCtO5rnVZVm6RQGhZz5vFzQWik2sFF.jpg', 0),
(8, 'Erkin', 'erkin@mail.com', 'terreyyu ertyetey', NULL, 0),
(16, 'TEST #1', 'test@mail.com', '22333', 'WtsRAzeB0J2koTaA8SfWhiCIorfVsoso.jpg', 0),
(17, 'TEST #2', 'est@mail.com', 'www sssdffd fff ', 'vehdp2Ue3GeHbifjTuagqWYzmJu1GA2b.jpg', 1),
(19, 'eqreq', 'qef', 'eqfqe', 'Q9dDD2YJgYVlzWjIExCUTNYO2c7PwKfm.jpg', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
 ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;