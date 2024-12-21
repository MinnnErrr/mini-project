<?php
require "dbconfig.php";

session_start();

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == 'admin'){
        header('location: adminDashboard.php');
        exit;
    }elseif($_SESSION['role'] == 'staff'){
        header('location: staffDashboard.php');
        exit;
    }elseif($_SESSION['role'] == 'customer'){
        header('location: customerDashboard.php');
        exit;
    }
}

if (isset($_POST['signIn'])) {
    $emailOrName = $_POST['emailOrName'];
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE Username = :emailOrName OR Email = :emailOrName");
        $stmt->bindParam(':emailOrName', $emailOrName);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['Password'])) {
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['username'] = $user['Username'];

                if ($user['Role'] == 'admin') {
                    $_SESSION['role'] = 'admin';
                    header('location:adminDashboard.php');
                    exit;
                } else if ($user['Role'] == 'staff') {
                    $_SESSION['role'] = 'staff';
                    header('location:staffDashboard.php');
                    exit;
                } else if ($user['Role'] == 'customer') {
                    $_SESSION['role'] = 'customer';
                    $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :userid");
                    $stmt->bindParam(':userid', $user['UserID']);
                    $stmt->execute();
                    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
                    if(!isset($customer['StudentCard'])){
                        header('location:studentCard.php');
                    }
                    else{
                        header('location:customerDashboard.php');
                    }
                
                   
                    exit;
                }
            } else {
                $_SESSION['loginError'] = 'Wrong password. Please try again';
            }
        } else {
            $_SESSION['loginError'] = 'No user found. Please sign in as guest of contact administrator';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();

        $_SESSION['loginError'] = 'An error occurred while processing your request. Please try again later.';
    }
}
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row vh-100">
            <!--left-->
            <div class="col justify-content-center align-items-center d-flex">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <img src="./RapidPrintSquare.png" alt="RapidPrint Logo" class="img-fluid" style="max-width: 20vw;">
                    </div>
                    <div class="col-12">
                        <p class="fs-5 text-center">Fast, Convenient, Affordable</p>
                    </div>
                </div>
            </div>
            <!--right-->
            <div class="col-12 col-lg-6 bg-body-tertiary justify-content-center align-items-center d-flex flex-column">
                <form action="" method="post" class="w-75">
                    <h2 class="mb-4">USER LOGIN</h2>
                    <?php if (isset($_SESSION['loginError'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['loginError']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['loginError']);
                    endif;
                    ?>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="emailOrName" placeholder="">
                        <label for="floatingInput">Email Address/Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" placeholder="">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="btn btn-dark w-100 py-2 mb-3" type="submit" name="signIn">Sign in</button>
                    <button class="btn btn-light w-100 py-2" type="submit" name="guestSignIn">Sign in as guest</button>
                </form>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>