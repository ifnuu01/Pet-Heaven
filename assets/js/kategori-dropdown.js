const dropdownKategori = document.querySelector('#kategori');
const dropdown = document.querySelector('#dropdown-kategori');
const nav = document.querySelector('nav');

dropdownKategori.addEventListener('click', function() {
    dropdownKategori.classList.toggle('active');
    dropdown.classList.toggle('active');
    nav.classList.toggle('active');
});

document.addEventListener('click', function(event) {
    if (!dropdown.contains(event.target) && !dropdownKategori.contains(event.target)) {
        dropdown.classList.remove('active');
        dropdownKategori.classList.remove('active');
        nav.classList.remove('active');
    }
});
