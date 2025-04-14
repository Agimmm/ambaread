<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldUsername = $_SESSION['username'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    // Cek apakah username baru sudah digunakan oleh orang lain
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ? AND username != ?");
    $stmt->bind_param("ss", $newUsername, $oldUsername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        // Update username dan password jika ada
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE username = ?");
            $updateStmt->bind_param("sss", $newUsername, $hashedPassword, $oldUsername);
        } else {
            $updateStmt = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
            $updateStmt->bind_param("ss", $newUsername, $oldUsername);
        }

        if ($updateStmt->execute()) {
            $_SESSION['username'] = $newUsername;
            $success = "Profil berhasil diperbarui!";
        } else {
            $error = "Terjadi kesalahan saat memperbarui profil.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
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
        
        <?php if (isset($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <a href="settings.php">
            <button class="register-btn">Kembali</button>
        </a>
    </div>
</div>

</body>
</html>
