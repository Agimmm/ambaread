<?php
include 'koneksi.php';

// Ambil input pencarian
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    
    $search_query = "SELECT username FROM users WHERE username LIKE ? LIMIT 10";
    $stmt = $conn->prepare($search_query);
    $like_query = $query . '%'; 
    $stmt->bind_param("s", $like_query);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            echo '<div class="suggestion-item"><a href="profil.php?username=' . htmlspecialchars($row['username']) . '">' . htmlspecialchars($row['username']) . '</a></div>';
        }
    } else {
        echo 'No users found';
    }

    $stmt->close();
    $conn->close();
}
?>
