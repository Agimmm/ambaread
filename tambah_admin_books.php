<?php
session_start();
include 'koneksi.php';

// Cek apakah user adalah admin
if ($_SESSION['username'] !== 'admin') {
    header('Location: welcome.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="csshome.css">
</head>
<body>
    <div class="admin-form">
        <h2>Tambah Buku Baru</h2>
        <form action="admin_books_proses.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="judul" placeholder="Judul Buku" required>
            <input type="text" name="penulis" placeholder="Penulis" required>
            <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
            <input type="number" name="rating" step="0.1" min="0" max="5" placeholder="Rating" required>
            
            <!-- Input untuk genre -->
            <input type="text" name="genre" placeholder="Genre Buku" required>

            <!-- Input untuk tahun terbit -->
            <input type="number" name="publication_year" placeholder="Tahun Terbit" required>

            <!-- Input untuk jumlah halaman -->
            <input type="number" name="total_pages" placeholder="Jumlah Halaman" required>

            <!-- Input untuk upload gambar -->
            <input type="file" name="cover" accept="image/*" required>
            
            <button type="submit" name="tambah">Tambah Buku</button>
        </form>
    </div>
</body>
</html>
