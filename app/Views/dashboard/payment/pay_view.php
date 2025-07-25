<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-xl font-bold mb-4 text-blue-700">Pembayaran Booking</h2>

<div class="bg-white rounded-lg shadow p-6 max-w-xl mx-auto">
  <p><strong>Nama:</strong> <?= esc($booking['nama_pelanggan']) ?></p>
  <p><strong>Lapangan:</strong> <?= esc($booking['nama_lapangan']) ?></p>
  <p><strong>Tanggal:</strong> <?= esc($booking['tanggal_booking']) ?></p>
  <p><strong>Jam:</strong> <?= esc($booking['jam_mulai']) ?> s/d <?= esc($booking['jam_selesai']) ?></p>
  <p><strong>Total Bayar:</strong> 
    <span class="text-green-700 font-bold">Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></span>
  </p>

  <button id="pay-button" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded font-semibold">
    Bayar Sekarang
  </button>

  <!-- Tombol Snap test manual (opsional) -->
  <button onclick="snap.pay('4d3ff4a3-db8f-4b31-a89f-0b5d0429cb37')" 
          class="mt-2 ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
    Coba Snap Manual
  </button>
</div>

<!-- Load Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-0ef5cP54fhUsJaMr"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    console.log("Booking ID: <?= $booking['id'] ?>");

    fetch('<?= base_url("/payment/tokenize") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ booking_id: <?= $booking['id'] ?> })
    })
    .then(res => res.json())
    .then(data => {
        console.log("Snap Token Response:", data);

        if (!data.token) {
            alert("Gagal mendapatkan token pembayaran.");
            return;
        }

        snap.pay(data.token, {
    onSuccess: function(result) {
        console.log("Pembayaran berhasil!", result);
        updateBookingStatus(<?= $booking['id'] ?>);
    },
    onPending: function(result) {
        console.log("Pembayaran tertunda!", result);
        updateBookingStatus(<?= $booking['id'] ?>); // masih tetap confirmed untuk kamu
    },
    onError: function(result) {
        alert("Pembayaran gagal!");
    },
    onClose: function() {
        alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
    }
});

    })
    .catch(error => {
        console.error("Fetch Error:", error);
        alert("Terjadi kesalahan saat menghubungi server.");
    });
});
</script>
<script>
function updateBookingStatus(bookingId) {
    fetch('<?= base_url("/booking/update-status") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ booking_id: bookingId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            alert("Status booking berhasil diperbarui!");
        } else {
            alert("Gagal memperbarui status booking.");
        }

        // Redirect ke halaman booking list
        location.href = "<?= base_url('/booking') ?>";
    });
}
</script>


<?= $this->endSection() ?>
