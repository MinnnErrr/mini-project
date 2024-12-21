<?php
require 'dbconfig.php';
print_r("sjadsad");
if(isset($_GET['deleteUserID'])){
    if($_GET['role'] == 'customer'){
        $stmt = $conn->prepare("DELETE FROM user WHERE UserID = :editUserID");
        $stmt->bindParam(':editUserID', $_GET['deleteUserID']);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM customer WHERE UserID = :editUserID");
        $stmt->bindParam(':editUserID', $_GET['deleteUserID']);
        $stmt->execute();
        header("location:ManageUser.php");
    }
    elseif ($_GET['role'] == 'staff'){
        $stmt = $conn->prepare("DELETE FROM user WHERE UserID = :editUserID");
        $stmt->bindParam(':editUserID', $_GET['deleteUserID']);
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM staff WHERE UserID = :editUserID");
        $stmt->bindParam(':editUserID', $_GET['deleteUserID']);
        $stmt->execute();
        header("location:ManageUser.php");
    }
}
?>