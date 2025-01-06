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

//================================================================================================================================

// Get all months from the 'order' table where StaffID has 'Collected' orders
$query8 = "SELECT DISTINCT DATE_FORMAT(Date, '%Y-%m') AS Month
           FROM `order` 
           WHERE StaffID = $StaffID 
           AND Status = 'Collected'";
$result8 = mysqli_query($link, $query8);

while ($row8 = mysqli_fetch_assoc($result8)) {
    $Month = $row8['Month']; // The month is fetched from the database
    
    // Calculate MonthlySales for this specific month
    $MonthlySales = 0;
    $querySales = "SELECT TotalPrice 
                  FROM `order` 
                  WHERE StaffID = $StaffID 
                  AND Status = 'Collected' 
                  AND DATE_FORMAT(Date, '%Y-%m') = '$Month'";
    $resultSales = mysqli_query($link, $querySales);

    while ($rowSales = mysqli_fetch_assoc($resultSales)) {
        $MonthlySales += $rowSales['TotalPrice'];
    }

    // Check if an entry for this month exists in the reward table
    $queryReward = "SELECT COUNT(*) AS RewardCount 
                    FROM `reward` 
                    WHERE StaffID = $StaffID 
                    AND DATE_FORMAT(Date, '%Y-%m') = '$Month'";
    $resultReward = mysqli_query($link, $queryReward);
    $rowReward = mysqli_fetch_assoc($resultReward);

    if ($rowReward['RewardCount'] > 0) {
        // Update MonthlySales for this month in the reward table
        $queryUpdate = "UPDATE `reward` 
                        SET MonthlySales = $MonthlySales 
                        WHERE StaffID = $StaffID 
                        AND DATE_FORMAT(Date, '%Y-%m') = '$Month'";
        mysqli_query($link, $queryUpdate) or die("Error updating MonthlySales: " . mysqli_error($link));
    } else {
        // Insert a new entry for this month in the reward table
        $queryInsert = "INSERT INTO `reward` (StaffID, Date, MonthlySales, Bonus, Description, Points) 
                        VALUES ($StaffID, STR_TO_DATE('$Month-01', '%Y-%m-%d'), $MonthlySales, NULL, '', 0)";
        mysqli_query($link, $queryInsert) or die("Error inserting reward: " . mysqli_error($link));
    }

    // Determine the bonus, points, and description based on MonthlySales
    $Bonus = 0;
    $Points = 0;
    $Description = "";

    if ($MonthlySales > 450) {
        $Bonus = 150;
        $Points = 40;
        $Description = "More than RM450";
    } elseif ($MonthlySales > 350) {
        $Bonus = 120;
        $Points = 30;
        $Description = "More than RM350";
    } elseif ($MonthlySales > 280) {
        $Bonus = 80;
        $Points = 20;
        $Description = "More than RM280";
    } elseif ($MonthlySales > 200) {
        $Bonus = 50;
        $Points = 10;
        $Description = "More than RM200";
    }

    // Update the bonus, points, and description in the reward table for this month
    $queryUpdateBonus = "UPDATE `reward` 
                         SET Bonus = $Bonus, Points = $Points, Description = '$Description' 
                         WHERE StaffID = $StaffID 
                         AND DATE_FORMAT(Date, '%Y-%m') = '$Month'";
    mysqli_query($link, $queryUpdateBonus) or die("Error updating bonus and points: " . mysqli_error($link));
}

?>
