<!--do not edit this template-->
<?php
require 'dbconfig.php';

session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
  header('location:login.php');
}
   require 'retrieveCustomerInfo.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Membership</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="membership.css">
    <link rel="stylesheet" href="membershipCard.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


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

            <?php require 'customerSidebar.php' ?>
            
            <div class="col-sm-12 col-lg-10">
                <!--right content-->
              

                <div class="row ">
                    <form  class="seach" action="totalPoints.php" method="post">
                    <input type="text" placeholder="Enter ID for search membership point" name="membershipID"></input>
                    <button name="searchTotalPoints">Search</button>
                    </form>
                </div>
                <div class="row template-Membership-detail">
                    <div class="col-lg-10 col-sm-9">
                        <table class="table  m-3  h-50">
                            <tbody>
                                <tr>
                                    <th >Membership Id</th>
                                    <td><?php echo $membershipID ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Balance(RM)</th>
                                    <td > <?php echo "$balance" ?></td>
                                    <td ></td>
                                </tr>
                                <tr>
                                    <th >Points</th>
                                    <td class="w-1"> <?php echo "$accumulatedPoints" ?></td>
                                    <!-- <td class="m-1"><a href="recordPoints.php" style="color:blue;">view all records</a></td> -->
                                    <td></td>
                                </tr>
                                <tr>
                                    <th >Name</th>
                                    <td ><?php echo $username ?></td>
                                    <td></td>

                                </tr>
                                <tr>
                                    <th >Email</th>
                                    <td><?php echo $email ?></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th >Phone Number</th>
                                    <td><?php echo $phoneNumber ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div class="container_card">

                            <header id="head">
                                <div class="camp">
                                    <h4>Membership</h4>
                                </div>
                                <img src="./lorem.jpg" id="logo">
                            </header>

                            <div class="content">
                                <img src="" id="imgDisplayed">
                                <ul>
                                    ID Card :<li id="ID Card"></li>
                                    Name:<li id="name"></li>
                                    Phone:<li id="birth"></li>


                                </ul>
                            </div>


                        </div> -->

                    </div>
                    <div class="col-lg col-sm action">
                        <table class="table w-15 m-3  h-50 ">
                            <tbody>
                                <tr>

                                <td><button type="button" class="btn btn-primary btn-block"><a href="createQr.php?membershipID=<?php echo $membershipID?>">View Qr code</a></button>
                                </td>

                                </tr>
                                <tr>

                                    <td><button type="button" class="btn btn-primary btn-block"><a href="addMoney.php">Add Money</a></button></td>

                                </tr>
                                <tr>
                                    <td><button type="button" class="btn btn-primary btn-block" ><a href="editCustomerUser.php?editUserID=<?=$user_id?>">Edit Personal Information</a></button>
                                    </td>
                                </tr>
                                <tr>
                                   
                                    <td>
                                    
                                        <button type="button" name= "cancelMembership" class="btn btn-primary btn-block" ><a href="./controllerModule2/membershipControler.php?membershipID=<?php   echo $membershipID?>">Cancel membership</a></button>
                                   
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


    
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('membership').classList.add('is-active');
    function confirmDelete(itemId) {
    if (confirm("Are you sure you want to cancel membership ?")) {
        document.getElementById('deleteForm').membershipID.value = itemId;
        document.getElementById('deleteForm').submit();
    }
}
    </script>
    <script src="manageUser.js"></script>
</body>

</html>