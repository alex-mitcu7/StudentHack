<?php
session_start();
require "/home/alex/Twilio/twilio-php-master/Services/Twilio.php"; // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "YOUR SID";
$token = "YOUR AUTH TOKEN";
$client = new \Services_Twilio($sid, $token);

$client->account->messages->sendMessage(
    "your number",
    $_SESSION['phoneNumber'],
    $_SESSION['response']
);

session_unset();
session_destroy();
header("Location: /path/to/index.html");
exit;
?>
