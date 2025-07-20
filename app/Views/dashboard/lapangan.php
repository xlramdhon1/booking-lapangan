<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Data Lapangan</h2>

<?php if (session()->getFlashdata('success')): ?>
  <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<!-- Form Tambah -->
<form method="post" action="<?= base_url('/dashboard/lapangan/tambah') ?>">
  <input type="text" name="nama_lapangan" placeholder="Nama Lapangan" required>
  <input type="text" name="jenis_olahraga" placeholder="Jenis Olahraga" required>
  <input type="number" name="harga_per_jam" placeholder="Harga per Jam" required>
  <button type="submit">Tambah</button>
</form>

<br>

<!-- Tabel Data -->
<table border="1" cellpadding="10" cellspacing="0">
  <tr>
    <th>No</th>
    <th>Nama Lapangan</th>
    <th>Jenis</th>
    <th>Harga / Jam</th>
    <th>Aksi</th>
  </tr>

  <?php $no = 1; foreach ($lapangan as $row): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= esc($row['nama_lapangan']) ?></td>
      <td><?= esc($row['jenis_olahraga']) ?></td>
      <td>Rp<?= number_format($row['harga_per_jam'], 0, ',', '.') ?></td>
      <td>
        <!-- Nanti bisa tambah edit -->
        <a href="<?= base_url('/dashboard/lapangan/hapus/' . $row['id']) ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>

<?= $this->endSection() ?>
