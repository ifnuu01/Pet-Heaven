<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="stylesheet" href="../../../../assets/css/sidebar.css">
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
</head>
<body>
    <nav>
        <button class="pengaturan"><iconify-icon icon="material-symbols-light:settings-outline"></iconify-icon><span>Pengaturan</span></button>
    </nav>
    <div class="dropdown-pengaturan">
        <div class="dropdown-content">
            <button><iconify-icon icon="mdi:password-outline"></iconify-icon><span>Ubah Password</span></button>
            <button><iconify-icon icon="bxs:door-open"></iconify-icon><span>Keluar</span></button>
        </div>
    </div>
    <div class="sidebar">
        <ul>
            <div class="logo">
                <a href=""><img src="../../../../assets/logo/logo.png" alt="" width="150px"></a>
                <div class="line"></div>
            </div>
            <div class="sidebar-menu">
                <a href=""><iconify-icon icon="clarity:dashboard-line" ></iconify-icon><span>Dashboard</span></a>
                <a href=""><iconify-icon icon="ep:sell" ></iconify-icon><span>Data Penjualan</span></a>
                <a href=""><iconify-icon icon="cil:animal" ></iconify-icon><span>Manajemen Hewan</span></a>
                <a href=""><iconify-icon icon="mingcute:user-4-line" ></iconify-icon><span>Manajemen User</span></a>
                <a href=""><iconify-icon icon="fluent-mdl2:waitlist-confirm" ></iconify-icon><span>Konfirmasi Pembelian</span></a>
            </div>
            <div class="footer">
                <span>Copyright © 2024 Ember</span>
            </div>
        </ul>
    </div>
    <script src="../../../../assets/js/pengaturan-dropdown.js"></script>
</body>
</html>