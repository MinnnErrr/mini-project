<?php
require 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']); // Convert to int
    $orderID = intval($_POST['order_id']);
    $action = $_POST['action'];

    // Connect to the database
    $link = mysqli_connect("localhost", "root", "", "mini_project") or die("Could not connect: " . mysqli_connect_error());

    switch ($action) {
        case 'delete':
            // Delete order
            $query = "DELETE FROM `order` WHERE `OrderID` = $orderID AND `Status` NOT IN ('Order Complete', 'Collected')";
            if (mysqli_query($link, $query)) {
                header('location:manageprinting.php');
            } else {
                echo "Error deleting order: " . mysqli_error($link);
            }
            break;

        case 'generate_invoice':
            // Count the number of invoices for the given OrderID in the invoice table.
            $checkQuery = "SELECT COUNT(*) AS InvoiceCount FROM `invoice` WHERE `OrderID` = $orderID"; 
            $checkResult = mysqli_query($link, $checkQuery);
            $row = mysqli_fetch_assoc($checkResult);

            // if an invoice already exists for the order
            if ($row['InvoiceCount'] > 0) {
                // Redirect to the existing invoice page
                header("Location: invoice.php?orderID=$orderID");
                exit();
            } else {
                // Insert a new invoice if not already present
                $query = "INSERT INTO `invoice` (`OrderID`, `InvoiceDate`, `TotalInvoice`)
                        SELECT $orderID, NOW(), `TotalPrice` FROM `order` WHERE `OrderID` = $orderID";
                if (mysqli_query($link, $query)) {
                    header("Location: invoice.php?orderID=$orderID");
                    exit();
                } else {
                    echo "Error generating invoice: " . mysqli_error($link);
                }
            }
            break;
        
        case 'accept_order':
            // Mark as "Accepted"
            $query = "UPDATE `order` SET `Status` = 'Accepted' , 
            `StaffID` = (SELECT `StaffID` FROM `staff` WHERE `UserID` = $user_id) 
            WHERE `OrderID` = $orderID";
            if (mysqli_query($link, $query)) {
                  header('location:manageprinting.php');
            } else {
                echo "Error updating order: " . mysqli_error($link);
            }
            break;

        case 'complete_order':
            // Mark as "Order Complete"
            $query = "UPDATE `order` SET `Status` = 'Order Complete' WHERE `OrderID` = $orderID";
            if (mysqli_query($link, $query)) {
                header('location:manageprinting.php');
            } else {
                echo "Error updating order: " . mysqli_error($link);
            }
            break;

        case 'mark_collected':
            // Mark as "Collected"
            $query = "UPDATE `order` SET `Status` = 'Collected' WHERE `OrderID` = $orderID";
            if (mysqli_query($link, $query)) {
                header('location:manageprinting.php');
            } else {
                echo "Error updating order: " . mysqli_error($link);
            }
            break;

            case 'deleteD':
                // Delete order
                $query = "DELETE FROM `order` WHERE `OrderID` = $orderID AND `Status` NOT IN ('Order Complete', 'Collected')";
                if (mysqli_query($link, $query)) {
                    header('location:staffDashboard.php');
                } else {
                    echo "Error deleting order: " . mysqli_error($link);
                }
                break;

            case 'accept_orderD':
                // Mark as "Accepted"
                $query = "UPDATE `order` SET `Status` = 'Accepted' , 
                    `StaffID` = (SELECT `StaffID` FROM `staff` WHERE `UserID` = $user_id) 
                     WHERE `OrderID` = $orderID";
                     
                if (mysqli_query($link, $query)) {
                      header('location:staffDashboard.php');
                } else {
                    echo "Error updating order: " . mysqli_error($link);
                }
                break;
    
            case 'complete_orderD':
                // Mark as "Order Complete"
                $query = "UPDATE `order` SET `Status` = 'Order Complete' WHERE `OrderID` = $orderID";
                if (mysqli_query($link, $query)) {
                    header('location:staffDashboard.php');
                } else {
                    echo "Error updating order: " . mysqli_error($link);
                }
                break;
    
            case 'mark_collectedD':
                // Mark as "Collected"
                $query = "UPDATE `order` SET `Status` = 'Collected' WHERE `OrderID` = $orderID";
                if (mysqli_query($link, $query)) {
                    header('location:staffDashboard.php');
                } else {
                    echo "Error updating order: " . mysqli_error($link);
                }
                break;
        default:
            echo "Invalid action.";
    }

    mysqli_close($link);

}
?>
