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
    <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_per_jam'] ?>">
      <?= esc($l['nama_lapangan']) ?> - Rp <?= number_format($l['harga_per_jam'], 0, ',', '.') ?>/jam
    </option>
  <?php endforeach; ?>
</select>
  <br><br>

  <?php 
  // Format: yyyy-mm-ddTHH:MM (HTML5 format untuk datetime-local)
  $minDateTime = date('Y-m-d\TH:i'); 
  ?>

<label for="tanggal">Tanggal Booking:</label><br>
<input type="date" name="tanggal" id="tanggal" required min="<?= date('Y-m-d') ?>">
<br><br>

<label for="jam">Jam Mulai:</label><br>
<input type="time" name="jam" id="jam" required>
<br><br>
  
<label for="durasi">Durasi (jam):</label><br>
<input type="number" name="durasi" id="durasi" min="1" max="24" required>
<br><br>

<label for="total_bayar">Total Bayar (Rp):</label><br>
<input type="number" name="total_bayar" id="total_bayar" readonly>
  <br><br>

  <button type="submit">Tambah Booking</button>
  <a href="<?= base_url('/dashboard/booking') ?>">Batal</a>
</form>

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
