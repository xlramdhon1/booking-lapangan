<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Tambah Data Pelanggan</h2>

<form method="post" action="<?= base_url('/dashboard/pelanggan/tambah') ?>">
  <label>Nama</label><br>
  <input type="text" name="nama" required><br><br>

  <label>No HP</label><br>
  <input type="text" name="no_hp" required><br><br>

  <label>Email</label><br>
  <input type="email" name="email"><br><br>

  <label>Alamat</label><br>
  <textarea name="alamat"></textarea><br><br>

  <button type="submit">Simpan</button>
  <a href="<?= base_url('/dashboard/pelanggan') ?>">← Kembali</a>
</form>

<?= $this->endSection() ?>
