<?php

  header("Content-Type: application/json");
  error_reporting(0);
  require 'database.php';

  // bind post to variables
  $username = $_POST['username'];
  $fullname = urldecode($_POST['name']);
  $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $phoneNumber = $_POST['phone'];

  // check username uniqueness, fail if already taken
  $stmt = $mysqli->prepare("select count(*) from users where username=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $stmt->bind_result($nameCount);
  $stmt->fetch();
  $stmt->close();
  if ($nameCount > 0) {
    echo json_encode(array(
      "success" => false,
      "message" => "The username you chose has already been claimed; please choose another."
    ));
    exit;
  }

  // check TA code, fail to register if not equal
  if ($_POST['auth'] == 123456) { // hardcoded, but could be replaced with an actual auth token taken from our sql database
    $type = "ta";
  } else if ($_POST['auth'] == "nah") {
    $type = "student";
  } else {
    echo json_encode(array(
      "success" => false,
      "message" => "We couldn't validate your TA code; try again and check with your professor if this error persists."
    ));
    exit;
  }

  // if the above passes, register user in the database
  $stmt = $mysqli->prepare("insert into users (username, passHash, fullName, phoneNumber, type) values (?, ?, ?, ?, ?)");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('sssss', $username, $passwordHash, $fullname, $phoneNumber, $type);
  $stmt->execute();
  $stmt->close();

  session_start();
  $_SESSION['username'] = $username;
  $_SESSION['type'] = $type;

  echo json_encode(array(
    "success" => true
  ));

?>
