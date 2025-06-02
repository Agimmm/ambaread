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

// Fetch all books for search functionality
$all_books_query = "SELECT * FROM books";
$all_books_result = $conn->query($all_books_query);
$all_books = [];
while($book = $all_books_result->fetch_assoc()) {
    $all_books[] = $book;
}
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
<?php include 'header.php'; ?>

    <!-- Tambahkan banner selamat datang di sini -->
    <div class="welcome-banner">Selamat datang kembali, <?php echo htmlspecialchars($user['username']); ?>!</div>
    
    <div class="search-container">
        <div class="search-bar">
            <span class="search-icon">🔍</span>     
            <input type="text" id="searchInput" placeholder="Search Your Books">
            <span class="filter-icon">⚙️</span>
        </div>
    </div>
    
    <!-- Regular content - shown by default -->
    <div class="regular-content">
        <section>
            <h2>Trending Books</h2>
            <div class="suggestion-grid">
                <?php while($book = $trending_result->fetch_assoc()): ?>
                <div class="suggestion-card">
                    <a href="buku.php?id=<?php echo $book['id']; ?>">
                        <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
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
    </div>
    
    <!-- Search results - hidden by default -->
    <div class="search-results">
        <section>
            <h2>Books keyword: "<span id="searchKeyword"></span>"</h2>
            <div id="searchResultsGrid" class="suggestion-grid">
                <!-- Search results will be populated here via JavaScript -->
            </div>
            <div id="noResults" class="no-results" style="display: none;">
                Tidak ada buku yang sesuai dengan pencarian Anda.
            </div>
        </section>
    </div>
    
    <?php include 'footer.php'; ?>

    <script>
    // Store all books from PHP to JavaScript
    const allBooks = <?php echo json_encode($all_books); ?>;
    
    document.addEventListener('DOMContentLoaded', function() {
        // ===== SEARCH FUNCTIONALITY =====
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.querySelector('.search-results');
        const regularContent = document.querySelector('.regular-content');
        const searchKeyword = document.getElementById('searchKeyword');
        const searchResultsGrid = document.getElementById('searchResultsGrid');
        const noResults = document.getElementById('noResults');
        
        // Function to perform search
        function performSearch() {
            const searchQuery = searchInput.value.trim().toLowerCase();
            
            // Update keyword display
            searchKeyword.textContent = searchQuery;
            
            // If search is empty, show regular content
            if (searchQuery === '') {
                document.body.classList.remove('searching');
                return;
            }
            
            // Switch to search mode
            document.body.classList.add('searching');
            
            // Filter books based on search query
            const filteredBooks = allBooks.filter(book => 
                book.title.toLowerCase().includes(searchQuery) || 
                (book.author && book.author.toLowerCase().includes(searchQuery))
            );
            
            // Clear previous results
            searchResultsGrid.innerHTML = '';
            
            // Show no results message if needed
            if (filteredBooks.length === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
                
                // Populate search results
                filteredBooks.forEach(book => {
                    const card = document.createElement('div');
                    card.className = 'suggestion-card';
                    
                    card.innerHTML = `
                        <a href="buku.php?id=${book.id}">
                            <img src="${book.cover_image}" alt="${book.title}">
                        </a>
                    `;
                    
                    searchResultsGrid.appendChild(card);
                });
            }
        }
        
        // Event listeners for search
        searchInput.addEventListener('input', performSearch);
        
        // Clear search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                if (searchInput.value.trim() === '') {
                    document.body.classList.remove('searching');
                }
            }
        });
    
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

        // ===== WELCOME BANNER =====
        const welcomeBanner = document.querySelector('.welcome-banner');
        
        // Tampilkan welcome banner
        setTimeout(() => {
            welcomeBanner.classList.add('show');
            
            // Sembunyikan setelah beberapa detik
            setTimeout(() => {
                welcomeBanner.classList.remove('show');
            }, 3000);
        }, 1000);

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

        // ===== SCROLL ANIMATIONS =====
        // Tambahkan animasi saat section muncul ketika di-scroll
        const sections = document.querySelectorAll('section');
        
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const sectionObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('section-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        sections.forEach(section => {
            section.classList.add('section-hidden');
            sectionObserver.observe(section);
        });

        // ===== SLIDER BUKU =====
        // Implementasi slider sederhana untuk bagian trending books
        const sliders = document.querySelectorAll('.suggestion-grid');
        
        sliders.forEach(slider => {
            let isDown = false;
            let startX;
            let scrollLeft;
            let moved = false;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.classList.add('active');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                moved = false;
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                slider.classList.remove('active');
            });

            slider.addEventListener('mouseup', (e) => {
                isDown = false;
                slider.classList.remove('active');
                
                // Jangan mencegah navigasi jika tidak bergerak
                if (moved) {
                    e.preventDefault();
                }
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                moved = true;
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Kecepatan scroll
                slider.scrollLeft = scrollLeft - walk;
            });
        });
    });zz
    </script>
</body>
</html>