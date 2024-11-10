<?php

require 'connection.php';


// ADMIN FUNCTION 

function totalHewan($conn)
{
    $query = "SELECT COUNT(id) as total FROM hewan WHERE status = 1";
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

function getDataHewan($conn, $limit_bawah, $limit_atas)
{
    $query = "
            SELECT 
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
    $target_dir = '/assets/img/hewan/';
    $default_path = $target_dir . 'hewan.jpg';

    if (isset($file['name']) && $file['name'] != "") {
        $filename = basename($file['name']);
        $target_file = $target_dir . uniqid() . '_' . $filename; 

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

    $query = "INSERT INTO hewan (nama_hewan, path_poto, tahapan_usia, berat, jenis_kelamin, warna, jenis_hewan, harga) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssdssid", $nama, $path_poto, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan);
    
    if ($stmt->execute()) {
        return [
            "status" => true,
            "message" => "Data hewan berhasil ditambahkan."
        ];
    } else {
        return  [
            "status" => false,
            "message" => "Gagal menambahkan data hewan: " . $stmt->error
        ];
    }
}


// Penggunaan function tambahHewan
// Ada di demo 

function editHewan($conn, $id_hewan, $nama, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan, $file) 
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

    $target_dir = '/assets/img/hewan/';
    $default_path = $target_dir . 'hewan.jpg';
    $path_poto = $current_path_poto; 

    if (isset($file['name']) && $file['name'] != "") {
        $filename = basename($file['name']);
        $target_file = $target_dir . uniqid() . '_' . $filename; 

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

        if ($current_path_poto !== $default_path && file_exists($current_path_poto)) {
            unlink($current_path_poto); 
        }

        $path_poto = $target_file; 
    }

    $update_query = "UPDATE hewan SET nama_hewan = ?, path_poto = ?, tahapan_usia = ?, berat = ?, jenis_kelamin = ?, warna = ?, jenis_hewan = ?,  harga = ? WHERE id = ?";
    
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssdssidi", $nama, $path_poto, $tahap_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga_hewan, $id_hewan);
    
    if ($update_stmt->execute()) {
        return [
            "status" => true,
            "message" => "Data hewan berhasil diperbarui."
        ];
    } else {
        return [
            "status" => false,
            "message" => "Gagal memperbarui data hewan: " . $update_stmt->error
        ];
    }
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
        if ($current_path_poto !== '/assets/img/hewan/hewan.jpg' && file_exists($current_path_poto)) {
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


