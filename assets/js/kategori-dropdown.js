const kategoriDropdown = document.getElementById('container-kategori');
const buttonKategori = document.getElementById('button-kategori');

buttonKategori.addEventListener('click', () => {
    kategoriDropdown.classList.toggle('active');
    buttonKategori.classList.toggle('active');
});

document.addEventListener('click', (event) => {
    if (!kategoriDropdown.contains(event.target) && !buttonKategori.contains(event.target)) {
        kategoriDropdown.classList.remove('active');
        buttonKategori.classList.remove('active');
    }
});