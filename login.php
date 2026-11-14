<?php
include "koneksi.php";
if (isset($_POST["login"])) {
    $username = $_POST["username"];
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
            echo "<div class='alert theme-danger' role='alert'>
              <p>Password salah</p>
            </div>";
        }
    } else {
        echo "<div class='alert theme-danger' role='alert'>
          <p>Username tidak ada</p>
        </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
	<script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
</head>
<body class="vh-100">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="w-25 shadow-xl shadow-black p-5 bg-body rounded">
            <h3><center>Login</center></h3>
            <form action="" method="POST">
              <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <button type="submit" name="login" class=" btn-solid w-100 theme-primary">Login</button>
              <p class=""><center>Belum punya akun ? <a href="register.php">Register</a></center></p>
            </form>
        </div>
    </div>

</body>
</html>
