<?php

function pembayaran($conn, $id_pengguna, $id_hewan, $metode_pembayaran, $file_bukti_pembayaran){

    $filename = basename($file_bukti_pembayaran['name']);
    $target_dir = "assets/img/pembayaran/";
    $target_file = $target_dir . uniqid() .'_'. $filename;

    $max_size = 5 * 1024 * 1024; // 5MB
    if ($_FILES["bukti_pembayaran"]["size"] > $max_size) {
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

    if (!move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
        return [
            "status" => false,
            "message" => "Gagal mengunggah bukti pembayaran."
        ];
    }

    $query = "INSERT INTO transaksi (id_pengguna, id_hewan, metode_pembayaran, bukti_pembayaran) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $id_pengguna, $id_hewan, $metode_pembayaran, $target_file);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
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

    // Get the current photo path
    $query = "SELECT path_poto FROM pengguna WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $stmt->bind_result($current_photo_path);
    $stmt->fetch();
    $stmt->close();

    // Move the new file
    if (!move_uploaded_file($file_tmp, $file_destination)) {
        return ['status' => false, 'message' => 'Terjadi kesalahan saat mengunggah foto'];
    }

    // Delete the old file if it exists
    if ($current_photo_path && file_exists($current_photo_path)) {
        unlink($current_photo_path);
    }

    // Update the database with the new file path
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
              WHERE n.id_pengguna = ?";
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

?>