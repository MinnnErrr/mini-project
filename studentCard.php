<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  try {
    $imgCard = file_get_contents($_FILES['imgCard']['tmp_name']);
    $stmt = $conn->prepare("UPDATE customer SET StudentCard = :StudentCard WHERE UserID = :user_id");
    $stmt->bindParam(':StudentCard', $imgCard);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
  } catch (PDOException $e) {
    error_log(message: "Database Error: " . $e->getMessage());
    $_SESSION['signupError'] = $e->getMessage();
    header('location: registration.php');
  }
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
</head>


<body class="bg-body-secondary bg-opacity-50">

    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require 'customerSidebar.php' ?>

            <div class="template">
                <div class="form">
                    <form method='post' action='' enctype='multipart/form-data'>
                        <div class="title">Uplaod Student Card</div>

                        <div class="input-box">
                            <div class="photo"><img  alt="" id="imageStudent"></div>
                            <div class="file">
                                <input id="id-image-input" type="file" name="imgCard" required>
                            </div>
                        </div>

                        <div class="button-template">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
            <?php require 'footer.php' ?>

        </div>
    </div>
    <script src="studentCard.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>