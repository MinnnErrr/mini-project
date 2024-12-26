<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_id = intval($_POST['invoice_id']); // Convert to int
    $orderID = intval($_POST['order_id']);
    $action = $_POST['action'];

    // Connect to the database
    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

    switch ($action) {
        case 'delete':
            // Delete invoice
            $query = "DELETE FROM `invoice` WHERE `InvoiceID` = $invoice_id";
            if (mysqli_query($link, $query)) {
                header('location:manageprinting.php');
            } else {
                echo "Error deleting order: " . mysqli_error($link);
            }
            break;

        case 'editLocation':
                header("location:editInvoice.php?orderID=$orderID");
            break;

        case 'edit':
            // Edit invoice
            $query = "UPDATE `invoice` SET `Status` = 'Order Complete' WHERE `OrderID` = $orderID";
            if (mysqli_query($link, $query)) {
                header('location:manageprinting.php');
            } else {
                echo "Error deleting order: " . mysqli_error($link);
            }
            break;
        }

       
    }
?>
