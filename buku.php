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

// Ambil buku serupa (dalam genre yang sama)
$similar_books_query = $conn->prepare("SELECT * FROM books WHERE genre = ? AND id != ? LIMIT 4");
$similar_books_query->bind_param("si", $book['genre'], $book_id);
$similar_books_query->execute();
$similar_books_result = $similar_books_query->get_result();
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
    <header>
        <div class="logo-container">
            <img src="assets/ambaa.jpg" alt="Logo" class="logo">
            <div class="brand-name">AmbaRead</div>
        </div>
        
        <nav class="nav-container">
            <ul>
                <li><a href="#" class="active">Beranda</a></li>
                <li><a href="#">Kategori</a></li>
                <li><a href="#">Koleksi</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-btn">Lainnya ▼</a>
                    <div class="dropdown-content">
                        <a href="#">Tentang Kami</a>
                        <a href="#">Hubungi Kami</a>
                    </div>
                </li>
            </ul>
        </nav>
        
        <div class="profile-container">
            <a href="profil.php" title="Laman Profil">
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-pic">
            </a>
        </div>
    </header>

    <div class="search-container">
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" placeholder="Cari buku, penulis...">
            <span class="filter-icon">🔬</span>
        </div>
    </div>

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
                <img src="assets/diddy.png" alt="Penulis" class="author-avatar">
                <div>
                    <h4><?php echo htmlspecialchars($book['author']); ?></h4>
                    <p>Penulis <?php echo htmlspecialchars($book['genre']); ?> berbakat</p>
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

            <!-- Tombol Baca Sekarang -->
            <a href="baca_buku.php?id=<?php echo $book['id']; ?>" class="read-now-button">Baca Sekarang</a>
        </div>
    </div>
    
    <h2 style="text-align: center;">Pembaca Juga Menikmati</h2>
    <div class="similar-books">
        <?php while($similar_book = $similar_books_result->fetch_assoc()): ?>
        <div class="similar-book">
            <a href="buku.php?id=<?php echo $similar_book['id']; ?>">
                <img src="<?php echo $similar_book['cover_image']; ?>" alt="<?php echo htmlspecialchars($similar_book['title']); ?>">
                <h4><?php echo htmlspecialchars($similar_book['title']); ?></h4>
                <p><?php echo htmlspecialchars($similar_book['author']); ?></p>
            </a>
        </div>
        <?php endwhile; ?>
    </div>

    <footer>
        <!-- Footer content remains the same as previous version -->
    </footer>
</body>
</html>
