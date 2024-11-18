<?php
require_once 'functions/connection.php';
require_once 'functions/admin_function.php';

$limit_bawah = isset($_GET['limit_bawah']) ? (int)$_GET['limit_bawah'] : 0;
$limit_atas = isset($_GET['limit_atas']) ? (int)$_GET['limit_atas'] : 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$hewanData = getDataHewan($conn, $limit_bawah, $limit_atas, $search, $kategori);

header('Content-Type: application/json');
echo json_encode($hewanData);
?>