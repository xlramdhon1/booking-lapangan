<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Edit Data Pelanggan</h2>

<form method="post" action="<?= base_url('/dashboard/pelanggan/update/' . $pelanggan['id']) ?>">
  <label>Nama</label><br>
  <input type="text" name="nama" value="<?= esc($pelanggan['nama']) ?>" required><br><br>

  <label>No HP</label><br>
  <input type="text" name="no_hp" value="<?= esc($pelanggan['no_hp']) ?>" required><br><br>

  <label>Email</label><br>
  <input type="email" name="email" value="<?= esc($pelanggan['email']) ?>"><br><br>

  <label>Alamat</label><br>
  <textarea name="alamat"><?= esc($pelanggan['alamat']) ?></textarea><br><br>

  <button type="submit">Update</button>
  <a href="<?= base_url('/dashboard/pelanggan') ?>">← Kembali</a>
</form>

<?= $this->endSection() ?>
