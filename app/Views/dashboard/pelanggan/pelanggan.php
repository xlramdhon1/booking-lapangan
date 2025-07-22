<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: '<?= session()->getFlashdata('success') ?>',
    timer: 2000,
    showConfirmButton: false
  });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '<?= session()->getFlashdata('error') ?>',
    timer: 2000,
    showConfirmButton: false
  });
</script>
<?php endif; ?>


<h2>Data Pelanggan</h2>

<?php if (session()->getFlashdata('success')): ?>
  <p style="color: green;"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<a href="<?= base_url('/pelanggan/tambah') ?>">
  <button>Tambah Data Pelanggan</button>
</a>

<br>
<br>
<!-- Tabel Data Pelanggan -->
<table border="1" cellpadding="10" cellspacing="0" width="100%">
  <tr>
    <th>No</th>
    <th>Nama</th>
    <th>No HP</th>
    <th>Email</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>

  <?php $no = 1; foreach ($pelanggan as $row): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= esc($row['nama_pelanggan']) ?></td>
      <td><?= esc($row['no_hp']) ?></td>
      <td><?= esc($row['email']) ?></td>
      <td><?= esc($row['alamat']) ?></td>
      <td>
        <a href="<?= base_url('/dashboard/pelanggan/edit/' . $row['id']) ?>">Edit</a> |
        <a href="#" onclick="confirmDelete(<?= $row['id'] ?>)">Hapus</a>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        function confirmDelete(id) {
          Swal.fire({
            title: 'Yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '<?= base_url('/dashboard/pelanggan/hapus') ?>/' + id;
            }
          });
}
</script>

      </td>
    </tr>
  <?php endforeach; ?>
</table>

<?= $this->endSection() ?>
