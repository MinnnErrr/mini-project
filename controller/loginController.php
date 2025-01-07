<?php
require "../dbconfig.php";
session_start();

//registered user signin
if (isset($_POST['signIn'])) {
    $emailOrName = $_POST['emailOrName'];
    $password = $_POST['password'];

    try {
        if ($emailOrName && $password) {
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
                        header('location:../adminDashboard.php');
                        exit;
                    } else if ($user['Role'] == 'staff') {
                        $_SESSION['role'] = 'staff';
                        header('location:../staffDashboard.php');
                        exit;
                    } else if ($user['Role'] == 'customer') {
                        $_SESSION['role'] = 'customer';
                        $stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :userid");
                        $stmt->bindParam(':userid', $user['UserID']);
                        $stmt->execute();
                        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

                        // check if user is verified
                        if ($customer['VerificationStatus'] == "pending") { // if user is not verified
                            if (!isset($customer['StudentCard'])) { // if user has not uploaded student card
                                header('location:../studentCard.php');
                            } else { // if user has not uploaded student card and is not verified
                                header('location:../waitingVerify.php');
                            }
                        } else { // if user is verified
                            header('location:../customerDashboard.php');
                        }

                        exit;
                    }
                } else {
                    $_SESSION['loginError'] = 'Wrong password. Please try again';
                    header('location:../login.php');
                }
            } else {
                $_SESSION['loginError'] = 'No user found. Please sign in as guest or contact administrator for registration';
                header('location:../login.php');
            }
        } else {
            $_SESSION['loginError'] = 'Please enter your username/email and password.';
            header('location:../login.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();

        $_SESSION['loginError'] = 'An error occurred while processing your request. Please try again later.';
        header('location:../login.php');
    }
}

//guest signin
if (isset($_POST['guestSignIn'])) {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $role = 'customer';
    $verificationStatus = "unregistered";

    try {
        if ($username && $phoneNumber && $email) {
            $stmt = $conn->prepare("INSERT INTO user (Email, Username, Role) VALUES (:email, :username, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            $_SESSION['user_id'] = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO customer (PhoneNumber, VerificationStatus, UserID) VALUES (:phoneNumber, :verificationStatus, :userID)");
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':verificationStatus', $verificationStatus);
            $stmt->bindParam(':userID', $_SESSION['user_id']);
            $stmt->execute();

            $_SESSION['customer_id'] = $conn->lastInsertId();
            $_SESSION['status'] = $verificationStatus;
            header('location:../order_management.php');
            exit;
        } else {
            $_SESSION['loginError'] = 'Please complete your details.';
            header('location:../guestLogin.php');
        }
    } catch (PDOException $e) {
        $_SESSION['loginError'] = $e->getMessage();
        header('location:../guestLogin.php');
    }
}


$conn = null;
