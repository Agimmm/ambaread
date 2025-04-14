<?php
session_start();
include 'koneksi.php';

// Cek apakah user adalah admin
if ($_SESSION['username'] !== 'admin') {
    header('Location: welcome.php');
    exit();
}

// Ambil data buku dari database
$result = $conn->query("SELECT * FROM books");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Buku untuk Diedit</title>
    <link rel="stylesheet" href="csshome.css">
</head>
<body>
    <div class="admin-form">
        <h2>Pilih Buku untuk Diedit</h2>
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($book = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td>
                            <a href="edit_buku.php?id=<?= $book['id'] ?>">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>