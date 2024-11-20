document.addEventListener('DOMContentLoaded', () => {
    const dialogs = [
        { buttonId: 'btn-form-jenis_kelamin', dialogId: 'form-jenis_kelamin', formId: 'form-jenis-kelamin-form' },
        { buttonId: 'btn-form-nama', dialogId: 'form-nama', formId: 'form-nama-form' },
        { buttonId: 'btn-form-nomor-hp', dialogId: 'form-nomor-hp', formId: 'form-nomor-hp-form' },
        { buttonId: 'btn-ubahpass', dialogId: 'form-pass', formId: 'form-pass' },
        { buttonId: 'btn-form-tgl_lahir', dialogId: 'form-tgl_lahir', formId: 'form-tgl_lahir-form' },
        { buttonId: 'btn-form-email', dialogId: 'form-email', formId: 'form-email-form' }
    ];

    dialogs.forEach(({ buttonId, dialogId, formId }) => {
        const button = document.getElementById(buttonId);
        const dialog = document.getElementById(dialogId);
        const form = document.getElementById(formId);
        const closeButton = dialog.querySelector('.close-buttons');

        // Buka dialog saat tombol diklik
        button.addEventListener('click', () => {
            dialog.showModal();
        });

        // Tutup dialog saat tombol "X" diklik
        closeButton.addEventListener('click', () => {
            dialog.close();
        });

        // Tutup dialog saat area di luar dialog diklik
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) {
                dialog.close();
            }
        });

        // Cegah penutupan dialog jika form belum terisi
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                form.reportValidity();
            } else {
                dialog.close();
            }
        });
    });
});

document.getElementById('photo').addEventListener('change', function() {
    let fileInput = document.getElementById('photo');
    let label = document.getElementById('pilih_poto');
    if (fileInput.files.length > 0) {
        label.textContent = 'Foto Terupload';
    }
});