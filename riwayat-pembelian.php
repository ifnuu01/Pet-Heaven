<?php

include 'template-user/header.php';

require_once 'functions/user_function.php';

$id_pengguna = $_SESSION['user']['id'];
$riwayat = riwayat_pembelian($conn, $id_pengguna);

$total_riwayat = count($riwayat);
$pembelian_berhasil = count(array_filter($riwayat, function($item) { return $item['status'] == 'Dikonfirmasi'; }));
$pembelian_ditolak = count(array_filter($riwayat, function($item) { return $item['status'] == 'Ditolak'; }));
$pembelian_tertunda = count(array_filter($riwayat, function($item) { return $item['status'] == 'Menunggu'; }));

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
                <span class="stat-value"><?= $total_riwayat ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Berhasil</span>
                <span class="stat-value"><?= $pembelian_berhasil ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Ditolak</span>
                <span class="stat-value"><?= $pembelian_ditolak ?></span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pembelian Tertunda</span>
                <span class="stat-value"><?= $pembelian_tertunda ?></span>
            </div>
        </div>

        <div class="purchase-history">
        <?php if (!empty($riwayat)): ?>
            <?php foreach ($riwayat as $item): ?>
            <div class="purchase-card">
                <img src="<?= htmlspecialchars($item['path_poto']) ?>" alt="Gambar" class="purchase-image">
                <div class="purchase-group">
                    <div class="purchase-info">
                        <?php if ($item['status'] == 'Dikonfirmasi'): ?>
                                <span class="status-badge status-success">Berhasil</span>
                            <?php elseif ($item['status'] == 'Menunggu'): ?>
                                <span class="status-badge status-pending">Tertunda</span>
                            <?php elseif ($item['status'] == 'Ditolak'): ?>
                                <span class="status-badge status-rejected">Ditolak</span>
                        <?php endif; ?>
                        <h3 class="item-name"><?= htmlspecialchars($item['nama_hewan']) ?></h3>
                        <p class="item-category"><?= htmlspecialchars($item['jenis_hewan']) ?></p>
                    </div>
                    <div class="purchase-price">
                        <a href="detail_riwayat?no_pembelian=<?= $item['no_pembelian'] ?>" class="detail-button">Detail</a>
                        <p class="price">Rp<?= htmlspecialchars(number_format($item['harga'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada riwayat pembelian untuk saat ini.</p>
        <?php endif; ?>
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
