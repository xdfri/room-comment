<?php
// menyimpan ke variabel 
$servername = "localhost:8111"; //sesuaikan port yang kalian gunakan
$username = "root";
$password = "";
$dbname = "komen"; // sesuaikan dengan database kalian

// Buat koneksi
$koneksi = new mysqli($servername, $username, $password, $dbname);

// cek koneksi
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

//<link rel="icon" href="icon.web.png" type="image/gif">
?>

