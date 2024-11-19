<?php

include 'template-user/header.php'

?>

<link rel="stylesheet" href="assets/css/pembayaran.css">
<form class="container-pembayaran" method="post" enctype="multipart/form-data">
        <div class="detail-hewan-bayar">
            <div class="title">
                <h1>Pembayaran</h1>
            </div>
            <div class="img">
                <img src="assets/img/hewan/gambar.png" alt="" width="100px">
            </div>
            <div class="header-text">
                <h2>Johnson</h2>
                <h1>Rp25.000</h1>
            </div>
            <div class="content-detail-hewan">
                <div class="content">
                    <span class="title">Jenis Hewan</span>
                    <span class="value">Hamster</span>
                </div>
                <div class="content">
                    <span class="title">Tahapan Usia</span>
                    <span class="value">Dewasa</span>
                </div>
                <div class="content">
                    <span class="title">Warna</span>
                    <span class="value">Hitam</span>
                </div>
                <div class="content">
                    <span class="title">Jenis Kelamin</span>
                    <span class="value">Jantan</span>
                </div>
                <div class="content">
                    <span class="title">Berat</span>
                    <span class="value">2 Kg</span>
                </div>
            </div>
        </div>
        <div class="detail-pembayaran">
            <div class="title">
                <h3>Detail Pembayaran</h3>
            </div>
            <div class="content-detail-pembayaran">
                <div class="content">
                    <span class="title">Harga Hewan</span>
                    <span class="value">Rp25.000</span>
                </div>
                <div class="content">
                    <span class="title">Biaya Pengiriman</span>
                    <span class="value">Rp20.000</span>
                </div>
                <div class="content">
                    <span class="title">Pajak Admin</span>
                    <span class="value">Rp2000</span>
                </div>
                <div class="line"></div>
                <div class="content">
                    <span class="title">Total</span>
                    <span class="value">Rp47.000</span>
                </div>  
            </div>
        </div>

        <div class="rekening">
            <div class="title">
                <h3>Tujuan Pembayaran</h3>
            </div>
            <div class="content">
                <span class="title">Nomor Rekening</span>
                <span class="value">652197XXXX</span>
            </div>
        </div>

        <div class="metode-pembayaran-container">
            <div class="title">
                <h3>Metode Pembayaran</h3>
            </div>
            <div class="metode-pembayaran">
                <div class="radio">
                    <input type="radio" name="metode-pembayaran" id="Dana" value="Dana"> 
                    <label for="Dana"><img src="assets/logo/Dana.png" alt="" width="100px"></label>
                </div>
                <div class="radio">
                    <input type="radio" name="metode-pembayaran" id="Gopay" value="Gopay"> 
                    <label for="Gopay"><img src="assets/logo/Gopay.png" alt="" width="100px"></label>
                </div>
                <div class="radio">
                    <input type="radio" name="metode-pembayaran" id="BRI" value="BRI"> 
                    <label for="BRI"><img src="assets/logo/BRI.jpg" alt="" width="50px"></label>
                </div>
                <div class="radio">
                    <input type="radio" name="metode-pembayaran" id="Mandiri" value="Mandiri"> 
                    <label for="Mandiri"><img src="assets/logo/Mandiri.png" alt="" width="100px"></label>
                </div>
            </div>
        </div>

        <div class="button">
            <div class="bukti-pembayaran">
                <label for="bukti-pembayaran">Bukti Pembayaran</label>
                <input type="file" name="bukti-pembayaran" id="bukti-pembayaran" hidden>
            </div>
            <div class="btn-action">
                <a href=""><button class="btn">Kembali</button></a>
                <button type="submit" class="btn">Konfirmasi</button>
            </div>
        </div>
    </form>

    <?php
    include 'template-user/footer.php';
    ?>
    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>