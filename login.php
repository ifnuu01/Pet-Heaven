<?php
session_start();

require_once 'functions/connection.php';
require_once 'functions/auth_function.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'Admin') {
        echo "<script>location.href='dashboard';</script>";
    } else {
        echo "<script>location.href='/';</script>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $message = login($conn, $username, $password);
    if ($message['status']) {
        echo "<script>alert('$message[message]');</script>";
        $message['status']['role'] == 'Admin' ? header('Location: dashboard') : header('Location: /');
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
    <link rel="stylesheet" href="assets/css/auth.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="login-page">
            <form action="#" method="POST">
                <a href="/" class="icon"><iconify-icon icon="uil:exit"></iconify-icon></a>
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
            <span>Belum memiliki akun? <a href="/register" class="regis">Buat akun sekarang</a></span>
        </div>
    </div>
</body>
</html>