<?php
require '../dbconfig.php';

//create package
if (isset($_POST['createPackage'])) {
    $name = $_POST['packageName'];
    $description = $_POST['description'];
    $basePrice = $_POST['price'];
    $availability = $_POST['availability'];
    $branchID = $_POST['branch'];

    try {
        $stmt = $conn->prepare("SELECT * FROM printingpackage WHERE Name = :name AND BranchID = :branchID");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':branchID', $branchID);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            
            $stmt = $conn->prepare("INSERT INTO printingpackage (Name, Description, BasePrice, Availability, BranchID) VALUES (:name, :description, :basePrice, :availability, :branchID)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':basePrice', $basePrice);
            $stmt->bindParam(':availability', $availability);
            $stmt->bindParam(':branchID', $branchID);
            $stmt->execute();

            echo "
            <script>
                alert('Package created successfully.');
                location.href='../packageManagement.php';
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

//update package
if (isset($_POST['updatePackage'])) {
    $name = $_POST['packageName'];
    $description = $_POST['description'];
    $basePrice = $_POST['basePrice'];
    $availability = $_POST['availability'];
    $branchID = $_POST['branch'];
    $packageID = $_POST['packageID'];

    try {
        $stmt = $conn->prepare("UPDATE printingpackage SET Name = :name, Description = :description, BasePrice = :basePrice, Availability = :availability, BranchID = :branchID WHERE PackageID = :packageID");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':basePrice', $basePrice);
        $stmt->bindParam(':availability', $availability);
        $stmt->bindParam(':branchID', $branchID);
        $stmt->bindParam(':packageID', $packageID);
        $stmt->execute();

        echo "
        <script>
            alert('Package updated successfully.');
            location.href='../viewPackage.php?id=$packageID';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

//delete branch
if (isset($_POST['deletePackage'])) {
    $packageID = $_POST['packageID'];

    try {
        $stmt = $conn->prepare("DELETE FROM printingpackage WHERE PackageID = :packageID");
        $stmt->bindParam(':packageID', $packageID);
        $stmt->execute();

        echo "
        <script>
            alert('Package deleted successfully.');
            location.href='../packageManagement.php';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
