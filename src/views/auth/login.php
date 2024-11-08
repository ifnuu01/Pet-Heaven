<?php

require_once '../../functions/connection.php';
require_once '../../functions/auth_function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $message = login($conn, $username, $password);
    if ($message['status']) {
        echo "<script>alert('$message[message]');</script>";
        echo "<script>location.href='../../../public/index.php';</script>";
    } else {
        echo "<script>alert('$message[message]');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Pet-Heaven</title>
    <link rel="stylesheet" href="../../../assets/css/auth.css">
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form action="#" method="POST">
                <h1>Masuk</h1>
                <div class="input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" autofocus required>
                </div>
                <div class="input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>
            <span>Belum memiliki akun? <a href="registrasi.php" class="regis">Buat akun sekarang</a></span>
        </div>
    </div>
</body>
</html>