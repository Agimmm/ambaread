<?php
session_start();

// Cek apakah user adalah admin
if ($_SESSION['username'] !== 'admin') {
    header('Location: welcome.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Buku</title>
    <link rel="stylesheet" href="csshome.css">
    <style>
        /* Tambahan styling untuk tombol */
        .admin-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .admin-box {
            text-align: center;
            background-color: #a4c0ed;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .admin-box h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .admin-btn {
            width: 100%;
            padding: 15px;
            background-color: #4361ee;
            color: white;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease;
        }

        .admin-btn:hover {
            background-color: #3a56d4;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-box">
            <h2>Kelola Buku</h2>
            <a href="edit_admin_books.php">
                <button class="admin-btn">Edit Buku</button>
            </a>
            <a href="tambah_admin_books.php">
                <button class="admin-btn">Tambah Buku</button>
            </a>
        </div>
    </div>
</body>
</html>
