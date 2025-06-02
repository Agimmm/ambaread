<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    echo "Error: Pengguna tidak terautentikasi.";
    exit();
}

$username = $_SESSION['username'];  

// Ambil book_id dan action dari form
$book_id = isset($_POST['book_id']) ? intval($_POST['book_id']) : 0;
$action = isset($_POST['action']) ? $_POST['action'] : '';

// Periksa apakah book_id valid dan action terdefinisi
if ($book_id > 0 && in_array($action, ['add', 'remove'])) {
    // Ambil user_id berdasarkan username
    $user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $user_query->bind_param("s", $username);
    $user_query->execute();
    $user_result = $user_query->get_result();
    
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];

        if ($action === 'add') {
            // Periksa apakah buku sudah ada di favorit pengguna
            $check_query = $conn->prepare("SELECT * FROM favorites WHERE user_id = ? AND book_id = ?");
            $check_query->bind_param("ii", $user_id, $book_id);
            $check_query->execute();
            $check_result = $check_query->get_result();

            if ($check_result->num_rows == 0) {
                // Jika belum ada, tambahkan ke favorit
                $add_query = $conn->prepare("INSERT INTO favorites (user_id, book_id) VALUES (?, ?)");
                $add_query->bind_param("ii", $user_id, $book_id);
                if ($add_query->execute()) {
                    echo "Buku berhasil ditambahkan ke favorit!";
                } else {
                    echo "Error: Gagal menambahkan buku ke favorit.";
                }
            } else {
                echo "Buku ini sudah ada di favorit Anda.";
            }
        } elseif ($action === 'remove') {
            // Hapus buku dari favorit
            $remove_query = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND book_id = ?");
            $remove_query->bind_param("ii", $user_id, $book_id);
            if ($remove_query->execute()) {
                echo "Buku berhasil dihapus dari favorit.";
            } else {
                echo "Error: Gagal menghapus buku dari favorit.";
            }
        }
    } else {
        echo "Error: Pengguna tidak ditemukan.";
    }
} else {
    echo "Error: Buku atau tindakan tidak valid.";
}
?>
