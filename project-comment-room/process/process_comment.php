<?php
// Menyimpan ke variabel
$servername = "localhost:8111"; // Sesuaikan port yang digunakan
$username = "root";
$password = "";
$dbname = "komen"; // Sesuaikan dengan database

// Buat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Periksa apakah form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = $_POST['comment'];
    $parent_id = isset($_POST['parent_id']) ? $_POST['parent_id'] : null;
    $username = 'Anonymous'; // Bisa menambahkan input nama jika diperlukan

    // Menghindari SQL Injection dan siapkan query
    $stmt = $koneksi->prepare("INSERT INTO comments (username, comment, parent_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $username, $comment, $parent_id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman utama setelah menyimpan komentar
        header('Location: ../index.php');
        exit(); // Pastikan tidak ada kode tambahan yang dijalankan setelah redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Tutup koneksi
$koneksi->close();
?>