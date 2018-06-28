<?php

// borrowed from http://makitweb.com/how-to-get-data-from-mysql-with-angularjs-php/

$host = "localhost"; /* Host name */
$user = "wustl_inst"; /* User */
$password = "wustl_pass"; /* Password */
$dbname = "ta_hours"; /* Database name */
//$asdf = $_GET['room'];

session_start();

$roomName = $_SESSION['room'];

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

$qury = "select * from demo where session=\"" . $roomName . "\"";
//$qury = "select * from users where type=\"ta\"";

$sel = mysqli_query($con,$qury);
$data = array();



$i = 1;

while ($row = mysqli_fetch_array($sel)) {
  $nameWithNumber = $i . ". " . $row['fullName'];
 $data[] = array("fname"=>$nameWithNumber);
 $i++;
}

//$data[] += array("fname"=>$asdf);

echo json_encode($data);

?>
