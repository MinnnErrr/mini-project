<div class="col-lg-2 border-end bg-body">
    <!-- Sidebar -->
    <div class="offcanvas-lg offcanvas-start position-fixed p-lg-2" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">Admin Panel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body overflow-hidden">
            <!-- Navigation Links -->
            <ul class="nav flex-column d-flex justify-content-between vh-100 overflow-hidden">
                <div>
                    <li class="nav-item mt-lg-3">
                        <a class="nav-link is-dark" id="dashboard" href="adminDashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="branch" href="branchManagement.php">Branch Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="package" href="packageManagement.php">Package Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="user" href="manageUser.php">User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="profile" href="viewAdminPersonalProfile.php">My Profile</a>
                    </li>
                </div>

                <div class="mb-5 pb-5">
                    <li>
                        <button class="btn w-100 btn-dark rounded-3" onclick="location.href='logout.php'">
                            Log Out
                        </button>
                    </li>
                </div>
            </ul>


        </div>
    </div>
</div>