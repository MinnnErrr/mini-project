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

    $stmt = $conn->prepare("SELECT Date,Amount FROM `point` WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID',$membershipID);
    $stmt->execute();
    $pointDateAmount = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT Date,TotalPrice FROM `order` WHERE CustomerID = :customerID");
    $stmt->bindParam(':customerID', $CustomerID);
    $stmt->execute();
    $orderDateAmount = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['datePointSearch'])){
        $date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));
        $stmt = $conn->prepare("SELECT Date,Amount FROM `point` WHERE date(`date`) BETWEEN :date1 AND :date2 AND MembershipID = :membershipID");
        $stmt->bindParam(":date1", $date1);
        $stmt->bindParam(":date2", $date2);
        $stmt->bindParam(':membershipID',$membershipID);
        $stmt->execute();
        $pointDateAmount = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    if(isset($_POST['dateOrderSearch'])){
        $date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));
        $stmt = $conn->prepare("SELECT Date,TotalPrice FROM `order` WHERE date(`date`) BETWEEN :date1 AND :date2 AND  CustomerID = :customerID");

        $stmt->bindParam(":date1", $date1);
        $stmt->bindParam(":date2", $date2);
        $stmt->bindParam(':customerID', $CustomerID);
        $stmt->execute();
        $orderDateAmount = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    usort($pointDateAmount, function ($a, $b) {
        return strtotime($a['Date']) - strtotime($b['Date']); 
    }); // Sort the pointDateAmount array by date
    usort($orderDateAmount , function ($a, $b) {
        return strtotime($a['Date']) - strtotime($b['Date']);
    });
    echo "<script>const pointData = " . json_encode($pointDateAmount) . ";</script>";
    echo "<script>const orderSpending = " . json_encode($orderDateAmount) . ";</script>";
  
   
?>