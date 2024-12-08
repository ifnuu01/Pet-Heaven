<?php

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
    <link rel="shortcut icon" href="assets/logo/logo.ico" type="image/x-icon">
    <title>
        <?php 
        if ($url === '/login') {
            echo 'Masuk';
        } elseif ($url === '/register') {
            echo 'Daftar Akun';
        }
        ?>
    </title>
    <link rel="stylesheet" href="assets/css/auth.css">
    <link rel="stylesheet" href="assets/css/alert.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<body>
<dialog id="alert-modal">
        <div class="alert-modal-content">
            <div class="logo" id="logo-alert">
                <img src="" alt="">
            </div>
            <div class="alert-modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="alert-modal-footer">
                <button class="btn btn-alert">Lanjut</button>
            </div>
        </div>
    </dialog>
<script src='assets/js/alert.js' ></script>