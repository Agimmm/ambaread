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

// Fetch trending books
$trending_query = "SELECT * FROM books ORDER BY rating DESC LIMIT 7";
$trending_result = $conn->query($trending_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbaRead</title>
    <link rel="stylesheet" href="csshome.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="assets/ambaa.jpg" alt="Logo" class="logo">
            <div class="brand-name">AmbaRead</div>
        </div>
        
        <div class="nav-container">
            <nav>
                <ul>
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="#">My Books</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-btn">Genre ▼</a>
                        <div class="dropdown-content">
                            <div class="dropdown-column">
                                <h4>Fiction</h4>
                                <a href="#">Fantasy</a>
                                <a href="#">Science Fiction</a>
                                <a href="#">Mystery</a>
                                <a href="#">Thriller</a>
                                <a href="#">Romance</a>
                                <a href="#">Horror</a>
                                <a href="#">Historical Fiction</a>
                                <a href="#">Literary Fiction</a>
                            </div>
                            <div class="dropdown-column">
                                <h4>Non-Fiction</h4>
                                <a href="#">Biography</a>
                                <a href="#">Memoir</a>
                                <a href="#">Self-Help</a>
                                <a href="#">Business</a>
                                <a href="#">History</a>
                                <a href="#">Science</a>
                                <a href="#">Philosophy</a>
                                <a href="#">Travel</a>
                            </div>
                        </div>
                    </li>
                    <li><a href="#">Contact US</a></li>
                    <?php 
if ($_SESSION['username'] === 'admin') { ?>
    <li><a href="before_admin_books.php">Edit Buku</a></li>
<?php } ?>
                </ul>
            </nav>
        </div>
        
        <div class="profile-container">
            <a href="profil.php" title="Laman Profil">
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-pic">
            </a>
        </div>
    </header>
    
    <div class="search-container">
        <div class="search-bar">
            <span class="search-icon">🔍</span>     
            <input type="text" placeholder="Search Your Books">
            <span class="filter-icon">⚙️</span>
        </div>
    </div>
    
    <section>
        <h2>Trending Books</h2>
        <div class="book-grid">
            <?php while($book = $trending_result->fetch_assoc()): ?>
            <div class="book-card">
                <a href="buku.php?id=<?php echo $book['id']; ?>">
                    <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="author-image">
                    <div class="book-title"><?php echo htmlspecialchars($book['title']); ?></div>
                    <div class="author-name"><?php echo htmlspecialchars($book['author']); ?></div>
                    <div class="book-desc"><?php echo htmlspecialchars(substr($book['description'], 0, 50)); ?>...</div>
                    <div class="stars">
                        <?php 
                        $rating = round($book['rating']);
                        for($i = 1; $i <= 5; $i++) {
                            echo $i <= $rating ? '★' : '☆';
                        }
                        ?>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    
    <section>
        <h2>Suggestions</h2>
        <div class="suggestion-grid">
            <?php 
            // Reset the pointer
            $trending_result->data_seek(0);
            while($book = $trending_result->fetch_assoc()): 
            ?>
            <div class="suggestion-card">
                <a href="buku.php?id=<?php echo $book['id']; ?>">
                    <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                </a>
            </div>
            <?php endwhile; ?>
        </div>
    </section>
    
    <footer>
        <div class="footer-content">
            <div class="company-work-container">
                <div>
                    <div class="footer-section">
                        <h3>COMPANY</h3>
                        <ul>
                            <li><a href="#">About us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">Privacy</a></li>
                            <li><a href="#">Interest Based Ads</a></li>
                            <li><a href="#">Ads Preferences</a></li>
                            <li><a href="#">Help</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>WORK WITH US</h3>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Advertise</a></li>
                        <li><a href="#">Author & Ads blog</a></li>
                        <li><a href="#">API</a></li>
                    </ul>
                </div>
            </div>
            
            <div>
                <div class="footer-section">
                    <h3>CONTACT</h3>
                    <div class="social-icons">
                        <img src="assets/facebook.png" alt="Facebook" class="social-icon">
                        <img src="assets/x.png" alt="X (Twitter)" class="social-icon">
                        <img src="assets/apple.png" alt="Apple" class="social-icon">
                        <img src="assets/linkedin.png" alt="LinkedIn" class="social-icon">
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>SUPPORT</h3>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Search Guide</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-brand">
                <div class="footer-brand-name">AmbaRead</div>
                <div class="app-buttons">
                    <a href="#" class="app-button">
                       <img src="assets/getplaystore.png">
                    </a>
                    <a href="#" class="app-button">
                      <img src="assets/getappstore.png">
                    </a>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            Copyright © YYYY - YYYY Company name. All rights reserved
        </div>
    </footer>
</body>
</html>