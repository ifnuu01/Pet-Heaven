<?php
session_start();

require_once 'functions/connection.php';
require_once 'functions/auth_function.php';


if (isset($_POST['logout'])) {
    logout();   
    header('location: login');
    exit();
}

if (isset($_SESSION['user']['role'])){
    if ($_SESSION['user']['role'] == 'Admin') {
        echo "<script>location.href='dashboard';</script>";
    }
}

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if ($url === '/') {
            echo 'Home';
        } elseif ($url === '/profile') {
            echo 'Profile';
        } elseif ($url === '/riwayat_pembelian') {
            echo 'Riwayat Pembelian';
        } elseif ($url === '/notifikasi') {
            echo 'Notifikasi';
        } elseif ($url === '/alamat') {
            echo 'Alamat';
        } elseif ($url === '/detail_hewan') {
            echo 'Detail Hewan';
        } elseif ($url === '/pembayaran') {
            echo 'Pembayaran';
        } elseif ($url === '/konfirmasi_pembayaran') {
            echo 'Konfirmasi Pembayaran';
        }
        ?>
    </title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer-user.css">
    <link rel="stylesheet" href="assets/css/home-user.css">
    <link rel="stylesheet" href="assets/css/modal-confirm.css">
</head>
<body>
<dialog id="confirmModal">
    <div class="modal-content">
        <p id="modalMessage"></p>
        <div class="btn-modal">
            <button class="cancel" id="cancelBtn"></button>
            <button class="confirm" id="confirmBtn"></button>
        </div>
    </div>
</dialog>
    <nav>
        <ul class="content-nav-item">
            <li class="item1">
                <div>
                    <a href="/"><img src="assets/logo/logo.png" alt="" width="120px"></a>
                    <a href="/"><iconify-icon icon="line-md:home"></iconify-icon></a>
                    <span id="kategori">Kategori</span>
                </div>
            </li>
            <li class="item2">
                <form action="" method="get">
                    <input type="text" name="search" id="search" placeholder="Mencari">
                    <button type="submit" hidden >Cari</button>
                </form>
            </li>
            <li class="item3">
                <?php
                if (isset($_SESSION['user'])){ ?>
                    <div class="profile">
                        <span><?php echo $_SESSION['user']['nama_depan'] ?></span>
                        <div class="profile-img">
                            <img src="" alt="">
                        </div>
                    </div>
                <?php
                }
                else{ ?>
                    <div>
                        <a href="/login">Masuk</a>
                        <div class="line"></div>
                        <a href="/register">Daftar</a>
                    </div>
                <?php } ?>
            </li>
        </ul>
    </nav>
    <?php
    if (isset($_SESSION['user'])){
    ?>
    <div class="profile-dropdown">
        <div class="profile-content">
            <a href="/profile">
                <iconify-icon icon="gg:profile"></iconify-icon>
                <span>Profile</span>
            </a>
            <form action="/" method="post" id="logoutForm">
                <input type="hidden" name="logout" value="1"></input>
            </form>
            <button  class="actionBtn" 
            data-action="logout" 
            data-message="Apakah Anda yakin ingin keluar dari akun anda?" 
            data-form="logoutForm"
            data-cancel-text="Tidak"
            data-confirm-text="Ya">
                <iconify-icon icon="bxs:door-open"></iconify-icon>
                <span>Keluar</span>
            </button>
        </div>
    </div>
    <?php
    }?>
    <div id="dropdown-kategori" class="">
        <div class="dropdown-content">
            <a href="/?kategori=1">Anjing</a>
            <a href="/?kategori=2">Kucing</a>
            <a href="/?kategori=3">Kelinci</a>
            <a href="/?kategori=4">Hamster</a>
            <a href="/?kategori=5">Sugar Glider</a>
            <a href="/?kategori=6">Reptil</a>
            <a href="/?kategori=7">Burung</a>
            <a href="/?kategori=8">Ikan</a>
        </div>
    </div>
