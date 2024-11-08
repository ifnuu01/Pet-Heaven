<?php

require_once '../../functions/connection.php';
require_once '../../functions/auth_function.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $message = registrasi($conn, $username, $nama_depan, $nama_belakang, $email, $password);
    if ($message['status']) {
        echo "<script>alert('$message[message]');</script>";
        echo "<script>location.href='login.php';</script>";
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
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="../../../assets/css/auth.css">
</head>
<body>
<div class="container">
        <div class="registration-page">
            <form action="#" method="POST">
                <h1>Daftar</h1>
                <div class="input">
                    <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" autofocus required>
                </div>
                <div class="input-name">
                    <input type="text" name="nama_depan" id="nama_depan" placeholder="Nama Depan" required>
                    <input type="text" name="nama_belakang" id="nama_belakang" placeholder="Nama Belakang" required>
                </div>
                <div class="input">
                    <input type="email" name="email" id="email" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="input">
                    <input type="password"  name="password" id="password" placeholder="Password" autocomplete="off" required>
                </div>
                <button type="submit" class="btn">Daftar</button>
            </form>
            <span>Sudah memiliki akun? <a href="login.php" class="login">Masuk ke website</a></span>
        </div>
    </div>
</body>
</html>