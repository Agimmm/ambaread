<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <img src="assets/ambaa.jpg" alt="Logo" class="logo">
        <span class="site-title">AmbaRead</span>
    </div>
    <div class="login-container">
        <div class="login-box">
            <h2>Welcome Back</h2>
            <p>Login to Continue</p>
            <form action="proses_login.php" method="POST">
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="username" name="username" placeholder="Enter Username" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
            <a href="#" class="forgot-password">Forgot password?</a>
            <p>Login with</p>
            <div class="social-login">
                <img src="assets/google.png" alt="Google">
                <img src="assets/apple.png" alt="Apple">
                <img src="assets/facebook.png" alt="Facebook">
                <img src="assets/x.png" alt="X">
            </div>
            <p>New User? <a href="register.php" class="sign-up">Sign Up</a></p>
        </div>
    </div>
</body>
</html>
