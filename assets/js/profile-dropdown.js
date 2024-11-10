const buttonProfile = document.querySelector('.profile');
const dropdownProfile = document.querySelector('.profile-dropdown');


buttonProfile.addEventListener('click', function() {
    dropdownProfile.classList.toggle('active');
    buttonProfile.classList.toggle('active');
});

document.addEventListener('click', function(event) {
    if (!dropdownProfile.contains(event.target) && !buttonProfile.contains(event.target)) {
        dropdownProfile.classList.remove('active');
        buttonProfile.classList.remove('active');
    }
});