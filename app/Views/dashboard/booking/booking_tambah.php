<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Tambah Booking Baru</h2>

<div class="w-full max-w-lg bg-white rounded-xl shadow p-8">
  <form action="<?= base_url('/booking/simpan') ?>" method="post" class="space-y-5">
    <?= csrf_field() ?>

    <div>
      <label for="pelanggan_id" class="block font-semibold mb-1">Pilih Pelanggan</label>
      <select name="pelanggan_id" id="pelanggan_id" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">-- Pilih Pelanggan --</option>
        <?php foreach($pelanggan as $p): ?>
          <option value="<?= $p['id'] ?>"><?= esc($p['nama_pelanggan']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="lapangan_id" class="block font-semibold mb-1">Pilih Lapangan</label>
      <select name="lapangan_id" id="lapangan_id" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">-- Pilih Lapangan --</option>
        <?php foreach($lapangan as $l): ?>
          <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_jam'] ?>">
            <?= esc($l['nama_lapangan']) ?> - Rp <?= number_format($l['harga_per_jam'], 0, ',', '.') ?>/jam
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div>
      <label for="tanggal_booking" class="block font-semibold mb-1">Tanggal Booking</label>
      <input type="date" name="tanggal_booking" id="tanggal_booking" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="jam_mulai" class="block font-semibold mb-1">Jam Mulai</label>
      <input type="time" name="jam_mulai" id="jam_mulai" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="durasi" class="block font-semibold mb-1">Durasi (jam)</label>
      <input type="number" name="durasi" id="durasi" min="1" max="24" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>

    <div>
      <label for="total_bayar" class="block font-semibold mb-1">Total Bayar (Rp)</label>
      <input type="number" name="total_bayar" id="total_bayar" readonly
        class="w-full px-4 py-2 border border-gray-300 rounded bg-gray-100 focus:outline-none" />
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-10 py-4 rounded-lg transition text-base w-full sm:w-auto">
        Tambah Booking
      </button>
      <a href="<?= base_url('booking') ?>"
        class="sm:ml-4 text-blue-600 hover:underline font-semibold text-center py-4 sm:py-0">Batal</a>
    </div>
  </form>
</div>

<script>
  const lapanganSelect = document.getElementById('lapangan_id');
  const durasiInput = document.getElementById('durasi');
  const totalBayarInput = document.getElementById('total_bayar');

  function updateTotalBayar() {
    const selectedOption = lapanganSelect.options[lapanganSelect.selectedIndex];
    const hargaPerJam = selectedOption.getAttribute('data-harga');
    const durasi = durasiInput.value;

    if (hargaPerJam && durasi) {
      const total = hargaPerJam * durasi;
      totalBayarInput.value = total;
    } else {
      totalBayarInput.value = '';
    }
  }

  lapanganSelect.addEventListener('change', updateTotalBayar);
  durasiInput.addEventListener('input', updateTotalBayar);
</script>

<?= $this->endSection() ?>
