<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
  header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>User Management</title>
  <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./main.css">
  <link rel="stylesheet" href="manageUser.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <style type="text/tailwindcss">
    @layer utilities {
      .content-auto {
        content-visibility: auto;
      }
    }
  </style>
</head>


<body class="bg-light">

  <?php require 'navbar.php' ?>

  <div class="container-fluid">
    <div class="row vh-100">
      
      <?php require 'adminSideBar.php' ?>

      <!--right content-->
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
                <tr class="odd:bg-blue-50">

                  <td class="p-4 text-sm">
                    <div class="flex items-center cursor-pointer w-max">
                      <img src='https://readymadeui.com/profile_4.webp' class="w-9 h-9 rounded-full shrink-0" />
                      <div class="ml-4">
                        <p class="text-sm text-black">Gladys Jones</p>
                        <p class="text-xs text-gray-500 mt-0.5">gladys@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-black">
                    Admin
                  </td>

                  <td class="p-4">

                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                      <a href="editUser.php">Edit</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                      <a href="viewProfile.php">View</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete">
                      <a>Delete</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                      <a href="verifyUser.php">Verify</a>
                    </button>
                  </td>
                </tr>

                <tr class="odd:bg-blue-50">

                  <td class="p-4 text-sm">
                    <div class="flex items-center cursor-pointer w-max">
                      <img src='https://readymadeui.com/profile_5.webp' class="w-9 h-9 rounded-full shrink-0" />
                      <div class="ml-4">
                        <p class="text-sm text-black">Jennie Cooper</p>
                        <p class="text-xs text-gray-500 mt-0.5">jennie@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-black">
                    customer
                  </td>

                  <td class="p-4">

                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                      <a>Edit</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                      <a>View</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete">
                      <a>Delete</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                      <a>Verify</a>
                    </button>

                  </td>
                </tr>

                <tr class="odd:bg-blue-50">

                  <td class="p-4 text-sm">
                    <div class="flex items-center cursor-pointer w-max">
                      <img src='https://readymadeui.com/profile_3.webp' class="w-9 h-9 rounded-full shrink-0" />
                      <div class="ml-4">
                        <p class="text-sm text-black">Philip Steward</p>
                        <p class="text-xs text-gray-500 mt-0.5">philip@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-black">
                    customer
                  </td>

                  <td class="p-4">
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                      <a>Edit</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                      <a>View</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete">
                      <a>Delete</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                      <a>Verify</a>
                    </button>
                  </td>
                </tr>

                <tr class="odd:bg-blue-50">

                  <td class="p-4 text-sm">
                    <div class="flex items-center cursor-pointer w-max">
                      <img src='https://readymadeui.com/profile_2.webp' class="w-9 h-9 rounded-full shrink-0" />
                      <div class="ml-4">
                        <p class="text-sm text-black">Jorge Black</p>
                        <p class="text-xs text-gray-500 mt-0.5">jorge@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-black">
                    staff
                  </td>

                  <td class="p-4">
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                      <a>Edit</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                      <a>View</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete">
                      <a>Delete</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                      <a>Verify</a>
                    </button>
                  </td>
                </tr>

                <tr class="odd:bg-blue-50">

                  </td>
                  <td class="p-4 text-sm">
                    <div class="flex items-center cursor-pointer w-max">
                      <img src='https://readymadeui.com/profile_6.webp' class="w-9 h-9 rounded-full shrink-0" />
                      <div class="ml-4">
                        <p class="text-sm text-black">Evan Flores</p>
                        <p class="text-xs text-gray-500 mt-0.5">evan@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="p-4 text-sm text-black">
                    staff
                  </td>

                  <td class="p-4">
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="edit">
                      <a>Edit</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="view">
                      <a>View</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="delete">
                      <a id="deleteButton">Delete</a>
                    </button>
                    <button class="mr-4 text-blue-600 hover:text-blue-800 visited:text-purple-600" title="verify">
                      <a>Verify</a>
                    </button>
                  </td>
                </tr>
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

  <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('user').classList.add('is-active');
  </script>
  <script src="manageUser.js"></script>
</body>

</html>