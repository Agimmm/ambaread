<?php
session_start();
include 'koneksi.php';

// Cek apakah user adalah admin
if ($_SESSION['username'] !== 'admin') {
    header('Location: welcome.php');
    exit();
}

// Ambil data buku untuk edit
$book = null; // Inisialisasi variabel
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitasi input
    $stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Buku tidak ditemukan.";
        exit();
    }
    $stmt->close();
} else {
    echo "ID buku tidak diberikan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="csshome.css">
</head>
<body>
    <div class="admin-form">
        <h2>Edit Buku</h2>
        <form action="admin_books_proses.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($book['id']) ?>">

            <!-- Input untuk judul buku -->
            <input type="text" name="judul" value="<?= htmlspecialchars($book['title']) ?>" placeholder="Judul Buku" required>

            <!-- Input untuk penulis -->
            <input type="text" name="penulis" value="<?= htmlspecialchars($book['author']) ?>" placeholder="Penulis" required>

            <!-- Textarea untuk deskripsi buku -->
            <textarea name="deskripsi" placeholder="Deskripsi" required><?= htmlspecialchars($book['description']) ?></textarea>

            <!-- Input untuk rating -->
            <input type="number" name="rating" step="0.1" value="<?= htmlspecialchars($book['rating']) ?>" min="0" max="5" placeholder="Rating" required>

            <!-- Input untuk genre buku -->
            <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" placeholder="Genre Buku" required>

            <!-- Input untuk tahun terbit -->
            <input type="number" name="publication_year" value="<?= htmlspecialchars($book['publication_year']) ?>" placeholder="Tahun Terbit" required>

            <!-- Input untuk jumlah halaman -->
            <input type="number" name="total_pages" value="<?= htmlspecialchars($book['total_pages']) ?>" placeholder="Jumlah Halaman" required>

            <!-- Input untuk upload gambar (opsional jika tidak ada perubahan gambar) -->
            <input type="file" name="cover" accept="image/*">

            <!-- Menampilkan gambar lama -->
            <?php if ($book['cover_image']): ?>
                <div>
                    <img src="<?= htmlspecialchars($book['cover_image']) ?>" alt="Cover Book" width="100">
                    <p>Cover Saat Ini</p>
                </div>
            <?php endif; ?>

            <!-- Tombol untuk submit -->
            <button type="submit" name="update">Update Buku</button>
        </form>
    </div>
</body>
</html>