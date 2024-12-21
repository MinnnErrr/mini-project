<?php

use PDO;
require 'dbconfig.php';
session_start();
// if($_SERVER["REQUEST_METHOD"] == "POST"){
   



if (isset($_POST["register"])) {
        
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $phoneNumber = $_POST['phoneNumber'];
    $studentID = $_POST['studentID'];
    $position = $_POST['position'];
    $branchID = $_POST['branchID'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE Username = :username OR Email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // 只要是select都要fetch，其他的都到execute而已        

        if ($stmt->rowCount() < 1) { //如果在database有return不多过1行一样的user info(意思就是不存在database的话才proceed if()里面的东西)
            //prepare SQL statement
            $stmt = $conn->prepare("INSERT INTO user (Email, Password, Username, Role) VALUES (:email, :password, :username, :role)");
            //bind parameters
            
// $username = $_POST['name'];
// $email = $_POST['email'];
// $password = $_POST['password'];
// $role = $_POST['role'];

// $studentID = $_POST[“studentID”];

$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':email', $email);
            
            //execute statement
            $stmt->execute();
            if($role == 'customer'){
                $userID = $conn->lastInsertId(); // need fix later maybe have error
                $stmt = $conn->prepare("INSERT INTO customer(StudentID,UserID) VALUES (:studentID,  :userID)");
                $stmt->bindParam(':studentID', $studentID);
                $stmt->bindParam(':userID',  $userID); 
                $stmt->execute();
            }
            else if($role == 'staff'){
                $userID = $conn->lastInsertId();
                $stmt = $conn->prepare(query: "INSERT INTO staff(Position,UserID,BranchID) VALUES (:position,  :userID, :branchID)");
                $stmt->bindParam(':position', $position);
                $stmt->bindParam(':userID',  $userID); 
                $stmt->bindParam(':branchID',  $branchID); 
                $stmt->execute();
            }
            
            $_SESSION['signupSuccess'] = 'Registration successful!';
            header('location: login.php');
        } else {
            $_SESSION['signupError'] = 'Email or username already exist. Please try with a different one.';
            header('location: registration.php');
        }
    } catch (PDOException $e) {
        error_log(message: "Database Error: " . $e->getMessage());
        $_SESSION['signupError'] = $e->getMessage();
        header('location: registration.php');
    }

    exit();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="bg-body-secondary bg-opacity-50">

    <?php if (isset($_SESSION['signupError'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['signupError']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
        unset($_SESSION['signupError']);
    endif;
    ?>
    <?php require 'navbar.php' ?>

    <div class="container-fluid">
        <div class="row">
            <?php require 'sidebar.php' ?>
            <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">


                <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                        <form method="POST" action="#">
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium leading-5  text-gray-700">Name</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input id="name" name="name" placeholder="John Doe" type="text" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <div
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            </div>


                            <div class="mt-6">
                                <label for="phoneNumber" class="block text-sm font-medium leading-5 text-gray-700">
                                    Phone number
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input id="phoneNumber" name="phoneNumber" placeholder="012113123" type="text"
                                        required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <div
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                                    Email address
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input id="email" name="email" placeholder="user@example.com" type="email"
                                        required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                    <div
                                        class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                                    Role
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <select name="role" id="role"
                                        class=" w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                        <option value="" disabled selected>Select a role</option>
                                        <option value="customer">Customer</option>
                                        <option value="staff">Staff</option>
                                    </select>

                                </div>
                            </div>
                            <div class="mt-6 " id="studentIDTemplete">
                                <!-- <label for="ID" class=" block text-sm font-medium leading-5 text-gray-700 ">
                                    Student ID
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="studentID" name="studentID" type="text" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div> -->
                            </div>
                            <div class="mt-6 " id="positionTemplete">
                                <!-- <label for="position" class="block text-sm font-medium leading-5 text-gray-700">
                                    Position
                                </label>
                                <div class="mt-1 rounded-md shadow-sm" >
                                    <input id="position" name="position" type="text" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div> -->
                            </div>

                            <div class="mt-6 " id="branchIDTemplete">
                               
                            </div>
                            <div class="mt-6">
                                <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
                                    Password
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="password" name="password" type="password" required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div>
                            </div>



                            <div class="mt-6">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium leading-5 text-gray-700">
                                    Confirm Password
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                        required=""
                                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                </div>
                            </div>

                            <div class="mt-6">
                                <span class="block w-full rounded-md shadow-sm">
                                    <button type="submit" name="register" value="register"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                        Create account
                                    </button>
                                </span>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <?php require 'footer.php' ?>
        </div>

    </div>
    <script src="RegisterUser.js"></script>
    <!-- <form action="" method="post">
        Username:
        <input type="text" name="username">
        <br>
        Email:
        <input type="text" name="email">
        <br>
        Password:
        <input type="text" name="password">
        <br>
        Type:
        <select name="role" id="">
            <option value="admin">admin</option>
            <option value="customer">customer</option>
            <option value="staff">staff</option>
        </select>
        <br>
        <input type="submit" value="Register" name=register>
    </form> -->
</body>

</html>