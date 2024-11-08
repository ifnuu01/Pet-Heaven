<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet-heaven</title>
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="../../../../assets/css/navbar.css">
</head>
<body>
    <nav>
        <ul class="content-nav-item">
            <li class="item1">
                <a href="index.php"><img src="../../../../assets/logo/logo.png" alt="" width="120px"></a>
                <a href="index.php"><iconify-icon icon="line-md:home"></iconify-icon></a>
                <span id="kategori">Kategori</span>
            </li>
            <li class="item2">
                <form action="public/index.php">
                    <input type="text" name="search" id="search" placeholder="Mencari">
                    <button type="submit" hidden >Cari</button>
                </form>
            </li>
            <li class="item3">
                <div>
                    <a href="">Masuk</a>
                    <div></div>
                    <a href="">Daftar</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="dropdown-kategori" class="">
        <div class="dropdown-content">
            <a href="index.php?kategori=1">Anjing</a>
            <a href="index.php?kategori=2">Kucing</a>
            <a href="index.php?kategori=3">Kelinci</a>
            <a href="index.php?kategori=4">Hamster</a>
            <a href="index.php?kategori=5">Sugar Glider</a>
            <a href="index.php?kategori=6">Reptil</a>
            <a href="index.php?kategori=7">Burung</a>
            <a href="index.php?kategori=8">Ikan</a>
        </div>
    </div>