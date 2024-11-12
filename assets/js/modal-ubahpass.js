const modal_ubahpass = document.getElementById('modal-ubah-pass');
const btn_ubahpass = document.getElementById('btn-ubahpass');
const btn_close_ubahpass = document.getElementById('btn-ubah-pass');

btn_ubahpass.addEventListener('click', () => {
    modal_ubahpass.showModal();
});


btn_close_ubahpass.addEventListener('click', () => {
    modal_ubahpass.close();
});

modal_ubahpass.addEventListener("click", (event) => {
  const modalDimensions = modal_ubahpass.getBoundingClientRect();
  if (
    event.clientX < modalDimensions.left ||
    event.clientX > modalDimensions.right ||
    event.clientY < modalDimensions.top ||
    event.clientY > modalDimensions.bottom
  ) {
    modal_ubahpass.close();
  }
});