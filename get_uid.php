<?php
require 'db.php';

// Ambil UID dari tabel temp_card
$sql = "SELECT uid FROM temp_card WHERE id = 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Cuma tampilkan teks UID-nya saja
echo $row['uid'];
?>