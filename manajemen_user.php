<?php
include 'template-admin/header.php';

// Set batas per halaman
$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;

// Jika ada filter pencarian
if (isset($_GET['search']) && $_GET['search'] !== '') {
    $nama_pengguna = $_GET['search'];
    $data = search_pengguna($conn, $nama_pengguna, $limit_bawah, $limit_per_halaman);
} else {
    $data = get_managemen_user($conn, $limit_bawah, $limit_per_halaman);
}

// Hitung total data untuk pagination
$total_data_query = $conn->query("SELECT COUNT(*) as total FROM pengguna p JOIN alamat a ON p.id = a.id_pengguna");
$total_data = $total_data_query->fetch_assoc()['total'];
$total_halaman = ceil($total_data / $limit_per_halaman);
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
                    <th>Nama Pengguna</th>
                    <th>Foto</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data['status'] && count($data['data']) > 0): ?>
                    <?php foreach ($data['data'] as $user): ?>
                        <tr>
                            <td class="align-center"><?= $user->nama_depan; ?></td>
                            <td class="align-center"><img src="<?= $user->path_poto; ?>" alt="Foto User"></td>
                            <td class="align-center"><?= $user->email; ?></td>
                            <td class="align-center"><?= $user->nomor_hp; ?></td>
                            <td class="align-center"><?= $user->tanggal_lahir; ?></td>
                            <td class="align-center"><?= $user->jenis_kelamin; ?></td>
                            <td><?= $user->alamat_pengiriman; ?></td>
                            <td class="align-center"><?= $user->tanggal_dibuat; ?></td>
                            <td class="align-center"><button class="detail-btn1"><iconify-icon icon="mdi:trash-can-outline"></iconify-icon></button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Tidak ada data pengguna yang ditemukan.</td>
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
</body>
</html>
