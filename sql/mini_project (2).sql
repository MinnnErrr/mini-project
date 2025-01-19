-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2025 at 03:58 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `BranchID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `ContactNumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`BranchID`, `Name`, `Address`, `ContactNumber`) VALUES
(4, 'KOOPUMPSA Pekan', 'Universiti Malaysia Pahang Al-Sultan Abdullah 26600 Pekan Pahang, Malaysia', '012345678'),
(6, 'KOOPUMPSA Gambang', 'Universiti Malaysia Pahang Al-Sultan Abdullah Lebuh Persiaran Tun Khalil Yaakob 26300, Kuantan Pahan', '0198765432'),
(9, 'test', 'test', 'test'),
(10, 'test2', 'test2', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `StudentID` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `StudentCard` varchar(255) DEFAULT NULL,
  `VerificationStatus` varchar(50) NOT NULL DEFAULT 'pending',
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `StudentID`, `PhoneNumber`, `StudentCard`, `VerificationStatus`, `UserID`) VALUES
(3, 'ca22222', '23543546', 'uploads/677cc4b11660c9.67146981.png', 'Verify', 3),
(33, NULL, '1232435', NULL, 'unregistered', 33),
(34, NULL, '123455', NULL, 'unregistered', 34),
(35, 'ca11114', '12435', 'uploads/677cc46be52674.89518314.png', 'Verify', 35),
(36, NULL, '1243255', NULL, 'unregistered', 36),
(41, NULL, 'y65646', NULL, 'unregistered', 41),
(44, 'ca11111', '12345', NULL, 'Verify', 44),
(45, 'ca11112', '1234567', NULL, 'pending', 45),
(46, 'ca11113', '12343565', NULL, 'pending', 46),
(47, NULL, '12321434', NULL, 'unregistered', 47),
(48, NULL, '123456', NULL, 'unregistered', 48);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `InvoiceDate` datetime DEFAULT current_timestamp(),
  `TotalInvoice` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `membershipcard`
--

