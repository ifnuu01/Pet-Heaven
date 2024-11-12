
const modalForm = document.getElementById("modal-add");
const closeButton = document.querySelector(".close-button");


function openModal() {
  modalForm.showModal(); 
}



closeButton.addEventListener("click", function () {
  modalForm.close(); 
}); 



modalForm.addEventListener("click", function (event) {
  if (event.target === modal) {
    modalForm.close(); 
  }
});


modalForm.addEventListener("click", (event) => {
  const modalDimensions = modalForm.getBoundingClientRect();
  if (
    event.clientX < modalDimensions.left ||
    event.clientX > modalDimensions.right ||
    event.clientY < modalDimensions.top ||
    event.clientY > modalDimensions.bottom
  ) {
    modalForm.close();
  }
});