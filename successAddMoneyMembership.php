<?php
require 'dbconfig.php';
require_once 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
$amount = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_FLOAT);

if(isset($amount)){
 try{
    $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :viewUserID");
    $stmt->bindParam(':viewUserID', $user_id);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    $CustomerID = $customer['CustomerID'];
    $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE CustomerID = :customerID");
    $stmt->bindParam(':customerID', $CustomerID);
    $stmt->execute();
    $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
    $membershipID= $membershipCard['MembershipID'];
    $balance= $membershipCard['Balance'];
    $newBalance = (float)$balance + (float)$amount;
     $stmt = $conn->prepare("UPDATE membershipcard SET Balance = :balance WHERE CustomerID = :customerID");
     $stmt->bindParam(':balance', $newBalance,PDO::PARAM_STR);
     $stmt->bindParam(':customerID', $CustomerID);
     $stmt->execute();
     $sql = "INSERT INTO transaction (Amount, Type, MembershipID) 
            VALUES (:amount, :type, :membershipID)";
     $stmt = $conn->prepare($sql);
     $topUpAmount = (float)$amount;
     $stmt->bindParam(':amount', $topUpAmount);
     $typeTransaction = "topUp";
     $stmt->bindParam(':type',$typeTransaction);
     $stmt->bindParam(':membershipID',$membershipID);
     $stmt->execute();
    header('location:successPaymentpage.php');
    
 }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}
else{
    header('location:login.php');
}
?>
