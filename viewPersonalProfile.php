<?php
require 'dbconfig.php';

session_start();


$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}



    $stmt = $conn->prepare("SELECT * FROM user WHERE UserID = :viewUserID");
    $stmt->bindParam(':viewUserID', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $Username = $user['Username'];
    $Email = $user['Email'];

 if($_SESSION['role'] == "customer"){
    $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :viewUserID");
    $stmt->bindParam(':viewUserID', $user_id);
    $stmt->execute();
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    $StudentID = $customer['StudentID'];
    $phoneNumber= $customer['PhoneNumber'];
}
else if($_SESSION['role'] == "staff"){
    $stmt = $conn->prepare("SELECT * FROM staff WHERE UserID = :viewUserID");
    $stmt->bindParam(':viewUserID', $user_id);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
    $position = $staff['Position'];
    $phoneNumber = $staff['PhoneNumber'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin profile</title>
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
            <?php
            if($_SESSION['role'] == "customer"){
              require 'customerSidebar.php';
            }
            else if($_SESSION['role'] == "staff"){
                require 'staffSidebar.php';
            }
            else if($_SESSION['role'] == "admin"){
                require 'adminSidebar.php';
            }
            ?>
   
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
                                            value="<?php echo htmlspecialchars($Username, ENT_QUOTES, 'UTF-8'); ?>"
                                            disabled
                                            >
                                        </input>


                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Email address
                                        </dt>
                                        <input disabled name="Email" type="text"
                                            class=" border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($Email, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>

                                    </div>
                                    <?php if($_SESSION['role'] == "customer"): ?>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            StudentID
                                        </dt>
                                        <input disabled name="StudentID" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($StudentID, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            Phone number
                                        </dt>
                                        <input disabled name="phoneNumber" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($phoneNumber, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($_SESSION['role'] == "staff"): ?>
                                        <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                        Position
                                        </dt>
                                        <input disabled name="position" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>
                                    </div>
                                    <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                        Phone Number
                                        </dt>
                                        <input disabled name="phoneNumber" type="text"
                                            class="border border-gray-300 rounded-md p-2 mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                                            value="<?php echo htmlspecialchars($phoneNumber, ENT_QUOTES, 'UTF-8'); ?>">
                                        </input>
                                    </div>
                                        <?php endif; ?>
                                </dl>
                            </div>
                        </div>

                    </div>
                    <div class="edit-button-template ">
                    <button class="btn btn-light"><a href="editPersonalProfile.php" >Edit</a></button>
                    </div>
            </div>
        
            <?php require 'footer.php' ?>
        </div>
    </div>
    </div>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>