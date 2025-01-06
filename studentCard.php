<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
include('uploadStudentCard.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--your page title-->
    <title></title> 
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="studentCard.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>


<body class="bg-light">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row vh-100">
            <!--change the sidebar file name-->
            <?php require 'verifySidebar.php' ?>

            <!--right content-->
            <div class="col-sm-12 col-lg-10">
                <div class="container min-vh-100 p-4">

                    
                <div class="template">
                <div class="form" >
                    <form method='post' action='' enctype='multipart/form-data'>
                        <div class="title">Uplaod Student Card</div>
                    
                        <div class="input-box">
                            <div class="photo"><img  alt="" id="imageStudent"></div>
                            <div class="file">
                                <input id="id-image-input" type="file" name="file" required>
                            </div>
                        </div>

                        <div class="button-template">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
                </div>

                <?php require 'footer.php' ?>
            </div>
        </div>
    </div>
    <script src="studentCard.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //change the id for every page according to the id in your sidebar. for example, the current page adminDashboard.php's id in adminSideBar is dashboard
        document.getElementById('dashboard').classList.add('is-active'); 
    </script>
</body>

</html>