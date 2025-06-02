<!-- header.php -->
<link rel="stylesheet" href="csshome.css">
<style>
    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }
    
    .username {
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }
    
    .profile-container {
        display: flex;
        align-items: center;
    }
    
    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-radius: 4px;
        min-width: 120px;
        display: none;
        z-index: 1000;
    }
    
    .profile-dropdown a {
        display: block;
        padding: 10px 15px;
        text-decoration: none;
        color: #333;
        transition: background-color 0.2s;
    }
    
    .profile-dropdown a:hover {
        background-color: #f5f5f5;
    }
    
    .user-profile:hover .profile-dropdown {
        display: block;
    }
    
    .profile-pic {
        cursor: pointer;
    }
    
    .login-button {
        background-color: #4285f4;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    
    .login-button:hover {
        background-color: #3367d6;
    }
</style>

<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header>
    <div class="logo-container">
        <img src="assets/ambaa.png" alt="Logo" class="logo">
        <a href="welcome.php" class="brand-name">AmbaRead</a>
    </div>
    
    <div class="nav-container">
        <nav>
            <ul>
                <li><a href="welcome.php" class="<?php echo ($current_page == 'welcome.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="mybooks.php" class="<?php echo ($current_page == 'mybooks.php') ? 'active' : ''; ?>">My Books</a></li>
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
                <li><a href="aboutus.php" class="<?php echo ($current_page == 'aboutus.php') ? 'active' : ''; ?>">Contact US</a></li>
                <?php 
                if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin') { ?>
                    <li><a href="before_admin_books.php" class="<?php echo ($current_page == 'before_admin_books.php') ? 'active' : ''; ?>">Edit Buku</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
    
    <div class="profile-container">
        <?php if (isset($_SESSION['username'])) { ?>
            <!-- Display user profile when logged in -->
            <div class="user-profile">
                <span class="username"><?php echo $_SESSION['username']; ?></span>
                <img src="<?php echo $profileImage; ?>" alt="Profile Picture" class="profile-pic">
                <div class="profile-dropdown">
                    <a href="profil.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php } else { ?>
            <!-- Display login button when not logged in -->
            <a href="login.php" class="login-button">Login</a>
        <?php } ?>
    </div>
</header>

<script>
// Only initialize the profile dropdown events if user is logged in
<?php if (isset($_SESSION['username'])) { ?>
    document.querySelector('.profile-pic').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('.profile-dropdown').style.display = 
            document.querySelector('.profile-dropdown').style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown when clicking elsewhere on the page
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.profile-pic')) {
            var dropdown = document.querySelector('.profile-dropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        }
    });
<?php } ?>
</script>