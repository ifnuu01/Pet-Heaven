const modal = document.getElementById('confirmModal');
const modalMessage = document.getElementById('modalMessage');
const cancelBtn = document.getElementById('cancelBtn');
const confirmBtn = document.getElementById('confirmBtn');
let targetForm = null; // Form yang akan disubmit sesuai aksi

// Event listener untuk tombol pemicu modal
document.querySelectorAll('.actionBtn').forEach(button => {
    button.addEventListener('click', (event) => {
        // Menggunakan event.currentTarget untuk memastikan elemen tombol yang tepat diambil
        const targetButton = event.currentTarget;
        const action = targetButton.dataset.action;
        const message = targetButton.dataset.message;
        const formId = targetButton.dataset.form;
        const cancelText = targetButton.dataset.cancelText || "Tidak";
        const confirmText = targetButton.dataset.confirmText || "Ya";

        // Mengatur pesan modal dan target form
        modalMessage.textContent = message || "Apakah Anda yakin?";
        cancelBtn.textContent = cancelText;
        confirmBtn.textContent = confirmText;
        targetForm = document.getElementById(formId);

        modal.showModal(); // Menampilkan modal
    });
});

// Menutup modal ketika tombol "Tidak" diklik
cancelBtn.addEventListener('click', () => {
    modal.close();
});

// Mengirim form ketika tombol "Ya" diklik
confirmBtn.addEventListener('click', () => {
    if (targetForm) {
        targetForm.submit(); // Submit form yang ditargetkan
    }
    modal.close(); // Menutup modal
});

modal.addEventListener('click', (event) => {
    const modalDimensions = modal.getBoundingClientRect();
    if (
        event.clientX < modalDimensions.left ||
        event.clientX > modalDimensions.right ||
        event.clientY < modalDimensions.top ||
        event.clientY > modalDimensions.bottom
    ) {
        modal.close();
    }
});