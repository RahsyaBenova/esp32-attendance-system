<?php
require 'db_connect.php';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the request
    if (isset($_POST["rfid_uid"]) && isset($_POST["device_name"])) {
        $rfid_uid = $_POST["rfid_uid"];
        $device_name = $_POST["device_name"];

        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO attendance_logs (rfid_uid, device_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $rfid_uid, $device_name);

        if ($stmt->execute()) {
            echo "Success: Attendance Logged";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Missing required parameters";
    }
} else {
    echo "Error: Only POST requests allowed";
}

$conn->close();
?>