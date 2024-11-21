<?php

include 'template-user/header.php';
require_once 'functions/user_function.php';


if (!isset($_SESSION['user'])) {
    header('Location: /');
}


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

$alamat = get_alamat($conn, $_SESSION['user']['id']);


if (isset($_POST['ubah_alamat'])) {
    $tempat = $_POST['tempat'];
    $jalan = $_POST['jalan'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kota_kabupaten = $_POST['kota'];
    $provinsi = $_POST['provinsi'];
    $nomor_hp = $_POST['nomor_hp'];

    $result = update_alamat($conn, $_SESSION['user']['id'], $tempat, $jalan, $kelurahan, $kecamatan, $kota_kabupaten, $provinsi, $nomor_hp);

    if ($result['status']) {
        echo "<script> alertModal('alamat', 'Berhasil mengubah alamat', 'Lanjut', 'assets/logo/centang.png') </script>";
    } else {
        echo "<script> alertModal('alamat', 'Gagal mengubah alamat', 'Lanjut', 'assets/logo/silang.png') </script>";
    }
}

?>

<link rel="stylesheet" href="assets/css/alamat.css">
<link rel="stylesheet" href="assets/css/form-alamat.css">

<dialog class="form-ubah-alamat">
            <div class="header-alamat">
                <h1>Form Input Alamat</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <form method="POST" id="form-ubah-alamat-form">
                <div class="item 1">
                    <label for="provinsi">Provinsi</label>
                    <select class="myselect" id="provinsi" name="provinsi" 
                    onmousedown="if(this.options.length>10){this.size=10;}"  
                    onchange='this.size=0;' required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
        
                <div class="item 2">
                    <label for="kota">Kota/Kabupaten</label>
                    <select class="myselect" id="kota" name="kota" 
                    onmousedown="if(this.options.length>10){this.size=10;}"  
                    onchange='this.size=0;' required>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                </div>
                <div class="item 3">
                    <label for="kecamatan">Kecamatan</label>
                    <select class="myselect" id="kecamatan" name="kecamatan" 
                    onmousedown="if(this.options.length>10){this.size=10;}"  
                    onchange='this.size=0;' required>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
                <div class="item 4">
                    <label for="kelurahan">Kelurahan</label>
                    <select class="myselect" id="kelurahan" name="kelurahan" 
                    onmousedown="if(this.options.length>10){this.size=10;}"  
                    onchange='this.size=0;' required>
                        <option value="">Pilih Kelurahan</option>
                    </select>
                </div>
                <div class="item 5">
                    <label for="jalan">Jalan</label>
                    <input type="text" id="jalan" name="jalan" required>
                </div>

                <div class="item 10">
                    <label for="tempat">tempat</label>
                    <select name="tempat" id="tempat" class="myselect">
                        <option value="Rumah">Rumah</option>
                        <option value="Kantor">Kantor</option>
                        <option value="Sekolah">Sekolah</option>
                        <option value="Hotel">Hotel</option>
                    </select>
                </div>
        
                <button type="submit" name="ubah_alamat">Submit</button>
            </form>
        </dialog>

<div class="container-alamat">
        <div class="header">
            <div class="title">Alamat</div>
            <a href="/" class="back-button">Kembali</a>
        </div>
        <div class="content">
            <div class="content-header">
                <h2>Alamat Saat Ini</h2>
                <button class="edit-button" id="btn-ubah-alamat">Ubah Alamat</button>
            </div>
            <div class="address-card">
                <div class="address-title">
                    <h3><?= htmlspecialchars($alamat['tempat']) ?></h3>
                </div>
                <div class="name">
                    <h1><?= htmlspecialchars($alamat['username']) ?></h1>
                </div>
                <p class="phone"><?= htmlspecialchars($alamat['nomor_hp']) ?></p>
                <p class="address">
                    <?= htmlspecialchars($alamat['alamat_pengiriman']) ?>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>
    <script src="assets/js/slider.js"></script>
    <script src="assets/js/form-alamat.js"></script>

<?php

include 'template-user/footer.php';

?>