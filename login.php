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


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $message = login($conn, $username, $password);
    if ($message['status']) {
        $url = $_SESSION['user']['role'] == 'Admin' ? 'dashboard' : '/';
        echo "<script>
            alertModal('{$url}', '{$message['message']}', 'Lanjut');
        </script>";
    } else {
        echo "<script>
            alertModal('login', '{$message['message']}', 'Lanjut');
        </script>";
    }
}

?>
    <div class="container">
        <div class="login-page">
            <form action="#" method="POST">
                <a href="/" class="icon"><iconify-icon icon="line-md:home"></iconify-icon></a>
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