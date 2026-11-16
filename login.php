<?php
include "koneksi.php";
session_start();

$user_ada = true;
$passwd_benar = true;

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $query = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($query, "s", $username);
    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["user-id"] = $user["id"];
            $_SESSION["name"] = $user["username"];

            header("location: dashboard.php");
            exit();
        } else {
            $passwd_benar = false;
        }
    } else {
        $user_ada = false;
    }
}
?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100">
    <div class="d-flex justify-content-center align-items-center h-100 px-3">
        <div class="shadow-sm p-4 p-md-5 bg-body rounded" style="width: 100%; max-width: 400px;">
            <h3 class="text-center mb-4">Login</h3>
            <form action="" method="POST">
                <?php if (!$user_ada): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        Username tidak ada
                    </div>
                <?php endif; ?>
                <?php if (!$passwd_benar): ?>
                    <div class="alert alert-danger py-2" role="alert">
                        Password salah
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
                <button type="submit" name="login" class="btn btn-primary w-100 mb-3">Login</button>
                <p class="text-center mb-0">Belum punya akun? <a href="register.php">Register</a></p>
            </form>
        </div>
    </div>
</body>
</html>
