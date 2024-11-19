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

?>