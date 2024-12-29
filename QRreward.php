<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

require 'queryReward.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--your page title-->
    <title>Reward</title> 
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid p-0">
        <div class="row vh-100 m-0">
            <!--change the sidebar file name-->
            <?php require 'staffsidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10 p-0">
                <div class="container min-vh-100 p-4">

                    <!-- your content starts here -->
                    <div class="header">
                        <h3 style="margin-left: 10px;">Staff Reward Dashboard</h3>
                        <p style="margin-left: 10px;">Track your sales performance and earned rewards</p>
                     </div>

                     <div class="row">
                            <div class="box">
                                <!-- fs-1 = Larger -->
                                <h5><i class="bi bi-person-circle fs-4"></i> Staff Information</h5>
                                <br>
                                <table style="text-align:left; margin-left:40px">
                                    <tr>
                                        <td><p>Staff Name: <?php echo $Name; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Staff ID: <?php echo $StaffID; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Position: <?php echo $Position; ?></p></td>
                                    </tr>
                                    <tr>
                                        <td><p>Branch: <?php echo $Branch; ?></p> </td>
                                    </tr>
                                </table>       
                            </div>
                        </div>
                      

                <div class="row">
                     <div class="col-4">
                        <div class="box3">
                            <h6>Monthly Printing Sales</h6>
                            <p>RM<?php echo $MonthlySales; ?>?</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <h6>Points Earned</h6>
                            <p>RM <?php echo $Points; ?>?</p>
                        </div>
                     </div>
                     <div class="col-4">
                        <div class="box3">
                            <h6>Current Bonus</h6>
                            <p>RM <?php echo $Bonus; ?>?</p>
                        </div>
                     </div>
                </div>     

                <div class="box2">
                     <h4>Reward History</h4>
                     <table class="table table-bordered" style="text-align:center">
                     <thead class="table-primary">
                        <tr>
                            <th>Monthly Printing Sales</th>
                            <th>Bonus Obtained (RM)</th>
                            <th>Points Awarded</th>
                        </tr>
                     </thead>   
                   
                        <tr>
                            <td>More than RM200</td>
                            <td>RM50</td>
                            <td>10</td>
                        </tr>
                       
                     </table>
                </div>
                </div>
                        <div class="row bg-body border-top py-2 m-0">
                            <footer class="col d-flex justify-content-center align-items-center">
                            <a href="#" class="text-decoration-none me-2">
                                <img src="./Images/RapidPrintIcon.png" alt="RapidPrint" width="25">
                            </a>
                            <span>&copy 2024 RapidPrint. All rights reserved.</span>
                            </footer>
                        </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('').classList.add('is-active'); 
    </script>
</body>

</html>

