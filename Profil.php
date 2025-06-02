<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    // Jika belum login, redirect ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil data user dari database untuk pengguna yang login
$username = $_SESSION['username'];
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

// Ambil user_id untuk query favorit
$user_id = $user['id'];

// Tentukan lokasi gambar profil
$profileImage = !empty($user['foto_profil']) ? "uploads/".$user['foto_profil'] : "/api/placeholder/50/50";

// Menangani pencarian profil pengguna lain
$username_to_view = isset($_GET['username']) ? $_GET['username'] : $user['username']; // Default ke username pengguna yang login

// Ambil data pengguna yang dicari
$search_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$search_query->bind_param("s", $username_to_view);
$search_query->execute();
$search_result = $search_query->get_result();
$profile_user = $search_result->fetch_assoc();

// Ambil user_id dari profil yang dilihat (bukan dari yang login)
$profile_user_id = $profile_user['id'];

// Query untuk mengambil 3 buku favorit pengguna yang sedang dilihat
$fav_books_query = "
    SELECT books.* 
    FROM books
    INNER JOIN favorites ON books.id = favorites.book_id
    WHERE favorites.user_id = ?
    LIMIT 3";
$fav_books_stmt = $conn->prepare($fav_books_query);
$fav_books_stmt->bind_param("i", $profile_user_id);  // Menggunakan user_id profil yang dilihat
$fav_books_stmt->execute();
$fav_books_result = $fav_books_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmbaRead - Profile</title>
    <link rel="stylesheet" href="profilcss.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styling for search bar */
        .search-container {
            position: relative;
            max-width: 500px;
            margin: 30px auto;
            width: 100%;
        }

        #search-bar {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: #f8f8f8;
            transition: all 0.3s ease;
        }

        #search-bar:focus {
            outline: none;
            border-color: #4CAF50;
            background-color: #fff;
        }

        #search-bar::placeholder {
            color: #bbb;
            font-style: italic;
        }

        #search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            max-height: 250px;
            overflow-y: auto;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            z-index: 10;
            display: none; /* Initially hidden */
        }

        .suggestion-item {
            padding: 12px 18px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .suggestion-item:hover {
            background-color: #f1f1f1;
        }

        .suggestion-item:active {
            background-color: #e0e0e0;
        }

        /* Styling for favorite books section */
        .favorite-books-container {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: #f9f2e2;
            padding: 20px;
            margin-bottom: 30px;
        }

        .favorite-books-wrapper {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 25px;
        }

        .favorite-book {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
            transition: transform 0.3s ease;
            text-align: center;
        }

        .favorite-book:hover {
            transform: translateY(-5px);
        }

        .favorite-book .book-cover img {
            width: 150px;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 12px;
        }

        .favorite-book .book-info {
            width: 100%;
        }

        .favorite-book .book-info h3 {
            font-size: 16px;
            margin: 8px 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .favorite-book .book-info .author {
            font-size: 14px;
            color: #666;
            margin-bottom: 6px;
        }

        .favorite-book .rating {
            color: #FFC107;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .view-all-container {
            text-align: center;
            margin-top: 15px;
        }

        .view-all-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
            font-weight: 500;
        }

        .view-all-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }

        .no-favorites {
            text-align: center;
            padding: 30px;
            background-color: #f8f8f8;
            border-radius: 8px;
            color: #666;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <main>
        <h2>Profile</h2>

        <!-- Show Edit Profile button only if the user is viewing their own profile -->
        <?php if ($username_to_view == $user['username']): ?>
            <div class="edit-profile-btn">
                <a href="profile.php">
                    <button>Edit Profile <i class="fas fa-edit"></i></button>
                </a>
            </div>
        <?php endif; ?>

        <!-- Search bar for other users -->
        <div class="search-container">
            <input type="text" id="search-bar" placeholder="Search for a user..." value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>">
            <div id="search-suggestions"></div> <!-- Auto-suggestions here -->
        </div>

        <section class="profile-card">
            <div class="profile-left">
                <img src="<?php echo !empty($profile_user['foto_profil']) ? "uploads/".$profile_user['foto_profil'] : "/api/placeholder/50/50"; ?>" alt="Profile Picture" class="profile-image">
                <h3>Details</h3>
                <div class="profile-details-small">
                    <p>Male, City, Country</p>
                    <p>Birth Day : DD/MM/YYYY</p>
                </div>
            </div>

            <div class="profile-right">
                <h3><?php echo $profile_user['username']; ?></h3>
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

        <!-- Mengganti section Reading dengan Favorite Books -->
        <section class="reading-section">
            <h2>Favorite Books</h2>
            <div class="favorite-books-container">
                <?php if($fav_books_result->num_rows > 0): ?>
                    <div class="favorite-books-wrapper">
                        <?php $counter = 0; ?>
                        <?php while($book = $fav_books_result->fetch_assoc()): ?>
                            <div class="favorite-book" data-book-id="<?php echo $book['id']; ?>">
                                <div class="book-cover">
                                    <img src="<?php echo $book['cover_image']; ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                                </div>
                                <div class="book-info">
                                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                    <p class="author"><?php echo htmlspecialchars($book['author']); ?></p>
                                    <div class="rating">
                                        <span class="star">★</span>
                                        <span class="star">★</span>
                                        <span class="star">★</span>
                                        <span class="star">★</span>
                                        <span class="star">★</span>
                                    </div>
                                </div>
                            </div>
                            <?php $counter++; ?>
                            <?php if($counter >= 3) break; // Limit to 3 books ?>
                        <?php endwhile; ?>
                    </div>
                    <div class="view-all-container">
                        <a href="mybooks.php">
                            <button class="view-all-btn">View All Favorites <i class="fas fa-arrow-right"></i></button>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="no-favorites">
                        <p>You haven't added any favorite books yet.</p>
                        <a href="explore.php">
                            <button class="view-all-btn">Explore Books <i class="fas fa-search"></i></button>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        // Handle keyup event in the search bar
        $('#search-bar').on('keyup', function() {
            var query = $(this).val(); // Get the value of the search bar

            // If the query is not empty, send an AJAX request
            if (query.length > 0) {
                $.ajax({
                    url: 'search_suggestions.php', // The PHP file that handles the search
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        // Display the results in the suggestion box
                        $('#search-suggestions').html(response).show();
                    }
                });
            } else {
                // If query is empty, hide the suggestions
                $('#search-suggestions').hide();
            }
        });

        // If a suggestion is clicked, set it in the search bar and submit the form
        $(document).on('click', '.suggestion-item', function() {
            $('#search-bar').val($(this).text()); // Set the search bar value
            window.location.href = 'profil.php?username=' + $(this).text(); // Redirect to selected user's profile
        });
    });
    </script>
</body>
</html>
