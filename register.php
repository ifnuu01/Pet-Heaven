<?php
session_start();

require_once 'functions/connection.php';
require_once 'functions/auth_function.php';

include 'template-auth/header.php';

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] == 'Admin') {
        echo "<script>location.href='dashboard';</script>";
    } else {
        echo "<script>location.href='/';</script>";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $message = registrasi($conn, $username, $nama_depan, $nama_belakang, $email, $password);
    if ($message['status']) {
        echo "<script>
    alertModal('login', '{$message['message']}', 'Lanjut');</script>";
} else {
        echo "<script>
    alertModal('register', '{$message['message']}', 'Lanjut');</script>";
    }
}


?>

<div class="container">
        <div class="registration-page">
            <form action="#" method="POST">
                <a href="/" class="icon"><iconify-icon icon="uil:exit"></iconify-icon></a>
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
            <span>Sudah memiliki akun? <a href="/login" class="login">Masuk ke website</a></span>
        </div>
    </div>
</body>
</html>