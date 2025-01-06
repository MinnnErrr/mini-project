<?php
if(isset($_GET['verifyUserID'])){
    $verifyUserID = $_GET['verifyUserID'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE UserID = :viewUserID");
    $stmt->bindParam(':viewUserID', $verifyUserID);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $Username = $user['Username'];
    $Email = $user['Email'];
    $Role = $user['Role'];
    $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :verifyUserID");
    $stmt->bindParam(':verifyUserID', $verifyUserID);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    $StudentID = $customer['StudentID'];
    $phoneNumber= $customer['PhoneNumber'];
    $studentCard= $customer['StudentCard'];
}
if(isset($_POST['verifyUser'])){
    $verifyUserID = $_GET['verifyUserID'];
    $stmt = $conn->prepare("UPDATE customer SET VerificationStatus =  :verifyStatus WHERE UserID = :verifyUserID"); // Update the user status * FROM user WHERE UserID = :viewUserID");
    $verifyStatus ="Verify";
    $stmt->bindParam(':verifyStatus',  $verifyStatus );
    $stmt->bindParam(':verifyUserID', $verifyUserID);
    $stmt->execute();
    echo "
    <script>
        alert('User verified successfully.');
        location.href='manageUser.php';
    </script>";
    exit;
}

?>