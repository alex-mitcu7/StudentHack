<?php
require "/home/alex/StudentHack/twilio-php-master/Services/Twilio.php"; // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
$sid = "AC377f38194b7c2ef80593aedae8be033f";
$token = "49583d53d8a1eb4fdbfcf8aa9f44117c";
$client = new Services_Twilio($sid, $token);

// Loop over the list of messages and echo a property for each one
foreach ($client->account->messages as $message) {
    echo $message->body;
}
?>