
<?php
$servername = "192.168.0.50";
$username = "sa";
$password = "sa11494";
$table = "hos";//ชื่อฐานข้อมูล
// Create connection
$conn= mysqli_connect($servername, $username, $password,$table);   
$conn->set_charset("utf8");
date_default_timezone_set('Asia/Bangkok');

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";

?>