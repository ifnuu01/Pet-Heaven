<?php

include 'template-user/header.php';

$limit_bawah = 0;
$limit_atas = 5;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$hewanData = getDataHewan($conn, $limit_bawah, $limit_atas, $search, $kategori);

?>
<link rel="stylesheet" href="assets/css/home-user.css">
<link rel="stylesheet" href="assets/css/slider.css">
<link rel="stylesheet" href="assets/css/card.css">

<div class="hero-1">
    <div class="hero-1-content">
        <div class="slider">
            <div class="slide active" style="background-image: url('assets/logo/slider-1.png');"></div>
            <div class="slide" style="background-image: url('assets/logo/slider-2.png');"></div>
            <div class="slide" style="background-image: url('assets/logo/slider-3.png');"></div>
            <div class="slide" style="background-image: url('assets/logo/slider-4.png');"></div>
            <div class="slide" style="background-image: url('assets/logo/slider-5.png');"></div>
        </div>
        <div class="content-hero-1">
            <div class="text-content">
                <p>Selamat datang di website <span>pet shop.id</span>, website yang menyediakan <br> layanan hewan peliharaan untuk Anda di rumah.</p>
                <p>Silakan pilih hewan peliharaan Anda, tutorial pemesanan <br> bisa dilihat pada <span>panduan!</span></p>
            </div>
            <div class="button-content">
                <a href="#" class="btn-primary">Panduan</a>
            </div>
        </div>
    </div>
</div>

<div class="hero-2">
    <div class="hero-2-content">
        <div class="hero-2-title">
            <h1>Hewan Peliharaan</h1>
        </div>
        <div class="hero-2-card" id="hewan-container">
            <?php
            if ($hewanData['status']) {
                if (count($hewanData['data']) > 0) {
                    foreach ($hewanData['data'] as $hewan) {
                        echo '<div class="card">
                                <div class="img">
                                    <img src="' . $hewan->path_poto . '" alt="">
                                </div>
                                <div class="card-content">
                                    <div class="card-text">
                                        <h3>' . $hewan->nama_hewan . '</h3>
                                        <h1>Rp' . number_format($hewan->harga, 0, ',', '.') . '</h1>
                                    </div>
                                    <div class="card-button">
                                        <a href="detail-hewan?id=' . $hewan->id . '" class="btn-primary"><iconify-icon icon="tdesign:cart-filled"></iconify-icon></a>
                                    </div>
                                </div>
                            </div>';
                    }
                } 
            }
            ?>
        </div>
        <?php
        if ($hewanData['status'] && count($hewanData['data']) > 0) {
            echo '<div class="muat">
            <button class="btn-primary btn-muat" id="load-more">Muat Lainnya</button>
        </div>';
        } else {
            echo '<div class="muat">
            <button class="btn-primary btn-muat" id="load-more" disabled>Hewan tidak ada</button>
        </div>';
        }
        ?>
    </div>
</div>  
<?php
include 'template-user/footer.php';
?>
<script src="assets/js/kategori-dropdown.js"></script>
<script src="assets/js/profile-dropdown.js"></script>
<script src="assets/js/modal-confirm.js"></script>
<script src="assets/js/slider.js"></script>
<script>
    let limitBawah = 0;
    let limitAtas = 5;
    const loadMoreBtn = document.getElementById('load-more');
    const hewanContainer = document.getElementById('hewan-container');

    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1, // Mulai animasi saat 10% dari elemen terlihat
    };

    const observerCallback = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                observer.unobserve(entry.target); // Berhenti mengamati setelah animasi berjalan
            }
        });
    };

    const observer = new IntersectionObserver(observerCallback, observerOptions);

    const observeCards = () => {
        const cards = document.querySelectorAll('.card:not(.show)');
        cards.forEach(card => observer.observe(card));
    };

    loadMoreBtn.addEventListener('click', function() {
        loadMoreBtn.textContent = 'Memuat...';
        limitBawah += 5;
        fetch(`/load_more_hewan.php?limit_bawah=${limitBawah}&limit_atas=${limitAtas}&search=${'<?php echo $search; ?>'}&kategori=${'<?php echo $kategori; ?>'}`)
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    if (data.data.length > 0) {
                        data.data.forEach(hewan => {
                            const card = document.createElement('div');
                            card.classList.add('card');
                            card.innerHTML = `
                                <div class="img">
                                    <img src="${hewan.path_poto}" alt="">
                                </div>
                                <div class="card-content">
                                    <div class="card-text">
                                        <h3>${hewan.nama_hewan}</h3>
                                        <h1>Rp${new Intl.NumberFormat('id-ID').format(hewan.harga)}</h1>
                                    </div>
                                    <div class="card-button">
                                        <a href="detail-hewan?id=${hewan.id}" class="btn-primary"><iconify-icon icon="tdesign:cart-filled"></iconify-icon></a>
                                    </div>
                                </div>
                            `;
                            hewanContainer.appendChild(card);
                        });
                        observeCards();
                        loadMoreBtn.textContent = 'Muat Lainnya';
                    } else {
                        loadMoreBtn.textContent = 'Hewan tidak ada';
                        loadMoreBtn.disabled = true;
                    }
                } else {
                    loadMoreBtn.textContent = 'Hewan tidak ada';
                    loadMoreBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadMoreBtn.textContent = 'Muat Lainnya';
            });
    });

    document.addEventListener('DOMContentLoaded', () => {
        observeCards();
    });

</script>
</body>
</html>