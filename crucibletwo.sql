-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 15, 2013 at 03:34 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wellness`
--

-- --------------------------------------------------------

--
-- Table structure for table `crucibletwo`
--

CREATE TABLE IF NOT EXISTS `crucibletwo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Last Name` varchar(13) DEFAULT NULL,
  `First Name` varchar(9) DEFAULT NULL,
  `EID` int(5) DEFAULT NULL,
  `DOB` varchar(10) DEFAULT NULL,
  `DOH` varchar(10) DEFAULT NULL,
  `Department` varchar(28) DEFAULT NULL,
  `Job title` varchar(23) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `crucibletwo`
--

INSERT INTO `crucibletwo` (`id`, `Last Name`, `First Name`, `EID`, `DOB`, `DOH`, `Department`, `Job title`) VALUES
(1, 'Bosco', 'John', 10354, '9/5/1980', '12/12/2011', 'Finishing Mills Gen (200330)', 'UTILITY TECHNICIAN'),
(2, 'Brown-Johnson', 'Karen', 10097, '3/25/1964', '11/16/2009', 'Finishing Mills Gen (200310)', 'OPERATING TECHNICIAN 1'),
(3, 'Clanton Jr', 'Alfred', 10275, '7/3/1966', '3/16/2010', 'Jobbing Mill (205310)', 'UTILITY TECHNICIAN'),
(4, 'Clukey', 'Jeffrey', 10364, '4/15/1989', '7/9/2012', 'Finishing Mills Gen (200330)', 'UTILITY TECHNICIAN '),
(5, 'Coon', 'Paul', 10190, '9/16/1973', '12/7/2009', '14" Mill (230310)', 'OPERATING TECHNICIAN 1'),
(6, 'Delany', 'William', 10248, '5/26/1976', '2/15/2010', '14" Mill (230310)', 'UTILITY TECHNICIAN'),
(7, 'Garcia', 'Jose''', 10118, '5/22/1973', '11/16/2009', 'Finishing Mills Gen (200310)', 'UTILITY TECHNICIAN'),
(8, 'Hamann', 'Eric', 10206, '4/21/1982', '12/7/2009', 'Finishing Mills Gen (200310)', 'OPERATING TECHNICIAN 1'),
(9, 'Jacobs', 'Gerald', 10201, '3/27/1967', '12/7/2009', 'Finishing Mills Gen (200310)', 'UTILITY TECHNICIAN'),
(10, 'James', 'Charles', 10177, '11/25/1950', '11/30/2009', '14" Mill (230310)', 'OPERATING TECHNICIAN 1'),
(11, 'Johnson', 'Aaron', 10358, '11/2/1986', '1/9/2012', 'Finishing Mills Gen (200310)', 'UTILITY TECHNICIAN'),
(12, 'Jones', 'Frederick', 10300, '3/23/1975', '5/17/2010', 'Jobbing Mill (205310)', 'UTILITY TECHNICIAN'),
(13, 'Kirkendall', 'Daniel', 10181, '5/17/1972', '12/7/2009', 'Finishing Mills Gen (200310)', 'SR OPERATING TECHNICIAN'),
(14, 'Krueger', 'Matthew', 10178, '12/7/1971', '11/30/2009', 'Jobbing Mill (205310)', 'SR OPERATING TECHNICIAN'),
(15, 'Ledford', 'Michael', 10153, '3/21/1962', '11/23/2009', 'Finishing Mills Gen (200310)', 'OPERATING TECHNICIAN 1'),
(16, 'Ledford Jr', 'Michael', 10295, '7/25/1990', '5/10/2010', 'Finishing Mills Gen (200310)', 'UTILITY TECHNICIAN'),
(17, 'Lee', 'Adam', 10189, '6/30/1976', '12/7/2009', 'Jobbing Mill (205310)', 'OPERATING TECHNICIAN 1'),
(18, 'Miller', 'John', 10182, '9/27/1960', '12/7/2009', '12/2 Mill (221310)', 'SR OPERATING TECHNICIAN'),
(19, 'Miller', 'Jeremy', 10196, '6/30/1982', '12/7/2009', 'Jobbing Mill (205310)', 'OPERATING TECHNICIAN 1'),
(20, 'Peck', 'Daniel', 10219, '11/3/1954', '1/4/2010', 'Finishing Mills Gen (200310)', 'SR OPERATING TECHNICIAN'),
(21, 'Priest', 'Lawrence', 10191, '6/7/1952', '12/7/2009', '14" Mill (230310)', 'OPERATING TECHNICIAN 1'),
(22, 'Riker', 'Edward', 10183, '1/4/1961', '12/7/2009', '14" Mill (230310)', 'SR OPERATING TECHNICIAN'),
(23, 'Robinson', 'Nathan', 10199, '7/7/1983', '12/7/2009', 'Finishing Mills Gen (200310)', 'OPERATING TECHNICIAN 1'),
(24, 'Rowland', 'Carl', 10186, '8/9/1977', '12/7/2009', 'Jobbing Mill (205310)', 'SR OPERATING TECHNICIAN'),
(25, 'Saccone Jr', 'Matthew', 10192, '6/13/1975', '12/7/2009', 'Jobbing Mill (205310)', 'WORK LEADER 5'),
(26, 'Schmitt', 'Joshua', 10353, '5/16/1986', '12/7/2011', 'Jobbing Mill (205330)', 'OPERATING TECHNICIAN 1'),
(27, 'Sliter', 'Stephen', 10366, '10/13/1986', '8/13/2012', 'Finishing Mills Gen (200330)', 'UTILITY TECHNICIAN'),
(28, 'Smith Jr', 'Elijah', 10367, '8/12/1973', '9/17/2012', 'Finishing Mills Gen (200330)', 'UTILITY TECHNICIAN - T1'),
(29, 'Sobon', 'John', 10187, '11/8/1957', '12/7/2009', '14" Mill (230310)', 'UTILITY TECHNICIAN'),
(30, 'Tomushunas', 'Brant', 10195, '10/30/1951', '12/7/2009', 'Finishing Mills Gen (200310)', 'OPERATING TECHNICIAN 1'),
(31, 'VanAuken', 'Rodney', 10150, '9/22/1952', '11/23/2009', 'Finishing Mills Gen (200310)', 'WORK LEADER 5'),
(33, 'Wynn', 'Linter', 10185, '1/18/1955', '12/7/2009', '14" Mill (230310)', 'OPERATING TECHNICIAN 1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