CREATE TABLE `membershipcard` (
  `MembershipID` int(11) NOT NULL,
  `AccumulatedPoints` int(11) NOT NULL,
  `Balance` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `CustomerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membershipcard`
--

INSERT INTO `membershipcard` (`MembershipID`, `AccumulatedPoints`, `Balance`, `Status`, `CreatedDate`, `CustomerID`) VALUES
(1, 120, '30.50', 'active', '2025-01-07 11:43:33', 45),
(2, 200, '50.75', 'active', '2025-01-07 11:43:33', 46),
(3, 350, '80.00', 'active', '2025-01-07 11:43:33', 33),
(4, 50, '15.25', 'active', '2025-01-07 11:43:33', 34),
(6, 0, '0.00', '', '2025-01-07 14:19:41', 35),
(7, 0, '0.00', '', '2025-01-19 21:19:27', 3);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `TotalPrice` decimal(10,2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Points` int(11) DEFAULT NULL,
  `PaymentMethod` varchar(20) NOT NULL,
  `PickUpDate` datetime DEFAULT NULL,
  `PickUpTime` datetime DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `descriptionOrder` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `Date`, `TotalPrice`, `Status`, `Points`, `PaymentMethod`, `PickUpDate`, `PickUpTime`, `CustomerID`, `StaffID`, `file`, `descriptionOrder`) VALUES
(3, '2024-11-03 08:00:00', '200.00', 'Collected', 250, 'MembershipCard', '2024-11-03 11:30:00', '2024-11-03 11:30:00', 44, 15, NULL, NULL),
(4, '2024-11-03 08:00:00', '200.00', 'Collected', 250, 'MembershipCard', '2024-11-03 11:44:48', '2024-11-03 11:44:48', 44, 15, NULL, NULL),
(5, '2024-10-03 11:51:07', '200.00', 'Collected', 250, 'MembershipCard', '2024-10-03 11:51:07', '2024-10-03 11:51:07', 44, 15, NULL, NULL),
(12, '2025-01-07 15:26:28', '50.00', 'Completed', 25, 'Cash', '2025-01-07 00:00:00', '0000-00-00 00:00:00', 44, NULL, '1736234788_Public_Library_Topology.pdf', '2'),
(13, '2025-01-07 15:36:50', '75.00', 'Completed', 38, 'Cash', '2025-01-07 00:00:00', '0000-00-00 00:00:00', 44, NULL, '1736235410_BCN2093 Project (3).pdf', '-'),
(14, '2025-01-07 15:40:15', '30.00', 'Ordered', 15, 'Cash', '2025-01-07 00:00:00', '0000-00-00 00:00:00', 44, NULL, '1736235615_Public_Library_Topology.pdf', '2'),
(17, '2025-01-19 21:04:05', '125.00', 'Ordered', 63, 'Cash', '2025-01-19 00:00:00', '0000-00-00 00:00:00', 3, NULL, '1737291845_Individual Report (1).pdf', '-');

-- --------------------------------------------------------

--
-- Table structure for table `orderprintingpackage`
--

CREATE TABLE `orderprintingpackage` (
  `OrderPackageID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PackageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderprintingpackage`
--

INSERT INTO `orderprintingpackage` (`OrderPackageID`, `Quantity`, `OrderID`, `PackageID`) VALUES
(1, 1, 3, 12),
(2, 2, 3, 13),
(5, 2, 12, 12),
(6, 5, 13, 13),
(7, 2, 14, 13),
(8, 5, 17, 12);

-- --------------------------------------------------------

--
-- Table structure for table `orderproperty`
--

CREATE TABLE `orderproperty` (
  `ID` int(11) NOT NULL,
  `OrderPackageID` int(11) NOT NULL,
  `PropertyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderproperty`
--

INSERT INTO `orderproperty` (`ID`, `OrderPackageID`, `PropertyID`) VALUES
(1, 1, 29),
(2, 2, 32),
(3, 5, 26),
(4, 6, 33),
(5, 7, 32),
(6, 8, 26);

-- --------------------------------------------------------

--
-- Table structure for table `packageproperty`
--

CREATE TABLE `packageproperty` (
  `PropertyID` int(11) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` float NOT NULL,
  `PackageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packageproperty`
--

INSERT INTO `packageproperty` (`PropertyID`, `Category`, `Name`, `Price`, `PackageID`) VALUES
(26, 'Size', '12” x 12” (304.8mm x 304.8mm)', 0, 12),
(27, 'Size', 'A2 - 16.5” x 23.5” (420mm x 594mm) ', 5.5, 12),
(28, 'Size', 'A1 - 23” x 33” (594mm x 840mm)', 15.2, 12),
(29, 'Lamination', 'Not required', 0, 12),
(30, 'Lamination', 'Gloss', 2.5, 12),
(32, 'Card Paper Type', 'White Ivory Card 250g', 0, 13),
(33, 'Card Paper Type', 'Cream Ivory Card 250g', 0, 13),
(34, 'Card Paper Type', 'Metallic Gold Poladon Card 250g', 0, 13),
(35, 'Size', 'A4 (210mm x 297mm)', 0, 14),
(36, 'Size', 'Letter Size (216mm x 279mm)', 0, 14),
(37, 'Size', 'A3 (297mm x 420mm)', 0.3, 3),
(38, 'Printing Color and Side', 'Single Sided Black & White', 0, 14),
(39, 'Printing Color and Side', 'Both Sided Black & White', 0.1, 14),
(40, 'Printing Color and Side', 'Single Sided Colour', 0.6, 14),
(41, 'Printing Color and Side', 'Both Sided Colour', 0.7, 14),
(42, 'Size', 'A3 - 297mm x 420mm', 0.6, 15),
(43, 'Size', 'A4 - 210mm x 297mm', 0.4, 15),
(44, 'Size', 'A5 - 148mm x 210mm', 0.1, 15),
(45, 'Size', 'A6 - 105mm x 148mm', 0, 15),
(46, 'Printing Side and Color', 'Full Color Single Sided', 0, 15),
(47, 'Printing Side and Color', 'Full Color Both Sided', 0.3, 15),
(48, 'Paper Type', 'Simili 80gsm', 0, 15),
(49, 'Paper Type', 'Simili 100gsm', 0, 15),
(50, 'Paper Type', 'Gloss Art Paper 100gsm', 0, 15),
(51, 'Paper Type', 'Gloss Art Paper 128gsm', 0.1, 15),
(52, 'Card Paper Type', 'White Ivory Card 250g', 0, 16),
(53, 'Card Paper Type', 'Cream Ivory Card 250g', 0, 16),
(54, 'Card Paper Type', 'Metallic Gold Poladon Card 250g', 0, 16),
(55, 'Size', 'A4 (210mm x 297mm)', 0, 17),
(56, 'Size', 'Letter Size (216mm x 279mm)', 0, 17),
(57, 'Size', 'A3 (297mm x 420mm)', 0.35, 17),
(58, 'Printing Color and Side', 'Single Sided Black & White', 0, 17),
(59, 'Printing Color and Side', 'Both Sided Black & White', 0.15, 17),
(60, 'Printing Color and Side', 'Single Sided Colour', 0.65, 17),
(61, 'Printing Color and Side', 'Both Sided Colour', 0.75, 17),
(62, 'testing', 'testing', 1, 18),
(63, 'test', 'test', 2, 18),
(64, 'cat1', 'property1', 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `point`
--

CREATE TABLE `point` (
  `Point_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Amount` decimal(10,0) NOT NULL DEFAULT 0,
  `MembershipID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `printingpackage`
--

CREATE TABLE `printingpackage` (
  `PackageID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `BasePrice` float NOT NULL,
  `Availability` varchar(20) NOT NULL,
  `BranchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `printingpackage`
--

INSERT INTO `printingpackage` (`PackageID`, `Name`, `Description`, `BasePrice`, `Availability`, `BranchID`) VALUES
(12, 'Poster', 'UV Inkjet 720 dpi | Single Sided | 180gsm Synthetic PVC\r\n\r\n', 25, 'Available', 4),
(13, 'Certificate', 'A4 (210mm x 297mm) | Full Color Printing | Single Sided \r\n\r\n', 15, 'Available', 4),
(14, 'Document Printing', '', 0.35, 'Available', 4),
(15, 'Brochure', 'Minimum 50 and above', 0.5, 'Available', 6),
(16, 'Certificate', 'A4 (210mm x 297mm) | Full Color Printing | Single Sided \r\n\r\n', 15.1, 'Available', 6),
(17, 'Document Printing', '', 0.3, 'Available', 6),
(18, 'test', '', 0, 'Unavailable', 9),
(19, 'test2', '', 2, 'Unavailable', 9);

-- --------------------------------------------------------

--
-- Table structure for table `reward`
--

CREATE TABLE `reward` (
  `RewardID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `MonthlySales` decimal(10,0) DEFAULT NULL,
  `Bonus` decimal(10,0) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Description` enum('More than RM200','More than RM280','More than RM350','More than RM450') DEFAULT NULL,
  `Points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reward`
--

INSERT INTO `reward` (`RewardID`, `StaffID`, `MonthlySales`, `Bonus`, `Date`, `Description`, `Points`) VALUES
(2, 15, '0', '0', '2025-01-07 13:56:57', '', 0),
(3, 15, '400', '120', '2024-11-01 00:00:00', 'More than RM350', 30),
(4, 15, '200', '0', '2024-10-01 00:00:00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `StaffID` int(11) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `BranchID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `Position`, `PhoneNumber`, `BranchID`, `UserID`) VALUES
(7, 'Manager', '1234353', 4, 26),
(8, 'Assistant Manager', '123432534', 4, 27),
(9, 'Senior Staff', '123423435', 4, 28),
(10, 'Manager', '123214325', 6, 29),
(11, 'Assistant Manager', '124343', 6, 30),
(12, 'Junior Staff', '12445', 4, 37),
(13, 'Junior Staff', '1243255', 4, 38),
(14, 'Junior Staff', '1242345235', 6, 39),
(15, 'Junior Staff', '414325454', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Amount` decimal(10,2) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `MembershipID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Email`, `Password`, `Username`, `CreatedAt`, `UpdatedAt`, `Role`) VALUES
(2, 'staff@gmail.com', '$2y$10$usqj6JvJJ9X1U/MZSZgZ5.cRJiEr8ZHHoKK0G4/Mv2p8IlQyP/NU.', 'staff', '2024-10-01 05:02:58', '2024-10-01 03:49:08', 'staff'),
(3, 'customer@gmail.com', '$2y$10$45DDbU3BHoNFKJPk8UmYBOwy0VnG0J9e.VtV5S3iv5QUk6YWd1vi.', 'customer', '2024-12-11 05:04:40', '2024-12-30 03:49:22', 'customer'),
(4, 'admin@gmail.com', '$2y$10$MQnVymbGD4I9mKnbt603mO4K/TkKIu/th2VmjOSijKTbqWfy.zNLi', 'admin', '2024-12-11 05:05:06', '2024-12-30 03:49:31', 'admin'),
(26, 'staff1@gmail.com', '$2y$10$9GFJjPda2R2H3SzccqtIvuxWn1Fl48N1NM989bn2p6IPn9wlgydWq', 'staff1', '2025-01-06 23:14:58', '2025-01-06 23:14:58', 'staff'),
(27, 'staff2@gmail.com', '$2y$10$qadFECC0IJOmNppAzClQ2.a9jg2kfL44n4Yca707FqeFUBePtMnCC', 'staff2', '2025-01-06 23:15:31', '2025-01-06 23:15:31', 'staff'),
(28, 'staff3@gmail.com', '$2y$10$KmbTQptKzBYtFQBpHPJEfO9wmtCj26kZ/7dlkuM9fby32D1fbJcOu', 'staff3', '2025-01-06 23:17:17', '2025-01-06 23:17:17', 'staff'),
(29, 'gambangstaff1@gmaill.com', '$2y$10$a2/jG/tfGeOgZldItCEN2.ZCixgwFwmqmEuoKKX/U/78xuorqYwNK', 'gambangstaff1', '2025-01-06 23:18:06', '2025-01-06 23:18:06', 'staff'),
(30, 'gambangstaff2@gmail.com', '$2y$10$0DTZWrkRALsTV2YmiXlyIeyEpJrqkt2AC6SprgihqawuowlJNHI36', 'gambangstaff2', '2025-01-06 23:18:33', '2025-01-06 23:18:33', 'staff'),
(33, 'customer6@gmail.com', '', 'customer6', '2025-01-06 23:26:02', '2025-01-06 23:26:02', 'customer'),
(34, 'customer7@gmail.com', '', 'customer7', '2025-01-06 23:28:31', '2025-01-06 23:28:31', 'customer'),
(35, 'customer8@gmail.com', '$2y$10$EQTr1NsFkRS2/kjIQfydgem1m0o/W66ZndspWxwC12a6fCQm4qrV2', 'customer8', '2025-01-06 23:31:10', '2025-01-06 23:31:10', 'customer'),
(36, 'customer9@gmail.com', '', 'customer9', '2025-01-06 23:33:01', '2025-01-06 23:33:01', 'customer'),
(37, 'staff4@gmail.com', '$2y$10$jjxGhxVwN.H4Df7YcWr9geBB/mrCoEpbGXUTpGTz0LXAMnGbCSvHK', 'staff4', '2025-01-06 23:35:14', '2025-01-06 23:35:14', 'staff'),
(38, 'staff5@gmail.com', '$2y$10$MQ7HLD0.bzy1qexNXBWrSOZO/bqeuNcpxR.TFPlHNPI3hGEgX0Dv.', 'staff5', '2025-01-06 23:35:59', '2025-01-06 23:35:59', 'staff'),
(39, 'gambangstaff3@gmail.com', '$2y$10$tYSfqt0pURAuX4YqQvqbJuiX/xjMuEuujVPS5vly8n7qKmY5wb0Oq', 'gambangstaff3', '2025-01-06 23:37:06', '2025-01-06 23:37:06', 'staff'),
(41, 'testing2@gmail.com', '', 'test', '2025-01-07 12:47:00', '2025-01-07 12:47:00', 'customer'),
(44, 'customer1@gmail.com', '$2y$10$TBclrAJL/gerJwdKvq.l6uiU1e5pDvgj7Lt9J/fTPAPa.KhjypopK', 'customer1', '2024-10-01 23:12:48', '2025-01-07 15:24:15', 'customer'),
(45, 'customer2@gmail.com', '$2y$10$SpZItJWYdJ8/lIiLI6OhWOh8WO0xh8btCxnM3YCwW8VMhluUdI0ja', 'customer2', '2025-01-06 23:13:26', '2025-01-07 15:24:25', 'customer'),
(46, 'customer3@gmail.com', '$2y$10$8JYSkhWMtSLKecaJO4/5dOIqdVOU8HoSTMFTOd6r9eeKJshxPWub2', 'customer3', '2025-01-06 23:14:20', '2025-01-07 15:24:42', 'customer'),
(47, 'guest2@gmail.com', '', 'guest2', '2025-01-07 15:46:46', '2025-01-07 15:46:46', 'customer'),
(48, 'guest@gmail.com', '', 'guest', '2025-01-19 15:35:34', '2025-01-19 15:35:34', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`BranchID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`),
  ADD KEY `UserID` (`UserID`) USING BTREE;

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `membershipcard`
--
ALTER TABLE `membershipcard`
  ADD PRIMARY KEY (`MembershipID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `orderprintingpackage`
--
ALTER TABLE `orderprintingpackage`
  ADD PRIMARY KEY (`OrderPackageID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `PackageID` (`PackageID`);

--
-- Indexes for table `orderproperty`
--
ALTER TABLE `orderproperty`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OrderPackageID` (`OrderPackageID`),
  ADD KEY `PropertyID` (`PropertyID`);

--
-- Indexes for table `packageproperty`
--
ALTER TABLE `packageproperty`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `PackageID` (`PackageID`);

--
-- Indexes for table `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`Point_ID`),
  ADD KEY `MembershipID` (`MembershipID`);

--
-- Indexes for table `printingpackage`
--
ALTER TABLE `printingpackage`
  ADD PRIMARY KEY (`PackageID`),
  ADD KEY `BranchID` (`BranchID`);

--
-- Indexes for table `reward`
--
ALTER TABLE `reward`
  ADD PRIMARY KEY (`RewardID`),
  ADD KEY `StaffID` (`StaffID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`),
  ADD KEY `BranchID` (`BranchID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `MembershipID` (`MembershipID`),
  ADD KEY `OrderID` (`OrderID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `BranchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membershipcard`
--
ALTER TABLE `membershipcard`
  MODIFY `MembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `orderprintingpackage`
--
ALTER TABLE `orderprintingpackage`
  MODIFY `OrderPackageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orderproperty`
--
ALTER TABLE `orderproperty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `packageproperty`
--
ALTER TABLE `packageproperty`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `point`
--
ALTER TABLE `point`
  MODIFY `Point_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `printingpackage`
--
ALTER TABLE `printingpackage`
  MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `RewardID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `membershipcard`
--
ALTER TABLE `membershipcard`
  ADD CONSTRAINT `membershipcard_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_4` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderprintingpackage`
--
ALTER TABLE `orderprintingpackage`
  ADD CONSTRAINT `orderprintingpackage_ibfk_3` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderprintingpackage_ibfk_4` FOREIGN KEY (`PackageID`) REFERENCES `printingpackage` (`PackageID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderproperty`
--
ALTER TABLE `orderproperty`
  ADD CONSTRAINT `orderproperty_ibfk_1` FOREIGN KEY (`OrderPackageID`) REFERENCES `orderprintingpackage` (`OrderPackageID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderproperty_ibfk_2` FOREIGN KEY (`PropertyID`) REFERENCES `packageproperty` (`PropertyID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `point`
--
ALTER TABLE `point`
  ADD CONSTRAINT `point_ibfk_1` FOREIGN KEY (`MembershipID`) REFERENCES `membershipcard` (`MembershipID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `printingpackage`
--
ALTER TABLE `printingpackage`
  ADD CONSTRAINT `printingpackage_ibfk_1` FOREIGN KEY (`BranchID`) REFERENCES `branch` (`BranchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reward`
--
ALTER TABLE `reward`
  ADD CONSTRAINT `reward_ibfk_1` FOREIGN KEY (`StaffID`) REFERENCES `staff` (`StaffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_3` FOREIGN KEY (`BranchID`) REFERENCES `branch` (`BranchID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`MembershipID`) REFERENCES `membershipcard` (`MembershipID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_4` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
