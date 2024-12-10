<?php
require 'dbconfig.php';

session_start();
// if($_SERVER["REQUEST_METHOD"] == "POST"){
if (isset($_POST["register"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

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
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);

            //execute statement
            $stmt->execute();

            $_SESSION['signupSuccess'] = 'Registration successful!';
            header('location: login.php');
        } else {
            $_SESSION['signupError'] = 'Email or username already exist. Please try with a different one.';
            header('location: registration.php');
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        $_SESSION['signupError'] = 'An error occurred while processing your request. Please try again later.';
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
    <title>Registration</title>
</head>

<body>
    <?php if (isset($_SESSION['signupError'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['signupError']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        unset($_SESSION['signupError']);
    endif;
    ?>

    <form action="" method="post">
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
    </form>
</body>

</html>