<?php
require 'dbconfig.php';

if (isset($_GET['package_id'])) {
    $package_id = $_GET['package_id'];
    $query = "SELECT * FROM packageproperty WHERE PackageID = :package_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':package_id', $package_id, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($categories);
}
?>
