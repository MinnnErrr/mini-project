<?php
    $UserID = intval($_SESSION['user_id']);

    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

    $query2 = "SELECT s.StaffID AS StaffID,s.Position AS Position,s.PhoneNumber AS PhoneNumber,s.BranchID AS BranchID,s.UserID AS UserID
    ,u.Username AS Name, b.Name AS Branch
    FROM `staff` s
    JOIN 
        `user` u ON s.UserID = u.UserID
    JOIN 
        `branch` b ON b.BranchID = s.BranchID
    WHERE 
        u.UserID = $UserID";

    $result2 = mysqli_query($link, $query2);

    while ($row2 = mysqli_fetch_assoc($result2)){
            $StaffID = $row2["StaffID"];
            $Position = $row2["Position"];
            $PhoneNumber = $row2["PhoneNumber"];
            $BranchID = $row2["BranchID"];
            $UserID = $row2["UserID"];
            $Branch = $row2["Branch"];
            $Name = $row2["Name"];
    }

    // Get the current month and year
    // $currentMonth = date('Y-m'); // Format: YYYY-MM

    // Query to fetch order, customer, and package details
//     $query = "SELECT s.StaffID AS StaffID,s.Position AS Position,s.PhoneNumber AS PhoneNumber,s.BranchID AS BranchID,s.UserID AS UserID
//     ,r.RewardID AS RewardID,r.MonthlySales AS MonthlySales,r.Bonus AS Bonus,r.Date AS Date,r.Description AS Description,r.Points AS Points
//     ,u.Username AS Name, b.Name AS Branch
//     FROM `staff` s
//     JOIN 
//         `reward` r ON s.StaffID = r.StaffID
//     JOIN 
//         `user` u ON s.UserID = u.UserID
//     JOIN 
//         `branch` b ON b.BranchID = s.BranchID
//     WHERE 
//         u.UserID = $UserID AND DATE_FORMAT(Date, '%Y-%m') = $currentMonth";

// $result = mysqli_query($link, $query);

//     // Fetch the row from the result
//     if($row = mysqli_fetch_assoc($result)){
        
//         $RewardID = $row["RewardID"];
//         $MonthlySales = $row["MonthlySales"];
//         $Bonus = $row["Bonus"];
//         $Date = $row["Date"];
//         $Description = $row["Description"];
//         $Points = $row["Points"];
//     }