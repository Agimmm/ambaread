<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang bisa menghapus akun
if ($_SESSION['username'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    // Ambil username untuk ditampilkan di notifikasi
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $deleted_username = $row['username'];
    $stmt->close();

   
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $message = "Akun '$deleted_username' berhasil dihapus!";
    } else {
        $message = "Gagal menghapus akun.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Akun</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<video autoplay loop muted playsinline id="video-bg">
    <source src="assets/background.mp4" type="video/mp4">
</video>

<div class="container">
    <div class="delete-box">
        <h2>Konfirmasi Penghapusan</h2>
        <p><?php echo $message; ?></p>
        <a href="delete_account.php" class="back-btn">Kembali</a>
    </div>
</div>

</body>
</html>
