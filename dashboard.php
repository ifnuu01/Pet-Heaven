<?php

include 'template-admin/header.php';

$total_pendapatan = get_jumlah_pendapatan($conn);
$total_data_penjualan = total_data_penjualan($conn);
$total_hewan = total_hewan($conn);
$total_pengguna = total_pengguna($conn);
?>


<div class="container-content-dashboard">
    <div class="title">Selamat Datang di Dashboard <br> <span>Admin</span></div>
    <div class="container-card">
        <div class="single-card">
            <div class="logo"><iconify-icon icon="dashicons:money-alt"></iconify-icon></div>
            <div class="content">
                <span>Jumlah Pendapatan</span>
                <span>Rp<?= number_format($total_pendapatan['total'] ? $total_pendapatan['total'] : 0.00 ,2) ?></span>
            </div>
        </div>
        <div class="single-card">
            <div class="logo"><iconify-icon icon="ep:sell" ></iconify-icon></div>
            <div class="content">
                <span>Data Penjualan</span>
                <span><?= $total_data_penjualan['total']?></span>
            </div>
        </div>
        <div class="single-card">
            <div class="logo"><iconify-icon icon="cil:animal" ></iconify-icon></div>
            <div class="content">
                <span>Total Hewan</span>
                <span><?= $total_hewan['total']?></span>
            </div>
        </div>
        <div class="single-card">
            <div class="logo"><iconify-icon icon="mingcute:user-4-line" ></iconify-icon></div>
            <div class="content">
                <span>Total Pengguna</span>
                <span><?= $total_pengguna['total']?></span>
            </div>
        </div>
    </div>
</div>


<?php

include 'template-admin/footer.php';
?>