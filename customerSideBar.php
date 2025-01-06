<div class="col-lg-2 border-end bg-body">
    <div class="offcanvas-lg offcanvas-start position-fixed p-lg-2" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Customer Panel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body overflow-hidden">
            <ul class="nav flex-column d-flex justify-content-between vh-100 overflow-hidden">
                <div class="mt-lg-3">
                    <?php if(isset($_SESSION['status']) != 'Unregistered'): ?>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="customerDashboard.php" id="customerDashboard">Dashboard</a>
                    </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link is-dark" href="order_management.php" id="orderManagement">Add Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="showOrder.php" id="showOrder">View Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="viewOrder.php" id="viewOrder">Checkout</a>
                    </li>

                    <?php if(isset($_SESSION['status']) != 'Unregistered'): ?>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="Membership.php" id="applyMembership">Membership Card</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php if(isset($_SESSION['status']) != 'Unregistered'): ?>
                    <li class="nav-item">
                        <a class="nav-link is-dark" href="viewPersonalProfile.php" id="customerProfile">Profile</a>
                    </li>
                    <?php endif; ?>
                   
                </div>

                <div class="mb-5 pb-5">
                    <li>
                        <button class="btn w-100 btn-dark rounded-3" onclick="location.href='logout.php'">
                        <?php 
                        if(isset($_SESSION['status']) != 'Unregistered'): 
                            echo "Log Out";
                        else:
                            echo "Back to Login" ;
                        endif;   
                        ?>
                        </button>
                    </li>
                </div>
            </ul>

        </div>
    </div>
</div>