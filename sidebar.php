<div class="col-lg-2 border-end bg-light">
    <div class="offcanvas-lg offcanvas-start position-fixed" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasResponsiveLabel">RapidPrint</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvasResponsive" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column d-flex justify-content-between" style="height: 87dvh;">
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
                        <a class="nav-link is-dark" id="user" href="">User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link is-dark" id="profile" href="adminProfile.php">My Profile</a>
                    </li>
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