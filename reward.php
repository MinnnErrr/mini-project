<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reward</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'staffsidebar.php' ?>

            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100">
                    <!-- Your content here... -->
                     <div class="header">
                        <h3 style="margin-left: 10px;">Staff Reward Dashboard</h3>
                        <p style="margin-left: 10px;">Track your sales performance and earned rewards</p>
                     </div>

                     <div class="row">
                        <div class="col-6">
                            <div class="box">
                                <h5>Staff Information</h5>
                                <p>Staff Name</p>
                                <p>ID</p>
                                <p>Department</p>
                                <p>Join Date</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="box">
                                <h5 style="margin-bottom:15px;"><b>Your QR Code</b></h5>
                                <!-- QR Code Container with fixed dimensions -->
                                <div id="qrcode" style="margin-left:34%"></div>
                                <p style="font-size:smaller">Scan to view detailed performance</p>
                            </div>   
                        </div>
                     </div>

                <div class="row">
                     <div class="col-4">
                        <div class="box3">
                            <h6>Monthly Printing Sales</h6>
                            <p>RM</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <h6>Points Earned</h6>
                            <p>RM</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <h6>Current Bonus</h6>
                            <p>RM</p>
                        </div>
                     </div>
                </div>     

                <div class="box2">
                     <h4>Bonus Structure</h4>
                     <table class="tablestyle">
                        <tr>
                            <th>Monthly Printing Sales</th>
                            <th>Bonus Obtained (RM)</th>
                            <th>Points Awarded</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                     </table>
                </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('reward').classList.add('is-active', 'text-decoration-underline');
    </script>

</body>

</html>

  <!-- QRCode.js Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // Generate the QR Code
    var qrcode = new QRCode(document.getElementById("qrcode"), {
        text: "http://localhost/WEBFILE/mini-project/reward.php",
        width: 160,  // Fixed width
        height: 160, // Fixed height
        colorDark: "#000000", // QR code color
        colorLight: "#ffffff" // Background color
    });
</script>