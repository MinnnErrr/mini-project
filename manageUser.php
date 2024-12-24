<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
  header('location:login.php');
}
$stmt = $conn->prepare("SELECT * FROM user");
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./main.css">
  <link rel="stylesheet" href="manageUser.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
</head>


<body class="bg-body-secondary bg-opacity-50">

  <?php require 'navbar.php' ?>

  <div class="container-fluid">
    <div class="row">
      <?php require 'adminSidebar.php' ?>
      <div class="col-sm-12 col-lg-10">
        <div class="container min-vh-100 p-4">
          <div class="template">

            <div class="input-search">
              <input type="text" placeholder="search">
              <button type="button">Search</button>
            </div>
            <button class="add-new-user"><a href="registration.php">Add New User</a></button>

          </div>
          <div class="font-[sans-serif] overflow-x-auto ml-50px">
            <table class="min-w-full bg-white">
              <thead class="whitespace-nowrap">
                <tr>

                  <th class="p-4 text-left text-sm font-semibold text-black">
                    User
                  </th>
                  <th class="p-4 text-left text-sm font-semibold text-black">
                    Role
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-gray-400 inline cursor-pointer ml-2"
                      viewBox="0 0 401.998 401.998">
                      <path
                        d="M73.092 164.452h255.813c4.949 0 9.233-1.807 12.848-5.424 3.613-3.616 5.427-7.898 5.427-12.847s-1.813-9.229-5.427-12.85L213.846 5.424C210.232 1.812 205.951 0 200.999 0s-9.233 1.812-12.85 5.424L60.242 133.331c-3.617 3.617-5.424 7.901-5.424 12.85 0 4.948 1.807 9.231 5.424 12.847 3.621 3.617 7.902 5.424 12.85 5.424zm255.813 73.097H73.092c-4.952 0-9.233 1.808-12.85 5.421-3.617 3.617-5.424 7.898-5.424 12.847s1.807 9.233 5.424 12.848L188.149 396.57c3.621 3.617 7.902 5.428 12.85 5.428s9.233-1.811 12.847-5.428l127.907-127.906c3.613-3.614 5.427-7.898 5.427-12.848 0-4.948-1.813-9.229-5.427-12.847-3.614-3.616-7.899-5.42-12.848-5.42z"
                        data-original="#000000" />
                    </svg>
                  </th>

                  <th class="p-4 text-left text-sm font-semibold text-black">
                    Action
                  </th>
                </tr>
              </thead>

              <tbody class="whitespace-nowrap">

                <?php
                require 'retrieveUser.php';
                ?>

              </tbody>
            </table>
          </div>
        </div>

        <?php require 'footer.php' ?>

      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <script src="manageUser.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('user').classList.add('is-active');
  </script>
</body>

</html>