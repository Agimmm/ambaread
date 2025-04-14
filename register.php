<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <a href="login.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali ke Login</a>
            <h2>Registrasi</h2>
            <form action="proses_register.php" method="POST">
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Enter Username" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </div>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="register-btn">Daftar</button>
            </form>
        </div>
    </div>
</body>
</html>
