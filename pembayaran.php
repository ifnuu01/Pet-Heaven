<?php

include 'template-user/header.php';
require_once 'functions/user_function.php';

if (!isset($_SESSION['user'])) {
    header('Location: /');
}

if (!isset($_GET['id']) or empty($_GET['id'])) {
    header('Location: /');
}

?>

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
$id_hewan = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_hewan) {
    $data = get_hewan_by_id($conn, $id_hewan);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metode_pembayaran = isset($_POST['metode-pembayaran']) ? $_POST['metode-pembayaran'] : null;
    $file_bukti_pembayaran = isset($_FILES['bukti_pembayaran']) ? $_FILES['bukti_pembayaran'] : null;

    if ($id_hewan && $metode_pembayaran && $file_bukti_pembayaran) {
        $result = pembayaran($conn, $id_pengguna, $id_hewan, $metode_pembayaran, $file_bukti_pembayaran);
        if ($result['status']) {
            echo "<script>alertModal('payment-success', '{$result['message']}', 'Lanjut', 'assets/logo/centang.png');</script>";
        } else {
            echo "<script>alertModal('', '{$result['message']}', 'Lanjut', 'assets/logo/cancel.png');</script>";
        }
    } else {
        $error_message = "Metode pembayaran dan bukti pembayaran harus diisi.";
    }
}

?>

<dialog id="alert-modal" class="admin">
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
<script src='assets/js/alert.js'></script>

<?php
if (isset($data) && $data["status"]) {
    $hewan = $data["data"];
?>

<link rel="stylesheet" href="assets/css/pembayaran.css">
<form class="container-pembayaran" method="post" enctype="multipart/form-data">
    <div class="detail-hewan-bayar">
        <div class="title">
            <h1>Pembayaran</h1>
        </div>
        <div class="img">
            <img src="<?= htmlspecialchars($hewan['path_poto']) ?>" alt="" width="100px">
        </div>
        <div class="header-text">
            <h2><?= htmlspecialchars($hewan['nama_hewan']) ?></h2>
            <h1>Rp<?= htmlspecialchars(number_format($hewan['harga'])) ?></h1>
        </div>
        <div class="content-detail-hewan">
            <div class="content">
                <span class="title">Jenis Hewan</span>
                <span class="value"><?= htmlspecialchars($hewan['jenis']) ?></span>
            </div>
            <div class="content">
                <span class="title">Tahapan Usia</span>
                <span class="value"><?= htmlspecialchars($hewan['tahapan_usia']) ?></span>
            </div>
            <div class="content">
                <span class="title">Warna</span>
                <span class="value"><?= htmlspecialchars($hewan['warna']) ?></span>
            </div>
            <div class="content">
                <span class="title">Jenis Kelamin</span>
                <span class="value"><?= htmlspecialchars($hewan['jenis_kelamin']) ?></span>
            </div>
            <div class="content">
                <span class="title">Berat</span>
                <span class="value"><?= htmlspecialchars($hewan['berat']) ?> Kg</span>
            </div>
        </div>
    </div>
    <div class="detail-pembayaran">
        <div class="title">
            <h3>Detail Pembayaran</h3>
        </div>
        <div class="content-detail-pembayaran">
            <div class="content">
                <span class="title">Harga Hewan</span>
                <span class="value">Rp<?= htmlspecialchars(number_format($hewan['harga'])) ?></span>
            </div>
            <div class="content">
                <span class="title">Biaya Pengiriman</span>
                <span class="value">Rp20.000</span>
            </div>
            <div class="content">
                <span class="title">Pajak Admin</span>
                <span class="value">Rp2000</span>
            </div>
            <div class="line"></div>
            <div class="content">
                <span class="title">Total</span>
                <span class="value">Rp<?= htmlspecialchars(number_format($hewan['harga'] + 22000)) ?></span>
            </div>  
        </div>
    </div>

    <div class="rekening">
        <div class="title">
            <h3>Tujuan Pembayaran</h3>
        </div>
        <div class="content">
            <span class="title">Nomor Rekening</span>
            <span class="value">6521977123661</span>
        </div>
    </div>

    <div class="metode-pembayaran-container">
        <div class="title">
            <h3>Metode Pembayaran</h3>
        </div>
        <div class="metode-pembayaran">
            <div class="radio">
                <input type="radio" name="metode-pembayaran" id="Dana" value="Dana" required> 
                <label for="Dana"><img src="assets/logo/Dana.png" alt="" width="100px"></label>
            </div>
            <div class="radio">
                <input type="radio" name="metode-pembayaran" id="Gopay" value="Gopay" required> 
                <label for="Gopay"><img src="assets/logo/Gopay.png" alt="" width="100px"></label>
            </div>
            <div class="radio">
                <input type="radio" name="metode-pembayaran" id="BRI" value="BRI" required> 
                <label for="BRI"><img src="assets/logo/BRI.jpg" alt="" width="50px"></label>
            </div>
            <div class="radio">
                <input type="radio" name="metode-pembayaran" id="Mandiri" value="Mandiri" required> 
                <label for="Mandiri"><img src="assets/logo/Mandiri.png" alt="" width="100px"></label>
            </div>
        </div>
    </div>

    <div class="button">
        <div class="bukti-pembayaran">
            <label for="bukti_pembayaran">Upload Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" required>
        </div>
        <div class="btn-action">
            <a href="detail-hewan?id=<?= $hewan['id']?>"><button type="button" class="btn">Kembali</button></a>
            <button type="submit" class="btn">Konfirmasi</button>
        </div>
    </div>
</form>
<?php
} else {
    echo "<p>Data hewan tidak ditemukan.</p>";
}
?>

<?php
include 'template-user/footer.php';
?>
<script src="assets/js/kategori-dropdown.js"></script>
<script src="assets/js/profile-dropdown.js"></script>
<script src="assets/js/modal-confirm.js"></script>