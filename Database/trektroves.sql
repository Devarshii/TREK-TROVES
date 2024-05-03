-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2024 at 12:47 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trektroves`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `updationDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2020-05-11 11:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `tblactivityorder`
--

CREATE TABLE `tblactivityorder` (
  `id` int(11) NOT NULL,
  `activityId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `originalPrice` varchar(255) DEFAULT NULL,
  `totalPrice` varchar(255) DEFAULT NULL,
  `startingDate` varchar(255) DEFAULT NULL,
  `endingDate` varchar(255) DEFAULT NULL,
  `totalDays` int(11) DEFAULT NULL,
  `orderStatus` int(11) DEFAULT NULL COMMENT '0: Pending, 1: Success, 2: Failed',
  `txnId` varchar(255) DEFAULT NULL,
  `paymentResponse` text,
  `isReturned` int(11) DEFAULT '0' COMMENT '0: No, 1: Yes',
  `returnedQty` int(11) DEFAULT NULL,
  `comments` text,
  `createdOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblactivityorder`
--

INSERT INTO `tblactivityorder` (`id`, `activityId`, `userId`, `originalPrice`, `totalPrice`, `startingDate`, `endingDate`, `totalDays`, `orderStatus`, `txnId`, `paymentResponse`, `isReturned`, `returnedQty`, `comments`, `createdOn`, `updatedOn`) VALUES
(1, 1, 1, '12', '1', '2015-11-11', '2015-11-11', 4, 1, NULL, NULL, 1, 3, NULL, '2024-03-07 06:32:53', '2024-03-09 15:52:39'),
(21, 2, 1, '90', '90', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 13:24:19', NULL),
(22, 2, 1, '90', '90', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 13:24:36', NULL),
(23, 1, 1, '90', '180', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 15:18:49', NULL),
(24, 1, 1, '90', '180', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 15:19:39', NULL),
(25, 1, 1, '10', '10', '2024-03-24', '2024-03-24', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-24 15:15:28', NULL),
(26, 1, 1, '10', '10', '2024-03-24', '2024-03-24', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-24 15:15:42', NULL),
(27, 1, 1, '10', '10', '2024-03-24', '2024-03-24', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-24 15:41:57', NULL),
(28, 1, 1, '10', '10', '2024-03-24', '2024-03-24', 1, 1, NULL, 'pay_NqHtO5AMYzfmWE', 0, NULL, NULL, '2024-03-24 15:52:36', '2024-03-24 23:46:22'),
(29, 1, 1, '10', '10', '2024-03-29', '2024-03-29', 1, 1, NULL, 'pay_NsFi46b6H8omKF', 0, NULL, NULL, '2024-03-29 17:24:23', '2024-03-29 22:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbladventureactivities`
--

CREATE TABLE `tbladventureactivities` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `activityImage` varchar(255) DEFAULT NULL,
  `price_per_day` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0: Inactive, 1: Active, 2: Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladventureactivities`
--

INSERT INTO `tbladventureactivities` (`id`, `title`, `description`, `activityImage`, `price_per_day`, `status`) VALUES
(1, 'First', 'Test', '1710687748200X300.jpg', '10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblbooking`
--

CREATE TABLE `tblbooking` (
  `BookingId` int(11) NOT NULL,
  `PackageId` int(11) DEFAULT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `FromDate` varchar(100) DEFAULT NULL,
  `ToDate` varchar(100) DEFAULT NULL,
  `PackagePrice` varchar(255) DEFAULT NULL,
  `Comment` mediumtext,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `paymentResponse` varchar(255) DEFAULT NULL,
  `CancelledBy` varchar(5) DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbooking`
--

INSERT INTO `tblbooking` (`BookingId`, `PackageId`, `userId`, `UserEmail`, `FromDate`, `ToDate`, `PackagePrice`, `Comment`, `RegDate`, `status`, `paymentResponse`, `CancelledBy`, `UpdationDate`) VALUES
(4, 1, NULL, 'khatrisagar2@gmail.com', '2023-10-25', '2023-10-31', '', 'I Want To Book It', '2023-10-25 06:28:18', 0, NULL, NULL, NULL),
(5, 1, NULL, 'khatrisagar2@gmail.com', '2024-03-14', '2024-03-21', '', 'n', '2024-03-13 19:15:37', 0, NULL, NULL, NULL),
(6, 2, NULL, 'khatrisagar2@gmail.com', '2024-03-29', '2024-03-30', '', 'asdsad', '2024-03-14 20:01:45', 0, NULL, NULL, NULL),
(7, 1, NULL, 'khatrisagar2@gmail.com', '', '', '', 'test', '2024-03-29 17:23:55', 0, NULL, NULL, NULL),
(8, 0, '1', 'khatrisagar2@gmail.com', '', '', NULL, 'test', '2024-03-29 19:10:26', 0, NULL, NULL, NULL),
(9, 1, '1', 'khatrisagar2@gmail.com', '', '', '9500', 'aaaaa', '2024-03-29 19:14:14', 1, 'pay_NsHa7dKkQ8e1id', NULL, '2024-03-29 19:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblenquiry`
--

CREATE TABLE `tblenquiry` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `EmailId` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `Subject` varchar(100) DEFAULT NULL,
  `Description` mediumtext,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblenquiry`
--

INSERT INTO `tblenquiry` (`id`, `FullName`, `EmailId`, `MobileNumber`, `Subject`, `Description`, `PostingDate`, `Status`) VALUES
(1, 'Sagar', 'sagar@gmail.com', '9090123123', 'Need More Information', 'Need Information Related To Package', '2023-10-25 06:39:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblequipmentorder`
--

CREATE TABLE `tblequipmentorder` (
  `id` int(11) NOT NULL,
  `equipmentId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `originalPrice` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `totalPrice` varchar(255) DEFAULT NULL,
  `startingDate` varchar(255) DEFAULT NULL,
  `endingDate` varchar(255) DEFAULT NULL,
  `totalDays` int(11) DEFAULT NULL,
  `orderStatus` int(11) DEFAULT NULL COMMENT '0: Pending, 1: Success, 2: Failed',
  `txnId` varchar(255) DEFAULT NULL,
  `paymentResponse` text,
  `isReturned` int(11) DEFAULT '0' COMMENT '0: No, 1: Yes',
  `returnedQty` int(11) DEFAULT NULL,
  `comments` text,
  `createdOn` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblequipmentorder`
--

INSERT INTO `tblequipmentorder` (`id`, `equipmentId`, `userId`, `originalPrice`, `qty`, `totalPrice`, `startingDate`, `endingDate`, `totalDays`, `orderStatus`, `txnId`, `paymentResponse`, `isReturned`, `returnedQty`, `comments`, `createdOn`, `updatedOn`) VALUES
(1, 1, 1, '12', 3, '1', '2015-11-11', '2015-11-11', 4, 1, NULL, NULL, 1, 3, NULL, '2024-03-07 01:02:53', '2024-03-09 15:52:39'),
(2, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 0, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:13:15', NULL),
(3, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 0, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:13:53', NULL),
(4, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:14:16', NULL),
(5, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:18:47', NULL),
(6, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:18:54', NULL),
(7, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:19:53', NULL),
(8, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:20:00', NULL),
(9, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:23:11', NULL),
(10, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:23:32', NULL),
(11, 0, 1, '0', NULL, '0', '2024-03-07', '2024-03-07', 1, 1, NULL, NULL, 0, NULL, NULL, '2024-03-07 01:24:10', NULL),
(12, 0, 1, '0', NULL, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 06:08:59', NULL),
(13, 0, 1, '0', NULL, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 06:09:10', NULL),
(14, 0, 1, '0', NULL, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 06:10:11', NULL),
(15, 0, 1, '0', NULL, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:28:18', NULL),
(16, 0, 1, '0', 1, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:40:36', NULL),
(17, 0, 1, '0', 1, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:40:53', NULL),
(18, 0, 1, '0', 1, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:40:58', NULL),
(19, 0, 1, '0', 1, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:41:06', NULL),
(20, 2, 1, NULL, 1, '0', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:41:11', NULL),
(21, 2, 1, '90', 1, '90', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:54:19', NULL),
(22, 2, 1, '90', 1, '90', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 07:54:36', NULL),
(23, 1, 1, '90', 2, '180', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 09:48:49', NULL),
(24, 1, 1, '90', 2, '180', '2024-03-09', '2024-03-09', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-09 09:49:39', NULL),
(25, 1, 1, '90', 2, '180', '2024-03-29', '2024-03-29', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-29 18:35:29', NULL),
(26, 1, 1, '90', 2, '180', '2024-03-29', '2024-03-29', 1, 0, NULL, NULL, 0, NULL, NULL, '2024-03-29 18:35:41', NULL),
(27, 1, 1, '90', 2, '180', '2024-03-29', '2024-03-29', 1, 1, NULL, 'null', 0, NULL, NULL, '2024-03-29 18:35:59', '2024-03-30 00:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `tblequipments`
--

CREATE TABLE `tblequipments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT '',
  `detail` text,
  `price_per_day` varchar(255) DEFAULT NULL,
  `equipmentImage` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '0: Inactive, 1: Active, 2: Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblequipments`
--

INSERT INTO `tblequipments` (`id`, `name`, `detail`, `price_per_day`, `equipmentImage`, `status`) VALUES
(1, 'e1', 'testing', '90', '1709492905200X300.jpg', 1),
(2, 'e1', 'testing', '90', '1709492635200X300.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblissues`
--

CREATE TABLE `tblissues` (
  `id` int(11) NOT NULL,
  `UserEmail` varchar(100) DEFAULT NULL,
  `Issue` varchar(100) DEFAULT NULL,
  `Description` mediumtext,
  `PostingDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` mediumtext,
  `AdminremarkDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblissues`
--

INSERT INTO `tblissues` (`id`, `UserEmail`, `Issue`, `Description`, `PostingDate`, `AdminRemark`, `AdminremarkDate`) VALUES
(1, 'khatrisagar2@gmail.com', 'Booking Issues', 'Booking Issue In Package', '2023-10-25 06:35:36', 'Resolved Your Issue Please Check Now', '2023-10-25 06:37:20'),
(2, 'khatrisagar2@gmail.com', NULL, NULL, '2024-03-12 14:11:22', NULL, NULL),
(3, 'khatrisagar2@gmail.com', NULL, NULL, '2024-03-12 14:11:29', NULL, NULL),
(4, 'khatrisagar2@gmail.com', NULL, NULL, '2024-03-12 14:12:00', NULL, NULL),
(5, 'khatrisagar2@gmail.com', NULL, NULL, '2024-03-12 14:12:54', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpages`
--

CREATE TABLE `tblpages` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT '',
  `detail` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpages`
--

INSERT INTO `tblpages` (`id`, `type`, `detail`) VALUES
(1, 'Terms of Use', '										<p align=\"justify\"><font size=\"2\"><strong><font color=\"#990000\">(1) ACCEPTANCE OF TERMS</font><br><br></strong>Welcome to Yahoo! India. 1Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: <a href=\"http://in.docs.yahoo.com/info/terms/\">http://in.docs.yahoo.com/info/terms/</a>. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </font></p>\r\n<p align=\"justify\"><font size=\"2\">Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </font><a href=\"http://in.docs.yahoo.com/info/terms/\"><font size=\"2\">http://in.docs.yahoo.com/info/terms/</font></a><font size=\"2\">. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </font></p>\r\n<p align=\"justify\"><font size=\"2\">Welcome to Yahoo! India. Yahoo Web Services India Private Limited Yahoo\", \"we\" or \"us\" as the case may be) provides the Service (defined below) to you, subject to the following Terms of Service (\"TOS\"), which may be updated by us from time to time without notice to you. You can review the most current version of the TOS at any time at: </font><a href=\"http://in.docs.yahoo.com/info/terms/\"><font size=\"2\">http://in.docs.yahoo.com/info/terms/</font></a><font size=\"2\">. In addition, when using particular Yahoo services or third party services, you and Yahoo shall be subject to any posted guidelines or rules applicable to such services which may be posted from time to time. All such guidelines or rules, which maybe subject to change, are hereby incorporated by reference into the TOS. In most cases the guides and rules are specific to a particular part of the Service and will assist you in applying the TOS to that part, but to the extent of any inconsistency between the TOS and any guide or rule, the TOS will prevail. We may also offer other services from time to time that are governed by different Terms of Services, in which case the TOS do not apply to such other services if and to the extent expressly excluded by such different Terms of Services. Yahoo also may offer other services from time to time that are governed by different Terms of Services. These TOS do not apply to such other services that are governed by different Terms of Service. </font></p>\r\n										'),
(2, 'Privacy Policy', '										<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat</span>\r\n										'),
(3, 'About Us', '<div style=\"text-align: justify;\"><div>Welcome to Trek Troves!!!</div><div>TrekTroves is a Non Government Organization, being run by young students for social reformation and building the nation with moral values and ethics.</div></div>										<div></div>\r\n										'),
(11, 'Contact Us', '																				<span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\">Address------J-890 Dwarka House New Delhi-110096</span>');

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackageimages`
--

CREATE TABLE `tbltourpackageimages` (
  `id` int(11) NOT NULL,
  `packageId` int(11) DEFAULT NULL,
  `packageImage` varchar(255) DEFAULT NULL,
  `sort_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL COMMENT '0: Active, 1: Active, 2: Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltourpackageimages`
--

INSERT INTO `tbltourpackageimages` (`id`, `packageId`, `packageImage`, `sort_id`, `status`) VALUES
(4, 1, '1710354578300X200.jpg', NULL, '1'),
(6, 1, '171035725095995.jpg', NULL, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltourpackages`
--

CREATE TABLE `tbltourpackages` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(200) DEFAULT NULL,
  `PackageType` varchar(150) DEFAULT NULL,
  `PackageLocation` varchar(100) DEFAULT NULL,
  `PackagePrice` int(11) DEFAULT NULL,
  `PackageTimings` text,
  `PackageFetures` varchar(255) DEFAULT NULL,
  `PackageDetails` mediumtext,
  `PackageImage` varchar(100) DEFAULT NULL,
  `Creationdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO `tbltourpackages` (`PackageId`, `PackageName`, `PackageType`, `PackageLocation`, `PackagePrice`, `PackageTimings`, `PackageFetures`, `PackageDetails`, `PackageImage`, `Creationdate`, `UpdationDate`) VALUES
(1, 'Kasol Manali Adventure Camp', 'Family Package', 'Kasol', 9500, NULL, 'Departure from Ahmedabad', 'DAY 1\r\nDeparture from Ahmedabad\r\n\r\nDAY 2\r\nArrival at Pathankot & Depart to Kasol\r\n\r\nDAY 3\r\nDay for Acclimatisation & Kasol Visit', 'ee88644c-893d-4ca2-bcdb-de71eb6bf37a.jpg', '2023-10-25 06:22:18', NULL),
(2, 'Christine O\'Kon', '9485 Garth Spur', 'Corrupti ullam ducimus illo enim minus.', 95341, '[{\"startDate\":\"2024-03-29\",\"endDate\":\"2024-03-30\"},{\"startDate\":\"2024-03-15\",\"endDate\":\"2024-03-22\"},{\"startDate\":\"2024-03-15\",\"endDate\":\"2024-03-22\"},{\"startDate\":\"2024-03-21\",\"endDate\":\"2024-03-29\"},{\"startDate\":\"2024-03-28\",\"endDate\":\"2024-03-30\"}]', 'Itaque modi quia perspiciatis consectetur.', 'Odit cupiditate ullam.', NULL, '2024-03-14 19:45:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `MobileNumber` char(10) DEFAULT NULL,
  `EmailId` varchar(70) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `FullName`, `MobileNumber`, `EmailId`, `Password`, `RegDate`, `UpdationDate`) VALUES
(1, 'Sagar', '7878232386', 'khatrisagar2@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2023-10-25 06:24:06', '2024-03-07 06:29:13'),
(2, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-03-12 14:11:21', NULL),
(3, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-03-12 14:11:29', NULL),
(4, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-03-12 14:12:00', NULL),
(5, NULL, NULL, NULL, 'd41d8cd98f00b204e9800998ecf8427e', '2024-03-12 14:12:54', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblactivityorder`
--
ALTER TABLE `tblactivityorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladventureactivities`
--
ALTER TABLE `tbladventureactivities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooking`
--
ALTER TABLE `tblbooking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblequipmentorder`
--
ALTER TABLE `tblequipmentorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblequipments`
--
ALTER TABLE `tblequipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissues`
--
ALTER TABLE `tblissues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpages`
--
ALTER TABLE `tblpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltourpackageimages`
--
ALTER TABLE `tbltourpackageimages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  ADD PRIMARY KEY (`PackageId`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EmailId` (`EmailId`),
  ADD KEY `EmailId_2` (`EmailId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblactivityorder`
--
ALTER TABLE `tblactivityorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbladventureactivities`
--
ALTER TABLE `tbladventureactivities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbooking`
--
ALTER TABLE `tblbooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblenquiry`
--
ALTER TABLE `tblenquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblequipmentorder`
--
ALTER TABLE `tblequipmentorder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tblequipments`
--
ALTER TABLE `tblequipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblissues`
--
ALTER TABLE `tblissues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblpages`
--
ALTER TABLE `tblpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbltourpackageimages`
--
ALTER TABLE `tbltourpackageimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbltourpackages`
--
ALTER TABLE `tbltourpackages`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
