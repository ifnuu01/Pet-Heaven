<?php
session_start();

require_once 'functions/connection.php';
require_once 'functions/auth_function.php';
require_once 'functions/admin_function.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit();
}

if (isset($_POST['logout'])) {
    logout();   
}

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
function isActive($path) {
    global $url;
    return $url === $path ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if ($url === '/dashboard') {
            echo 'Dashboard';
        } elseif ($url === '/data_penjualan') {
            echo 'Data Penjualan';
        } elseif ($url === '/manajemen_hewan') {
            echo 'Manajemen Hewan';
        } elseif ($url === '/manajemen_user') {
            echo 'Manajemen User';
        } elseif ($url === '/konfirmasi_pembelian') {
            echo 'Konfirmasi Pembelian';
        }
        ?>
    </title>
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/datapenjualan.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<body>
    <nav>
        <button class="pengaturan"><iconify-icon icon="material-symbols-light:settings-outline"></iconify-icon><span>Pengaturan</span></button>
    </nav>
    <div class="dropdown-pengaturan">
        <div class="dropdown-content">
            <button><iconify-icon icon="mdi:password-outline"></iconify-icon><span>Ubah Password</span></button>
            <form action="/" method="post">
                <button type="submit" name="logout">
                    <iconify-icon icon="bxs:door-open"></iconify-icon>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
    <div class="sidebar">
        <ul>
            <div class="logo">
                <a href=""><img src="assets/logo/logo.png" alt="" width="150px"></a>
                <div class="line"></div>
            </div>
            <div class="sidebar-menu">
                <a href="/dashboard" class="<?= isActive('/dashboard') ?>"><iconify-icon icon="clarity:dashboard-line" ></iconify-icon><span>Dashboard</span></a>
                <a href="/data_penjualan" class="<?= isActive('/data_penjualan') ?>"><iconify-icon icon="ep:sell" ></iconify-icon><span>Data Penjualan</span></a>
                <a href="/manajemen_hewan" class="<?= isActive('/manajemen_hewan') ?>"><iconify-icon icon="cil:animal" ></iconify-icon><span>Manajemen Hewan</span></a>
                <a href="/manajemen_user" class="<?= isActive('/manajemen_user') ?>"><iconify-icon icon="mingcute:user-4-line" ></iconify-icon><span>Manajemen User</span></a>
                <a href="/konfirmasi_pembelian" class="<?= isActive('/konfirmasi_pembelian') ?>"><iconify-icon icon="fluent-mdl2:waitlist-confirm" ></iconify-icon><span>Konfirmasi Pembelian</span></a>
            </div>
            <div class="footer">
                <span>Copyright © 2024 Ember</span>
            </div>
        </ul>
    </div>
    