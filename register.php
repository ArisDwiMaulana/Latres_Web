<?php
include "koneksi.php";

$error = "";

if (isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) > 0) {
        $error = "Username sudah ada";
    } else {
        $query = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, password) VALUES (?, ?)",
        );
        mysqli_stmt_bind_param($query, "ss", $username, $hash_password);
        if (mysqli_stmt_execute($query)) {
            header("location: login.php");
            exit();
        } else {
            $error = "Register gagal";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100">
    <div class="d-flex justify-content-center align-items-center h-100 px-3">
        <div class="shadow-sm p-4 p-md-5 bg-body rounded" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Register</h3>
            <form action="" method="POST">
                <?php if ($error !== ""): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="register" class="btn btn-success w-100 mb-3">Submit</button>
                <p class="text-center mb-0">Sudah punya akun? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
