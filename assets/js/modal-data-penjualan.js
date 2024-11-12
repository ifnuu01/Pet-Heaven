
function openDetailPembayaran(data) {
    const modal = document.getElementById('modal-pembayaran');
    const animalImg = document.getElementById('animal-img');
    const animalName = document.getElementById('animal-name');
    const price = document.getElementById('price');
    const date = document.getElementById('date');
    const animalType = document.getElementById('animal-type');
    const ageStage = document.getElementById('age-stage');
    const color = document.getElementById('color');
    const gender = document.getElementById('gender');
    const weight = document.getElementById('weight');
    const adminTax = document.getElementById('admin-tax');
    const shippingFee = document.getElementById('shipping-fee');
    const totalPayment = document.getElementById('total-payment');
    const paymentMethod = document.getElementById('payment-method');
    const purchaseNumber = document.getElementById('purchase-number');
    const pembayaranImg = document.getElementById('pembayaran');

    animalImg.src = data.path_poto;
    pembayaranImg.src = data.bukti_pembayaran;
    animalName.textContent = data.nama_hewan;
    price.textContent = `Rp${data.harga}`;
    date.textContent = data.waktu_pembayaran;
    animalType.textContent = data.jenis;
    ageStage.textContent = data.tahapan_usia;
    color.textContent = data.warna;
    gender.textContent = data.jenis_kelamin;
    weight.textContent = data.berat;
    adminTax.textContent = `Rp${data.pajak}`;
    shippingFee.textContent = `Rp${data.biaya_pengiriman}`;
    totalPayment.textContent = `Rp${data.total_pembelian}`;
    paymentMethod.textContent = data.metode_pembayaran;
    purchaseNumber.textContent = data.no_pembelian;

    modal.showModal();
    }

document.getElementById('back-button-pembayaran').addEventListener('click', () => {
document.getElementById('modal-pembayaran').close();
});


modal.addEventListener("click", (event) => {
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