<?php
session_start();
require 'database.php';
if ($_SESSION['type']=="student") {
	die;
}
$room=$_SESSION['room'];

$stmt = $mysqli->prepare("DELETE FROM demo WHERE session=? ORDER BY id ASC LIMIT 1");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $room);
$stmt->execute();
$stmt->close();

$stmt = $mysqli->prepare("select phoneNumber FROM demo WHERE session=? ORDER BY id ASC LIMIT 1");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $room);
$stmt->execute();
$stmt->bind_result($phone);
$stmt->fetch();
$stmt->close();

//start code from Twilio.com// https://www.twilio.com/docs/libraries/php#using-without-composer
require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'AC403fbbf16e277a4ec8a6db6be40c8d48';
$auth_token = 'ff8147c99c9ed9e2b2a8919c21720134';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with SMS capabilities
$twilio_number = "+13142078420";

$client = new Client($account_sid, $auth_token);
$client->messages->create(
    // Where to send a text message (your cell phone?)
    $phone,
    array(
        'from' => $twilio_number,
        'body' => ("You're up for " . $room . " demo!")
    )
);


?>
