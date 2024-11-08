const pengaturan = document.querySelector('.pengaturan');


pengaturan.addEventListener('click', function() {
    const dropdown = document.querySelector('.dropdown-pengaturan');
    dropdown.classList.toggle('active');
    pengaturan.classList.toggle('active');
});