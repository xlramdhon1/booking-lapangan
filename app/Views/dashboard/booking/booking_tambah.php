<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Tambah Booking Baru</h2>

<form action="<?= base_url('/dashboard/booking/simpan') ?>" method="post">
  <?= csrf_field() ?>

  <label for="pelanggan_id">Pilih Pelanggan:</label><br>
  <select name="pelanggan_id" id="pelanggan_id" required>
    <option value="">-- Pilih Pelanggan --</option>
    <?php foreach($pelanggan as $p): ?>
      <option value="<?= $p['id'] ?>"><?= esc($p['nama']) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br>

  <label for="lapangan_id">Pilih Lapangan:</label><br>
  <select name="lapangan_id" id="lapangan_id" required>
    <option value="">-- Pilih Lapangan --</option>
    <?php foreach($lapangan as $l): ?>
      <option value="<?= $l['id'] ?>"><?= esc($l['nama']) ?></option>
    <?php endforeach; ?>
  </select>
  <br><br>

  <label for="tanggal_booking">Tanggal & Waktu Booking:</label><br>
  <input type="datetime-local" name="tanggal_booking" id="tanggal_booking" required>
  <br><br>

  <label for="durasi">Durasi (jam):</label><br>
  <input type="number" name="durasi" id="durasi" min="1" max="24" required>
  <br><br>

  <label for="total_bayar">Total Bayar (Rp):</label><br>
  <input type="number" name="total_bayar" id="total_bayar" min="0" required>
  <br><br>

  <button type="submit">Tambah Booking</button>
  <a href="<?= base_url('/dashboard/booking') ?>">Batal</a>
</form>

<?= $this->endSection() ?>
