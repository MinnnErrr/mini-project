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
            $query4="SELECT OrderPackageID FROM `orderprintingpackage` WHERE `OrderID` = $orderID"; 
            $result4 = mysqli_query($link, $query4);
            while ($row4 = mysqli_fetch_assoc($result4)) {
                $OrderPackageID = $row4['OrderPackageID'];
                $query3="DELETE FROM orderproperty WHERE OrderPackageID = $OrderPackageID";
                mysqli_query($link, $query3);

                $query2="DELETE FROM orderprintingpackage WHERE OrderID = $orderID";
                mysqli_query($link, $query2);
            }

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
                $query4="SELECT OrderPackageID FROM `orderprintingpackage` WHERE `OrderID` = $orderID"; 
                $result4 = mysqli_query($link, $query4);
                while ($row4 = mysqli_fetch_assoc($result4)) {
                    $OrderPackageID = $row4['OrderPackageID'];
                    $query3="DELETE FROM orderproperty WHERE OrderPackageID = $OrderPackageID";
                    mysqli_query($link, $query3);
    
                    $query2="DELETE FROM orderprintingpackage WHERE OrderID = $orderID";
                    mysqli_query($link, $query2);
                }
    
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

                case 'deleteReward':
                    // Get the StaffID for the logged-in user
                    $query = "SELECT s.StaffID AS StaffID 
                    FROM `staff` s
                    JOIN `user` u ON s.UserID = u.UserID
                    JOIN `branch` b ON b.BranchID = s.BranchID
                    WHERE u.UserID = $user_id";
                    $result = mysqli_query($link, $query);
                    $row = mysqli_fetch_assoc($result);

                    $StaffID = $row["StaffID"];

                    // Fetch the details of the order to be deleted
                    $orderQuery = "SELECT TotalPrice, Points, DATE_FORMAT(Date, '%Y-%m') AS OrderMonth 
                                   FROM `order` 
                                   WHERE OrderID = $orderID";
                    $orderResult = mysqli_query($link, $orderQuery);
                    
                    if ($orderResult && mysqli_num_rows($orderResult) > 0) {
                        $order = mysqli_fetch_assoc($orderResult);
                        $orderTotalPrice = $order['TotalPrice'];
                        $orderPoints = $order['Points'];
                        $orderMonth = $order['OrderMonth']; // Get the month of the order
                
                        // Deduct the order's contribution from MonthlySales
                        $updateRewardQuery = "
                            UPDATE `reward`
                            SET MonthlySales = MonthlySales - $orderTotalPrice,
                                Points = Points - $orderPoints
                            WHERE StaffID = $StaffID
                            AND DATE_FORMAT(Date, '%Y-%m') = '$orderMonth'";
                        mysqli_query($link, $updateRewardQuery) or die("Error updating rewards: " . mysqli_error($link));
                
                        // Recalculate Bonus and Points based on updated MonthlySales
                        $rewardQuery = "
                            SELECT MonthlySales
                            FROM `reward`
                            WHERE StaffID = $StaffID
                            AND DATE_FORMAT(Date, '%Y-%m') = '$orderMonth'";
                        $rewardResult = mysqli_query($link, $rewardQuery);
                        $reward = mysqli_fetch_assoc($rewardResult);
                        $updatedMonthlySales = $reward['MonthlySales'];
                
                        $bonus = 0;
                        $points = 0;
                        $description = "";
                
                        if ($updatedMonthlySales > 450) {
                            $bonus = 150;
                            $points = 40;
                            $description = "More than RM450";
                        } elseif ($updatedMonthlySales > 350) {
                            $bonus = 120;
                            $points = 30;
                            $description = "More than RM350";
                        } elseif ($updatedMonthlySales > 280) {
                            $bonus = 80;
                            $points = 20;
                            $description = "More than RM280";
                        } elseif ($updatedMonthlySales > 200) {
                            $bonus = 50;
                            $points = 10;
                            $description = "More than RM200";
                        }
                
                        // Update the recalculated Bonus, Points, and Description
                        $updateBonusQuery = "
                            UPDATE `reward`
                            SET Bonus = $bonus,
                                Points = $points,
                                Description = '$description'
                            WHERE StaffID = $StaffID
                            AND DATE_FORMAT(Date, '%Y-%m') = '$orderMonth'";
                        mysqli_query($link, $updateBonusQuery) or die("Error updating bonus: " . mysqli_error($link));
                
                        // Delete the order
                        $deleteQuery = "DELETE FROM `order` WHERE OrderID = $orderID";
                        if (mysqli_query($link, $deleteQuery)) {
                            header('location:showReward.php'); // Redirect back to the rewards page
                        } else {
                            echo "Error deleting order: " . mysqli_error($link);
                        }
                    } else {
                        echo "Order not found.";
                    }
                    break;
                
        default:
            echo "Invalid action.";
    }

    mysqli_close($link);

}
?>
