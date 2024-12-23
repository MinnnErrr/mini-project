<?php
    $UserID = intval($_SESSION['user_id']);

    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

    // Query to fetch order, customer, and package details
    $query = "SELECT s.StaffID AS StaffID,s.Position AS Position,s.PhoneNumber AS PhoneNumber,s.BranchID AS BranchID,s.UserID AS UserID
    ,r.RewardID AS RewardID,r.MonthlySales AS MonthlySales,r.Bonus AS Bonus,r.Date AS Date,r.Description AS Description,r.Points AS Points
    ,u.Username AS Name, b.Name AS Branch
    FROM `staff` s
    JOIN 
        `reward` r ON s.StaffID = r.StaffID
    JOIN 
        `user` u ON s.UserID = u.UserID
    JOIN 
        `branch` b ON b.BranchID = s.BranchID
    WHERE 
        u.UserID = $UserID";

$result = mysqli_query($link, $query);

    // Fetch the row from the result
    while ($row = mysqli_fetch_assoc($result)){
        $StaffID = $row["StaffID"];
        $Position = $row["Position"];
        $PhoneNumber = $row["PhoneNumber"];
        $BranchID = $row["BranchID"];
        $UserID = $row["UserID"];
        $RewardID = $row["RewardID"];
        $MonthlySales = $row["MonthlySales"];
        $Bonus = $row["Bonus"];
        $Date = $row["Date"];
        $Description = $row["Description"];
        $Points = $row["Points"];
        $Name = $row["Name"];
        $Branch = $row["Branch"];
    }