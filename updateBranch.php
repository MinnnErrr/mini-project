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
    <title>Update Branch</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <div class="col-lg-8 mx-auto border rounded-3 p-4 bg-white col-lg-6 mx-auto">

                        <h4 class="pb-3">Update Branch</h4>

                        <?php
                        $branchID = $_GET['id'];
                        $stmt = $conn->prepare("SELECT * FROM branch WHERE BranchID = '$branchID'");
                        $stmt->execute();

                        $branch = $stmt->fetch(PDO::FETCH_OBJ);
                        ?>

                        <form action="./controller/branchController.php" method="post">
                            <div class="mb-3 visually-hidden">
                                <label for="branchID" class="form-label">Branch ID</label>
                                <input type="text" class="form-control" name="branchID" id="branchID" value="<?php echo $branch->BranchID ?>">
                            </div>
                            <div class=" mb-3">
                                <label for="branchName" class="form-label">Branch name</label>
                                <input type="text" class="form-control" name="branchName" id="branchName" value="<?php echo $branch->Name ?>"">
                            </div>
                            <div class=" mb-3">
                                <label for="branchAddress" class="form-label">Address</label>
                                <textarea class="form-control" name="branchAddress" id="branchAddress"><?php echo $branch->Address ?></textarea>
                            </div>
                            <div class="mb-5">
                                <label for="branchContact" class="form-label">Contact number</label>
                                <input type="text" class="form-control" name="branchContact" id="branchContact" value="<?php echo $branch->ContactNumber ?>">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100" name="updateBranch">Save</button>
                                <a href="./viewBranch.php?id=<?php echo $branchID ?>" class="btn btn-outline-dark ms-3 w-100">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('branch').classList.add('is-active');
    </script>
</body>

</html>