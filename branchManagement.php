<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dahboard</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="adminDashboard.php">
                <img src="./RapidPrintIcon.png" alt="RapidPrint" width="40" class="d-inline-block">
                RapidPrint
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="adminDashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Branches Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="packageManagement.php">Packages Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adminProfile.php">Profile</a>
                    </li>
                </ul>
                <a href="logout.php">
                    <button class="btn btn-outline-dark">Log Out</button>
                </a>
            </div>
        </div>
    </nav>

    <h1>branches</h1>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>