<?php
// Otomatis menggunakan 'db' jika pakai docker, dan 'localhost' jika XAMPP native
$host = file_exists("/.dockerenv") ? "db" : "localhost";
$user = "root";
$pass = "";
$db = "toko_roti";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
