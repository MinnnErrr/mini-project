<?php
 $stmt = $conn->prepare("SELECT * FROM user WHERE UserID = :viewUserID");
 $stmt->bindParam(':viewUserID', $user_id);
 $stmt->execute();
 $user = $stmt->fetch(PDO::FETCH_ASSOC);
 $username = $user['Username'];
 $email = $user['Email'];
 $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :viewUserID");
 $stmt->bindParam(':viewUserID', $user_id);
 $stmt->execute();
 $customer = $stmt->fetch(PDO::FETCH_ASSOC);
 $phoneNumber= $customer['PhoneNumber'];
 $CustomerID = $customer['CustomerID'];
 $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE CustomerID = :customerID");
 $stmt->bindParam(':customerID', $CustomerID);
 $stmt->execute();
 $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
 $membershipID= $membershipCard['MembershipID'];
 $balance= $membershipCard['Balance'];
 $accumulatedPoints = $membershipCard['AccumulatedPoints'];
 $balance = $membershipCard['Balance'];
 if(!isset($membershipID)){
    header('location:applyMembership.php');
}
 ?>