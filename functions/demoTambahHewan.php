<?php
require 'includes/connection.php';
require 'includes/function.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $nama = $_POST['nama'];
    $tahap_usia = $_POST['tahap_usia'];
    $berat = $_POST['berat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $warna = $_POST['warna'];
    $jenis = $_POST['jenis'];
    $spesies = $_POST['spesies'];
    $harga_hewan = $_POST['harga_hewan'];

    // Panggil fungsi tambahHewan dengan file yang diunggah
    $message = tambahHewan($conn, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan, $_FILES['file_poto']);
    echo "<script>alert('$message');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Hewan</title>
</head>
<body>
    <h1>Tambah Hewan</h1>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Hewan:</label>
        <input type="text" name="nama" required><br>

        <label>Foto Hewan:</label>
        <input type="file" name="file_poto" accept="image/*"><br>

        <label>Tahap Usia:</label>
        <select name="tahap_usia" required>
            <option value="Larva">Larva</option>
            <option value="Bibit">Bibit</option>
            <option value="Anakan">Anakan</option>
            <option value="Muda">Muda</option>
            <option value="Dewasa">Dewasa</option>
            <option value="Tua">Tua</option>
        </select><br>

        <label>Berat (kg):</label>
        <input type="number" step="0.01" name="berat" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Jantan">Jantan</option>
            <option value="Betina">Betina</option>
        </select><br>

        <label>Warna:</label>
        <input type="text" name="warna" required><br>

        <label>Jenis:</label>
        <select name="jenis" required>
            <option value="Kucing">Kucing</option>
            <option value="Anjing">Anjing</option>
            <option value="Reptil">Reptil</option>
            <option value="Hamster">Hamster</option>
            <option value="Burung">Burung</option>
            <option value="Serangga">Serangga</option>
            <option value="Ikan Hias">Ikan Hias</option>
        </select><br>

        <label>Spesies:</label>
        <input type="text" name="spesies"><br>

        <label>Harga Hewan:</label>
        <input type="number" step="0.01" name="harga_hewan" required><br>

        <button type="submit" name="submit">Tambah Hewan</button>
    </form>
</body>
</html>
