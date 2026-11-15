<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("location: dashboard.php");
    exit();
}

$id = (int) $_GET["id"];

// ambil data lama
$stmt = mysqli_prepare($conn, "SELECT * FROM kue where id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$kue = mysqli_fetch_assoc($result);

if (!$kue) {
    header("location: dashboard.php");
    exit();
}

$error = "";
if (isset($_POST["simpan"])) {
    $nama  = trim($_POST["nama"]);
    $harga = (int) $_POST["harga"];
    $stok  = (int) $_POST["stok"];
    $foto_final = $kue["foto"]; // foto lama

    // user upload foto baru ?
    if ($_FILES["foto"]["error"] === 0) {
        $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $nama_file_unik = uniqid("kue_", true) . "." . $ext;
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], "uploads/" . $nama_file_unik)) {
                // Hapus file foto lama jika ada di folder uploads
                if (!empty($kue["foto"]) && file_exists("uploads/" . $kue["foto"])) {
                    unlink("uploads/" . $kue["foto"]);
                }
                $foto_final = $nama_file_unik;
            } else {
                $error = "Gagal mengupload foto baru.";
            }
        } else {
            $error = "Format gambar harus JPG, JPEG, PNG, atau WEBP.";
        }
    }

    if ($error === "") {
        $update = mysqli_prepare($conn, "UPDATE kue SET nama = ?, harga = ?, stok = ?, foto = ? WHERE id = ?");
        mysqli_stmt_bind_param($update, "siisi", $nama, $harga, $stok, $foto_final, $id);
        mysqli_stmt_execute($update);

        header("location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container d-flex justify-content-center">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 500px;">
            <h3 class="mb-4">Edit Kue</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label d-block">Foto Lama:</label>
                    <img src="uploads/<?= htmlspecialchars($kue['foto']) ?>"
                         alt="Foto Lama"
                         class="rounded border"
                         style="width: 150px; height: 100px; object-fit: cover;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kue</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($kue['nama']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control" min="0" value="<?= (int) $kue['harga'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" min="0" value="<?= (int) $kue['stok'] ?>" required>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="simpan" class="btn btn-warning">Simpan Perubahan</button>
                    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>