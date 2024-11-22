let poto_bukti = document.getElementById('bukti_pembayaran');
    let upload_bukti = document.getElementById('upload-bukti');

    poto_bukti.addEventListener('change', function() {
        if (poto_bukti.files.length > 0) {
            upload_bukti.textContent = 'Bukti Pembayaran Terupload';
        }
    });