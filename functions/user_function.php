<?php

function pembayaran($conn, $id_pengguna, $id_hewan, $metode_pembayaran, $file_bukti_pembayaran) {
    
    $filename = basename($file_bukti_pembayaran['name']);
    $target_dir = "assets/img/pembayaran/";
    $target_file = $target_dir . uniqid() . '_' . $filename;

    
    $max_size = 5 * 1024 * 1024; 
    if ($file_bukti_pembayaran["size"] > $max_size) {
        return [
            "status" => false,
            "message" => "Ukuran file bukti pembayaran terlalu besar. Maksimal 5MB"
        ];
    }

    
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_type, ['jpg', 'jpeg', 'png'])) {
        return [
            "status" => false,
            "message" => "Format file tidak didukung. Gunakan JPG atau PNG."
        ];
    }

    
    if (!move_uploaded_file($file_bukti_pembayaran["tmp_name"], $target_file)) {
        return [
            "status" => false,
            "message" => "Gagal mengunggah bukti pembayaran."
        ];
    }

    
    do {
        $random_no = str_pad(mt_rand(0, 999999999), 10, '0', STR_PAD_LEFT); 
        $query_check = "SELECT 1 FROM transaksi WHERE no_pembelian = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("s", $random_no);
        $stmt_check->execute();
        $stmt_check->store_result();
        $is_unique = $stmt_check->num_rows === 0;
    } while (!$is_unique);

    
    $query = "INSERT INTO transaksi (id_pengguna, id_hewan, metode_pembayaran, bukti_pembayaran, no_pembelian) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $id_pengguna, $id_hewan, $metode_pembayaran, $target_file, $random_no);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        
        $query_update = "UPDATE hewan SET status = 0 WHERE id = ?";
        $stmt_update = $conn->prepare($query_update);
        $stmt_update->bind_param("i", $id_hewan);
        $stmt_update->execute();

        
        $message = "Pembelian anda sedang diproses ID PEMBELIAN $random_no";
        $query_notifikasi = "INSERT INTO notifikasi (id_pengguna, no_pembelian, message) VALUES (?, ?, ?)";
        $stmt_notifikasi = $conn->prepare($query_notifikasi);
        $stmt_notifikasi->bind_param("iss", $id_pengguna, $random_no, $message);
        $stmt_notifikasi->execute();

        return [
            "status" => true,
            "message" => "Pembayaran berhasil dilakukan."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal melakukan pembayaran."
        ];
    }
}


function get_akun($conn, $id_pengguna){
    $query = "SELECT * FROM pengguna WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data;
}

function uploadPhoto($file, $id_pengguna, $conn) {
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed = ['jpg', 'jpeg', 'png'];

    if (!in_array($file_ext, $allowed)) {
        return ['status' => false, 'message' => 'Format file tidak didukung. Gunakan JPG atau PNG'];
    }

    if ($file_error !== 0) {
        return ['status' => false, 'message' => 'Terjadi kesalahan saat mengunggah foto'];
    }

    if ($file_size > 2097152) {
        return ['status' => false, 'message' => 'Ukuran file terlalu besar. Maksimal 2MB'];
    }

    $file_name_new = uniqid('', true) . '.' . $file_ext;
    $file_destination = 'assets/img/profiles/' . $file_name_new;

    
    $query = "SELECT path_poto FROM pengguna WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($current_photo_path);
    $stmt->fetch();
    $stmt->close();

    
    if (!move_uploaded_file($file_tmp, $file_destination)) {
        return ['status' => false, 'message' => 'Terjadi kesalahan saat mengunggah foto'];
    }

    
    if ($current_photo_path && file_exists($current_photo_path)) {
        unlink($current_photo_path);
    }

    
    $query = "UPDATE pengguna SET path_poto = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $file_destination, $id_pengguna);
    if ($stmt->execute()) {
        $_SESSION['user']['poto'] = $file_destination;
        return ['status' => true, 'message' => 'Berhasil mengubah foto'];
    } else {
        return ['status' => false, 'message' => 'Gagal mengubah foto'];
    }
}

function get_alamat($conn, $id_pengguna){
    $query = "SELECT p.username, 
    CONCAT_WS(', ', a.jalan, a.kelurahan, a.kecamatan, a.kota_kabupaten, a.provinsi) AS alamat_pengiriman,
    a.tempat, p.nomor_hp
    from pengguna p 
    join alamat a on p.id = a.id_pengguna
    where p.id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $nomr_hp = $data['nomor_hp'] ? $data['nomor_hp'] : "Nomor HP belum diatur";
    
    if ($data) {
        return [
            "status" => true,
            "username" => $data['username'],
            "alamat_pengiriman" => $data['alamat_pengiriman'],
            "tempat" => $data['tempat'],
            "nomor_hp" => $nomr_hp
        ];
    } else {
        return [
            "status" => false,
            "username" => $id_pengguna,
            "alamat_pengiriman" => "Alamat pengiriman belum anda tambahkan",
            "tempat" => "Tempat belum ada",
            "nomor_hp" => $nomr_hp
        ];
    }
}

function update_alamat ($conn, $id_pengguna, $tempat, $jalan, $kelurahan, $kecamatan, $kota_kabupaten, $provinsi){
    $query = "UPDATE alamat SET tempat = ?, jalan = ?, kelurahan = ?, kecamatan = ?, kota_kabupaten = ?, provinsi = ? WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $tempat, $jalan, $kelurahan, $kecamatan, $kota_kabupaten, $provinsi, $id_pengguna);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return [
            "status" => true,
            "message" => "Berhasil mengubah alamat"
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal mengubah alamat"
        ];
    }
}

function get_notifikasi($conn, $id_pengguna) {
    $query = "SELECT n.id, n.message, p.username
              FROM notifikasi n
              JOIN pengguna p ON n.id_pengguna = p.id
              WHERE n.id_pengguna = ? ORDER BY n.id desc";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function hapus_notifikasi($conn, $id_notifikasi) {
    $query = "DELETE FROM notifikasi WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_notifikasi);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function hapus_semua_notifikasi($conn, $id_pengguna) {
    $query = "DELETE FROM notifikasi WHERE id_pengguna = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function riwayat_pembelian($conn, $id_pengguna) {
    $query = "    
    select t.id_pengguna, t.id_hewan, t.no_pembelian, t.status, j.jenis_hewan, h.nama_hewan, h.harga, h.path_poto
    from transaksi t 
    join hewan h on t.id_hewan = h.id
    join jenis_hewan j on j.id = h.jenis_hewan where t.id_pengguna = ? ORDER BY t.waktu_pembayaran DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function detail_riwayat_pembelian ($conn, $nomor_pembelian)
{
    $query ="
    select h.nama_hewan, h.path_poto, h.harga, h.berat, h.jenis_kelamin, h.warna, h.tahapan_usia, j.jenis_hewan
    , t.biaya_pengiriman, t.pajak, (h.harga + t.biaya_pengiriman + t.pajak) as total_pembayaran, t.metode_pembayaran,
    t.status, t.waktu_pembayaran
    from transaksi t
    join hewan h on t.id_hewan = h.id
    join jenis_hewan j on h.jenis_hewan = j.id
    where t.no_pembelian = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $nomor_pembelian);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    return $data;
}


function maskEmail($email) {
    list($username, $domain) = explode('@', $email);
    $maskedUsername = substr($username, 0, 2) . str_repeat('*', strlen($username) - 2);
    return $maskedUsername . '@' . $domain;
}

?>