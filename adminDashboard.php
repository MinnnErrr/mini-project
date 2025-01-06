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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!--side bar-->
            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container-fluid min-vh-100 p-4">

                    <!--admin dashboard-->
                    <div class="rounded-3 p-4 bg-gradient shadow-sm d-flex justify-content-between mb-4" style="color: #0f524f; background-color: #08c4b3;">
                        <div>
                            <h4>Admin Dashboard</h4>
                            <p>Welcome back, <?php echo $username ?> !</p>
                        </div>
                        <div class="d-flex">
                            <img style="max-width: 160px;" src="./images/undraw_admin.svg" alt="">
                        </div>
                    </div>

                    <!-- user -->
                    <div class="rounded-3 p-4 bg-white mb-4 shadow-sm mb-1">
                        <div class="row mb-3">
                            <h5>User Statistics</h5>
                        </div>

                        <!-- number -->
                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-4">
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill d-flex flex-column">
                                    <h6>Total Number of Staffs</h6>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM staff");
                                    $stmt->execute();
                                    $staffs = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    ?>
                                    <p class="fs-3"><?php echo count($staffs) ?></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill d-flex flex-column">
                                    <h6>Total Number of Customers</h6>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM customer");
                                    $stmt->execute();
                                    $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    ?>
                                    <p class="fs-3"><?php echo count($customers) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- graph -->
                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-4">
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Number of Staff by Branch</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart1" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Number of Customer by Status</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart2" style="width:100%; max-height:280px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- search -->
                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-1">
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <div class="mb-4">
                                        <form action="./adminDashboard.php" method="get">
                                            <label for="type" class="mb-2">Please select a user type: </label>
                                            <div class="d-flex">
                                                <select class="form-select me-2" name="type">
                                                    <option value="all" <?php echo (isset($_GET['type']) && $_GET['type'] == 'all') || !isset($_GET['type']) ? 'selected' : '' ?>>All</option>
                                                    <option value="customer" <?php echo isset($_GET['type']) && $_GET['type'] == 'customer' ? 'selected' : '' ?>>Customer</option>
                                                    <option value="staff" <?php echo isset($_GET['type']) && $_GET['type'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                                                </select>
                                                <button class="btn btn-outline-success" type="submit" name="searchUserByType"><i class="bi bi-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <h6>Number of User Over Time Categorised by User Type</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart3" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <div class="mb-4">
                                        <form action="./adminDashboard.php" method="get">
                                            <div class="mb-2">
                                                <label for="year" class="form-label">Please select year:</label>
                                                <select class="form-select" name="year" id="year">
                                                    <option value="2024" <?php echo isset($_GET['year']) && $_GET['year'] == '2024' ? 'selected' : '' ?>>2024</option>
                                                    <option value="2025" <?php echo isset($_GET['year']) && $_GET['year'] == '2025' || !isset($_GET['searchUserByTime']) ? 'selected' : '' ?>>2025</option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="month" class="form-label">Please select month:</label>
                                                <div class="d-flex">
                                                    <select class="form-select me-2" name="month" id="month">
                                                        <option value="1" <?php echo (isset($_GET['month']) && $_GET['month'] == '1') || !isset($_GET['searchUserByTime']) ? 'selected' : '' ?>>January</option>
                                                        <option value="2" <?php echo isset($_GET['month']) && $_GET['month'] == '2' ? 'selected' : '' ?>>February</option>
                                                        <option value="3" <?php echo isset($_GET['month']) && $_GET['month'] == '3' ? 'selected' : '' ?>>March</option>
                                                        <option value="4" <?php echo isset($_GET['month']) && $_GET['month'] == '4' ? 'selected' : '' ?>>April</option>
                                                        <option value="5" <?php echo isset($_GET['month']) && $_GET['month'] == '5' ? 'selected' : '' ?>>May</option>
                                                        <option value="6" <?php echo isset($_GET['month']) && $_GET['month'] == '6' ? 'selected' : '' ?>>June</option>
                                                        <option value="7" <?php echo isset($_GET['month']) && $_GET['month'] == '7' ? 'selected' : '' ?>>July</option>
                                                        <option value="8" <?php echo isset($_GET['month']) && $_GET['month'] == '8' ? 'selected' : '' ?>>August</option>
                                                        <option value="9" <?php echo isset($_GET['month']) && $_GET['month'] == '9' ? 'selected' : '' ?>>September</option>
                                                        <option value="10" <?php echo isset($_GET['month']) && $_GET['month'] == '10' ? 'selected' : '' ?>>October</option>
                                                        <option value="11" <?php echo isset($_GET['month']) && $_GET['month'] == '11' ? 'selected' : '' ?>>November</option>
                                                        <option value="12" <?php echo isset($_GET['month']) && $_GET['month'] == '12' ? 'selected' : '' ?>>December</option>
                                                    </select>
                                                    <button class="btn btn-outline-success" type="submit" name="searchUserByTime"><i class="bi bi-search"></i></button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <h6>Number of User by Type Categorised by Month and Year</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart4" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- branch -->
                    <div class="rounded-3 p-4 bg-white mb-4 shadow-sm mb-1">
                        <div class="row mb-3">
                            <h5>Branch Statistics</h5>
                        </div>

                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-4">
                            <div class="col-lg-4 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Number of Branches</h6>

                                    <p class="fs-3"></p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Number of Orders</h6>

                                    <p class="fs-3"></p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Sales</h6>

                                    <p class="fs-3"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-1">
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Sales by Branch</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart1" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Sales Over Time</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="chart2" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- package -->
                    <div class="rounded-3 p-4 bg-white mb-4 shadow-sm mb-1">
                        <div class="row mb-3">
                            <h5>Package Statistics</h5>
                        </div>

                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-4">
                            <div class="col-lg-12 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Total Number of Packages</h6>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM printingpackage");
                                    $stmt->execute();
                                    $package = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    ?>
                                    <p class="fs-3"><?php echo count($package) ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-between align-items-stretch mb-lg-1">
                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <h6>Number of Available Packages by Branch</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="packageChart1" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12 d-flex flex-column mb-sm-4 mb-lg-0">
                                <div class="rounded-3 p-4 bg-white border border-2 flex-fill">
                                    <div class="mb-4">
                                        <form action="./adminDashboard.php" method="get">
                                            <label for="type" class="mb-2">Please select a branch: </label>
                                            <div class="d-flex">
                                                <select class="form-select me-2" name="branch">
                                                    <option value="overall" <?php echo (isset($_GET['branch']) && $_GET['branch'] == 'overall') ? 'selected' : '' ?>>Overall</option>
                                                    <?php
                                                    $stmt = $conn->prepare("SELECT Name FROM branch");
                                                    $stmt->execute();
                                                    $branches = $stmt->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($branches as $branch):
                                                    ?>
                                                        <option value="<?php echo $branch->Name ?>" <?php echo isset($_GET['branch']) && $_GET['branch'] == $branch->Name ? 'selected' : '' ?>><?php echo $branch->Name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button class="btn btn-outline-success" type="submit" name="searchPackagePopularity"><i class="bi bi-search"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                    <h6>Package Popularity Categorised by Branch</h6>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="packageChart2" style="width:100%; max-height:280px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- for active nav item -->
    <script>
        document.getElementById('dashboard').classList.add('is-active');
    </script>

    <!-- user chart 1 -->
    <?php
    $stmt = $conn->prepare("SELECT branch.Name AS branchName, COUNT(staff.StaffID) as staffCount
                            FROM staff
                            JOIN branch on staff.BranchID = branch.BranchID
                            GROUP BY branch.Name");
    $stmt->execute();
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $branchNames = [];
    $staffCounts = [];

    foreach ($staffs as $staff) {
        $branchNames[] = $staff['branchName'];
        $staffCounts[] = $staff['staffCount'];
    }
    ?>

    <script>
        const chart1 = document.getElementById('chart1');

        new Chart(chart1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($branchNames) ?>,
                datasets: [{
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: <?php echo json_encode($staffCounts) ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Branch'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Staff'
                        }
                    }
                }
            }
        });
    </script>

    <!-- user chart 2 -->
    <?php
    $stmt = $conn->prepare("SELECT VerificationStatus, COUNT(CustomerID) as customerCount
                            FROM customer
                            GROUP BY VerificationStatus");
    $stmt->execute();
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $customerStatus = [];
    $customerCount = [];

    foreach ($customers as $customer) {
        $customerStatus[] = $customer['VerificationStatus'];
        $customerCount[] = $customer['customerCount'];
    }
    ?>

    <script>
        const chart2 = document.getElementById('chart2');

        new Chart(chart2, {
            plugins: [ChartDataLabels],
            type: 'pie',
            data: {
                labels: <?php echo json_encode($customerStatus) ?>,
                datasets: [{
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: <?php echo json_encode($customerCount) ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        display: true,
                        color: '#black',
                        font: {
                            size: 14,
                        }
                    }
                }
            }
        });
    </script>

    <!-- user chart 3 -->
    <?php
    if (isset($_GET['searchUserByType']) && $_GET['type'] != 'all') {
        //clicked search button and type not equals all
        $role = $_GET['type'];

        try {
            $stmt = $conn->prepare('SELECT COUNT(UserID) as userCount, DATE(CreatedAt) as date
                                    FROM user 
                                    WHERE Role = :role
                                    GROUP BY DATE(CreatedAt) ASC');
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            $usersByType = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $date = [];
            $userCount = [];

            foreach ($usersByType as $type) {
                $date[] = $type['date'];
                $userCount[] = $type['userCount'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        //not clicked search button, show type equals all users
        try {
            $stmt = $conn->prepare('SELECT COUNT(UserID) as userCount, DATE(CreatedAt) as date
                                    FROM user 
                                    GROUP BY DATE(CreatedAt) ASC');
            $stmt->execute();
            $usersByType = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $date = [];
            $userCount = [];

            foreach ($usersByType as $type) {
                $date[] = $type['date'];
                $userCount[] = $type['userCount'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>

    <script>
        const chart3 = document.getElementById('chart3');

        new Chart(chart3, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($date) ?>,
                datasets: [{
                    label: "User Count",
                    backgroundColor: "#FF6384",
                    borderColor: "black",
                    data: <?php echo json_encode($userCount) ?>,
                    fill: false
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of User'
                        }
                    }
                }
            }
        });
    </script>

    <!-- user chart 4 -->
    <?php
    $userCount = [];
    $role = [];

    if (isset($_GET['searchUserByTime']) && $_GET['year'] != '2025' && $_GET['month'] != '1') {
        //clicked search button and not january 2025
        $year = $_GET['year'];
        $month = $_GET['month'];

        try {
            $stmt = $conn->prepare('SELECT COUNT(UserID) as userCount, Role
                                    FROM user
                                    WHERE YEAR(CreatedAt) = :year AND MONTH(CreatedAt) = :month AND Role IN ("customer", "staff")
                                    GROUP BY Role');
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':month', $month);
            $stmt->execute();
            $usersByTime = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($usersByTime as $time) {
                $role[] = $time['Role'];
                $userCount[] = $time['userCount'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        //not clicked search button, show january 2025
        try {
            $stmt = $conn->prepare('SELECT COUNT(UserID) as userCount, Role
                                    FROM user
                                    WHERE YEAR(CreatedAt) = 2025 AND MONTH(CreatedAt) = 1 AND Role IN ("customer", "staff")
                                    GROUP BY Role');
            $stmt->execute();
            $usersByTime = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($usersByTime as $time) {
                $role[] = $time['Role'];
                $userCount[] = $time['userCount'];
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    ?>

    <script>
        const chart4 = document.getElementById('chart4');

        new Chart(chart4, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($role) ?>,
                datasets: [{
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: <?php echo json_encode($userCount) ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'User Type'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of User'
                        }
                    }
                }
            }
        });
    </script>

    <!-- package chart 1 -->
    <?php
    $stmt = $conn->prepare("SELECT branch.Name as branchName, COUNT(printingpackage.PackageID) as packageCount
                            FROM printingpackage
                            JOIN branch on printingpackage.BranchID = branch.BranchID
                            WHERE printingpackage.Availability = 'Available'
                            GROUP BY branch.Name");
    $stmt->execute();
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $branchNames = [];
    $packageCount = [];

    foreach ($packages as $package) {
        $branchNames[] = $package['branchName'];
        $packageCount[] = $package['packageCount'];
    }
    ?>

    <script>
        const packageChart1 = document.getElementById('packageChart1');

        new Chart(packageChart1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($branchNames) ?>,
                datasets: [{
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: <?php echo json_encode($packageCount) ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Branch'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Package'
                        }
                    }
                }
            }
        });
    </script>

    <!-- package chart 2 -->
    <?php
    $packageNames = [];
    $packageSum = [];

    if (isset($_GET['searchPackagePopularity']) && $_GET['branch'] != "overall") {
        // Specific branch query
        $branch = $_GET['branch'];

        try {
            $stmt = $conn->prepare("SELECT printingpackage.Name as packageName, SUM(orderprintingpackage.quantity) as packageSum
                                    FROM orderprintingpackage
                                    JOIN printingpackage ON printingpackage.packageID = orderprintingpackage.packageID
                                    JOIN branch ON printingpackage.branchID = branch.BranchID
                                    WHERE branch.Name = :branch
                                    GROUP BY printingpackage.Name");
            $stmt->bindParam(':branch', $branch);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $packageNames[] = $result['packageName'];
                $packageSum[] = $result['packageSum'];
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    } else {
        // Overall query
        try {
            $stmt = $conn->prepare("SELECT printingpackage.Name as packageName, SUM(orderprintingpackage.quantity) as packageSum
                                    FROM orderprintingpackage
                                    JOIN printingpackage ON printingpackage.packageID = orderprintingpackage.packageID
                                    GROUP BY printingpackage.Name");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $packageNames[] = $result['packageName'];
                $packageSum[] = $result['packageSum'];
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
    ?>

    <script>
        const packageChart2 = document.getElementById('packageChart2');

        new Chart(packageChart2, {
            plugins: [ChartDataLabels],
            type: 'polarArea',
            data: {
                labels: <?php echo json_encode($packageNames) ?>,
                datasets: [{
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF"],
                    data: <?php echo json_encode($packageSum) ?>,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        display: true,
                        color: '#black',
                        font: {
                            size: 14,
                        },
                    }
                },
            }
        });
    </script>
</body>

</html>