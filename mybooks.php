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

// Ambil user_id
$user_id = $user['id'];

// Query untuk menampilkan buku favorit pengguna
    $books_query = "
        SELECT books.* 
        FROM books
        INNER JOIN favorites ON books.id = favorites.book_id
        WHERE favorites.user_id = ?";
    $books_result = $conn->prepare($books_query);
    $books_result->bind_param("i", $user_id);
    $books_result->execute();
    $books_result = $books_result->get_result();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Favorite Books - AmbaRead</title>
    <style>
        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Search Container */
        .search-container {
            margin-bottom: 20px;
            padding: 0 40px;
        }

        .search-bar {
            position: relative;
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 25px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-bar input {
            width: 100%;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            outline: none;
            transition: background-color 0.3s;
        }

        .search-bar input::placeholder {
            color: #888;
        }

        .search-bar.focused input {
            background-color: #f3f3f3;
        }

        .search-icon, .filter-icon {
            font-size: 20px;
            margin-right: 10px;
            color: #888;
            cursor: pointer;
        }

        .search-bar input:focus {
            background-color: #f3f3f3;
        }

        /* Section Styling */
        section {
            padding: 20px;
            margin-bottom: 40px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        /* Suggestion Grid */
        .suggestion-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Mengatur jumlah kolom */
            gap: 15px;
            justify-items: center;
        }

        .suggestion-card {
            position: relative;
            text-align: center;
            max-width: 250px;
            width: 100%;
        }

        /* Gambar standar buku */
        .suggestion-card img {
            width: 120px; /* Ukuran standar untuk gambar buku */
            height: 180px; /* Ukuran standar untuk gambar buku */
            object-fit: cover;
            border-radius: 10px;
        }

        /* Khusus untuk gambar buku favorit yang diperbesar */
        .favorite-book {
            width: 240px; /* Perbesar gambar buku favorit */
            height: 360px; /* Perbesar gambar buku favorit */
            object-fit: cover;
            border-radius: 10px;
        }

        /* Efek hover pada gambar buku */
        .suggestion-card img:hover {
            transform: scale(1.1); /* Efek zoom in saat hover */
            transition: transform 0.3s ease;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .loading-overlay .loader {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <!-- Bagian Search Container -->
    <div class="search-container">
        <div class="search-bar">
            <span class="search-icon">🔍</span>     
            <input type="text" placeholder="Search Your Favorite Books">
            <span class="filter-icon">⚙️</span>
        </div>
    </div>
    
    <!-- Bagian Buku Favorit Pengguna -->
    <section>
        <h2>My Favorite Books</h2>
        <div class="suggestion-grid">
            <?php while($book = $books_result->fetch_assoc()): ?>
            <div class="suggestion-card">
                <a href="buku.php?id=<?php echo $book['id']; ?>">
                    <!-- Berikan class 'favorite-book' pada gambar buku favorit -->
                    <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="favorite-book">
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== ANIMASI LOADING =====
        // Tambahkan overlay loading dan hapus setelah halaman dimuat
        const body = document.body;
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'loading-overlay';
        loadingOverlay.innerHTML = '<div class="loader"></div>';
        body.appendChild(loadingOverlay);

        setTimeout(() => {
            loadingOverlay.style.opacity = '0';
            setTimeout(() => {
                loadingOverlay.remove();
            }, 500);
        }, 800);

        // ===== EFEK SEARCH BAR =====
        const searchBar = document.querySelector('.search-bar input');
        const searchIcon = document.querySelector('.search-icon');
        const filterIcon = document.querySelector('.filter-icon');

        // Efek focus pada search bar
        searchBar.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        searchBar.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });

        // Animasi icon pencarian
        searchIcon.addEventListener('click', function() {
            searchBar.focus();
        });

        // Efek hover pada filter icon
        filterIcon.addEventListener('mouseover', function() {
            this.style.transform = 'rotate(90deg)';
        });

        filterIcon.addEventListener('mouseout', function() {
            this.style.transform = 'rotate(0deg)';
        });

        // ===== LIVE SEARCH =====
        searchBar.addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const cards = document.querySelectorAll('.suggestion-card');
            
            // Dapatkan semua judul buku (dari alt text)
            cards.forEach(card => {
                const bookTitle = card.querySelector('img').alt.toLowerCase();
                
                if (bookTitle.includes(searchQuery)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    </script>
</body>
</html>
    