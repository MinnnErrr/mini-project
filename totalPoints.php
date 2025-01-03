<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
if(isset($_POST['searchTotalPoints'])){
    $membershipID = $_POST['membershipID'];
    $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID', $membershipID);
    $stmt->execute();
    $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
    $accumulatedPoints = $membershipCard['AccumulatedPoints'];
}
if(isset($_GET['membershipID'])){
    $membershipID = $_GET['membershipID'];
    $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID', $membershipID);
    $stmt->execute();
    $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
    $accumulatedPoints = $membershipCard['AccumulatedPoints'];
}

 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="studentCard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style type="text/tailwindcss">
        @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require 'customerSideBar.php' ?>
            <div class="template">
                <div class="row">
                <h1 style="text-font-weight: bold;font-size: 30px">Total Points: <?php echo $accumulatedPoints ?></h1>
                </div>
            </div>
            <?php require 'footer.php' ?>

        </div>
    </div>
    <script src="studentCard.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>