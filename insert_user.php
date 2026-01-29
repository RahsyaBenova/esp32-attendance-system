<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];

    // Prevent registering "Wait for scan..."
    if ($uid == "Wait for scan...") {
        echo "<script>alert('Please scan a card first!'); window.location.href='register.php';</script>";
        exit();
    }

    $sql = "INSERT INTO users (username, serialnumber, gender) VALUES ('$name', '$uid', '$gender')";
    
    if ($conn->query($sql) === TRUE) {
        // Reset the temp card
        $conn->query("UPDATE temp_card SET uid = 'Wait for scan...' WHERE id = 1");
        echo "<script>alert('User Registered Successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>