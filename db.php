<?php
// เชื่อมต่อกับฐานข้อมูล
$mysqli = new mysqli('192.168.0.50', 'sa', 'sa11494', 'health_db');

// ตรวจสอบการเชื่อมต่อ
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
