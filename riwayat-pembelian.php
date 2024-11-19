<?php

include 'template-user/header.php';


?>

<link rel="stylesheet" href="assets/css/riawayat_pembelian.css">

<div class="content">
        <div class="header">
            <div class="item">Riwayat Pembelian</div>
            <a href="/" class="item non">Kembali</a>
        </div>
    <div class="container">
        <div class="stats-card">
            <div class="stat-item">
                <span class="stat-label">Total Riwayat</span>
                <span class="stat-value">3</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Berhasil</span>
                <span class="stat-value">1</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Ditolak</span>
                <span class="stat-value">1</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Tertunda</span>
                <span class="stat-value">1</span>
            </div>
        </div>

        <div class="purchase-history">
            <div class="purchase-card">
                <img src="assets/img/hewan/gambar.png" alt="Gambar" class="purchase-image">
                <div class="purchase-group">
                    <div class="purchase-info">
                        <span class="status-badge status-success">Berhasil</span>
                        <h3 class="item-name">Johnson</h3>
                        <p class="item-category">Kucing</p>
                    </div>
                    <div class="purchase-price">
                        <a href="#" class="detail-button">Detail</a>
                        <p class="price">Rp25.000</p>
                    </div>
                </div>
            </div>

            <div class="purchase-card">
                <img src="assets/img/hewan/gambar.png" alt="Gambar" class="purchase-image">
                <div class="purchase-group">
                    <div class="purchase-info">
                        <span class="status-badge status-pending">Tertunda</span>
                        <h3 class="item-name">Johnson</h3>
                        <p class="item-category">Kucing</p>
                    </div>
                    <div class="purchase-price">
                        <a href="#" class="detail-button">Detail</a>
                        <p class="price">Rp25.000</p>
                    </div>
                </div>
            </div>

            <div class="purchase-card">
                <img src="assets/img/hewan/gambar.png" alt="Gambar" class="purchase-image">
                <div class="purchase-group">
                    <div class="purchase-info">
                        <span class="status-badge status-rejected">Ditolak</span>
                        <h3 class="item-name">Johnson</h3>
                        <p class="item-category">Kucing</p>
                    </div>
                    <div class="purchase-price">
                        <a href="#" class="detail-button">Detail</a>
                        <p class="price">Rp25.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>
    <script src="assets/js/slider.js"></script>
<?php

include 'template-user/footer.php';

?>
