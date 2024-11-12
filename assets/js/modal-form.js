// Ambil elemen modal dan tombol close
const modalForm = document.getElementById("modal-add");
const closeButton = document.querySelector(".close-button");

// Fungsi untuk membuka modal
function openModal() {
  modalForm.showModal(); // Menampilkan modal
}

// Fungsi untuk menutup modal
function closeModal() {
  modalForm.close(); // Menutup modal
}

// Event listener untuk tombol close
closeButton.addEventListener("click", closeModal);

// Event listener untuk menutup modal jika klik di luar area konten
modalForm.addEventListener("click", function (event) {
  if (event.target === modal) {
    closeModal();
  }
});
