<?php
require '../dbconfig.php';

//create package property
if (isset($_POST['createPackageProperty'])) {
    $name = $_POST['propertyName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $packageID = $_POST['packageID'];

    try {
        $stmt = $conn->prepare("SELECT * FROM printingpackage WHERE Name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            
            $stmt = $conn->prepare("INSERT INTO packageproperty (Category, Name, Price, PackageID) VALUES (:category, :name, :price, :packageID)");
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':packageID', $packageID);
            $stmt->execute();

            echo "
            <script>
                alert('Package property created successfully.');
                location.href='../viewPackage.php?id=$packageID';
            </script>";
            exit;
        } else {
            echo "
            <script>
                alert('Package already exists.');
                location.href='../addPackage.php';
            </script>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//update package property
if (isset($_POST['updatePackageProperty'])) {
    $name = $_POST['propertyName'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $packageID = $_POST['packageID'];
    $propertyID = $_POST['propertyID'];

    try {
        $stmt = $conn->prepare("UPDATE packageproperty SET Category = :category, Name = :name, Price = :price, PackageID = :packageID WHERE PropertyID = :propertyID");
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':packageID', $packageID);
        $stmt->bindParam(':propertyID', $propertyID);
        $stmt->execute();

        echo "
        <script>
            alert('Property updated successfully.');
            location.href='../viewPackage.php?id=$packageID';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//delete package property
if (isset($_POST['deletePackageProperty'])) {
    $propertyID = $_POST['propertyID'];
    $packageID = $_POST['packageID'];

    try {
        $stmt = $conn->prepare("DELETE FROM packageproperty WHERE PropertyID = :propertyID");
        $stmt->bindParam(':propertyID', $propertyID);
        $stmt->execute();

        echo "
        <script>
            alert('Property deleted successfully.');
            location.href='../viewPackage.php?id=$packageID';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}