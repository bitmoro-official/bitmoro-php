<?php

use Bitmoro\Bitmorophp\Bitmoro;

$apiToken = "cHHv4wVEkBSKczBDKn1t-9b72900f61f51212cd3aa77357d34a6b06611490fa8d7c748e492c272799";
$senderId = "BIT_MORE";

require __DIR__ . '/vendor/autoload.php';


$bitmoro = new Bitmoro($apiToken, $senderId);

// Send OTP
// $number = ["9869352017"];
// $message = "Your OTP is 1234";
// $response = $bitmoro->sendOTP($number, $message);
// print_r($response);


// Send Bulk SMS
// $numbers = ["9869352017", "9842882495"];
// $message = "Hello, this is a test message";
// $response = $bitmoro->sendBulkSms($numbers, $message);
// print_r($response);

// // Send Dynamic SMS
