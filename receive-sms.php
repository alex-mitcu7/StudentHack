<?php
session_start();
require "/home/alex/Twilio/twilio-php-master/Services/Twilio.php"; // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "YOUR SID";
$token = "YOUR AUTH TOKEN";
$client = new \Services_Twilio($sid, $token);

// Loop over the list of messages and echo a property for each one
foreach ($client->account->sms_messages as $message) {
  if ($message->direction == "inbound") {
    $_SESSION['phoneNumber'] = $message->from;
    $_SESSION['text'] = $message->body;
    break;
  } // if
} //foreach

  header("Location: queryBuild.php");
  exit;
?>
