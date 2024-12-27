<?php

$UserID = intval($_SESSION['user_id']);

// Connect to the database
$link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

// Get the StaffID for the logged-in user
$query = "SELECT s.StaffID AS StaffID 
          FROM `staff` s
          JOIN `user` u ON s.UserID = u.UserID
          JOIN `branch` b ON b.BranchID = s.BranchID
          WHERE u.UserID = $UserID";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$StaffID = $row["StaffID"];

// Get the current month and year
$currentMonth = date('Y-m'); // Format: YYYY-MM

// Calculate MonthlySales from orders
$monthlySales = 0;
$query2 = "SELECT TotalPrice 
           FROM `order` 
           WHERE StaffID = $StaffID 
           AND Status = 'Collected' 
           AND DATE_FORMAT(Date, '%Y-%m') = '$currentMonth'";
$result2 = mysqli_query($link, $query2);

while ($row2 = mysqli_fetch_assoc($result2)) {
    $monthlySales += $row2['TotalPrice'];
}

// Check if an entry for the current month exists in the reward table
$query3 = "SELECT COUNT(*) AS RewardCount 
           FROM `reward` 
           WHERE StaffID = $StaffID 
           AND DATE_FORMAT(Date, '%Y-%m') = '$currentMonth'";
$result3 = mysqli_query($link, $query3);
$row3 = mysqli_fetch_assoc($result3);

if ($row3['RewardCount'] > 0) {
    // Update MonthlySales for the current month
    $query4 = "UPDATE `reward` 
               SET MonthlySales = $monthlySales 
               WHERE StaffID = $StaffID 
               AND DATE_FORMAT(Date, '%Y-%m') = '$currentMonth'";
    mysqli_query($link, $query4) or die("Error updating MonthlySales: " . mysqli_error($link));
} else {
    // Insert a new entry for the current month
    $query5 = "INSERT INTO `reward` (StaffID, Date, MonthlySales, Bonus, Description, Points) 
               VALUES ($StaffID, NOW(), $monthlySales, NULL, '', 0)";
    mysqli_query($link, $query5) or die("Error inserting reward: " . mysqli_error($link));
}

// Determine the bonus, points, and description based on MonthlySales
$bonus = 0;
$points = 0;
$Description = "";

if ($monthlySales > 450) {
    $bonus = 150;
    $points = 40;
    $Description = "More than RM450";
} elseif ($monthlySales > 350) {
    $bonus = 120;
    $points = 30;
    $Description = "More than RM350";
} elseif ($monthlySales > 280) {
    $bonus = 80;
    $points = 20;
    $Description = "More than RM280";
} elseif ($monthlySales > 200) {
    $bonus = 50;
    $points = 10;
    $Description = "More than RM200";
}

// Update the bonus, points, and description in the reward table
$query7 = "UPDATE `reward` 
           SET Bonus = $bonus, Points = $points, Description = '$Description' 
           WHERE StaffID = $StaffID 
           AND DATE_FORMAT(Date, '%Y-%m') = '$currentMonth'";
mysqli_query($link, $query7) or die("Error updating bonus and points: " . mysqli_error($link));

// echo "Reward table successfully updated.";
?>
