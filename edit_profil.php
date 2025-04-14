<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="edit-profile-container">
    <h2>Edit Profil</h2>
    <form action="proses_profil.php" method="POST" enctype="multipart/form-data">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea><br>

        <label for="hobi">Hobi:</label>
        <input type="text" id="hobi" name="hobi" value="<?php echo $user['hobi']; ?>"><br>

        <label for="foto_profil">Foto Profil:</label>
        <input type="file" id="foto_profil" name="foto_profil"><br>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="profile.php" class="back-btn">Kembali</a>
</div>

</body>
</html>
