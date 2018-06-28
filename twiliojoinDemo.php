<?php
  session_start();
  header("Content-Type: application/json");
  require 'database.php';

     $name=$_GET['username'];
     $room=$_GET['room'];
     $phone=$_GET['phone'];

  //
  $stmt = $mysqli->prepare("insert into demo (name, session, phoneNumber, fullName) values (?, ?, ?, ?)");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ssss', $name, $room, $phone, $name);
  $stmt->execute();
  $stmt->close();
  echo json_encode(array(
    "success" => true
  ));
  ?>
