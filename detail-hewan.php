<?php

include 'template-user/header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_hewan_by_id($conn, $id);
}


?>

<link rel="stylesheet" href="assets/css/detail_hewan.css">

<?php

if ($data["status"]){
    $hewan = $data["data"];
?>
<div class="container-detail-hewan">
        <div class="detail-hewan">
            <div class="title-detail">
                <h1>Detail Hewan</h1>
            </div>
            <div class="content-detail-hewan">
                <div class="img-hewan">
                    <img src="<?= htmlspecialchars($hewan['path_poto']) ?>" alt=   "">
                </div>
                <div class="detail-text">
                    <div class="name">
                        <h2><?= htmlspecialchars($hewan['nama_hewan']) ?></h2>
                    </div>
                    <div class="harga">
                        <h1>Rp<?= htmlspecialchars(number_format($hewan['harga'])) ?></h1>
                    </div>
                    <div class="detail-hewan-text">
                        <div class="text-hewan">
                            <span class="strong">Jenis Hewan</span>
                            <span><?= htmlspecialchars($hewan['jenis'])?></span>
                        </div>
                        <div class="text-hewan">
                            <span class="strong">Tahapan Usia</span>
                            <span><?= htmlspecialchars($hewan['tahapan_usia']) ?></span>
                        </div>
                        <div class="text-hewan">
                            <span class="strong">Warna</span>
                            <span><?= htmlspecialchars($hewan['warna']) ?></span>
                        </div>
                        <div class="text-hewan">
                            <span class="strong">Jenis Kelamin</span>
                            <span><?= htmlspecialchars($hewan['jenis_kelamin']) ?></span>
                        </div>
                        <div class="text-hewan">
                            <span class="strong">Berat</span>
                            <span><?= htmlspecialchars($hewan['berat'])?> Kg</span>
                        </div>
                    </div>
                    <div class="button-detail-hewan">
                        <?php
                        if (isset($_SESSION['user'])) {
                            ?>
                        <a href="pembayaran?id=<?= $hewan['id']?>" class="btn btn-primary">Beli Sekarang</a>
                        <?php
                        } else {
                            ?>
                        <a href="login" class="btn btn-primary">Beli? Login 😸</a>
                        <?php
                        }
                        ?>
                        <a href="/" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} 
?>

    <?php
    include 'template-user/footer.php';
    ?>
    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>