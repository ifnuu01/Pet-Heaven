const btntotop = document.getElementById('scrollToTopBtn');

window.onscroll = function() {

    const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

    if (scrollTop > 100) {
        btntotop.style.display = 'block';
    }
    else {
        btntotop.style.display = 'none';
    }

    const maxScroll = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrollPersent = (scrollTop / maxScroll) * 100;
    btntotop.style.background = `conic-gradient(#d87c00 ${scrollPersent}%, #ffa500 ${scrollPersent}% 100%)`;
};

btntotop.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});