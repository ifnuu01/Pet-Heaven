<?php

include 'template-admin/header.php';

$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;
$limit_atas = $limit_per_halaman;

// Panggil fungsi untuk mengambil data penjualan tanpa filter pencarian

// Jika ada filter pencarian
if (isset($_GET['search'])) {
    $nama_pengguna = $_GET['search'];
    $data = search_data_penjualan($conn, $nama_pengguna, $limit_bawah, $limit_atas);
    // Hitung total data untuk pagination
    $total_data_search = $conn->query("SELECT COUNT(p.nama_depan) as total FROM transaksi t join pengguna p on t.id_pengguna = p.id WHERE nama_depan LIKE '%$nama_pengguna%' AND t.status != 'Menunggu'");
    $total_data = $total_data_search->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
}else{
    $data = get_data_penjualan($conn, $limit_bawah, $limit_atas);
    // Hitung total data untuk pagination
    $total_data_query = $conn->query("SELECT COUNT(*) as total FROM transaksi WHERE status != 'Menunggu'");
    $total_data = $total_data_query->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
}


?>

<div class="container">
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Cari" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" hidden></button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. Pembelian</th>
                    <th>Nama Pengguna</th>
                    <th>Alamat Pengirim</th>
                    <th>Total Pembelian</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data['status'] && count($data['data']) > 0): ?>
                <?php foreach ($data['data'] as $penjualan): ?>
                <tr>
                    <td><?= $penjualan->no_pembelian ?></td>
                    <td><?= $penjualan->nama_depan ?></td>
                    <td class="address"><?= $penjualan->alamat_pengiriman ?></td>
                    <td>Rp<?= number_format($penjualan->total_pembelian, 2) ?></td>
                    <td><?= $penjualan->waktu_pembayaran ?></td>
                    <td class="status">
                        <?php if ($penjualan->status == 'Dikonfirmasi'): ?>
                            <span class="status-confirmed"><?= $penjualan->status ?></span>
                        <?php else : ?>
                            <span class="status-rejected"><?= $penjualan->status ?></span>
                        <?php endif; ?>
                    </td>
                    <td><button class="detail-btn">Detail</button></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada data ditemukan.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($halaman > 1): ?>
            <a class="button" href="?page=<?php echo $halaman - 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Sebelumnya</a>
        <?php else: ?>
            <span class="button">Sebelumnya</span>
        <?php endif; ?>

        <!-- Nomor Halaman -->
        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
            <?php if ($i == $halaman): ?>
                <strong class="nomor"><?php echo $i; ?></strong>
            <?php else: ?>
                <a class="nomor" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halaman < $total_halaman): ?>
            <a class="button" href="?page=<?php echo $halaman + 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Selanjutnya</a>
        <?php else: ?>
            <span class="button">Selanjutnya</span>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/pengaturan-dropdown.js"></script>
</body>
</html>
