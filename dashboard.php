<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("location: login.php");
    exit();
}

$query = "SELECT * FROM kue ORDER BY id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Gunakan Bootstrap 5.3 yang valid -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .kue-photo {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
        }
    </style>
</head>
<body class="p-4 p-md-5">
    <nav class="container d-flex justify-content-end mb-4">
        <a class="btn btn-danger" href="logout.php" role="button">Logout</a>
    </nav>

    <main class="container">
        <div class="row g-4">
			<h1 class="page-title h2">Katalog Kue</h1>
            <?php while ($kue = $result->fetch_assoc()): ?>
                <div class="mt-0 col-12 col-sm-6 col-md-4 col-lg-3">
                    <article class="card kue-card h-100 shadow-sm">
                        <img src="<?= "uploads/" . htmlspecialchars($kue['foto']) ?>"
                             class="card-img-top kue-photo"
                             alt="Foto <?= htmlspecialchars($kue['nama']) ?>"
                             loading="lazy">
                        <div class="card-body d-flex flex-column p-3">
                            <h2 class="h5 kue-name"><?= htmlspecialchars($kue['nama']) ?></h2>
                            <div class="kue-meta text-muted small mb-3">
                                <div>Harga: <span class="price-tag fw-semibold text-dark">Rp <?= number_format($kue['harga'], 0, ',', '.') ?></span></div>
                                <div>Stok: <strong><?= (int) $kue['stok'] ?></strong></div>
                            </div>
                            <div class="kue-actions d-flex gap-2 mt-auto">
                                <a href="edit_kue.php?id=<?= (int) $kue['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </a>
                                <a href="hapus_kue.php?id=<?= (int) $kue['id'] ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin ingin menghapus kue ini?');">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
			<div class="mt-4">
			    <a href="tambah_kue.php" class="btn btn-primary">
			        <i class="bi bi-plus-lg me-1"></i>Tambah Kue
			    </a>
			</div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>