<?php

require '../dbconfig.php';



// if(isset($_GET['ApplyMembershipCustomerID'])){
//  $customerID = $_GET['ApplyMembershipCustomerID'];
//  $stmt = $conn->prepare("INSERT INTO membershipcard (CustomerID) VALUES (:customerID)");
//  $stmt->bindParam(':customerID', $customerID);
//  $stmt->execute();
//  echo "
//  <script>
//      alert('Membership card applied successfully.');
//     location.href='../membership.php';
//     </script>
    
//  ";

// }
if(isset($_GET['membershipID'])){
    $membershipID = $_GET['membershipID'];
    try{
    $stmt = $conn->prepare("DELETE FROM membershipcard WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID', $membershipID);
    $stmt->execute();
    echo "
    <script>
        alert('Membership card cancelled successfully.');
        location.href='../customerDashboard.php';
    </script>
    ";
    }catch(PDOException $e){
        echo $e->getMessage();
    }
   
}


?>