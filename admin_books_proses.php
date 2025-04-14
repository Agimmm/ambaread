<?php
session_start();
include 'koneksi.php';

// Cek apakah user adalah admin
if ($_SESSION['username'] !== 'admin') {
    header('Location: welcome.php');
    exit();
}

// Fungsi untuk upload gambar
function uploadGambar($file) {
    $targetDir = "uploads/"; // Folder tujuan penyimpanan gambar
    $fileName = basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Validasi file gambar (hanya image yang diperbolehkan)
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return false;
    }

    // Cek apakah file sudah ada
    if (file_exists($targetFile)) {
        return false;
    }

    // Cek ukuran file (maksimal 5MB)
    if ($file["size"] > 5000000) {
        return false;
    }

    // Cek ekstensi file (hanya .jpg, .jpeg, .png, .gif)
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        return false;
    }

    // Pindahkan file ke folder
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    } else {
        return false;
    }
}

// Proses tambah buku
if (isset($_POST['tambah'])) {
    // Ambil data dari form
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $deskripsi = $_POST['deskripsi'];
    $rating = $_POST['rating'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];
    $total_pages = $_POST['total_pages'];
    
    // Proses upload gambar
    if (isset($_FILES['cover'])) {
        $cover = uploadGambar($_FILES['cover']);
        if ($cover === false) {
            echo "Gambar tidak valid.";
            exit();
        }
    }

    // Query untuk memasukkan data ke database
    $query = "INSERT INTO books (title, author, description, rating, genre, publication_year, total_pages, cover_image) 
              VALUES ('$judul', '$penulis', '$deskripsi', '$rating', '$genre', '$publication_year', '$total_pages', '$cover')";
    
    if ($conn->query($query) === TRUE) {
        header('Location: before_admin_books.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Proses update buku
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $deskripsi = $_POST['deskripsi'];
    $rating = $_POST['rating'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];
    $total_pages = $_POST['total_pages'];
    $cover = $_POST['cover'];

    // Jika ada file baru untuk sampul buku
    if (isset($_FILES['cover']) && $_FILES['cover']['name'] != "") {
        $cover = uploadGambar($_FILES['cover']);
        if ($cover === false) {
            echo "Gambar tidak valid.";
            exit();
        }
    }

    // Query untuk update data buku di database
    $query = "UPDATE books SET title='$judul', author='$penulis', description='$deskripsi', 
              rating='$rating', genre='$genre', publication_year='$publication_year', total_pages='$total_pages', cover_image='$cover' 
              WHERE id=$id";
    
    if ($conn->query($query) === TRUE) {
        header('Location: before_admin_books.php');
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>
