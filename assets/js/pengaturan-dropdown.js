const pengaturan = document.querySelector('.pengaturan');
const dropdownPengaturan = document.querySelector('.dropdown-pengaturan');


pengaturan.addEventListener('click', function() {
    dropdownPengaturan.classList.toggle('active');
    pengaturan.classList.toggle('active');
});


document.addEventListener('click', function(event) {
    if (!dropdownPengaturan.contains(event.target) && !pengaturan.contains(event.target)) {
        dropdownPengaturan.classList.remove('active');
        pengaturan.classList.remove('active');
    }
});