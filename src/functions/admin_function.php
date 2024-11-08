<?php

require 'connection.php';


// ADMIN FUNCTION 

function getDataPenjualan($conn) 
{
    $query = "
        SELECT 
            t.no_pembelian,
            p.nama_depan AS nama_pengguna,
            p.path_poto AS foto_user,
            h.nama AS nama_hewan,
            CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
            (h.harga_hewan + t.biaya_pengiriman + t.pajak) AS total_pembelian,
            t.path_bukti_pembayaran,
            t.status,
            t.waktu_pembayaran
        FROM 
            transaksi t
        JOIN 
            pengguna p ON t.id_pengguna = p.id
        JOIN 
            hewan h ON t.id_hewan = h.id
        LEFT JOIN 
            alamat a ON p.id = a.id_pengguna
        where 
            t.status != 'Menunggu'
    ";

    $result = $conn->query($query);

    if ($result === false) {
        return ["error" => $conn->error];
    }

    $penjualanData = [];
    while ($row = $result->fetch_object()) {
        $penjualanData[] = $row;
    }

    return (object) ["data" => $penjualanData];
};


// Penggunaan function getDataPenjualan
$penjualanData = getDataPenjualan($conn);

if (isset($penjualanData->error))
{
    echo $penjualanData->error;
}
else 
{
    if (count($penjualanData->data) > 0) 
    {
        foreach ($penjualanData->data as $penjualan) 
        {
            echo "No Pembelian: $penjualan->no_pembelian <br>";
            echo "Nama Pengguna: $penjualan->nama_pengguna <br>";
            echo "Foto Pengguna: <img src='$penjualan->foto_user' width='100' height='100'> <br>";
            echo "Nama Hewan: $penjualan->nama_hewan <br>";
            echo "Alamat Pengiriman: $penjualan->alamat_pengiriman <br>";
            echo "Total Pembelian: $penjualan->total_pembelian <br>";
            echo "Bukti Pembayaran: <img src='$penjualan->path_bukti_pembayaran' width='100' height='100'> <br>";
            echo "Status: $penjualan->status <br>";
            echo "Waktu Pembayaran: $penjualan->waktu_pembayaran <br>";
            echo "<hr>";
        }
    }
    else 
    {
        echo "Data penjualan tidak ditemukan";
    }
}

function searchDataPenjualan($conn, $namaPengguna) 
{
    $query = "
        SELECT 
            t.no_pembelian,
            p.nama_depan AS nama_pengguna,
            p.path_poto AS foto_user,
            h.nama AS nama_hewan,
            CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
            (h.harga_hewan + t.biaya_pengiriman + t.pajak) AS total_pembelian,
            t.path_bukti_pembayaran,
            t.status,
            t.waktu_pembayaran
        FROM 
            transaksi t
        JOIN 
            pengguna p ON t.id_pengguna = p.id
        JOIN 
            hewan h ON t.id_hewan = h.id
        LEFT JOIN 
            alamat a ON p.id = a.id_pengguna
        WHERE 
            p.nama_depan LIKE CONCAT('%', ?, '%')
            and t.status != 'Menunggu' 
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $namaPengguna);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return ["error" => $conn->error];
    }

    $penjualanData = [];
    while ($row = $result->fetch_object()) {
        $penjualanData[] = $row;
    }

    return (object) ["data" => $penjualanData];
};


// Penggunaan function searchDataPenjualan

// $hasilPencarian = searchDataPenjualan($conn, "A");


// foreach ($hasilPencarian->data as $penjualan) 
// {
//     echo "No Pembelian: $penjualan->no_pembelian <br>";
//     echo "Nama Pengguna: $penjualan->nama_pengguna <br>";
//     echo "Foto Pengguna: <img src='$penjualan->foto_user' width='100' height='100'> <br>";
//     echo "Nama Hewan: $penjualan->nama_hewan <br>";
//     echo "Alamat Pengiriman: $penjualan->alamat_pengiriman <br>";
//     echo "Total Pembelian: $penjualan->total_pembelian <br>";
//     echo "Bukti Pembayaran: <img src='$penjualan->path_bukti_pembayaran' width='100' height='100'> <br>";
//     echo "Status: $penjualan->status <br>";
//     echo "Waktu Pembayaran: $penjualan->waktu_pembayaran <br>";
//     echo "<hr>";
// }


function getDataKonfirmasiPembelian($conn)
{
    $query = "
        SELECT 
            t.no_pembelian,
            p.nama_depan AS nama_pengguna,
            p.path_poto AS foto_user,
            h.nama AS nama_hewan,
            CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
            (h.harga_hewan + t.biaya_pengiriman + t.pajak) AS total_pembelian,
            t.path_bukti_pembayaran,
            t.status,
            t.waktu_pembayaran
        FROM 
            transaksi t
        JOIN 
            pengguna p ON t.id_pengguna = p.id
        JOIN 
            hewan h ON t.id_hewan = h.id
        LEFT JOIN 
            alamat a ON p.id = a.id_pengguna
        where 
            t.status = 'Menunggu'
    ";

    $result = $conn->query($query);

    if ($result === false) {
        return ["error" => $conn->error];
    }

    $penjualanData = [];
    while ($row = $result->fetch_object()) {
        $penjualanData[] = $row;
    }

    return (object) ["data" => $penjualanData];
};

// Penggunaan function getDataKonfirmasiPembelian

// $konfirmasiPembelianData = getDataKonfirmasiPembelian($conn);

