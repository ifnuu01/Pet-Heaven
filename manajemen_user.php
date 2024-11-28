<?php
include 'template-admin/header.php';


$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;


if (isset($_GET['search']) && $_GET['search'] !== '') {
    $nama_pengguna = $_GET['search'];
    $data = search_pengguna($conn, $nama_pengguna, $limit_bawah, $limit_per_halaman);
    
    $total_data_search = $conn->query("SELECT COUNT(p.nama_depan) as total FROM pengguna p WHERE p.nama_depan LIKE '%$nama_pengguna%' and p.role = 'User' and p.status = 'Aktif'");
    $total_data = $total_data_search->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
} else {
    $data = get_managemen_user($conn, $limit_bawah, $limit_per_halaman);
    
    $total_data_query = $conn->query("SELECT COUNT(*) as total FROM pengguna p JOIN alamat a ON p.id = a.id_pengguna where p.role = 'User' and p.status = 'Aktif'");
    $total_data = $total_data_query->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['blokir'])) {
    $id = $_POST['blokir'];
    $status = blokir_user($conn, $id);
    if ($status['status']) {
        echo "<script>
    alertModal('manajemen_user', '{$status['message']}', 'Lanjut', 'assets/logo/centang.png');</script>";
    } else {
        echo "<script>
    alertModal('manajemen_user', '{$status['message']}', 'Lanjut', 'assets/logo/cancel.png');</script>";
    }
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
                    <th>Nama Pengguna</th>
                    <th>Foto</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($data['status'] && count($data['data']) > 0): ?>
                    <?php foreach ($data['data'] as $user): ?>
                        <tr>
                            <td class="align-center"><?= htmlspecialchars($user->nama_depan); ?></td>
                            <td class="align-center"><img src="<?= htmlspecialchars($user->path_poto); ?>" alt="Foto User" width="40px" height="30px"></td>
                            <td class="align-center"><?= htmlspecialchars($user->email); ?></td>
                            <td class="align-center"><?= htmlspecialchars($user->nomor_hp ? $user->nomor_hp : "" ); ?></td>
                            <td class="align-center">
                               <form action="#" method="POST" id="blokirUser-<?= htmlspecialchars($user->id); ?>">
                                    <input type="hidden" name="blokir" value="<?= htmlspecialchars($user->id); ?>">
                                </form>
                                <button class="detail-btn1 actionBtn"
                                data-action="blokir user" 
                                data-message="Apakah Anda yakin ingin memblokir user ini?" 
                                data-form="blokirUser-<?= htmlspecialchars($user->id); ?>"
                                data-cancel-text="Tidak"
                                data-confirm-text="Ya">
                                <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                                </button>
                            </td>
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
            <a class="button" href="?page=<?php echo $halaman - 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Sebelumnya</a>
        <?php else: ?>
            <span class="button red" hidden>Sebelumnya</span>
        <?php endif; ?>

        <!-- Nomor Halaman -->
        <?php
        $start_page = max(1, $halaman - 2);
        $end_page = min($total_halaman, $halaman + 2);
        if ($end_page - $start_page < 4) {
            $end_page = min($total_halaman, $start_page + 4);
        }
        if ($end_page - $start_page < 4) {
            $start_page = max(1, $end_page - 4);
        }
        ?>

        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
            <?php if ($i == $halaman): ?>
                <strong class="nomor"><?php echo $i; ?></strong>
            <?php else: ?>
                <a class="nomor" href="?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halaman < $total_halaman): ?>
            <a class="button" href="?page=<?php echo $halaman + 1; ?><?php echo isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Selanjutnya</a>
        <?php else: ?>
            <span class="button" hidden>Selanjutnya</span>
        <?php endif; ?>
    </div>
</div>




<?php

include 'template-admin/footer.php';

?>