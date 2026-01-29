<?php require 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register New User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <style> body { padding: 50px; background: #f8f9fa; } </style>
</head>
<body>
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>📝 Register New Card</h3>
        </div>
        <div class="card-body">
            
            <form action="insert_user.php" method="post">
                <div class="mb-3">
                    <label>Scanned Card UID (Auto-detected):</label>
                    <textarea name="uid" id="get_uid" class="form-control" placeholder="Please Scan your Card..." rows="1" readonly required></textarea>
                    <small class="text-muted">Tempelkan kartu di alat, UID akan muncul otomatis tanpa refresh halaman.</small>
                </div>
                <div class="mb-3">
                    <label>User Name:</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                </div>
                <div class="mb-3">
                    <label>Gender:</label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Save User</button>
                <a href="index.php" class="btn btn-secondary">Go to Dashboard</a>
            </form>
        </div>
    </div>
</div>

<script>
    // Script ini akan jalan setiap 1 detik (1000ms)
    $(document).ready(function(){
        setInterval(function(){
            // Panggil file get_uid.php
            $("#get_uid").load("get_uid.php");
        }, 1000); 
    });
</script>

</body>
</html>