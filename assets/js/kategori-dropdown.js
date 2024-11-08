const dropdownKategori = document.querySelector('#kategori');

dropdownKategori.addEventListener('click', function() {
    const dropdown = document.querySelector('#dropdown-kategori');
    const nav = document.querySelector('nav');
    dropdownKategori.classList.toggle('active');
    dropdown.classList.toggle('active');
    nav.classList.toggle('active');
});

