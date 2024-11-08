<?php
require_once 'includes/connection.php';
require_once 'includes/function.php';

$id_hewan = 6;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $tahap_usia = $_POST['tahap_usia'];
    $berat = $_POST['berat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $warna = $_POST['warna'];
    $jenis = $_POST['jenis'];
    $spesies = $_POST['spesies'];
    $harga_hewan = $_POST['harga_hewan'];

    // Panggil fungsi editHewan dengan file yang diunggah
    $message = editHewan($conn, $id_hewan, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan, $_FILES['file_poto']);
}

// Query untuk mendapatkan informasi hewan yang akan diedit
$query = "SELECT * FROM hewan WHERE id = ? AND status != 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_hewan);
$stmt->execute();
$result = $stmt->get_result();
$hewan = $result->fetch_assoc();

if (!$hewan) {
    echo "Hewan tidak ditemukan atau status hewan adalah 0.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hewan</title>
</head>
<body>
    <h1>Edit Hewan</h1>
    <p><?php echo $message; ?></p>
    <form method="post" enctype="multipart/form-data">
        <label>Nama Hewan:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($hewan['nama']); ?>" required><br>

        <label>Foto Hewan:</label>
        <input type="file" name="file_poto" accept="image/*"><br>
        <img src="<?php echo $hewan['path_poto']; ?>" alt="Foto Hewan" width="100"><br>

        <label>Tahap Usia:</label>
        <select name="tahap_usia" required>
            <option value="Larva" <?php if ($hewan['tahap_usia'] == 'Larva') echo 'selected'; ?>>Larva</option>
            <option value="Bibit" <?php if ($hewan['tahap_usia'] == 'Bibit') echo 'selected'; ?>>Bibit</option>
            <option value="Anakan" <?php if ($hewan['tahap_usia'] == 'Anakan') echo 'selected'; ?>>Anakan</option>
            <option value="Muda" <?php if ($hewan['tahap_usia'] == 'Muda') echo 'selected'; ?>>Muda</option>
            <option value="Dewasa" <?php if ($hewan['tahap_usia'] == 'Dewasa') echo 'selected'; ?>>Dewasa</option>
            <option value="Tua" <?php if ($hewan['tahap_usia'] == 'Tua') echo 'selected'; ?>>Tua</option>
        </select><br>

        <label>Berat (kg):</label>
        <input type="number" step="0.01" name="berat" value="<?php echo htmlspecialchars($hewan['berat']); ?>" required><br>

        <label>Jenis Kelamin:</label>
        <select name="jenis_kelamin" required>
            <option value="Jantan" <?php if ($hewan['jenis_kelamin'] == 'Jantan') echo 'selected'; ?>>Jantan</option>
            <option value="Betina" <?php if ($hewan['jenis_kelamin'] == 'Betina') echo 'selected'; ?>>Betina</option>
        </select><br>

        <label>Warna:</label>
        <input type="text" name="warna" value="<?php echo htmlspecialchars($hewan['warna']); ?>" required><br>

        <label>Jenis:</label>
        <select name="jenis" required>
            <option value="Kucing" <?php if ($hewan['jenis'] == 'Kucing') echo 'selected'; ?>>Kucing</option>
            <option value="Anjing" <?php if ($hewan['jenis'] == 'Anjing') echo 'selected'; ?>>Anjing</option>
            <option value="Reptil" <?php if ($hewan['jenis'] == 'Reptil') echo 'selected'; ?>>Reptil</option>
            <option value="Hamster" <?php if ($hewan['jenis'] == 'Hamster') echo 'selected'; ?>>Hamster</option>
            <option value="Burung" <?php if ($hewan['jenis'] == 'Burung') echo 'selected'; ?>>Burung</option>
            <option value="Serangga" <?php if ($hewan['jenis'] == 'Serangga') echo 'selected'; ?>>Serangga</option>
            <option value="Ikan" <?php if ($hewan['jenis'] == 'Ikan') echo 'selected'; ?>>Ikan</option>
        </select><br>

        <label>Spesies:</label>
        <input type="text" name="spesies" value="<?php echo htmlspecialchars($hewan['spesies']); ?>" required><br>

        <label>Harga (Rp):</label>
        <input type="number" name="harga_hewan" value="<?php echo htmlspecialchars($hewan['harga_hewan']); ?>" required><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
