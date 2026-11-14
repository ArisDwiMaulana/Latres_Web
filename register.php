<?php
include "koneksi.php";
if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");

    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) > 0) {
        echo "Username sudah ada";
    } else {
        $query = mysqli_prepare(
            $conn,
            "INSERT INTO users (username, password) VALUES (?,?)",
        );
        mysqli_stmt_bind_param($query, "ss", $username, $hash_password);
        if (mysqli_stmt_execute($query)) {
            header("location: login.php");
        } else {
            echo "Register gagal";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
	<script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body class="vh-100">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="w-25 shadow-xl shadow-black p-5 bg-body rounded">
            <h3><center>Register</center></h3>
            <form action="" method="POST">
              <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <button type="submit" name="register" class=" btn-solid w-100 theme-success">Submit</button>
              <p class=""><center>Sudah punya akun ? <a href="login.php">Login</a></center></p>
            </form>
        </div>
    </div>

</body>
</html>
