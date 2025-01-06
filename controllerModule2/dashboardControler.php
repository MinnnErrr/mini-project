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
    $balance =0;
    $accumulatedPoints =0;
    if(isset($membershipCard['MembershipID'])){
        $membershipID= $membershipCard['MembershipID'];
        $balance= $membershipCard['Balance'];
        $accumulatedPoints = $membershipCard['AccumulatedPoints'];
    }

    $stmt = $conn->prepare("SELECT SUM(Amount) FROM `point` WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID',$membershipID);
    $stmt->execute();
    $totalAmountPoint = $stmt->fetchColumn();
    $stmt = $conn->prepare("SELECT SUM(Amount) FROM `point` WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID',$membershipID);
    $stmt->execute();
    $totalAmountPoint = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT Date,Amount FROM `point` WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID',$membershipID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<script>const pointData = " . json_encode($result) . ";</script>";
    $stmt = $conn->prepare("SELECT Date,TotalPrice FROM `order` WHERE CustomerID = :customerID");
    $stmt->bindParam(':customerID', $CustomerID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<script>const orderSpending = " . json_encode($result) . ";</script>";


?>