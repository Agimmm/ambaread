<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi database sudah benar

$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk memeriksa username
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['username'] = $user['username'];
    header("Location:welcome.php");
    exit;
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Gagal</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

  

    <div class="login-container">
        <img src="assets/logo.png" alt="Logo" class="logo">
        <div class="login-box">
            
            <h2>Login Gagal</h2>
            <p class="error-message">Username atau password salah!</p>

            <a href="login.php">
                <button class="retry-btn">Coba Lagi</button>
            </a>
        </div>
    </div>

    </body>
    </html>
    <?php
}
?>
