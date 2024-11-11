<?php

function registrasi($conn, $username, $nama_depan, $nama_belakang, $email, $password)
{
    if (empty($username) || empty($nama_depan) || empty($nama_belakang) || empty($email) || empty($password))
    {
        return [
            "status" => false,
            "message" => "Data tidak boleh kosong"
        ];
        exit();
    }

    $query = "SELECT * FROM pengguna WHERE username = ? or email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row)
    {
        return [
            "status" => false,
            "message" => "Username atau email sudah terdaftar"
        ];
        exit();
    }

    if (strlen($password) < 8)
    {
        return [
            "status" => false,
            "message" => "Password minimal 8 karakter"
        ];
        exit();
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO pengguna (username, nama_depan, nama_belakang, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $nama_depan, $nama_belakang, $email, $password);
    $stmt->execute();

    if ($stmt->affected_rows > 0)
    {
        return [
            "status" => true,
            "message" => "Registrasi berhasil"
        ];
        exit();
    }else{
        return [
            "status" => false,
            "message" => "Registrasi gagal"
        ];
        exit();
    }
}

function login($conn, $username, $password)
{
    if (empty($username) || empty($password))
    {
        return [
            "status" => false,
            "message" => "Data tidak boleh kosong"
        ];
        exit();
    }

    $query = "SELECT * FROM pengguna WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row)
    {
        return[
            "status" => false,
            "message" => "Username tidak ditemukan"
        ];
        exit();
    }

    if (password_verify($password, $row['password']))
    {
        $_SESSION['user'] = [
            "id" => $row['id'],
            "username" => $row['username'],
            "nama_depan" => $row['nama_depan'],
            "nama_belakang" => $row['nama_belakang'],
            "email" => $row['email'],
            "role" => $row['role']
        ];
        return [
            "status" => true,
            "message" => "Login berhasil"
        ];
        exit();
    }else{
        return [
            "status" => false,
            "message" => "Password salah"
        ];
        exit();
    }
}

function logout()
{
    session_destroy();
    header('Location: /login');
    exit();
}

?>