// foreach ($konfirmasiPembelianData->data as $penjualan) 
// {
//     echo "No Pembelian: $penjualan->no_pembelian <br>";
//     echo "Nama Pengguna: $penjualan->nama_pengguna <br>";
//     echo "Foto Pengguna: <img src='$penjualan->foto_user' width='100' height='100'> <br>";
//     echo "Nama Hewan: $penjualan->nama_hewan <br>";
//     echo "Alamat Pengiriman: $penjualan->alamat_pengiriman <br>";
//     echo "Total Pembelian: $penjualan->total_pembelian <br>";
//     echo "Bukti Pembayaran: <img src='$penjualan->path_bukti_pembayaran' width='100' height='100'> <br>";
//     echo "Waktu Pembayaran: $penjualan->waktu_pembayaran <br>";
//     echo "<hr>";
// }

function konfirmasiPembelian($conn, $no_pembelian, $status_konfirmasi) {
    $queryCekTransaksi = "SELECT id_hewan FROM transaksi WHERE no_pembelian = ?";
    $stmtCekTransaksi = $conn->prepare($queryCekTransaksi);
    $stmtCekTransaksi->bind_param("s", $no_pembelian);
    $stmtCekTransaksi->execute();
    $result = $stmtCekTransaksi->get_result();
    
    if ($result->num_rows === 0) {
        return "Transaksi tidak ditemukan.";
    }

    $transaksi = $result->fetch_object();
    $id_hewan = $transaksi->id_hewan;

    if ($status_konfirmasi === "Berhasil") {
        $queryUpdateTransaksi = "UPDATE transaksi SET status = 'Berhasil' WHERE no_pembelian = ?";
    } else if ($status_konfirmasi === "Ditolak") {
        $queryUpdateTransaksi = "UPDATE transaksi SET status = 'Ditolak' WHERE no_pembelian = ?";
        
        $queryUpdateHewan = "UPDATE hewan SET status = 1 WHERE id = ?";
        $stmtUpdateHewan = $conn->prepare($queryUpdateHewan);
        $stmtUpdateHewan->bind_param("i", $id_hewan);
        $stmtUpdateHewan->execute();
    }

    $stmtUpdateTransaksi = $conn->prepare($queryUpdateTransaksi);
    $stmtUpdateTransaksi->bind_param("s", $no_pembelian);
    $stmtUpdateTransaksi->execute();

    return $stmtUpdateTransaksi->affected_rows > 0 ? "Konfirmasi berhasil diproses." : "Gagal memperbarui konfirmasi.";
}

// Penggunaan function konfirmasiPembelian
// $pesan = konfirmasiPembelian($conn, "0914317577", "Ditolak");
// echo $pesan;

function getDataHewan($conn)
{
    $query = "SELECT * FROM hewan";

    $result = $conn->query($query);

    if ($result === false) {
        return ["error" => $conn->error];
    }

    $hewanData = [];
    while ($row = $result->fetch_object()) {
        $hewanData[] = $row;
    }

    return (object) ["data" => $hewanData];
}


// Penggunaan function getDataHewan

// $hewanData = getDataHewan($conn);

// foreach ($hewanData->data as $hewan) 
// {
//     echo "ID Hewan: $hewan->id <br>";
//     echo "Nama Hewan: $hewan->nama <br>";
//     echo "Jenis Hewan: $hewan->jenis <br>";
//     echo "Harga Hewan: $hewan->harga_hewan <br>";
//     echo "Status: $hewan->status <br>";
//     echo "<hr>";
// }

function tambahHewan($conn, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan, $file) 
{
    $target_dir = 'assets/img/hewan/';
    $default_path = $target_dir . 'hewan.jpg';

    if (isset($file['name']) && $file['name'] != "") {
        $filename = basename($file['name']);
        $target_file = $target_dir . uniqid() . '_' . $filename; 

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            return "Format file tidak didukung. Gunakan JPG atau PNG.";
        }

        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            return "Gagal mengunggah file foto.";
        }

        $path_poto = $target_file; 
    } 

    $query = "INSERT INTO hewan (nama, path_poto, tahap_usia, berat, jenis_kelamin, warna, jenis, spesies, harga_hewan) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssdssssd", $nama, $path_poto, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan);
    
    if ($stmt->execute()) {
        return "Data hewan berhasil ditambahkan.";
    } else {
        return "Gagal menambahkan data hewan: " . $stmt->error;
    }
}


// Penggunaan function tambahHewan
// Ada di demo 

function editHewan($conn, $id_hewan, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan, $file) 
{
    $query = "SELECT path_poto, status FROM hewan WHERE id = ? AND status != 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_hewan);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return "Hewan tidak ditemukan atau status hewan adalah 0.";
    }

    $current_data = $result->fetch_assoc();
    $current_path_poto = $current_data['path_poto'];

    $target_dir = 'assets/img/hewan/';
    $default_path = $target_dir . 'hewan.jpg';
    $path_poto = $current_path_poto; 

    if (isset($file['name']) && $file['name'] != "") {
        $filename = basename($file['name']);
        $target_file = $target_dir . uniqid() . '_' . $filename; 

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            return "Format file tidak didukung. Gunakan JPG atau PNG.";
        }

        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            return "Gagal mengunggah file foto.";
        }

        if ($current_path_poto !== $default_path && file_exists($current_path_poto)) {
            unlink($current_path_poto); 
        }

        $path_poto = $target_file; 
    }

    $update_query = "UPDATE hewan SET nama = ?, path_poto = ?, tahap_usia = ?, berat = ?, jenis_kelamin = ?, warna = ?, jenis = ?, spesies = ?, harga_hewan = ? WHERE id = ?";
    
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssdsssdii", $nama, $path_poto, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $spesies, $harga_hewan, $id_hewan);
    
    if ($update_stmt->execute()) {
        return "Data hewan berhasil diperbarui.";
    } else {
        return "Gagal memperbarui data hewan: " . $update_stmt->error;
    }
}