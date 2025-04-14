<?php
include 'koneksi.php';  

$username = "admin";
$password = password_hash("agimganteng", PASSWORD_DEFAULT); 

$sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "Akun berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
