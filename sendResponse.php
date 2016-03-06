<?php
session_start();
require "/home/alex/Twilio/twilio-php-master/Services/Twilio.php"; // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "AC377f38194b7c2ef80593aedae8be033f";
$token = "49583d53d8a1eb4fdbfcf8aa9f44117c";
$client = new \Services_Twilio($sid, $token);

$client->account->messages->sendMessage(
    "+447400381668",
    $_SESSION['phoneNumber'],
    $_SESSION['response']
);

session_unset();
session_destroy();
header("Location: http://4b7054f0.ngrok.io/StudentHack/index.html");
exit;
?>
