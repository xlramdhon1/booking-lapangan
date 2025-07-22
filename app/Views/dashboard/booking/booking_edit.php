<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Edit Booking</h2>

<form action="<?= base_url('/booking/update/' . $booking['id']) ?>" method="post">
    <label for="pelanggan_id">Pelanggan</label>
    <select name="pelanggan_id" id="pelanggan_id" required>
        <?php foreach($pelanggan as $p): ?>
            <option value="<?= $p['id'] ?>" <?= $booking['pelanggan_id'] == $p['id'] ? 'selected' : '' ?>>
                <?= esc($p['nama_pelanggan']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="lapangan_id">Lapangan</label>
    <select id="lapangan_id" name="lapangan_id" onchange="updateTotalBayar()">
  <?php foreach ($lapangan as $l): ?>
    <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_jam'] ?>" <?= $booking['lapangan_id'] == $l['id'] ? 'selected' : '' ?>>
      <?= esc($l['nama_lapangan']) ?>
    </option>
  <?php endforeach; ?>
    </select>

    <label for="tanggal_booking">Tanggal Booking</label>
    <input type="date" name="tanggal_booking" id="tanggal_booking" value="<?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?>" required>

    <label for="jam_mulai">Jam Mulai</label>
    <input type="time" id="jam_mulai" name="jam_mulai" value="<?= date('H:i', strtotime($booking['jam_mulai'])) ?>" required>

    <label for="durasi">Durasi (jam)</label>
    <input type="number" id="durasi" name="durasi" value="<?= $booking['durasi'] ?>" onchange="updateTotalBayar()">

    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>

    <label for="total_bayar">Total Bayar</label>
    <input type="text" id="total_bayar" name="total_bayar" value="<?= $booking['total_bayar'] ?>" readonly>
    <br>
    <br>
    <button type="submit">Update Booking</button>
</form>


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
