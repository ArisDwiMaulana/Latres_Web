<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: login.php");
    exit();
}

$error = "";
if (isset($_POST["tambah"])) {
    $nama = trim($_POST["nama"]);
    $harga = (int) $_POST["harga"];
    $stock = (int) $_POST["stok"];

    $foto_name = $_FILES["foto"]["name"];
    $foto_tmp = $_FILES["foto"]["tmp_name"];
    $foto_err = $_FILES["foto"]["error"];

    if ($foto_err === 0) {
        $ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
        $allowed = ["jpg","jpeg","png","webp"];

        if (in_array($ext, $allowed)) {
            $nama_file_unik = uniqid("kue_", true) . "." . $ext;
            $tujuan = "uploads/" . $nama_file_unik;

            if (move_uploaded_file($foto_tmp, $tujuan)) {
                $stmt = mysqli_prepare($conn, "INSERT INTO kue (nama, harga, stok, foto) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "siis", $nama, $harga, $stock, $nama_file_unik);
                mysqli_stmt_execute($stmt);

                header("location: dashboard.php");
                exit();
            } else {
                $error = "Gagal memindahkan foto ke folder uploads/";
            }
        } else {
            $error = "Format gambar harus JPG, JPEG, PNG, WEBP";
        }
    } else {
        $error = "Silahkan pilih foto kue terlebih dahulu";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">
            <h3 class="mb-4">Tambah Kue</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Wajib ada enctype="multipart/form-data" untuk upload file -->
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kue</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>