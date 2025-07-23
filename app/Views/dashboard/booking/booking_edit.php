<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Edit Booking</h2>

<div class="w-full max-w-lg bg-white rounded-xl shadow p-8">
  <form action="<?= base_url('/booking/update/' . $booking['id']) ?>" method="post" class="space-y-5 w-full">
    <div>
      <label for="pelanggan_id" class="block font-semibold mb-1">Pelanggan</label>
      <select name="pelanggan_id" id="pelanggan_id" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <?php foreach($pelanggan as $p): ?>
          <option value="<?= $p['id'] ?>" <?= $booking['pelanggan_id'] == $p['id'] ? 'selected' : '' ?>>
            <?= esc($p['nama_pelanggan']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="lapangan_id" class="block font-semibold mb-1">Lapangan</label>
      <select id="lapangan_id" name="lapangan_id" onchange="updateTotalBayar()"
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <?php foreach ($lapangan as $l): ?>
          <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_jam'] ?>" <?= $booking['lapangan_id'] == $l['id'] ? 'selected' : '' ?>>
            <?= esc($l['nama_lapangan']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="tanggal_booking" class="block font-semibold mb-1">Tanggal Booking</label>
      <input type="date" name="tanggal_booking" id="tanggal_booking" value="<?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?>" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="jam_mulai" class="block font-semibold mb-1">Jam Mulai</label>
      <input type="time" id="jam_mulai" name="jam_mulai" value="<?= date('H:i', strtotime($booking['jam_mulai'])) ?>" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="durasi" class="block font-semibold mb-1">Durasi (jam)</label>
      <input type="number" id="durasi" name="durasi" value="<?= $booking['durasi'] ?>" min="1" max="24" onchange="updateTotalBayar()"
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="status" class="block font-semibold mb-1">Status</label>
      <select name="status" id="status" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
      </select>
    </div>

    <div>
      <label for="total_bayar" class="block font-semibold mb-1">Total Bayar</label>
      <input type="text" id="total_bayar" name="total_bayar" value="<?= $booking['total_bayar'] ?>" readonly
        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 focus:outline-none" />
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-10 py-4 rounded-lg transition text-base w-full sm:w-auto">
        Update Booking
      </button>
      <a href="<?= base_url('/booking') ?>"
        class="sm:ml-4 text-blue-600 hover:underline font-semibold text-center py-4 sm:py-0">Batal</a>
    </div>
  </form>
</div>

<script>
  function updateTotalBayar() {
    const lapanganSelect = document.getElementById('lapangan_id');
    const durasiInput = document.getElementById('durasi');
    const totalBayarInput = document.getElementById('total_bayar');

    const harga = parseInt(lapanganSelect.selectedOptions[0].getAttribute('data-harga')) || 0;
    const durasi = parseInt(durasiInput.value) || 0;

    totalBayarInput.value = harga * durasi;
  }

  // panggil sekali agar total bayar update saat load page
  updateTotalBayar();
</script>

<?= $this->endSection() ?>
