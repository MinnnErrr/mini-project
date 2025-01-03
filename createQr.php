<?php

if(!isset($_GET['user_id'])) {
    header("login.php");
}
if(isset($_GET['membershipID'])){
    $message = "http://localhost:3000/mini-project/totalPoints.php?membershipID=".$_GET['membershipID'].""; // URL with user data

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" 
         content="width=device-width, 
                        initial-scale=1.0" />
    <title>QR Code Generator</title>
   
    <style>
        h1, h3 {
          color: black;
        }
        body, header {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
        }
    </style>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js">
    </script>
</head>

<body>
    <header>
        <h1>Qr code Membership</h1>
    </header>
    <main>
        <div id="qrcode"></div>
        <button onclick="goBack()" style="width: 100%;margin-top:20px;padding:10px;background-color:#B3E5FC">back</button>
    </main>
 
    <script>
           function goBack() {
            history.back();
        }
        var qrcode = new QRCode("qrcode",
        <?php echo json_encode($message); ?>);
    </script>
</body>

</html>