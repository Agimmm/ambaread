<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "ambaread";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Tambahkan baris ini untuk mengatur encoding koneksi
mysqli_set_charset($conn, "utf8mb4");
?>
