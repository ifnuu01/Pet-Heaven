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

$id_pengguna = $_SESSION['user']['id'];

$data = get_akun($conn, $id_pengguna);

$tanggal_lahir = $data['tanggal_lahir'] ? date('Y-m-d', strtotime($data['tanggal_lahir'])) : 'Belum terisi😿';
$jenis_kelamin = $data['jenis_kelamin'] ? $data['jenis_kelamin'] : 'Belum terisi😿';
$nomor_hp = $data['nomor_hp'] ? $data['nomor_hp'] : 'Belum terisi😿';
$email = maskEmail($data['email']);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ubah_gender'])) {
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $query = "UPDATE pengguna SET jenis_kelamin = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $jenis_kelamin, $id_pengguna);
        if ($stmt->execute()) {
            echo "<script> alertModal('profile', 'Berhasil mengubah jenis kelamin', 'Lanjut', 'assets/logo/centang.png') </script>";
        } else {
            echo "<script> alertModal('profile', 'Gagal mengubah jenis kelamin', 'Lanjut', 'assets/logo/cancel.png') </script>";
        }
    } elseif (isset($_POST['ubah_name'])) {
        $nama_depan = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $query = "UPDATE pengguna SET nama_depan = ?, nama_belakang = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nama_depan, $nama_belakang, $id_pengguna);
        if ($stmt->execute()) {
            echo "<script> alertModal('profile', 'Berhasil mengubah nama', 'Lanjut', 'assets/logo/centang.png') </script>";
        } else {
            echo "<script> alertModal('profile', 'Gagal mengubah nama', 'Lanjut', 'assets/logo/cancel.png') </script>";
        }
    } elseif (isset($_POST['ubah_nomor_hp'])) {
        $nomor_hp = $_POST['nomor_hp'];
        $query = "UPDATE pengguna SET nomor_hp = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $nomor_hp, $id_pengguna);
        if ($stmt->execute()) {
            echo "<script> alertModal('profile', 'Berhasil mengubah nomor HP', 'Lanjut', 'assets/logo/centang.png') </script>";
        } else {
            echo "<script> alertModal('profile', 'Gagal mengubah nomor HP', 'Lanjut', 'assets/logo/cancel.png') </script>";
        }
    } elseif (isset($_POST['ubah_pass'])) {
        $password = $_POST['password'];
        $new_password = $_POST['new-password'];
        if (strlen($new_password) < 8) {
            echo "<script> alertModal('profile', 'Password baru harus 8 karakter atau lebih', 'Lanjut', 'assets/logo/cancel.png') </script>";
        } else {
            $new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);
            $query = "SELECT password FROM pengguna WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id_pengguna);
            $stmt->execute();
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            $stmt->close();
            if (password_verify($password, $hashed_password)) {
                $query = "UPDATE pengguna SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $new_password_hashed, $id_pengguna);
                if ($stmt->execute()) {
                    echo "<script> alertModal('profile', 'Berhasil mengubah password', 'Lanjut', 'assets/logo/centang.png') </script>";
                } else {
                    echo "<script> alertModal('profile', 'Gagal mengubah password', 'Lanjut', 'assets/logo/cancel.png') </script>";
                }
                $stmt->close();
            } else {
                echo "<script> alertModal('profile', 'Password lama tidak cocok', 'Lanjut', 'assets/logo/cancel.png') </script>";
            }
        }
    } elseif (isset($_POST['ubah_tgl'])) {
        $tgl_lahir = $_POST['tgl_lahir'];
        $query = "UPDATE pengguna SET tanggal_lahir = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $tgl_lahir, $id_pengguna);
        if ($stmt->execute()) {
            echo "<script> alertModal('profile', 'Berhasil mengubah tanggal lahir', 'Lanjut', 'assets/logo/centang.png') </script>";
        } else {
            echo "<script> alertModal('profile', 'Gagal mengubah tanggal lahir', 'Lanjut', 'assets/logo/cancel.png') </script>";
        } 
    } elseif (isset($_POST['ubah_email'])) {
        $email_lama = $_POST['email_lama'];
        $email_baru = $_POST['email_baru'];
        $query = "SELECT email FROM pengguna WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_pengguna);
        $stmt->execute();
        $stmt->bind_result($current_email);
        $stmt->fetch();
        if ($email_lama === $current_email) {
            $query = "UPDATE pengguna SET email = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $email_baru, $id_pengguna);
            if ($stmt->execute()) {
                echo "<script> alertModal('profile', 'Berhasil mengubah email', 'Lanjut', 'assets/logo/centang.png') </script>";
            } else {
                echo "<script> alertModal('profile', 'Gagal mengubah email', 'Lanjut', 'assets/logo/cancel.png') </script>";
            } 
        } else {
            echo "<script> alertModal('profile', 'Email lama tidak cocok', 'Lanjut', 'assets/logo/cancel.png') </script>";
        }
    } elseif (isset($_POST['ubah_photo'])) {
        $result = uploadPhoto($_FILES['photo'], $id_pengguna, $conn);
        if ($result['status']) {
            echo "<script> alertModal('profile', '{$result['message']}', 'Lanjut', 'assets/logo/centang.png') </script>";
        } else {
            echo "<script> alertModal('profile', '{$result['message']}', 'Lanjut', 'assets/logo/cancel.png') </script>";
        }
    }
}

?>

