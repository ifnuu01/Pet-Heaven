function openEditModal(hewan) {
    document.getElementById('edit-id').value = hewan.id;
    document.getElementById('edit-nama-hewan').value = hewan.nama_hewan;
    document.getElementById('edit-berat').value = hewan.berat;
    document.getElementById('edit-tahapan-usia').value = hewan.tahapan_usia;
    document.getElementById('edit-warna').value = hewan.warna;
    document.getElementById('edit-harga').value = hewan.harga;

    const jantanRadio = document.getElementById('edit-jantan');
    const betinaRadio = document.getElementById('edit-betina');
    if (hewan.jenis_kelamin == 'Jantan') {
        jantanRadio.checked = true;
    } else {
        betinaRadio.checked = true;
    }

    
    const jenisSelect = document.getElementById('edit-jenis');
    for (let i = 0; i < jenisSelect.options.length; i++) {
        if (jenisSelect.options[i].value == hewan.jenis_hewan) {
            jenisSelect.options[i].selected = true;
            break;
        }
    }

    document.getElementById('modal-edit').showModal();
}

document.querySelectorAll('.close-button-edit').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('modal-edit').close();
    });
});