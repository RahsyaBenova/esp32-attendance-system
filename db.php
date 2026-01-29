<?php
$conn = new mysqli("localhost", "root", "", "esp32_attendance");
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
?>