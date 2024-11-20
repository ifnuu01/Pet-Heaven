<?php

include 'template-user/header.php';
require 'functions/user_function.php';

if (!isset($_GET['no_pembelian']) or empty($_GET['no_pembelian'])) {
    header('Location: riwayat-pembelian');
}

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

$no_pembelian = $_GET['no_pembelian'];
$detail = detail_riwayat_pembelian($conn, $no_pembelian);

?>

<link rel="stylesheet" href="assets/css/detail_riwayat.css">

<div class="container-detail-hewan">
    <div class="detail-hewan">
        <div class="title-detail">
            <h1>Detail Riwayat Pembelian</h1>
        </div>
        <div class="content-detail-hewan">
            <div class="img-hewan">
                <img src="<?= htmlspecialchars($detail['path_poto']) ?>" alt="Gambar Hewan">
                <div class="no_pembelian">
                    <span>No Pembelian</span>
                    <span><?= htmlspecialchars($no_pembelian) ?></span>
                </div>
            </div>
            <div class="detail-text">
                <div class="header-text">
                    <div class="name">
                        <h2><?= htmlspecialchars($detail['nama_hewan']) ?></h2>
                    </div>
                    <div class="harga">
                        <h1>Rp<?= htmlspecialchars(number_format($detail['harga'])) ?></h1>
                    </div>
                    <div class="btn">
                        <?php if ($detail['status'] == 'Dikonfirmasi'): ?>
                            <button class="btn success">Dikonfirmasi</button>
                        <?php elseif ($detail['status'] == 'Menunggu'): ?>
                            <button class="btn warning">Menunggu</button>
                        <?php elseif ($detail['status'] == 'Ditolak'): ?>
                            <button class="btn danger">Ditolak</button>
                        <?php endif; ?>
                    </div>
                    <div class="tanggal">
                        <span><?= htmlspecialchars(date('d-m-Y', strtotime($detail['waktu_pembayaran']))) ?></span>
                    </div>
                </div>
                <div class="detail-hewan-text">
                    <div class="text-hewan">
                        <span class="strong">Jenis Hewan</span>
                        <span><?= htmlspecialchars($detail['jenis_hewan']) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Tahapan Usia</span>
                        <span><?= htmlspecialchars($detail['tahapan_usia']) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Warna</span>
                        <span><?= htmlspecialchars($detail['warna']) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Jenis Kelamin</span>
                        <span><?= htmlspecialchars($detail['jenis_kelamin']) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Berat</span>
                        <span><?= htmlspecialchars($detail['berat']) ?> Kg</span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Pajak Admin</span>
                        <span>Rp<?= htmlspecialchars(number_format($detail['pajak'])) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Biaya Pengiriman</span>
                        <span>Rp<?= htmlspecialchars(number_format($detail['biaya_pengiriman'])) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Total Pembayaran</span>
                        <span>Rp<?= htmlspecialchars(number_format($detail['total_pembayaran'])) ?></span>
                    </div>
                    <div class="text-hewan">
                        <span class="strong">Metode Pembayaran</span>
                        <span><?= htmlspecialchars($detail['metode_pembayaran']) ?></span>
                    </div>
                </div>
                <div class="button-detail-hewan">
                    <a href="riwayat-pembelian" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'template-user/footer.php';
?>

<script src="assets/js/kategori-dropdown.js"></script>
<script src="assets/js/profile-dropdown.js"></script>
<script src="assets/js/modal-confirm.js"></script>