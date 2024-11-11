<?php
session_start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$isLogin = isset($_SESSION['user']);
$role = $_SESSION['user']['role'] ?? null;

switch(true)
{
    case $request === '/':
        if ($isLogin) {
            if ($role === 'Admin') {
                require 'src/views/admin/dashboard.php';
            } else {
                require 'src/views/user/index.php';
            }
        } else {
            require 'src/views/index.php';
        }
        break;
    case preg_match('/^\/login$/', $request):
        require 'src/views/auth/login.php';
        break;
    case preg_match('/^\/register$/', $request):
        require 'src/views/auth/register.php';
        break;
    case preg_match('/^\/manajemen_hewan$/', $request):
        require 'src/views/admin/manajemenHewan.php';
        break;
    case preg_match('/^\/manajemen_user$/', $request):
        require 'src/views/admin/manajemenUser.php';
        break;
    case preg_match('/^\/data_penjualan$/', $request):
        require 'src/views/admin/dataPenjualan.php';
        break;
    case preg_match('/^\/konfirmasi_pembelian$/', $request):
        require 'src/views/admin/konfirmasiPembelian.php';
        break;
    default:
        echo "404 Not Found";
        break;
    
}


?>
