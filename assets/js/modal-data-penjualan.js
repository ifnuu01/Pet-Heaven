
const modal_penjualan = document.getElementById('modal-pembayaran');

console.log(modal_penjualan)

modal_penjualan.addEventListener("click", (event) => {
  const modalDimensions = modal_penjualan.getBoundingClientRect();
  if (
    event.clientX < modalDimensions.left ||
    event.clientX > modalDimensions.right ||
    event.clientY < modalDimensions.top ||
    event.clientY > modalDimensions.bottom
  ) {
    console.log("hello")
    modal_penjualan.close();
  }
});

function openDetailPembayaran(data) {
    const modal_penjualan = document.getElementById('modal-pembayaran');
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
    const status_konfirmasi = document.getElementById('status-konfirmasi');

    animalImg.src = data.path_poto;
    pembayaranImg.src = data.bukti_pembayaran;
    animalName.textContent = data.nama_hewan;
    price.textContent = `Rp${data.harga}`;
    date.textContent = data.waktu_pembayaran;
    animalType.textContent = data.jenis;
    ageStage.textContent = data.tahapan_usia;
    color.textContent = data.warna;
    gender.textContent = data.jenis_kelamin;
    weight.textContent = `${data.berat} Kg`;
    adminTax.textContent = `Rp${data.pajak}`;
    shippingFee.textContent = `Rp${data.biaya_pengiriman}`;
    totalPayment.textContent = `Rp${data.total_pembelian}`;
    paymentMethod.textContent = data.metode_pembayaran;
    purchaseNumber.textContent = data.no_pembelian;
    status_konfirmasi.textContent = data.status;

    if (data.status == "Ditolak") {
        status_konfirmasi.classList.add('merah');
    }

    modal_penjualan.showModal();
    }

document.getElementById('back-button-pembayaran').addEventListener('click', () => {
document.getElementById('modal-pembayaran').close();
});
