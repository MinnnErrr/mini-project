<!--do not edit this template-->
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
    <!--your page title-->
    <title></title>

    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="">
    <!-- Use this if local files are not working -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="addMoney.css">

</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <!--change the sidebar file name-->
            <?php require 'customerSideBar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4 d-flex justify-content-center align-items-center">

                    <div class="template-add-money p-4" >
                        <h4 style="margin-bottom: 50px;">Add Money to membership card</h4>
                        <div>
                        <form action="membershipCheckOut.php" method="post">
                            <div data-mdb-input-init class="form-outline d-flex justify-content-center align-items-center"
                            style="width: 22rem;">
                            
                            <div style="margin-right: 8px;">RM</div>
                            <input name = "amount" id="postfix" placeholder="Please enter amount" type='text' id="form2"
                                class="form-control" />
                        
                            
                        </div>
                        <div class="d-flex justify-content-end" style="margin-top:10px">
                        <button class="btn btn-primary" name="addMoney">Add</button>
                        </form>
                        </div>
                        </div>
                        
                    </div>

                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
    document.getElementById('membership').classList.add('is-active');
    </script>
</body>

</html>