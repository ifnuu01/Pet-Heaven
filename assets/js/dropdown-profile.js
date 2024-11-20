const profileDropdown = document.querySelector('.profile-dropdown');
const buttonProfile = document.querySelector('.profile');

buttonProfile.addEventListener('click', () => {
    profileDropdown.classList.toggle('active');
});

document.addEventListener('click', (event) => {
    if (!profileDropdown.contains(event.target) && !buttonProfile.contains(event.target)) {
        profileDropdown.classList.remove('active');
    }
});