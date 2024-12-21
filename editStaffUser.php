<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}
if(isset($_GET['editUserID'])){
    $editUserID = $_GET['editUserID'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE UserID = :editUserID");
    $stmt->bindParam(':editUserID', $editUserID);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $Username = $user['Username'];
    $Email = $user['Email'];
    $Role = $user['Role'];
    $stmt = $conn->prepare("SELECT * FROM staff WHERE UserID = :editUserID");
    $stmt->bindParam(':editUserID', $editUserID);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
    $Position = $staff['Position'];
    print_r($staff);
}
if(isset($_POST['editStaffUser'])){
    $editUserID = $_GET['editUserID'];
    $editUsername = $_POST['Username'];
    $editEmail = $_POST['Email'];
    $editPosition = $_POST['Position'];
    $stmt = $conn->prepare("UPDATE user SET Username = :editUsername, Email = :editEmail WHERE UserID = :editUserID");
    $stmt->bindParam(':editUsername', $editUsername);
    $stmt->bindParam(':editEmail', $editEmail);
    $stmt->bindParam(':editUserID', $editUserID);
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE staff SET  Position = :editPosition WHERE UserID = :editUserID");
    $stmt->bindParam(':editPosition', $editPosition);
    $stmt->bindParam(':editUserID', $editUserID);
    $stmt->execute();
    header("Refresh:0");
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
    <link rel="stylesheet" href="CustomerProfile.css">
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
            <?php require 'sidebar.php' ?>

            <div class="profile-teamplate">
                <form action="" method="post" enctype="multipart/form-data">
                    <div>
                        <div class="bg-white overflow-hidden shadow rounded-lg border">
                            <div class="px-4 py-5 sm:px-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    User Profile
                                </h3>

                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200">
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Full name
                                        </dt>
                                        <input name="Username" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($Username, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>


                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Email address
                                        </dt>
                                        <input name="Email" type="text"
                                            class=" border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($Email, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>

                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Position
                                        </dt>
                                        <input name="Position" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($Position, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <div class="edit-button-template">
                            <button name="editStaffUser">Submit</button>
                        </div>
                    </div>
                </form>


            </div>


            <?php require 'footer.php' ?>
        </div>
    </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>