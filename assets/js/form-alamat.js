const buttonAlamat = document.getElementById('btn-ubah-alamat');
const dialogAlamat = document.querySelector('.form-ubah-alamat')
const formAlamat = document.getElementById('form-ubah-alamat-form');
const closeButtonAlamat = dialogAlamat.querySelector('.close-buttons');

buttonAlamat.addEventListener('click', () => {
    dialogAlamat.showModal();
});

closeButtonAlamat.addEventListener('click', () => {
    dialogAlamat.close();
});

dialogAlamat.addEventListener('click', (event) => {
    if (event.target === dialogAlamat) {
        dialogAlamat.close();
    }
});

formAlamat.addEventListener('submit', (event) => {
    if (!formAlamat.checkValidity()) {
        event.preventDefault();
        formAlamat.reportValidity();
    } else {
        dialogAlamat.close();
    }
});

fetch('https://ibnux.github.io/data-indonesia/provinsi.json')
.then(response => response.json())
.then(data => {
    let provinsiSelect = document.getElementById('provinsi');
    data.forEach(provinsi => {
        let option = document.createElement('option');
        option.value = provinsi.nama;
        option.setAttribute('data-id', provinsi.id);
        option.textContent = provinsi.nama;
        provinsiSelect.appendChild(option);
    });
});

// Fetch data kota berdasarkan provinsi yang dipilih
document.getElementById('provinsi').addEventListener('change', function () {
let provinsiId = this.options[this.selectedIndex].getAttribute('data-id');
fetch(`https://ibnux.github.io/data-indonesia/kabupaten/${provinsiId}.json`)
    .then(response => response.json())
    .then(data => {
        let kotaSelect = document.getElementById('kota');
        kotaSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        data.forEach(kota => {
            let option = document.createElement('option');
            option.value = kota.nama;
            option.setAttribute('data-id', kota.id);
            option.textContent = kota.nama;
            kotaSelect.appendChild(option);
        });
    });
});

// Fetch data kecamatan berdasarkan kota yang dipilih
document.getElementById('kota').addEventListener('change', function () {
let kotaId = this.options[this.selectedIndex].getAttribute('data-id');
fetch(`https://ibnux.github.io/data-indonesia/kecamatan/${kotaId}.json`)
    .then(response => response.json())
    .then(data => {
        let kecamatanSelect = document.getElementById('kecamatan');
        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        data.forEach(kecamatan => {
            let option = document.createElement('option');
            option.value = kecamatan.nama;
            option.setAttribute('data-id', kecamatan.id);
            option.textContent = kecamatan.nama;
            kecamatanSelect.appendChild(option);
        });
    });
});

// Fetch data kelurahan berdasarkan kecamatan yang dipilih
document.getElementById('kecamatan').addEventListener('change', function () {
let kecamatanId = this.options[this.selectedIndex].getAttribute('data-id');
fetch(`https://ibnux.github.io/data-indonesia/kelurahan/${kecamatanId}.json`)
    .then(response => response.json())
    .then(data => {
        let kelurahanSelect = document.getElementById('kelurahan');
        kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
        data.forEach(kelurahan => {
            let option = document.createElement('option');
            option.value = kelurahan.nama;
            option.setAttribute('data-id', kelurahan.id);
            option.textContent = kelurahan.nama;
            kelurahanSelect.appendChild(option);
        });
    });
});