<link rel="stylesheet" href="assets/css/profile.css">
<link rel="stylesheet" href="assets/css/form-profile.css">

    <dialog class="container-form-profile" id="form-jenis_kelamin">
        <form class="container-form" method="POST" id="form-jenis-kelamin-form" >
            <div class="form-header">
                <h1>Ubah Jenis Kelamin</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group gender">
                    <div class="input-gender">
                        <input type="radio" name="jenis_kelamin" id="pria" value="Pria" <?= $data['jenis_kelamin'] === 'Pria' ? 'checked' : '' ?> required>
                        <label for="pria">Pria</label>
                    </div>
                    <div class="input-gender">
                        <input type="radio" name="jenis_kelamin" id="wanita" value="Wanita" <?= $data['jenis_kelamin'] === 'Wanita' ? 'checked' : '' ?> required>
                        <label for="wanita">Wanita</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_gender">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>

    <dialog class="container-form-profile" id="form-nama">
        <form class="container-form" method="POST" id="form-nama-form">
            <div class="form-header">
                <h1>Ubah Nama</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group name">
                    <div class="input-name">
                        <label for="nama_depan">Nama Depan</label>
                        <input type="text" name="nama_depan" id="nama_depan" required>
                    </div>
                    <div class="input-name">
                        <label for="nama_belakang">Nama Belakang</label>
                        <input type="text" name="nama_belakang" id="nama_belakang" required>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_name">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>

    <dialog class="container-form-profile" id="form-nomor-hp">
        <form class="container-form" method="POST" id="form-nomor-hp-form">
            <div class="form-header">
                <h1>Ubah Nomor HP</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label for="nomor_hp">Nomor HP</label>
                    <input type="text" id="nomor_hp" name="nomor_hp" maxlength="13" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_nomor_hp">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>

    <dialog class="container-form-profile" id="form-pass">
        <form class="container-form" method="POST">
            <div class="form-header">
                <h1>Ubah Password</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label for="password">Password Lama</label>
                    <input type="password" name="password" id="password" placeholder="Password Lama" required>
                </div>
                <div class="form-group">
                    <label for="new-password">Password Baru</label>
                    <input type="password" name="new-password" id="new-password" placeholder="Password Baru" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_pass">Ubah Password</button>
                </div>
            </div>
        </form>
    </dialog>

    <dialog class="container-form-profile" id="form-tgl_lahir">
        <form class="container-form" method="POST" id="form-tgl_lahir-form">
            <div class="form-header">
                <h1>Ubah Tanggal Lahir</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" id="tgl_lahir" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_tgl">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>

    <dialog class="container-form-profile" id="form-email">
        <form class="container-form" method="POST" id="form-email-form">
            <div class="form-header">
                <h1>Ubah Email</h1>
                <div class="close-buttons"><iconify-icon icon="line-md:close-small"></iconify-icon></div>
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label for="email_lama">Email Lama</label>
                    <input type="email" name="email_lama" id="email_lama" required>
                </div>
                <div class="form-group">
                    <label for="email_baru">Email Baru</label>
                    <input type="email" name="email_baru" id="email_baru" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="ubah_email">Simpan</button>
                </div>
            </div>
        </form>
    </dialog>


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
                <img src="<?= htmlspecialchars($data['path_poto']) ?>" alt="Profile Photo">
                <form method="POST" enctype="multipart/form-data" id="photo-form">
                    <label for="photo" id="pilih_poto" >Pilih Foto</label>
                    <input type="file" name="photo" id="photo" accept="image/*" hidden required>
                    <button type="submit" name="ubah_photo" class="unggah">Unggah Foto</button>
                </form>
                <p>Ukuran maksimal foto 2 Mb, format file JPG, JPEG, PNG</p>
            </div>



            <!-- Right Section -->
            <div class="info-section2">
                <h3>Ubah Biodata Diri</h3>
                <div class="field">
                    <div>Nama <span><?= htmlspecialchars($data['nama_depan']), " ", htmlspecialchars($data['nama_belakang']) ?> </span></div> 
                    <button class="ubah" id="btn-form-nama"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                </div>
                <div class="field">
                    <div>Tanggal Lahir <span><?= htmlspecialchars($tanggal_lahir) ?></span></div> 
                    <button class="ubah" id="btn-form-tgl_lahir"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                </div>
                <div class="field">
                    <div>Jenis Kelamin <span><?= htmlspecialchars($jenis_kelamin) ?></span></div> 
                    <button class="ubah" id="btn-form-jenis_kelamin"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                </div>

                <h3>Ubah Kontak</h3>
                <div class="field">
                    <div>Email <span><?= htmlspecialchars($email) ?> </span></div> 
                    <button class="ubah" id="btn-form-email"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                </div>
                <div class="field">
                    <div>Nomor HP <span><?= htmlspecialchars($nomor_hp) ?></span></div> 
                    <button class="ubah" id="btn-form-nomor-hp"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                </div>

                <button class="change-password-btn" id="btn-ubahpass">Ubah Password</button>
            </div>
        </div>
    </div>

    <script src="assets/js/kategori-dropdown.js"></script>
    <script src="assets/js/profile-dropdown.js"></script>
    <script src="assets/js/modal-confirm.js"></script>
    <script src="assets/js/slider.js"></script>
    <script src="assets/js/form-profile.js"></script>
<?php

include 'template-user/footer.php';
?>