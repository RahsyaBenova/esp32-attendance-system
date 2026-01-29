<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance Dashboard</title>
    <meta http-equiv="refresh" content="5">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style> body { padding: 30px; } </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📊 Live Attendance Log</h2>
        <a href="register.php" class="btn btn-primary">+ Register New User</a>
    </div>

    <table class="table table-bordered table-striped shadow">
        <thead class="table-dark">
            <tr>
                <th>Log ID</th>
                <th>Name</th>
                <th>UID</th>
                <th>Status</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Join users and attendance tables
            $sql = "SELECT attendance.id, users.username, users.serialnumber, attendance.status, attendance.log_time 
                    FROM attendance 
                    JOIN users ON attendance.user_id = users.id 
                    ORDER BY attendance.id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $statusColor = ($row['status'] == 'IN') ? 'text-success' : 'text-danger';
                    echo "<tr>
                            <td>" . $row["id"]. "</td>
                            <td><strong>" . $row["username"]. "</strong></td>
                            <td>" . $row["serialnumber"]. "</td>
                            <td class='fw-bold $statusColor'>" . $row["status"]. "</td>
                            <td>" . $row["log_time"]. "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No attendance logs yet.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>
</body>
</html>