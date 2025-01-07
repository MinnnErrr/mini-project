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
    <title>View Branch</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSideBar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <div class="col-lg-8 mx-auto">
                        <div class="rounded-3 p-4 pt-3 pb-3 bg-gradient mb-4" style="color: #0f524f; background-color: #08c4b3;">
                            <h4>Branch Details</h4>
                        </div>

                        <div class="border rounded-3 p-4 bg-white mb-4">
                            <?php
                            $branchID = $_GET['id'];
                            $stmt = $conn->prepare("SELECT * FROM branch WHERE BranchID = '$branchID'");
                            $stmt->execute();

                            $branch = $stmt->fetch(PDO::FETCH_OBJ);
                            ?>

                            <form action="">
                                <div class="mb-3">
                                    <label for="branchName" class="form-label fw-bold">Branch name</label>
                                    <input type="text" value="<?php echo $branch->Name ?>" readonly class="form-control-plaintext" name="branchName" id="branchName">
                                </div>

                                <div class="mb-3">
                                    <label for="branchAddress" class="form-label fw-bold">Address</label>
                                    <textarea readonly class="form-control-plaintext" name="branchAddress" id="branchAddress"><?php echo $branch->Address ?></textarea>
                                </div>

                                <div class="mb-5">
                                    <label for="branchContact" class="form-label fw-bold">Contact number</label>
                                    <input type="text" value="<?php echo $branch->ContactNumber ?>" readonly class="form-control-plaintext" name="branchContact" id="branchContact">
                                </div>

                                <div class="d-flex justify-content-center">
                                    <a href="./updateBranch.php?id=<?php echo $branch->BranchID ?>" class="btn btn-outline-dark me-3 w-100">Edit</a>
                                    <a href="./branchManagement.php" class="btn btn-outline-dark ms-3 w-100">Back</a>
                                </div>
                            </form>
                        </div>

                        <div class="border rounded-3 p-4 bg-white">
                            <div class="mb-3">
                                <h6 class="fw-bold">Branch Executives</h6>
                                <p>You can add/edit the details at User Management</p>
                            </div>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare("SELECT * FROM branch 
                                                        JOIN staff ON staff.BranchID = branch.BranchID
                                                        JOIN user ON user.UserID = staff.UserID
                                                        WHERE branch.BranchID = '$branchID'
                                                        AND (staff.Position = 'Manager' OR staff.Position = 'Assistant Manager')");
                                    $stmt->execute();

                                    $staffs = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($staffs as $staff):
                                    ?>

                                        <tr>
                                            <td><?php echo $staff->Username ?></td>
                                            <td><?php echo $staff->PhoneNumber ?></td>
                                            <td><?php echo $staff->Position ?></td>
                                        </tr>

                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('branch').classList.add('is-active');
    </script>
</body>

</html>