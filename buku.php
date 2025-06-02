<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Ambil user_id dari session
$username = $_SESSION['username'];  

// Ambil data buku dari database
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$book_id) {
    die("Buku tidak ditemukan.");
}

$query = $conn->prepare("SELECT * FROM books WHERE id = ?");
$query->bind_param("i", $book_id);
$query->execute();
$book = $query->get_result()->fetch_assoc();

if (!$book) {
    die("Buku tidak ditemukan.");
}

// Ambil data user
$user_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$user = $user_query->get_result()->fetch_assoc();

// Tentukan gambar profil
$profileImage = !empty($user['foto_profil']) ? "uploads/".$user['foto_profil'] : "/api/placeholder/50/50";

// Periksa apakah buku sudah ada di favorit pengguna
$check_favorite = $conn->prepare("SELECT * FROM favorites WHERE user_id = (SELECT id FROM users WHERE username = ?) AND book_id = ?");
$check_favorite->bind_param("si", $username, $book_id);
$check_favorite->execute();
$favorite_result = $check_favorite->get_result();

// Tentukan apakah buku ada di favorit
$is_favorite = $favorite_result->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Detail Buku</title>
    <link rel="stylesheet" href="csshome.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover">
        
        <div class="book-details">
            <h1 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h1>
            
            <div class="book-rating">
                <div class="stars">
                    <?php 
                    $rating = round($book['rating']);
                    for($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating ? '★' : '☆';
                    }
                    ?>
                </div>
                <span>(45 Ulasan)</span>
            </div>
            
            <h3>Tentang Penulis</h3>
            <div class="author-section">
                <img src="<?php echo $book['author_picture']; ?>" alt="Penulis" class="author-avatar">
                <div>
                    <h4><?php echo htmlspecialchars($book['author']); ?></h4>
                    <p>Penulis <?php echo htmlspecialchars($book['genre']); ?> </p>
                </div>
            </div>
            
            <h3>Detail Buku</h3>
            <div class="book-metadata">
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($book['genre']); ?></p>
                <p><strong>Tahun Terbit:</strong> <?php echo $book['publication_year']; ?></p>
                <p><strong>Jumlah Halaman:</strong> <?php echo $book['total_pages']; ?></p>
            </div>
            
            <h3>Deskripsi</h3>
            <p><?php echo htmlspecialchars($book['description']); ?></p>

            <!-- Form Add to Favorite atau Remove from Favorite -->
            <button class="favorite-button" id="favorite-button" data-book-id="<?php echo $book['id']; ?>">
                <?php echo $is_favorite ? 'Remove from Favorite' : 'Add to Favorite'; ?>
            </button>

            <!-- Tombol Baca Sekarang -->
            <a href="baca_buku.php?id=<?php echo $book['id']; ?>" class="read-now-button">Baca Sekarang</a>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Menangani klik pada tombol Add/Remove to Favorite
        document.getElementById('favorite-button').addEventListener('click', function() {
            var bookId = this.getAttribute('data-book-id');  // Ambil ID buku dari data-attribute
            var action = this.textContent === 'Add to Favorite' ? 'add' : 'remove';  // Cek apakah tombol untuk Add atau Remove

            // Buat request AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "favorite_action.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            // Ketika permintaan selesai
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Ubah teks tombol berdasarkan status favorit
                    if (action === 'add') {
                        document.getElementById('favorite-button').textContent = 'Remove from Favorite';
                    } else {
                        document.getElementById('favorite-button').textContent = 'Add to Favorite';
                    }
                    // Tampilkan pesan sukses
                    alert(xhr.responseText);
                } else {
                    alert("Terjadi kesalahan. Coba lagi nanti.");
                }
            };
            
            // Kirim data book_id dan action ke favorite_action.php
            xhr.send("book_id=" + bookId + "&action=" + action);
        });
    </script>
</body>
</html>
