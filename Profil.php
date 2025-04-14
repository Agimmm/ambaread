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
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbaRead - Profile</title>
    <link rel="stylesheet" href="profilcss.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="assets/ambaa.jpg" alt="Logo" class="logo">
            <span class="brand-name">AmbaRead</span>
        </div>
        
        <div class="nav-container">
            <nav>
                <ul>
                    <li><a href="welcome.php" class="active">Home</a></li>
                    <li><a href="my-books.php">My Books</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-btn">Genre</a>
                        <div class="dropdown-content">
                            <div class="dropdown-column">
                                <h4>Fiction</h4>
                                <a href="#">Fantasy</a>
                                <a href="#">Science Fiction</a>
                                <a href="#">Mystery</a>
                                <a href="#">Romance</a>
                            </div>
                            <div class="dropdown-column">
                                <h4>Non-Fiction</h4>
                                <a href="#">Biography</a>
                                <a href="#">History</a>
                                <a href="#">Self-Help</a>
                                <a href="#">Business</a>
                            </div>
                        </div>
                    </li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </nav>
        </div>
        
        <div class="profile-container">
            <img src="<?php echo $profileImage; ?>" alt="Profile" class="profile-pic">
        </div>
    </header>

  

    <main>
        <h2>Profile</h2>
        <div class="edit-profile-btn">
            <a href="profile.php">
                <button>Edit Profile <i class="fas fa-edit"></i></button>
            </a>
        </div>

        <section class="profile-card">
            <div class="profile-left">
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-image">
                <h3>Details</h3>
                <div class="profile-details-small">
                    <p>Male, City, Country</p>
                    <p>Birth Day : DD/MM/YYYY</p>
                </div>
            </div>

            <div class="profile-right">
                <h3><?php echo $user['username']; ?></h3>
                <div class="stats-container">
                    <div class="stat-box">
                        <p class="stat-number">150</p>
                        <p class="stat-label">Books</p>
                    </div>
                    <div class="stat-box">
                        <p class="stat-number">1,715</p>
                        <p class="stat-label">Pages</p>
                    </div>
                    <div class="stat-box">
                        <p class="stat-number">8</p>
                        <p class="stat-label">Following</p>
                    </div>
                </div>

                <h3>Details</h3>
                <p class="bio">FAVORITE GENRE: SCI-FI</p>
                <p class="bio">READING SERIES</p>
                <p class="bio">Favorite Novels/Titles: Fantasy, Science Fiction, YA Novels</p>

                <h3>My Bookshelves</h3>
                <div class="bookshelf-btns">
                    <button class="bookshelf-btn">Read <span>149</span></button>
                    <button class="bookshelf-btn">Currently Reading <span>1</span></button>
                    <button class="bookshelf-btn">To Read <span>144</span></button>
                </div>
            </div>
        </section>

        <section class="reading-section">
            <h2>Reading</h2>
            <div class="book-card">
                <div class="book-cover">
                    <img src="book-cover.jpg" alt="Book Cover">
                </div>
                <div class="book-info">
                    <h3>Book Name</h3>
                    <p>Author Name</p>
                    <div class="rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div class="progress" style="width: 33%;"></div>
                        </div>
                        <span class="progress-text">33%</span>
                    </div>
                    <button class="continue-btn">Continue</button>
                </div>
            </div>
        </section>

        <section class="statistics-section">
            <h2>This Week Statistics</h2>
            <div class="chart-container">
                <div class="chart">
                    <div class="y-axis">
                        <div class="y-label">5h</div>
                        <div class="y-label">4h</div>
                        <div class="y-label">3h</div>
                        <div class="y-label">2h</div>
                        <div class="y-label">1h</div>
                        <div class="y-label">0h</div>
                    </div>
                    <div class="bars">
                        <div class="bar-container">
                            <div class="bar" style="height: 25%;"></div>
                            <div class="x-label">Mon</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 40%;"></div>
                            <div class="x-label">Tue</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 20%;"></div>
                            <div class="x-label">Wed</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 30%;"></div>
                            <div class="x-label">Thu</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 15%;"></div>
                            <div class="x-label">Fri</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 45%;"></div>
                            <div class="x-label">Sat</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar" style="height: 10%;"></div>
                            <div class="x-label">Sun</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="company-work-container">
                <div class="footer-section">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Work With Us</h3>
                    <ul>
                        <li><a href="#">Authors</a></li>
                        <li><a href="#">Advertisers</a></li>
                        <li><a href="#">Publishers</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-section">
                <h3>Connect With Us</h3>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="app-buttons">
                    <a href="#" class="app-button">
                        <i class="fab fa-apple"></i>
                        <span>App Store</span>
                    </a>
                    <a href="#" class="app-button">
                        <i class="fab fa-google-play"></i>
                        <span>Google Play</span>
                    </a>
                </div>
                <button class="logout-btn">Logout</button>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 AmbaRead. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>