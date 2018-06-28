<?php
header('Content-Type: application/json');
$name = $_GET['name'];
$roomid = $_GET['roomid'];
$phonenumber = $_GET['phonenumber'];
echo $name;
echo $roomid;
echo $phonenumber;
require 'database.php';

$stmt = $mysqli->prepare("insert into demolist (roomid, phonenumber, name) values (?, ?, ?)");
if(!$stmt){
  echo json_encode(array(
  "success" => false,
  "name"=>$name));
	exit;
}
$stmt->bind_param('iss', $roomid, $phonenumber, $name);
$stmt->execute();
$stmt->close();
echo json_encode(array(
"success" => true,));
    ?>
<!--Skan - Living Hell (ft. M.I.M.E, Blvkstn & Lox Chatterbox) [Lyrics]
  -->
