<?php
require "../dbconfig.php";

/**
 * ./ current folder
 * ../ previous folder
 */

//create branch
if (isset($_POST['createBranch'])) {
    $name = $_POST['branchName'];
    $address = $_POST['branchAddress'];
    $contactNumber = $_POST['branchContact'];

    try {
        $stmt = $conn->prepare("SELECT * FROM branch WHERE Name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            //branch bot exist, insert new branch
            $stmt = $conn->prepare("INSERT INTO branch (Name, Address, ContactNumber) VALUES (:name, :address, :contactNumber)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':contactNumber', $contactNumber);
            $stmt->execute();

            echo "
            <script>
                alert('Branch added successfully.');
                location.href='../branchManagement.php';
            </script>";
            exit;
        } else {
            echo "
            <script>
                alert('Branch already exists.');
                location.href='../addBranch.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//update branch
if (isset($_POST['updateBranch'])) {
    $name = $_POST['branchName'];
    $address = $_POST['branchAddress'];
    $contactNumber = $_POST['branchContact'];
    $branchID = $_POST['branchID'];

    try {
        $stmt = $conn->prepare("UPDATE branch SET Name = :name, Address = :address, ContactNumber = :contactNumber WHERE BranchID = $branchID");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':contactNumber', $contactNumber);
        $stmt->execute();

        echo "
        <script>
            alert('Branch updated successfully.');
            location.href='../viewBranch.php?id=" . $branchID . "';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//delete branch
if (isset($_POST['deleteBranch'])) {
    $branchID = $_POST['branchID'];

    try {
        $stmt = $conn->prepare("DELETE FROM branch WHERE BranchID = $branchID");
        $stmt->execute();

        echo "
        <script>
            alert('Branch deleted successfully.');
            location.href='../branchManagement.php';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$conn = null;
