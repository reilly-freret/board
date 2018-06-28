<?php
session_start();
header('Content-Type: application/json');
$classname = $_GET['name'];
error_reporting(0);

require 'database.php';
$stmt = $mysqli->prepare("SELECT COUNT(*) FROM sessions WHERE name=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $classname);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

if($count>0)
{
  echo json_encode(array(
  "exist" => true
));
	$_SESSION['room']=$classname;
	exit;
}
if($count==0)
{
  echo json_encode(array(
  "exist" => false));
}
?>
