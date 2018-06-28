<?php

header("Content-Type: application/json");

error_reporting(0);
require 'database.php';

$username = $_POST['username'];
$pass = $_POST['password'];
$givenType = $_POST['type'];

$stmt = $mysqli->prepare("select count(*), passHash, type, phoneNumber from users where username=?");

$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($cnt, $passHash, $type, $phoneNumber);
$stmt->fetch();
$stmt->close();

if ($cnt != 1) {
  echo json_encode(array(
    "success" => false,
    "message" => "It looks like you haven't set up an account yet; navigate to the registration page to sign up for Board."
  ));
  exit;
} else {
  if (strcmp($givenType, $type)) {
    $errMsg = "Are you sure you're in the right place? This username is registered as a " . $type . ", but you're trying to log in as a " . $givenType . ".";
    echo json_encode(array(
      "success" => false,
      "message" => $errMsg
    ));
  } else if (password_verify($pass, $passHash)) {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['type'] = $type;
    $_SESSION['phone'] = $phoneNumber;
    echo json_encode(array(
      "success" => true
    ));
  } else {
    $errMsg = "Incorrect password for user \"" . $username . "\".";
    echo json_encode(array(
      "success" => false,
      "message" => $errMsg
    ));
  }
}

?>
