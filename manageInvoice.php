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
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Get the updated data from the form
                $modifypackageID =$_POST['package']; 
                $modifyQty = $_POST['quantity']; 
                $modifypropertyID1 = $_POST['properties1'];
                $modifypropertyID2 = $_POST['properties2']; 
                $modifypropertyID3 = $_POST['properties3']; 
                $modifypropertyID4 = $_POST['properties4']; 
    
                $i=0;
                $query2 = "SELECT OrderPackageID FROM orderprintingpackage WHERE OrderID = $orderID";
                $result2 = mysqli_query($link, $query2);
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    $orderPackageID=$row2['OrderPackageID'];
                    $AllPackageID=$modifypackageID[$i];
                    $AllQty=$modifyQty[$i];
                    $AllPropertyID1=$modifypropertyID1[$i];
                    $AllPropertyID2=$modifypropertyID2[$i];
                    $AllPropertyID3=$modifypropertyID3[$i];
                    $AllPropertyID4=$modifypropertyID4[$i];

                // Update package and quantity
                $query = "UPDATE orderprintingpackage SET Quantity = $AllQty, PackageID = $AllPackageID  
                WHERE OrderID = $orderID AND OrderPackageID = $orderPackageID";
                mysqli_query($link, $query);
    
                $query4 = "UPDATE orderproperty SET PropertyID = $AllPropertyID WHERE OrderPackageID = $orderPackageID";
                mysqli_query($link, $query4);

                 // Delete existing properties for the package
                 $query3 = "DELETE FROM `orderproperty` WHERE `OrderPackageID` = $orderPackageID";
                 mysqli_query($link, $query3);
 
                 // Insert new properties
                if($AllPropertyID1>0){
                    $query4 = "INSERT INTO `orderproperty` (`OrderPackageID`, `PropertyID`) 
                               VALUES ($orderPackageID, $AllPropertyID1)";
                    mysqli_query($link, $query4);
                }
                if($AllPropertyID2>0){
                    $query4 = "INSERT INTO `orderproperty` (`OrderPackageID`, `PropertyID`) 
                               VALUES ($orderPackageID, $AllPropertyID2)";
                    mysqli_query($link, $query4);
                }
                if($AllPropertyID3>0){
                    $query4 = "INSERT INTO `orderproperty` (`OrderPackageID`, `PropertyID`) 
                               VALUES ($orderPackageID, $AllPropertyID3)";
                    mysqli_query($link, $query4);
                }
                if($AllPropertyID4>0){
                    $query4 = "INSERT INTO `orderproperty` (`OrderPackageID`, `PropertyID`) 
                               VALUES ($orderPackageID, $AllPropertyID4)";
                    mysqli_query($link, $query4);
                }
                    

                    ++$i;
                }
    
                    header("location:editInvoice.php?orderID=$orderID");
            }
               
                break;
        }

       
    }
?>
