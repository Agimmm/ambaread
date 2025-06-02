<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil data user dari database
$username = $_SESSION['username'];
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Tentukan lokasi gambar profil
$profileImage = !empty($user['foto_profil']) ? "uploads/".$user['foto_profil'] : "/api/placeholder/50/50";

// Ambil detail buku
if (!isset($_GET['id'])) {
    die("Buku tidak ditemukan");
}

$book_id = intval($_GET['id']);
$book_query = $conn->prepare("SELECT * FROM books WHERE id = ?");
$book_query->bind_param("i", $book_id);
$book_query->execute();
$book_result = $book_query->get_result();
$book = $book_result->fetch_assoc();

if (!$book) {
    die("Buku tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: <?php echo htmlspecialchars($book['title']); ?></title>
    <link rel="stylesheet" href="csshome.css">
    <style>
        .reading-container {
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .book-content {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }
    </style>
</head>
<body>
   <?php include 'header.php'; ?>

    <div class="search-container">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Cari buku, penulis...">
            <span class="filter-icon">🔬</span>
        </div>
    </div>

    <div class="reading-container">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>
        <div class="book-content">
            <?php echo nl2br(htmlspecialchars($book['isi_buku'])); ?>
        </div>
    </div>

    <footer>
        <!-- Footer content remains the same as previous version -->
    </footer>
</body>
</html>
