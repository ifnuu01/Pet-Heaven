<?php

include 'template-admin/header.php';

// Set batas per halaman
$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;

// Jika ada filter pencarian
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $nama_hewan = $_GET['search'];
    $data = search_manajemen_hewan($conn, $nama_hewan, $limit_bawah, $limit_per_halaman);
} else {
    $data = getDataHewan($conn, $limit_bawah, $limit_per_halaman);
}

// Hitung total data untuk pagination
$total_data_query = $conn->query("SELECT COUNT(*) as total FROM hewan WHERE status = 1");
$total_data = $total_data_query->fetch_assoc()['total'];
$total_halaman = ceil($total_data / $limit_per_halaman);
?>

<div class="container">
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Cari" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" hidden></button>
        </form>
        <button class="detail-btn3">Tambah Hewan</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Hewan</th>
                    <th>Foto</th>
                    <th>Tahapan Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Jenis Hewan</th>
                    <th>Harga Hewan</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data['status'] && count($data['data']) > 0): ?>
                <?php foreach ($data['data'] as $hewan): ?>
                    <tr>
                        <td><?php echo $hewan->nama_hewan; ?></td>
                        <td><?php echo $hewan->path_poto; ?></td>
                        <td><?php echo $hewan->tahapan_usia; ?></td>
                        <td><?php echo $hewan->jenis_kelamin; ?></td>
                        <td><?php echo $hewan->jenis_hewan; ?></td>
                        <td>Rp<?php echo number_format($hewan->harga, 2); ?></td>
                        <td><?php echo $hewan->tanggal_ditambahkan; ?></td>
                        <td class="container-btn">
                            <button class="detail-btn2"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                            <button class="detail-btn1"><iconify-icon icon="mdi:trash-can-outline"></iconify-icon></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Data hewan tidak ditemukan.</td>
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