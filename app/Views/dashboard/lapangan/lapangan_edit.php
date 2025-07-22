<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Edit Data Lapangan</h2>

<form method="post" action="<?= base_url('/lapangan/update/' . $lapangan['id']) ?>">
  <label>Nama Lapangan</label><br>
  <input type="text" name="nama_lapangan" value="<?= esc($lapangan['nama_lapangan']) ?>" required><br><br>

  <label>Jenis Olahraga</label><br>
  <input type="text" name="jenis_olahraga" value="<?= esc($lapangan['jenis_olahraga']) ?>" required><br><br>

  <label>Harga per Jam</label><br>
  <input type="number" name="harga_per_jam" value="<?= esc($lapangan['harga_per_jam']) ?>" required><br><br>

  <button type="submit">Update</button>
</form>

<a href="<?= base_url('/lapangan') ?>">← Kembali ke Daftar</a>

<?= $this->endSection() ?>
