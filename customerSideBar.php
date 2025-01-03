<?php
require "dbconfig.php";


$stmt = $conn->prepare("SELECT * FROM customer WHERE UserID = :userid"); 
$stmt->bindParam(':userid', $_SESSION['user_id']);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);// check if user is verified
$status = $customer["VerificationStatus"];
?>
<div class="col-lg-2 border-end bg-light">
    <div class="offcanvas-lg offcanvas-start position-fixed" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">RapidPrint</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column d-flex justify-content-between" style="height: 87dvh;">
                <div>
                    <?php
                    if($status == "unregistered"){
                        echo'<li class="nav-item">
                    <a class="nav-link is-dark"  id="orderManagement" href="order_management.php">Add Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link is-dark"  id="orderView"  href="showOrder.php">View Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link is-dark" id="checkout" href="viewOrder.php">Checkout</a>
                </li>';
                }else{
                    echo'
                     <li class="nav-item mt-lg-3">
                        <a class="nav-link is-dark" id="dashboard" href="customerDashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark"  id="orderManagement" href="order_management.php">Add Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark"  id="orderView"  href="showOrder.php">View Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="checkout" href="viewOrder.php">Checkout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="membership" href="membership.php">Membership Card</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="profile" href="CustomerProfile.php">Profile</a>
                    </li>
                    ';
                }
                    ?>
                   
                   
                </div>

                <div>
                    <li class="nav-item">
                        <div class="nav-link">
                            <button class="btn w-100 btn-outline-dark" onclick="location.href='logout.php'">
                                Log Out
                            </button>
                        </div>
                    </li>
                </div>
            </ul>

        </div>
    </div>
</div>
