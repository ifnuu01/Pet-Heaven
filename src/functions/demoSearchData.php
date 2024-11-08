<?php
require 'connection.php';
require 'function.php';

$hasilPencarian = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nama_pengguna"])) {
    $namaPengguna = $_POST["nama_pengguna"];
    $hasilPencarian = searchDataPenjualan($conn, $namaPengguna);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Data Penjualan</title>
</head>
<body>
    <h1>Cari Data Penjualan Berdasarkan Nama Pengguna</h1>
    <form method="POST" action="">
        <label for="nama_pengguna">Nama Pengguna:</label>
        <input type="text" id="nama_pengguna" name="nama_pengguna" required>
        <button type="submit">Cari</button>
    </form>

    <?php if (!empty($hasilPencarian)) : ?>
        <h2>Hasil Pencarian:</h2>
        <table border="1">
            <tr>
                <th>No</th>
                <th>No. Pembelian</th>
                <th>Nama Pengguna</th>
                <th>Foto User</th>
                <th>Nama Hewan</th>
                <th>Alamat Pengiriman</th>
                <th>Total Pembelian</th>
                <th>Bukti Pembayaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($hasilPencarian->data as $index => $penjualan) : ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $penjualan->no_pembelian ?></td>
                    <td><?= $penjualan->nama_pengguna ?></td>
                    <td><img src="<?= $penjualan->foto_user ?>" width="100" height="100"></td>
                    <td><?= $penjualan->nama_hewan ?></td>
                    <td><?= $penjualan->alamat_pengiriman ?></td>
                    <td><?= $penjualan->total_pembelian ?></td>
                    <td><img src="<?= $penjualan->path_bukti_pembayaran ?>" width="100" height="100"></td>
                    <td><?= $penjualan->waktu_pembayaran ?></td>
                    <td><?= $penjualan->status ?></td>
                    <td><button>Detail</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST") : ?>
        <p>Tidak ada data penjualan yang ditemukan untuk nama pengguna tersebut.</p>
    <?php endif; ?>
</body>
</html>

