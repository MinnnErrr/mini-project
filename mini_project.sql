-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 01:40 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `StudentID` varchar(50) DEFAULT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `StudentCard` varchar(255) DEFAULT NULL,
  `VerificationStatus` varchar(50) NOT NULL DEFAULT 'Pending',
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Balance` decimal(10,0) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `CustomerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `TotalPrice` decimal(10,0) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Points` int(11) DEFAULT NULL,
  `PaymentMethod` varchar(20) NOT NULL,
  `PickUpDate` datetime DEFAULT NULL,
  `PickUpTime` datetime DEFAULT NULL,
  `CustomerID` int(11) NOT NULL,
  `StaffID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `packageproperty`
--

CREATE TABLE `packageproperty` (
  `PropertyID` int(11) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` decimal(10,0) NOT NULL,
  `PackageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `BasePrice` decimal(10,0) NOT NULL,
  `Availability` tinyint(1) NOT NULL,
  `BranchID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `TransactionID` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `Amount` decimal(10,0) NOT NULL,
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
(2, 'staff@gmail.com', '$2y$10$usqj6JvJJ9X1U/MZSZgZ5.cRJiEr8ZHHoKK0G4/Mv2p8IlQyP/NU.', 'staff', '2024-12-11 05:02:58', '2024-12-11 05:02:58', 'staff'),
(3, 'customer@gmail.com', '$2y$10$45DDbU3BHoNFKJPk8UmYBOwy0VnG0J9e.VtV5S3iv5QUk6YWd1vi.', 'customer', '2024-12-11 05:04:40', '2024-12-11 05:04:40', 'customer'),
(4, 'admin@gmail.com', '$2y$10$MQnVymbGD4I9mKnbt603mO4K/TkKIu/th2VmjOSijKTbqWfy.zNLi', 'admin', '2024-12-11 05:05:06', '2024-12-11 05:05:06', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`BranchID`);

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
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `BranchID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `membershipcard`
--
ALTER TABLE `membershipcard`
  MODIFY `MembershipID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orderprintingpackage`
--
ALTER TABLE `orderprintingpackage`
  MODIFY `OrderPackageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packageproperty`
--
ALTER TABLE `packageproperty`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `point`
--
ALTER TABLE `point`
  MODIFY `Point_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `printingpackage`
--
ALTER TABLE `printingpackage`
  MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward`
--
ALTER TABLE `reward`
  MODIFY `RewardID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
