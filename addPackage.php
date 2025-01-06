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
    <title>Add Package</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">

            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    <div class="border rounded-3 p-4 bg-white col-lg-6 mx-auto">
                        <h4 class="pb-3">Add Package</h4>
                        <form action="./controller/packageController.php" method="post">
                            <div class="mb-3">
                                <label for="packageName" class="form-label">Package name</label>
                                <input type="text" class="form-control" name="packageName" id="packageName" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Base Price (RM)</label>
                                <input type="text" class="form-control" name="price" id="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="availability" class="form-label">Availability</label>
                                <select id="availability" class="form-select" name="availability" required>
                                    <option value="Available">Available</option>
                                    <option value="Unavailable">Unavailable</option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label for="branch" class="form-label">Branch</label>
                                <select id="branch" class="form-select" name="branch" required>

                                    <?php
                                    $stmt = $conn->prepare('SELECT * FROM branch');
                                    $stmt->execute();

                                    $branches = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($branches as $branch):
                                    ?>

                                    <option value="<?php echo $branch->BranchID ?>"><?php echo $branch->Name ?></option>    

                                    <?php endforeach; ?>

                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark me-3 w-100" name="createPackage">Create</button>
                                <a href="./packageManagement.php" class="btn btn-outline-dark ms-3 w-100">Back</a>
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
        document.getElementById('package').classList.add('is-active');
    </script>
</body>

</html>