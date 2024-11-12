<?php

require 'connection.php';


// ADMIN FUNCTION 

function getDataHewan($conn, $limit_bawah, $limit_atas)
{
    $query = "
            SELECT 
                *
            FROM hewan 
            WHERE status = 1
            LIMIT ?, ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $hewanData = [];
    while ($row = $result->fetch_object()) {
        $hewanData[] = $row;
    }

    return [
        "status" => true,
        "data" => $hewanData
    ];
}

// Cara penggunaan function getDataHewan

// $hewanData = getDataHewan($conn, 0, 5);

// if ($hewanData['status']) {
//     foreach ($hewanData['data'] as $hewan) {
//         echo "ID: $hewan->id <br>";
//         echo "Nama Hewan: $hewan->nama_hewan <br>";
//         echo "Foto: <img src='$hewan->path_poto' width='100' height='100'> <br>";
//         echo "Tahapan Usia: $hewan->tahapan_usia <br>";
//         echo "Jenis Kelamin: $hewan->jenis_kelamin <br>";
//         echo "Jenis Hewan: $hewan->jenis_hewan <br>";
//         echo "Harga: $hewan->harga <br>";
//         echo "Tanggal Ditambahkan: $hewan->tanggal_ditambahkan <br>";
//         echo "<hr>";
//     }
// } else {
//     echo $hewanData['message'];
// }

function tambahHewan($conn, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan, $file) 
{
    $filename = basename($file['name']);
    $target_dir = 'assets/img/hewan/';
    $target_file = $target_dir . uniqid() . '_' . $filename;

    
    $max_size = 5 * 1024 * 1024; 
    if ($file['size'] > $max_size) {
        return [
            "status" => false,
            "message" => "Ukuran file terlalu besar. Maksimal 5MB."
        ];
    }

    
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
        return [
            "status" => false,
            "message" => "Format file tidak didukung. Gunakan JPG atau PNG."
        ];
    }

    
    if (!move_uploaded_file($file['tmp_name'], $target_file)) {
        return [
            "status" => false,
            "message" => "Gagal mengunggah file foto."
        ];
    }

    
    $query = "INSERT INTO hewan (nama_hewan, path_poto, tahapan_usia, berat, jenis_kelamin, warna, jenis_hewan, harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    
    $stmt->bind_param("sssdssdi", $nama, $target_file, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan);
    $stmt->execute();

    
    if ($stmt->affected_rows > 0) {
        return [
            "status" => true,
            "message" => "Data hewan berhasil ditambahkan."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal menambahkan data hewan: " . $stmt->error
        ];
    }
}


// Penggunaan function tambahHewan
// Ada di demo 

function editHewan($conn, $id_hewan, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan, $file) 
{
    $query = "SELECT path_poto, status FROM hewan WHERE id = ? AND status = 1 ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_hewan);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return [
            "status" => false,
            "message" => "Data hewan tidak ditemukan."
        ];
    }

    $current_data = $result->fetch_assoc();
    $current_poto = $current_data['path_poto'];
    $path_poto = $current_poto;

    if ($file['size'] > 0) {
        $filename = basename($file['name']);
        $target_dir = 'assets/img/hewan/';
        $target_file = $target_dir . uniqid() . '_' . $filename;

        $max_size = 5 * 1024 * 1024; 
        if ($file['size'] > $max_size) {
            return [
                "status" => false,
                "message" => "Ukuran file terlalu besar. Maksimal 5MB."
            ];
        }

        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
            return [
                "status" => false,
                "message" => "Format file tidak didukung. Gunakan JPG atau PNG."
            ];
        }

        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            return [
                "status" => false,
                "message" => "Gagal mengunggah file foto."
            ];
        }

        $path_poto = $target_file;
    }

    $query = "UPDATE hewan SET nama_hewan = ?, path_poto = ?, tahapan_usia = ?, berat = ?, jenis_kelamin = ?, warna = ?, jenis_hewan = ?, harga = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssdssidi", $nama, $path_poto, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan, $id_hewan);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return [
            "status" => true,
            "message" => "Data hewan berhasil diubah."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal mengubah data hewan: " . $stmt->error
        ];
    }
}

function get_hewan_by_id($conn, $id_hewan)
{
    $query = "SELECT * FROM hewan WHERE id = ? AND status = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_hewan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [
            "status" => false,
            "message" => "Data hewan tidak ditemukan."
        ];
    }

    $hewan = $result->fetch_assoc();
    return [
        "status" => true,
        "data" => $hewan
    ];
}

// Hapus hewna
function hapusHewan($conn, $id_hewan) 
{
    $query = "SELECT path_poto, status FROM hewan WHERE id = ? AND status != 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_hewan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [
            "status" => false,
            "message" => "Data hewan tidak ditemukan."
        ];
    }

    $current_data = $result->fetch_assoc();
    $current_path_poto = $current_data['path_poto'];

    $delete_query = "DELETE FROM hewan WHERE id = ?";

    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $id_hewan);
    $delete_stmt->execute();

    if ($delete_stmt->affected_rows > 0) {
        if (file_exists($current_path_poto)) {
            unlink($current_path_poto);
        }

        return [
            "status" => true,
            "message" => "Data hewan berhasil dihapus."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal menghapus data hewan: " . $delete_stmt->error
        ];
    }
}

