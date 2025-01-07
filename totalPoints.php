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
    $stmt = $conn->prepare("SELECT SUM(Amount) AS total_points FROM point WHERE MembershipID = :membership_id"); // Calculate total points
    $stmt->bindParam(':membership_id', $membershipID );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_points = $result["total_points"];
    
    $stmt = $conn->prepare("UPDATE membershipcard SET AccumulatedPoints= :accumulatedPoints WHERE MembershipID = :membership_id"); // Update accumulated points
    $stmt->bindParam(':membership_id', $membershipID);
    $stmt->bindParam(':accumulatedPoints', $total_points);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID', $membershipID);
    $stmt->execute();
    $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
    $accumulatedPoints = $membershipCard['AccumulatedPoints'];

    
    $stmt = $conn->prepare("SELECT * FROM point WHERE MembershipID = :membershipID"); // Calculate total points
    $stmt->bindParam(':membershipID', $membershipID );
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_GET['membershipID'])){
    $membershipID = $_GET['membershipID'];
    $stmt = $conn->prepare("SELECT SUM(Amount) AS total_points FROM point WHERE MembershipID = :membership_id"); // Calculate total points
    $stmt->bindParam(':membership_id', $membershipID );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_points = $result["total_points"];
    
    $stmt = $conn->prepare("UPDATE membershipcard SET AccumulatedPoints= :accumulatedPoints WHERE MembershipID = :membership_id"); // Update accumulated points
    $stmt->bindParam(':membership_id', $membershipID);
    $stmt->bindParam(':accumulatedPoints', $total_points);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT * FROM membershipcard WHERE MembershipID = :membershipID");
    $stmt->bindParam(':membershipID', $membershipID);
    $stmt->execute();
    $membershipCard= $stmt->fetch(PDO::FETCH_ASSOC);
    $accumulatedPoints = $membershipCard['AccumulatedPoints'];

    $stmt = $conn->prepare("SELECT * FROM point WHERE MembershipID = :membershipID"); // Calculate total points
    $stmt->bindParam(':membershipID', $membershipID );
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
if(isset($_POST['dateSearch'])){
    $membershipID = $_POST['membershipID'];
    $stmt = $conn->prepare("SELECT SUM(Amount) AS total_points FROM point WHERE MembershipID = :membership_id"); // Calculate total points
    $stmt->bindParam(':membership_id', $membershipID );
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $accumulatedPoints  = $result["total_points"];

    $date1 = date("Y-m-d", strtotime($_POST['date1']));
    $date2 = date("Y-m-d", strtotime($_POST['date2']));
    $stmt = $conn->prepare("SELECT * FROM `point` WHERE date(`date`) BETWEEN :date1 AND :date2 AND MembershipID = :membershipID");
    $stmt->bindParam(":date1", $date1);
    $stmt->bindParam(":date2", $date2);
    $stmt->bindParam(":membershipID", $membershipID);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="totalPoints.css">
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!--change the sidebar file name-->
            <?php require 'CustomerSideBar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">
                    <div class="template p-5">
                        <div class="row">
                            <h1 style="text-font-weight: bold;font-size: 30px">Total Points:<?php echo $accumulatedPoints ?>
                            </h1>
                            <div class="m-2 rounded-3 p-2 bg-white shadow-sm">
                            <div class="filter-template">
                          
                                <div style="font-weight: bold;font-size: 20px">Date
                                    filter</div>
                                <form action="" method="post">
                                    <div class="d-flex">
                                        <div class="dateStart">
                                            <p>From: </p> <input type="date" name="date1" value="<?php echo( isset($_POST['dateSearch']) ? $_POST['date1'] : '' )?>">
                                        </div>
                                        <div class="dateEnd">
                                            <p>To: </p> <input type="date" name="date2" value="<?php echo( isset($_POST['dateSearch']) ? $_POST['date2'] : '' )?>">
                                        </div>
                                        <input type="text" name="membershipID" value="<?php echo $membershipID ?>" hidden>
                                    </div>
                                    <button name="dateSearch" class="m-1 btn btn-primary">Enter</button>
                                </form>
                            </div>
                            </div>
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Number</th>
                                            <th scope="col">Point ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
    $number =0;   
    foreach($result as $row){
        $number++;
        echo '<tr>';
        echo '<th scope="row">'.$number.'</th>';
        echo '<td>'.$row["Point_ID"].'</td>';
        echo '<td>'.$row["Date"].'</td>';
        echo '<td>'.$row["Amount"].'</td>';
        echo '</tr>';
     }
    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="studentCard.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>