<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php'; 

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $verified = 0; // default belum diverifikasi

    // Cek apakah username sudah digunakan
    $checkUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $result = $checkUser->get_result();

    if ($result->num_rows > 0) {
        $message = "Username sudah digunakan! Silakan coba yang lain.";
    } else {
        // Masukkan data ke database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, verified) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $password, $verified);

        if ($stmt->execute()) {
            $message = "Registrasi berhasil! Silakan login.";
            $success = true; 
        } else {
            $message = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        }
        $stmt->close();
    }

    $checkUser->close();
    $conn->close();
} else {
    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">
    <img src="assets/logo.png" alt="Logo" class="logo">
    <div class="login-box">
        <p>Hello Jomokers! Welcome to AmbaRead</p>
        <h2>Registrasi</h2>

        <?php if (!empty($message)) : ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <?php if (isset($success) && $success) : ?>
            <a href="login.php">
                <button class="login-btn">Login Sekarang</button>
            </a>
        <?php else : ?>
            <a href="register.php">
                <button class="retry-btn">Coba Lagi</button>
            </a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
