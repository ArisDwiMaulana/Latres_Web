<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // ambil data kue yn akan dihapus
    $stmt = mysqli_prepare($conn, "SELECT foto FROM kue WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $kue = mysqli_fetch_assoc($result);

    if ($kue) {
        // hapus gambar
        $path_foto = "uploads/" . $kue['foto'];
        if (!empty($kue['foto']) && file_exists($path_foto)) {
            unlink($path_foto);
        }

        // hapus data kue di db
        $del = mysqli_prepare($conn, "DELETE FROM kue WHERE id = ?");
        mysqli_stmt_bind_param($del, "i", $id);
        mysqli_stmt_execute($del);
    }
}

header("location: dashboard.php");
exit();
?>