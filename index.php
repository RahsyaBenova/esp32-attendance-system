<?php require 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>ESP32 Attendance System</title>
    <meta http-equiv="refresh" content="5"> 
    <style>
        body { font-family: sans-serif; text-align: center; }
        table { margin: 0 auto; border-collapse: collapse; width: 60%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #04AA6D; color: white; }
        tr:nth-child(even){background-color: #f2f2f2;}
    </style>
</head>
<body>
    <h2>Live Attendance Log</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>RFID UID</th>
            <th>Device</th>
            <th>Timestamp</th>
        </tr>
        <?php
        $sql = "SELECT id, rfid_uid, device_name, log_time FROM attendance_logs ORDER BY id DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["rfid_uid"]. "</td>
                        <td>" . $row["device_name"]. "</td>
                        <td>" . $row["log_time"]. "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>