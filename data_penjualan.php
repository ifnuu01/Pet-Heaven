<?php

include 'template-admin/header.php';

?>

<div class="container">
    <div class="search">
        <form action="" method="GET">
            <input type="text" name="search" id="search" placeholder="Cari">
            <button type="submit" hidden>Cari</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>No. Pembelian</th>
                    <th>Nama Pengguna</th>
                    <th>Alamat Pengiriman</th>
                    <th>Total Pembelian</th>
                    <th>Bukti Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Andi</td>
                    <td>Jl. Jendral Sudirman No. 1</td>
                    <td>Rp 500.000</td>
                    <td>gambar</td>
                    <td>2021-08-01</td>
                    <td>Dikonfirmasi</td>
                    <td>
                        <button>Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="pagination">
        <button>Sebelumnya</button>
        <button>1</button>
        <button>2</button>
        <button>3</button>
        <button>Selanjutnya</button>
    </div>
</div>


<script src="assets/js/pengaturan-dropdown.js"></script>
</body>
</html>