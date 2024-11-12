const modalAlert = document.getElementById('alert-modal');
const closealert = document.querySelector('.btn-alert');
let urlAlert = null;

closealert.addEventListener('click', () => {
    modalAlert.close();
    window.location.href = urlAlert;
});


function alertModal(url, pesan, buttonText){
    console.log(url);
    urlAlert = url;
    const modalText = document.querySelector('.alert-modal-body p');
    const modalButton = document.querySelector('.btn-alert');
    modalText.innerHTML = pesan;
    modalButton.innerHTML = buttonText;
    modalAlert.showModal();
}

modalAlert.addEventListener('click', (event) => {
    const modalDimensions = modalAlert.getBoundingClientRect();
    if (
        event.clientX < modalDimensions.left ||
        event.clientX > modalDimensions.right ||
        event.clientY < modalDimensions.top ||
        event.clientY > modalDimensions.bottom
    ) {
        modalAlert.close();
        window.location.href = urlAlert;
    }
});
