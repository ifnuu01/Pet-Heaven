<?php

include 'template-user/header.php';

$id_pengguna = $_SESSION['id_pengguna'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ubah_gender'])) {
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $query = "UPDATE pengguna SET jenis_kelamin = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $jenis_kelamin, $id_pengguna);
        if ($stmt->execute()) {
            $message = "Jenis kelamin berhasil diubah.";
        } else {
            $message = "Gagal mengubah jenis kelamin.";
        }
    } elseif (isset($_POST['ubah_name'])) {
        $nama_depan = $_POST['nama_depan'];
        $nama_belakang = $_POST['nama_belakang'];
        $query = "UPDATE pengguna SET nama_depan = ?, nama_belakang = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nama_depan, $nama_belakang, $id_pengguna);
        if ($stmt->execute()) {
            $message = "Nama berhasil diubah.";
        } else {
            $message = "Gagal mengubah nama.";
        }
    } elseif (isset($_POST['ubah_nomor_hp'])) {
        $nomor_hp = $_POST['nomor_hp'];
        $query = "UPDATE pengguna SET nomor_hp = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $nomor_hp, $id_pengguna);
        if ($stmt->execute()) {
            $message = "Nomor HP berhasil diubah.";
        } else {
            $message = "Gagal mengubah nomor HP.";
        }
    } elseif (isset($_POST['ubah_pass'])) {
        $password = $_POST['password'];
        $new_password = password_hash($_POST['new-password'], PASSWORD_BCRYPT);
        $query = "SELECT password FROM pengguna WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_pengguna);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $query = "UPDATE pengguna SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $new_password, $id_pengguna);
            if ($stmt->execute()) {
                $message = "Password berhasil diubah.";
            } else {
                $message = "Gagal mengubah password.";
            }
        } else {
            $message = "Password lama salah.";
        }
    } elseif (isset($_POST['ubah_tgl'])) {
        $tgl_lahir = $_POST['tgl_lahir'];
        $query = "UPDATE pengguna SET tanggal_lahir = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $tgl_lahir, $id_pengguna);
        if ($stmt->execute()) {
            $message = "Tanggal lahir berhasil diubah.";
        } else {
            $message = "Gagal mengubah tanggal lahir.";
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
                $message = "Email berhasil diubah.";
            } else {
                $message = "Gagal mengubah email.";
            }
        } else {
            $message = "Email lama tidak cocok.";
        }
    } elseif (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));
        $allowed = ['jpg', 'jpeg', 'png'];
        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 2097152) {
                    $file_name_new = uniqid('', true) . '.' . $file_ext;
                    $file_destination = 'assets/img/profiles/' . $file_name_new;
                    if (move_uploaded_file($file_tmp, $file_destination)) {
                        $query = "UPDATE pengguna SET path_poto = ? WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("si", $file_name_new, $id_pengguna);
                        if ($stmt->execute()) {
                            $message = "Foto berhasil diubah.";
                        } else {
                            $message = "Gagal mengubah foto.";
                        }
                    } else {
                        $message = "Gagal mengunggah foto.";
                    }
                } else {
                    $message = "Ukuran file terlalu besar.";
                }
            } else {
                $message = "Terjadi kesalahan saat mengunggah foto.";
            }
        } else {
            $message = "Format file tidak didukung.";
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
                        <input type="radio" name="jenis_kelamin" id="pria" value="Pria" required>
                        <label for="pria">Pria</label>
                    </div>
                    <div class="input-gender">
                        <input type="radio" name="jenis_kelamin" id="wanita" value="Wanita" required>
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
                <img src="assets/img/profiles/profile.jpg" alt="Profile Photo">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="photo">Pilih Foto</label>
                    <input type="file" name="photo" id="photo" hidden accept="image/*">
                </form>
                <p>Ukuran maksimal foto 2 Mb, format file JPG, JPEG, PNG</p>
            </div>

            <!-- Right Section -->
            <div class="info-section2">
                <h3>Ubah Biodata Diri</h3>
                <div class="field">
                    <div>Nama <span>Ucup Ajaaa </span></div> 
                    <button class="ubah" id="btn-form-nama">Ubah</button>
                </div>
                <div class="field">
                    <div>Tanggal Lahir <span>2004-08-25</span></div> 
                    <button class="ubah" id="btn-form-tgl_lahir">Ubah</button>
                </div>
                <div class="field">
                    <div>Jenis Kelamin <span>Pria</span></div> 
                    <button class="ubah" id="btn-form-jenis_kelamin">Ubah</button>
                </div>

                <h3>Ubah Kontak</h3>
                <div class="field">
                    <div>Email <span>Ucup@gmail.com </span></div> 
                    <button class="ubah" id="btn-form-email">Ubah</button>
                </div>
                <div class="field">
                    <div>Nomor HP <span>089501603099 </span></div> 
                    <button class="ubah" id="btn-form-nomor-hp">Ubah</button>
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