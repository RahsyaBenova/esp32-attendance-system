<?php
require 'db.php';

// Check if a UID was sent by ESP32
if (isset($_POST["rfid_uid"])) {
    $uid = $_POST["rfid_uid"];

    // 1. Check if this UID exists in the 'users' table
    $sql = "SELECT * FROM users WHERE serialnumber = '$uid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // --- EXISTING USER: HANDLE IN/OUT LOGIC ---
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
        $user_name = $row['username'];

        // Check the LAST log for this user
        $last_log_sql = "SELECT status FROM attendance WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
        $last_log_result = $conn->query($last_log_sql);

        $new_status = "IN"; // Default if no previous logs exist

        if ($last_log_result->num_rows > 0) {
            $last_row = $last_log_result->fetch_assoc();
            // Toggle Status
            if ($last_row['status'] == "IN") {
                $new_status = "OUT";
            }
        }

        // Insert new attendance record
        $insert_sql = "INSERT INTO attendance (user_id, status) VALUES ('$user_id', '$new_status')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "Success: " . $user_name . " is checked " . $new_status;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    } else {
        // --- UNKNOWN USER: SEND TO REGISTRATION QUEUE ---
        // Update the temp_card table so the Registration page sees it
        $update_temp = "UPDATE temp_card SET uid = '$uid' WHERE id = 1";
        $conn->query($update_temp);
        echo "Card Unknown. Ready to Register.";
    }
} else {
    echo "No UID received";
}
$conn->close();
?>