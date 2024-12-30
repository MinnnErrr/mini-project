<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
require 'calcSales.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Sales Graph</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./printing.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid p-0">
        <div class="row vh-100 m-0">
            <!--side bar-->
            <?php require 'staffsidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10 p-0">
                <div class="container min-vh-100 p-4">

                    <!-- your content starts here -->
                    <h5><b>Monthly Sales Overview</b></h5>
                                    <?php
                                    // Fetch monthly rewards data for the graph
                                    $query = "SELECT DATE_FORMAT(Date, '%b %Y') AS Month, MonthlySales, Bonus 
                                            FROM `reward` 
                                            WHERE StaffID = $StaffID 
                                            ORDER BY Date ASC";
                                    $result = mysqli_query($link, $query);

                                    $months = [];
                                    $Monthlysales = [];
                                    $Bonuses = [];

                                    // Prepare data for the graph
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $months[] = $row['Month']; // e.g., "Jan 2024"
                                        $Monthlysales[] = $row['MonthlySales'];
                                        $Bonuses[] = $row['Bonus'];
                                    }
                                    ?>

<canvas id="rewardChart" style="width:100%;max-width:1000px;"></canvas>
    <script>
        // Pass PHP data to JavaScript
        const months = <?php echo json_encode($months); ?>;
        const monthlySales = <?php echo json_encode($Monthlysales); ?>;
        const bonuses = <?php echo json_encode($Bonuses); ?>;

        // Render the chart
        new Chart("rewardChart", {
            type: "bar",
            data: {
                labels: months,
                datasets: [
                    {
                        label: "Monthly Sales (RM)",
                        data: monthlySales,
                        backgroundColor: "rgba(0, 123, 255, 0.7)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        borderWidth: 1
                    },
                    {
                        label: "Bonus (RM)",
                        data: bonuses,
                        backgroundColor: "rgba(40, 167, 69, 0.7)",
                        borderColor: "rgba(40, 167, 69, 1)",
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (RM)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Months'
                        }
                    }
                }
            }
        });
        </script>

</script>

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
</body>

</html>