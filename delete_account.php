<?php
session_start();
include 'koneksi.php';

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['username'] !== 'admin') {
    header("Location: welcome.php");
    exit();
}

// Ambil daftar pengguna dari database
$result = $conn->query("SELECT id, username FROM users WHERE username != 'admin'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<video autoplay loop muted playsinline id="video-bg">
    <source src="assets/background.mp4" type="video/mp4">
</video>

<div class="container">
    <div class="delete-box">
        <h2>Delete User Account</h2>
        <form action="proses_delete.php" method="POST">
            <label for="user_id">Pilih Akun yang akan dihapus:</label>
            <select name="user_id" id="user_id" required>
                <option value="">-- Pilih Akun --</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= $row['username']; ?></option>
                <?php endwhile; ?>
            </select>
            <br><br>
            <button type="submit" class="delete-btn">Delete Account</button>
        </form>
        <a href="welcome.php" class="back-btn">Kembali</a>
    </div>
</div>

</body>
</html>
