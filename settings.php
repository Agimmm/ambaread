<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari database
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - AmbaRead</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<video autoplay loop muted playsinline id="video-bg">
    <source src="assets/background.mp4" type="video/mp4">
</video>

<div class="login-container">
    <img src="assets/logo.png" alt="Logo" class="logo">
    <div class="login-box">
        <h2>Update Profile</h2>
        <form action="proses_update.php" method="POST">
            <label for="username">New Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required><br><br>

            <label for="password">New Password (optional):</label>
            <input type="password" id="password" name="password"><br><br>

            <input type="submit" value="Update">
        </form>
        
        <!-- Button kembali ke Home -->
        <a href="welcome.php">
            <button class="register-btn">Back to Home</button>
        </a>
    </div>
</div>

</body>
</html>
