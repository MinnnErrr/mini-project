<?php
require 'dbconfig.php';

$stmt = $conn->prepare("SELECT * FROM branch");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>