<?php
include 'koneksi.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE token_verifikasi = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update = $conn->prepare("UPDATE users SET status = 'verified' WHERE token_verifikasi = ?");
        $update->bind_param("s", $token);
        if ($update->execute()) {
            echo "<script>alert('Akun berhasil diverifikasi! Silakan login.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat verifikasi.'); window.location.href='register.php';</script>";
        }
    } else {
        echo "<script>alert('Token tidak valid!'); window.location.href='register.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Token tidak ditemukan!'); window.location.href='register.php';</script>";
}
?>
