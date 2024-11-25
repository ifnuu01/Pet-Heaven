<?php

    include 'template-user/header.php';
    
    if (!isset($_SESSION['user'])) {
        header('Location: /');
    }
?>
<link rel="stylesheet" href="assets/css/payment-success.css">

<div class="hero">
        <div class="container-hasil">
            <div class="logo">
                <img src="assets/logo//centang.png" alt="">
            </div>
            <div class="title"><h1>Pembelian Berhasil Dilakukan</h1></div>
            <div class="text-content"><p>Pesanan anda sedang menunggu konfirmasi dari pihak kami <br>silahkan tunggu notifikasi selanjutnya</p></div>
            <div class="btn">
                <a href="riwayat-pembelian" class="lihat-riwayat">
                    Lihat Riwayat Pembelian
                </a>
                <a href="/" class="menu">
                    Menu Utama
                </a>
            </div>
        </div>
    </div>
    
    <?php
    include 'template-user/footer.php';
    ?>
    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>
    <script>
        let paymentResult = localStorage.getItem('paymentResult');

        if (!paymentResult) {
            window.location.href = '/';
        }
        window.addEventListener('beforeunload', function() {
            localStorage.removeItem('paymentResult');
        });
    </script>