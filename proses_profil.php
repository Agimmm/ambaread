<?php
session_start();
include "koneksi.php";

// Tampilkan semua error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi database berhasil
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Pastikan pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// Ambil data lama dari database
$query = "SELECT foto_profil FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query Error (SELECT): " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$foto_lama = $user['foto_profil'];

// Inisialisasi variabel foto_profil
$foto_profil = $foto_lama; 

// Jika pengguna mengupload foto baru
if (isset($_FILES['foto_profil']) && !empty($_FILES['foto_profil']['name'])) {
    $targetDir = "uploads/";
    $foto_profil = time() . "_" . basename($_FILES["foto_profil"]["name"]);
    $targetFilePath = $targetDir . $foto_profil;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["foto_profil"]["tmp_name"], $targetFilePath)) {
            // Hapus foto lama jika ada
            if (!empty($foto_lama) && file_exists("uploads/" . $foto_lama)) {
                unlink("uploads/" . $foto_lama);
            }
        } else {
            die("❌ Gagal mengupload foto! Pastikan folder 'uploads/' memiliki izin tulis.");
        }
    } else {
        die("❌ Format gambar tidak didukung! Gunakan JPG, PNG, atau GIF.");
    }
}

// **Update ke database**
$query = "UPDATE users SET foto_profil = ? WHERE username = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Query Error (UPDATE): " . $conn->error);
}
$stmt->bind_param("ss", $foto_profil, $username);

// Jalankan query update
if ($stmt->execute()) {
    echo "<script>alert('✅ Profil berhasil diperbarui!'); window.location.href='welcome.php';</script>";
    exit();
} else {
    die("❌ Gagal memperbarui database: " . $stmt->error);
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>