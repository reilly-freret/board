<?php
  session_start();
  $verified = True;
  header("Content-Type: application/json");
  require 'database.php';

  // bind post to variables
  $newRoom = $_POST['newRoom'];
  $name=$_SESSION['username'];

  if ($_SESSION['type']=="student") {
    die;
  }
  // check roomName uniqueness, fail if already taken
  $stmt = $mysqli->prepare("select count(*) from sessions where name=?");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('s', $newRoom);
  $stmt->execute();
  $stmt->bind_result($nameCount);
  $stmt->fetch();
  $stmt->close();
  if ($nameCount > 0) {
    echo json_encode(array(
      "success" => false,
      "message" => "The room name you chose has already been claimed; please choose another."
    ));
    exit;
  }
  //
  $stmt = $mysqli->prepare("insert into sessions (name, creator) values (?, ?)");
  if (!$stmt) {
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->bind_param('ss', $newRoom, $name);
  $stmt->execute();
  $stmt->close();
  echo json_encode(array(
    "success" => true
  ));
  ?>
