<?php
header("Content-Type: application/json");
ini_set("session.cookie_httponly", 1);
session_start();
//echo $_SESSION['type'];
if (isset($_SESSION['username'])) {
  if (isset($_SESSION['room'])) {
    echo json_encode(array(
      "success" => true,
      "username" => $_SESSION['username'],
      "userType" => $_SESSION['type'],
      "room" => $_SESSION['room']
    ));
  } else {
    echo json_encode(array(
    "success" => true,
    "username" => $_SESSION['username'],
    "userType" => $_SESSION['type']
  ));
  }
} else {
  echo json_encode(array(
		"success" => false,
	));
}
?>
