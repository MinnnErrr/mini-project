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
    <title>Branch Management</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <!-- <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/af-2.7.0/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/rg-1.5.1/sb-1.8.1/sp-2.3.3/datatables.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.8/b-3.2.0/r-3.0.3/rg-1.5.1/sc-2.4.3/sb-1.8.1/sp-2.3.3/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./tablePagination.css">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <?php require 'adminSidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container-fluid min-vh-100 p-4">

                    <div class="bg-white p-5 rounded-3 shadow-sm">
                        <div class="d-flex justify-content-between pb-3">
                            <h4>Koperasi Branches</h4>
                            <button class="btn btn-sm btn-secondary" onclick="location.href='./addBranch.php'">
                                <i class="bi bi-plus-circle me-1"></i>
                                ADD BRANCH
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover w-100" id="branchTable">
                                <thead>
                                    <tr>
                                        <th width="10%" scope="col" class="text-start">No.</th>
                                        <th scope="col">Branch Name</th>
                                        <th width="20%" scope="col">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $conn->prepare('SELECT * FROM branch ORDER BY branch.BranchID DESC');
                                    $stmt->execute();

                                    $branches = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    $i = 1;
                                    foreach ($branches as $branch):
                                    ?>
                                        <tr>
                                            <th scope="row" class="text-start"><?php echo $i ?></th>
                                            <td><?php echo $branch->Name ?></td>
                                            <td>
                                                <div class="d-flex">
                                                    <button class="btn btn-secondary me-4" onclick="location.href='./viewBranch.php?id=<?php echo $branch->BranchID ?>'">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?php echo $branch->BranchID ?>" name="deleteBranch">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="delete<?php echo $branch->BranchID ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel<?php echo $branch->BranchID ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5">Delete</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete branch <?php echo $branch->Name ?>?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Back</button>
                                                        <form action="./controller/branchController.php" method="post">
                                                            <input type="hidden" name="branchID" value="<?php echo $branch->BranchID ?>">
                                                            <button type="submit" class="btn btn-danger" name="deleteBranch">Confirm</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                        $i++;
                                    endforeach
                                    ?>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.1.8/af-2.7.0/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/rg-1.5.1/sb-1.8.1/sp-2.3.3/datatables.min.js"></script> -->
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.1.8/b-3.2.0/r-3.0.3/rg-1.5.1/sc-2.4.3/sb-1.8.1/sp-2.3.3/datatables.min.js"></script>

    <script>
        document.getElementById('branch').classList.add('is-active');
    </script>
    <script>
        new DataTable('#branchTable');
    </script>
</body>

</html>