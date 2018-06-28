<?php
  session_start();
  header("Content-Type: application/json");
  require 'database.php';
  // bind post to variables
  $name=$_SESSION['username'];
  $room=$_SESSION['room'];
  $phone=$_SESSION['phone'];

  $stmt = $mysqli->prepare("select fullName from users where username=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $name);
  $stmt->execute();
  $stmt->bind_result($fullName);
  $stmt->fetch();
  $stmt->close();

  // check username uniqueness, fail if already taken
  $stmt = $mysqli->prepare("select count(*) from help where name=? and session=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ss', $name, $room);
  $stmt->execute();
  $stmt->bind_result($nameCount);
  $stmt->fetch();
  $stmt->close();
  if ($nameCount > 0) {
    exit;
  } else {
    $stmt = $mysqli->prepare("insert into help (name, session, phoneNumber, fullName) values (?, ?, ?, ?)");
    if (!$stmt) {
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ssss', $name, $room, $phone, $fullName);
    $stmt->execute();
    $stmt->close();
    echo json_encode(array(
      "success" => true
    ));
  }


  ?>
