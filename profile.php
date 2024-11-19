<?php

include 'template-user/header.php';

?>

<link rel="stylesheet" href="assets/css/profile.css">

<div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="title">Biodata Diri</div>
            <a href="/" class="back-button">Kembali</a>
        </div>

        <!-- Content -->
        <div class="inner-container">
            <!-- Left Section -->
            <div class="info-section">
                <img src="assets/img/profiles/profile.jpg" alt="Profile Photo">
                <form action="" method="POST">
                    <label for="photo">Pilih Foto</label>
                    <input type="file" name="photo" id="photo" hidden>
                </form>
                <p>Ukuran maksimal foto 2 Mb, format file JPG, JPEG, PNG</p>
            </div>

            <!-- Right Section -->
            <div class="info-section2">
                <h3>Ubah Biodata Diri</h3>
                <div class="field">
                    <div>Nama <span>Ucup Ajaaa </span></div> 
                    <button class="ubah">Ubah</button>
                </div>
                <div class="field">
                    <div>Tanggal Lahir <span>2004-08-25</span></div> 
                    <button class="ubah">Ubah</button>
                </div>
                <div class="field">
                    <div>Jenis Kelamin <span>Pria</span></div> 
                    <button class="ubah">Ubah</button>
                </div>

                <h3>Ubah Kontak</h3>
                <div class="field">
                    <div>Email <span>Ucup@gmail.com </span></div> 
                    <button class="ubah">Ubah</button>
                </div>
                <div class="field">
                    <div>Nomor HP <span>089501603099 </span></div> 
                    <button class="ubah">Ubah</button>
                </div>

                <button class="change-password-btn">Ubah Password</button>
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