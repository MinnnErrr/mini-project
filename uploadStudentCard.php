<?php
if (isset($_POST["submit"])) {
    $file = $_FILES["file"]["tmp_name"];
    $file_name = $_FILES["file"]["name"];
    $file_size = $_FILES["file"]["size"];
    $file_type = $_FILES["file"]["type"];
    $file_error = $_FILES["file"]["error"];
    $fileExt = explode(".", $file_name); //spliting the file name into an array based on "."
    $fileActualEct = strtolower(end($fileExt)); // finding the file extension (.jpeg, .png, .jpg)
    $allowed = array("jpg", "jpeg", "png"); 

    if (in_array($fileActualEct, $allowed)) { // if the file extension is in the allowed array
            if($file_error === 0){ // if there is no error
                if($file_size < 1000000){ // if the file size is less than 1MB
                    $fileNameNew = uniqid("", true).".".$fileActualEct; 
                    $fileDestination = "uploads/".$fileNameNew;
                    move_uploaded_file($file, $fileDestination);
                    try {
                        $stmt = $conn->prepare("UPDATE customer SET StudentCard = :StudentCard WHERE UserID = :user_id");
                        $stmt->bindParam(':StudentCard', $fileDestination);
                        $stmt->bindParam(':user_id', $user_id);
                        $stmt->execute();
                        header("location:login.php");
                      } catch (PDOException $e) {
                        error_log(message: "Database Error: " . $e->getMessage());
                        $_SESSION['signupError'] = $e->getMessage();
                        header('location: login.php');
                      }
                }
                else{
                    echo "file is too big";
                }
            }
            else{
                echo "there was an error uploading the file";
            }
    }
    else{
        echo "invalid file type";
    }

   
}

?>