function get_jumlah_pendapatan($conn)
{
    $query = "select 
    sum(t.biaya_pengiriman + t.pajak + h.harga) as total_pendapatan
    from transaksi t
    join hewan h on t.id_hewan = h.id
    where t.status = 'Dikonfirmasi'";
    $result = $conn->query($query);
    
    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $total = $result->fetch_assoc();
    return [
        "status" => true,
        "total" => $total['total_pendapatan']
    ];
}

function total_data_penjualan($conn)
{   
    $query = "SELECT COUNT(no_pembelian) as total FROM transaksi";
    $result = $conn->query($query);

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $total = $result->fetch_assoc();
    return [
        "status" => true,
        "total" => $total['total']
    ];
}

function total_hewan($conn)
{
    $query = "SELECT COUNT(id) as total FROM hewan";
    $result = $conn->query($query);

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $total = $result->fetch_assoc();
    return [
        "status" => true,
        "total" => $total['total']
    ];
}

function total_pengguna($conn)
{
    $query = "SELECT COUNT(id) as total FROM pengguna";
    $result = $conn->query($query);

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $total = $result->fetch_assoc();
    return [
        "status" => true,
        "total" => $total['total']
    ];
}

function get_data_penjualan($conn, $limit_bawah, $limit_atas)
{
    $query = "select  p.nama_depan, CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
	(t.biaya_pengiriman + t.pajak + h.harga) as total_pembelian, h.* , j.jenis_hewan as jenis, t.*
    from transaksi t 
    join pengguna p on t.id_pengguna = p.id
    join alamat a on p.id = a.id_pengguna
    join hewan h on t.id_hewan = h.id
    join jenis_hewan j on h.jenis_hewan = j.id
    where t.status != 'Menunggu'
    LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $data_penjualan = [];

    while ($row = $result->fetch_object()) {
        $data_penjualan[] = $row;
    }

    return [
        "status" => true,
        "data" => $data_penjualan
    ];
}

// cara penggunaan
// $data_penjualan = get_data_penjualan($conn, 0, 5);

// if ($data_penjualan['status']) {
//     foreach ($data_penjualan['data'] as $data) {
//         echo "No. Pembelian: $data->no_pembelian <br>";
//         echo "Nama Pengguna: $data->nama_depan <br>";
//         echo "Alamat Pengiriman: $data->alamat_pengiriman <br>";
//         echo "Bukti Pembayaran: <img src='$data->bukti_pembayaran' width='100' height='100'> <br>";
//         echo "Waktu Pembayaran: $data->waktu_pembayaran <br>";
//         echo "Status: $data->status <br>";
//         echo "<hr>";
//     }
// } else {
//     echo $data_penjualan['message'];
// }

function detail_pembayaran($conn, $no_pembelian)
{
    $query = "select p.id, t.no_pembelian, p.nama_depan, t.bukti_pembayaran, t.waktu_pembayaran, t.status, t.pajak, t.biaya_pengiriman,t.metode_pembayaran, 
    h.*
    from transaksi t
    join pengguna p on t.id_pengguna = p.id
    join hewan h on t.id_hewan = h.id
    where t.no_pembelian = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $no_pembelian);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $detail_pembayaran = $result->fetch_object();

    return [
        "status" => true,
        "data" => $detail_pembayaran
    ];
}

function get_managemen_user($conn, $limit_bawah, $limit_atas)
{
    $query = "select p.id, p.nama_depan, p.email, p.nomor_hp, p.tanggal_lahir, p.jenis_kelamin, p.path_poto,
    CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman, p.tanggal_dibuat
    from pengguna p 
    join alamat a on p.id = a.id_pengguna
    where status = 'Aktif' and role = 'User'
    LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit_bawah, $limit_atas);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $manajemen_user = [];

    while ($row = $result->fetch_object()) {
        $manajemen_user[] = $row;
    }

    return [
        "status" => true,
        "data" => $manajemen_user
    ];
}

function blokir_user($conn, $id)
{
    // Cek apakah pengguna ada
    $query = "SELECT id FROM pengguna WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [
            "status" => false,
            "message" => "Pengguna tidak ditemukan."
        ];
    }

    // Update status pengguna menjadi "Tidak Aktif"
    $query = "UPDATE pengguna SET status = 'Tidak Aktif' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $conn->commit();  // Menyimpan perubahan pada database
        return [
            "status" => true,
            "message" => "Pengguna berhasil diblokir."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal memblokir pengguna: " . $stmt->error
        ];
    }
}


