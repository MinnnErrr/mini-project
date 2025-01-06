<?php
require_once 'vendor/autoload.php';
session_start();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($user_id)) {
    header('location:login.php');
}

if(isset($_POST['addMoney'])){
    $total = (float)$_POST['amount'];
    print_r($total);

    $stripeSecreteKey= "sk_test_51Qd4St2ZUv6XfYCkTOL1b4NjUyX9wLYIPAKouRDp9bXtMFxWPzKh04PX7RGL1ctCTiPAtvPdk0UsHLkxmwyyep7800vstGla76";
    \Stripe\Stripe::setApiKey($stripeSecreteKey);
    $checkout = \Stripe\Checkout\Session::create(
        [
            "mode" => "payment",
            "success_url" => "http://localhost:3000/mini-project/successAddMoneyMembership.php?amount=$total",
            "line_items" =>[
                [
                    "quantity" =>1,
                    "price_data" =>[
                        "currency" => "myr",
                        "unit_amount" => $total * 100,
                        "product_data" =>[
                            "name" => "Membership Card Top up"
                        ]
                    ]
                ]
            ]
        ]
    );
    http_response_code(303);


    header("Location: " . $checkout->url);
}



?>