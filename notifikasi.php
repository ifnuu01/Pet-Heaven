<?php

include 'template-user/header.php';
require 'functions/user_function.php';

?>

<link rel="stylesheet" href="assets/css/alert.css">
<dialog id="alert-modal">
        <div class="alert-modal-content">
            <div class="logo" id="logo-alert">
                <img src="" alt="">
            </div>
            <div class="alert-modal-body">
                <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="alert-modal-footer">
                <button class="btn btn-alert">Lanjut</button>
            </div>
        </div>
    </dialog>
<script src='assets/js/alert.js' ></script>

<?php

$id_pengguna = $_SESSION['user']['id'];

$notifikasi = get_notifikasi($conn, $id_pengguna);

if (isset($_POST['hapus_notifikasi'])) {
    $id_notifikasi = $_POST['id_notifikasi'];
    hapus_notifikasi($conn, $id_notifikasi);
    echo "<script> alertModal('notifikasi', 'Berhasil menghapus notifikasi', 'Lanjut', 'assets/logo/centang.png') </script>";

}

// Hapus semua notifikasi
if (isset($_POST['hapus_semua_notifikasi'])) {
    hapus_semua_notifikasi($conn, $id_pengguna);
    echo "<script> alertModal('notifikasi', 'Berhasil menghapus semua notifikasi', 'Lanjut', 'assets/logo/centang.png') </script>";
}

?>
<link rel="stylesheet" href="assets/css/notifikasi.css">

<div class="container">
    <div class="header-notif">
        <a class="active" href="#"><h3>Notifikasi</h3></a>
        <a href="/"><h3>Kembali</h3></a>
    </div>
    <div>
        <div class="notification-container">
            <div class="header">
                    <h2>Notifikasi Anda</h2>
                    <?php
                    if (!empty($notifikasi)) {
                        echo '<button class="delete-btn actionBtn"
                        data-action="hapus_semua"
                        data-message="Apakah Anda yakin ingin menghapus semua notifikasi?"
                        data-form="hapusSemuaForm"
                        data-cancel-text="Tidak"
                        data-confirm-text="Ya">Hapus Semua</button>';
                    }
                    ?>
                    <form id="hapusSemuaForm" method="POST" style="display:none;">
                        <input type="hidden" name="hapus_semua_notifikasi" value="1">
                    </form>
            </div>
            <?php if (!empty($notifikasi)): ?>
                <?php foreach ($notifikasi as $notif): ?>
                    <div class="notification">
                        <p><strong>Admin Pet Haven</strong></p>
                        <p><span class="user-notif">Untuk <?= htmlspecialchars($notif['username']) ?></span></p>
                        <p><?= htmlspecialchars($notif['message']) ?></p>
                        <button class="delete-btn actionBtn"
                                data-action="hapus"
                                data-message="Apakah Anda yakin ingin menghapus notifikasi ini?"
                                data-form="hapusForm<?= $notif['id'] ?>"
                                data-cancel-text="Tidak"
                                data-confirm-text="Ya">Hapus</button>
                        <form id="hapusForm<?= $notif['id'] ?>" method="POST" style="display:none;">
                            <input type="hidden" name="id_notifikasi" value="<?= $notif['id'] ?>">
                            <input type="hidden" name="hapus_notifikasi" value="1">
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="kosong-notif">Tidak ada notifikasi untuk saat ini 😭</p>
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