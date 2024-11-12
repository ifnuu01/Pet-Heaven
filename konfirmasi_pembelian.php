<?php
include 'template-admin/header.php';

// Set batas per halaman
$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;

// Jika ada filter pencarian
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $nama_pengguna = $_GET['search'];
    $data = search_konfirmasi_pembelian($conn, $nama_pengguna, $limit_bawah, $limit_per_halaman);
    $total_data_search = $conn->query("SELECT COUNT(p.nama_depan) as total FROM transaksi t JOIN pengguna p ON t.id_pengguna = p.id WHERE p.nama_depan LIKE '%$nama_pengguna%' AND t.status = 'Menunggu'");
    $total_data = $total_data_search->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
} else {
    $data = get_konfirmasi_pembelian($conn, $limit_bawah, $limit_per_halaman);
    $total_data_query = $conn->query("SELECT COUNT(*) as total FROM transaksi t JOIN pengguna p ON t.id_pengguna = p.id WHERE t.status = 'Menunggu'");
    $total_data = $total_data_query->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
}
?>

<div class="container">
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Cari Pengguna" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" hidden></button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No. Pembelian</th>
                    <th>Nama Pengguna</th>
                    <th>Foto User</th>
                    <th>Nama Hewan</th>
                    <th>Alamat Pengiriman</th>
                    <th>Total Pembelian</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data['status'] && count($data['data']) > 0): ?>
                <?php foreach ($data['data'] as $konfirmasi): ?>
                    <tr>
                        <td class="align-center"><?= $konfirmasi->no_pembelian; ?></td>
                        <td class="align-center"><?= $konfirmasi->nama_depan; ?></td>
                        <td><img src="<?= $konfirmasi->path_poto; ?>" alt="Foto User" width="50"></td>
                        <td class="align-center"><?= $konfirmasi->nama_hewan; ?></td>
                        <td><?= $konfirmasi->alamat_pengiriman; ?></td>
                        <td class="align-center">Rp <?= number_format($konfirmasi->total_pembelian, 2); ?></td>
                        <td class="align-center"><?= $konfirmasi->waktu_pembayaran; ?></td>
                        <td class="align-center"><button class="detail-btn">Detail</button></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Data konfirmasi pembelian tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($halaman > 1): ?>
            <a class="button" href="?page=<?= $halaman - 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Sebelumnya</a>
        <?php else: ?>
            <span class="button">Sebelumnya</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
            <?php if ($i == $halaman): ?>
                <strong class="nomor"><?= $i; ?></strong>
            <?php else: ?>
                <a class="nomor" href="?page=<?= $i; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halaman < $total_halaman): ?>
            <a class="button" href="?page=<?= $halaman + 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Selanjutnya</a>
        <?php else: ?>
            <span class="button">Selanjutnya</span>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/pengaturan-dropdown.js"></script>
<script src="assets/js/modal-confirm.js"></script>
</body>
</html>
