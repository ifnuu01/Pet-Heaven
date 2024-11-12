<?php

include 'template-admin/header.php';


$limit_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit_bawah = ($halaman - 1) * $limit_per_halaman;


if (isset($_GET['search']) && $_GET['search'] !== '') {
    $nama_hewan = $_GET['search'];
    $data = search_manajemen_hewan($conn, $nama_hewan, $limit_bawah, $limit_per_halaman);
    
    $total_data_search = $conn->query("SELECT COUNT(h.nama_hewan) as total FROM hewan h WHERE h.nama_hewan LIKE '%$nama_hewan%'");
    $total_data = $total_data_search->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
} else {
    $data = getDataHewan($conn, $limit_bawah, $limit_per_halaman);
    
    $total_data_query = $conn->query("SELECT COUNT(*) as total FROM hewan WHERE status = 1");
    $total_data = $total_data_query->fetch_assoc()['total'];
    $total_halaman = ceil($total_data / $limit_per_halaman);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_hewan'])) {
    $id = $_POST['hapus_hewan'];
    $status = hapusHewan($conn, $id);
    if ($status['status']) {
        echo "<script>alert('Hewan berhasil dihapus.');</script>";
        echo "<script>window.location = 'manajemen_hewan.php';</script>";
    } else {
        echo "<script>alert('Hewan gagal dihapus: {$status['message']}');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
  
  $nama_hewan = $_POST['nama-hewan'];
  $berat = $_POST['berat'];
  $jenis = $_POST['jenis'];
  $tahapan_usia = $_POST['tahapan-usia'];
  $warna = $_POST['warna'];
  $harga = $_POST['harga'];
  $jenis_kelamin = $_POST['jenis-kelamin'];
  $foto = $_FILES['unggah-foto'];

  $status = tambahHewan($conn, $nama_hewan, $tahapan_usia, $berat, $jenis_kelamin, $warna, $jenis, $harga, $foto);
  if ($status['status']) {
      echo "<script>alert('Hewan berhasil ditambahkan.');</script>";
      echo "<script>window.location = 'manajemen_hewan';</script>";
  } else {
      echo "<script>alert('Hewan gagal ditambahkan: {$status['message']}');</script>";
  }
}

?>

<div class="container">
    <div class="search-container">
        <form action="" method="GET">
            <input type="text" name="search" class="search-input" placeholder="Cari Hewan" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit" hidden></button>
        </form>
        <button class="detail-btn3" onclick="openModal()" >Tambah Hewan</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nama Hewan</th>
                    <th>Foto</th>
                    <th>Tahapan Usia</th>
                    <th>Jenis Kelamin</th>
                    <th>Jenis Hewan</th>
                    <th>Harga Hewan</th>
                    <th>Tanggal Ditambahkan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($data['status'] && count($data['data']) > 0): ?>
                <?php foreach ($data['data'] as $hewan): ?>
                    <tr>
                        <td class="align-center"><?= $hewan->nama_hewan; ?></td>
                        <td class="align-center"><img src="<?= $hewan->path_poto; ?>" alt="Foto Hewan" width="40px" height="30px"></td>
                        <td class="align-center"><?= $hewan->tahapan_usia; ?></td>
                        <td class="align-center"><?= $hewan->jenis_kelamin; ?></td>
                        <td class="align-center"><?= $hewan->jenis_hewan; ?></td>
                        <td class="align-center">Rp<?= number_format($hewan->harga, 2); ?></td>
                        <td class="align-center"><?= $hewan->tanggal_ditambahkan; ?></td>
                        <td class="container-btn">
                            <button class="detail-btn2"><iconify-icon icon="ph:note-pencil-bold"></iconify-icon></button>
                            <form action="#" method="POST" id="hapusHewan-<?= $hewan->id; ?>">
                                    <input type="hidden" name="hapus_hewan" value="<?= $hewan->id; ?>">
                            </form>
                            <button class="detail-btn1 actionBtn"
                            data-action="hapus hewan" 
                            data-message="Apakah Anda yakin ingin menghapus hewan ini?" 
                            data-form="hapusHewan-<?= $hewan->id; ?>"
                            data-cancel-text="Tidak"
                            data-confirm-text="Ya">
                            <iconify-icon icon="mdi:trash-can-outline"></iconify-icon>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Data hewan tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($halaman > 1): ?>
            <a class="button" href="?page=<?= $halaman - 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Sebelumnya</a>
        <?php else: ?>
            <span class="button">Sebelumnya</span>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
            <?php if ($i == $halaman): ?>
                <strong class="nomor"><?= $i; ?></strong>
            <?php else: ?>
                <a class="nomor" href="?page=<?= $i; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>"><?= $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halaman < $total_halaman): ?>
            <a class="button" href="?page=<?= $halaman + 1; ?><?= isset($_GET['search']) ? '&search=' . $_GET['search'] : ''; ?>">Selanjutnya</a>
        <?php else: ?>
            <span class="button">Selanjutnya</span>
        <?php endif; ?>
    </div>
  </div>
<dialog id="modal-add" class="modal-add">
  <div class="container-modal-form">
    <div class="modal-content-add">
      <div class="modal-header">
        <h3>Tambah Hewan</h3>
        <span class="close-button"><iconify-icon icon="uil:exit"></iconify-icon></span>
      </div>
      <div class="modal-body">
        <form class="modal-form grid-3x3" action="#" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="add" value="add">
          <div class="form-group">
            <label for="nama-hewan">Nama hewan</label>
            <input type="text" id="nama-hewan" name="nama-hewan" required>
          </div>
          <div class="form-group">
            <label for="berat">Berat</label>
            <input type="number" id="berat" name="berat" min="1" required>
          </div>
          <div class="form-group">
            <label for="jenis">Jenis</label>
            <select id="jenis" name="jenis" required>
              <option value="">Pilih jenis</option>
              <option value="1" selected>Kucing</option>
              <option value="2">Anjing</option>
              <option value="3">Ikan Hias</option>
              <option value="4">Burung</option>
              <option value="5">Reptil</option>
              <option value="6">Hamster</option>
              <option value="7">Serangga</option>
            </select>
          </div>
          <div class="form-group">
            <label for="tahapan-usia">Tahapan Usia</label>
            <input type="text" id="tahapan-usia" name="tahapan-usia" required>
          </div>
          <div class="form-group">
            <label for="warna">Warna</label>
            <input type="text" id="warna" name="warna" required>
          </div>
          <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" min="1" required>
          </div>
          <div class="form-group">
            <label for="unggah-foto">Unggah Foto</label>
              <input type="file" id="unggah-foto" name="unggah-foto" accept="image/*" required>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="radio-group">
              <div class="radio-item">
                <input type="radio" id="kelamin" name="jenis-kelamin" value="Jantan" required>
                <label for="Jantan">Jantan</label>
              </div>
              <div class="radio-item">
                <input type="radio" id="kelamin" name="jenis-kelamin" value="Betina" styles="" required>
                <label for="Betina">Betina</label>
              </div>
            </div>
          </div>
          <button type="submit" name="add" class="btn-primary">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</dialog>


<script src="assets/js/modal-confirm.js" defer></script>
<script src="assets/js/modal-form.js" defer></script>
<script src="assets/js/pengaturan-dropdown.js" defer></script>
</body>
</html>