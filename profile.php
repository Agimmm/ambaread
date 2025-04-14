<?php
session_start();
include "koneksi.php";

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Ambil data pengguna dari database
$query = "SELECT username, foto_profil FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Tentukan foto profil yang akan ditampilkan
$foto_profil = !empty($user['foto_profil']) ? "uploads/" . $user['foto_profil'] : "assets/default.jpg";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - AmbaRead</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
  
</head>
<body>
    <div class="header">
        <img src="assets/ambaa.jpg" alt="Logo" class="logo">
        <span class="site-title">AmbaRead</span>
    </div>
    
    <div class="profile-container">
        <div class="profile-box">
            <h2>Profil Pengguna</h2>
            <p>Kelola informasi profil Anda</p>
            
            <img src="<?php echo $foto_profil; ?>" alt="User Profile" class="profile-image">
            
            <form action="proses_profil.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                </div>
                
                <div class="file-input-group">
                    <label for="foto_profil">Ganti Profil : </label>
                    <input type="file" id="foto_profil" name="foto_profil">
                </div>
                
                <button type="submit" name="update" class="update-btn">Simpan Perubahan</button>
            </form>
            
            <a href="dashboard.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>