function get_konfirmasi_pembelian($conn, $limit_bawah, $limit_atas)
{
    $query = "select t.*, p.nama_depan, CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
	(t.biaya_pengiriman + t.pajak + h.harga) as total_pembelian, h.* , j.jenis_hewan as jenis, p.path_poto as poto_pengguna
    from transaksi t 
    join pengguna p on t.id_pengguna = p.id
    join alamat a on p.id = a.id_pengguna
    join hewan h on t.id_hewan = h.id
    join jenis_hewan j on h.jenis_hewan = j.id
    where t.status = 'Menunggu'
    LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $konfirmasi_pembelian = [];

    while ($row = $result->fetch_object()) {
        $konfirmasi_pembelian[] = $row;
    }

    return [
        "status" => true,
        "data" => $konfirmasi_pembelian
    ];
}

function konfirmasi_pembelian($conn, $no_pembelian, $status)
{
    $query = "UPDATE transaksi SET status = ? WHERE no_pembelian = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $status, $no_pembelian);

    if ($stmt->execute()) {
        return [
            "status" => true,
            "message" => "Pembelian berhasil dikonfirmasi."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal mengkonfirmasi pembelian: " . $stmt->error
        ];
    }
}


function ubah_password($conn, $newpass, $oldpass, $id)
{
    $query = "select password from pengguna where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $data = $result->fetch_assoc();

    if (!password_verify($oldpass, $data['password'])) {
        return [
            "status" => false,
            "message" => "Password lama salah."
        ];
    }

    $newpass = password_hash($newpass, PASSWORD_DEFAULT);
    $query = "UPDATE pengguna SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $newpass, $id);

    if ($stmt->execute()) {
        return [
            "status" => true,
            "message" => "Password berhasil diubah."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal mengubah password: " . $stmt->error
        ];
    }
}



function search_data_penjualan($conn, $nama_pengguna, $limit_bawah, $limit_atas)
{
    $query = "select t.no_pembelian, p.nama_depan, CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman
    , t.bukti_pembayaran, t.waktu_pembayaran, t.status, (t.biaya_pengiriman + t.pajak + h.harga) as total_pembelian
    from transaksi t 
    join pengguna p on t.id_pengguna = p.id
    join alamat a on p.id = a.id_pengguna
    join hewan h on t.id_hewan = h.id
    where t.status != 'Menunggu' AND p.nama_depan LIKE ?
    LIMIT ?, ?";
    
    $nama_pengguna = "%" . $nama_pengguna . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $nama_pengguna, $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $data_penjualan = [];

    while ($row = $result->fetch_object()) {
        $data_penjualan[] = $row;
    }

    return [
        "status" => true,
        "data" => $data_penjualan
    ];
}

function search_manajemen_hewan($conn, $nama_hewan, $limit_bawah, $limit_atas)
{
    $query = "SELECT 
    h.id,
    h.nama_hewan,
    h.path_poto,
    h.tahapan_usia,
    h.jenis_kelamin,
    j.jenis_hewan,
    h.harga,
    h.tanggal_ditambahkan
    FROM hewan h
    JOIN jenis_hewan j ON h.jenis_hewan = j.id 
    WHERE h.status = 1 AND h.nama_hewan LIKE ?
    LIMIT ?, ?";
    
    $nama_hewan = "%" . $nama_hewan . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $nama_hewan, $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $hewanData = [];
    while ($row = $result->fetch_object()) {
        $hewanData[] = $row;
    }

    return [
        "status" => true,
        "data" => $hewanData
    ];
}

function search_pengguna($conn, $nama_pengguna, $limit_bawah, $limit_atas)
{
    $query = "select p.id, p.nama_depan, p.email, p.nomor_hp, p.tanggal_lahir, p.jenis_kelamin, p.path_poto,
    CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman, p.tanggal_dibuat
    from pengguna p 
    join alamat a on p.id = a.id_pengguna
    where p.nama_depan LIKE ?
    LIMIT ?, ?";

    $nama_pengguna = "%" . $nama_pengguna . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $nama_pengguna, $limit_bawah, $limit_atas);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $manajemen_user = [];

    while ($row = $result->fetch_object()) {
        $manajemen_user[] = $row;
    }

    return [
        "status" => true,
        "data" => $manajemen_user
    ];
}

function search_konfirmasi_pembelian($conn, $nama_pengguna, $limit_bawah, $limit_atas)
{
    $query = "select t.no_pembelian, p.nama_depan, p.path_poto, h.nama_hewan, CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman
    , (t.biaya_pengiriman + t.pajak + h.harga) as total_pembelian , t.waktu_pembayaran
    from transaksi t
    join pengguna p on t.id_pengguna = p.id
    join hewan h on t.id_hewan = h.id
    join alamat a on p.id = a.id_pengguna
    where t.status = 'Menunggu' AND p.nama_depan LIKE ?
    LIMIT ?, ?";

    $nama_pengguna = "%" . $nama_pengguna . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $nama_pengguna, $limit_bawah, $limit_atas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        return [
            "status" => false,
            "message" => $conn->error
        ];
    }

    $konfirmasi_pembelian = [];

    while ($row = $result->fetch_object()) {
        $konfirmasi_pembelian[] = $row;
    }

    return [
        "status" => true,
        "data" => $konfirmasi_pembelian
    ];
}