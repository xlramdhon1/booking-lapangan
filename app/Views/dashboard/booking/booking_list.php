<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Daftar Booking</h2>

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

<a href="<?= base_url('/dashboard/booking/tambah') ?>">
  <button>Tambah Booking Baru</button>
</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Pelanggan</th>
      <th>Nama Lapangan</th>
      <th>Tanggal Booking</th>
      <th>Durasi (jam)</th>
      <th>Status</th>
      <th>Total Bayar (Rp)</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach($bookings as $booking): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= esc($booking['pelanggan_nama']) ?></td>
      <td><?= esc($booking['lapangan_nama']) ?></td>
      <td><?= date('d-m-Y H:i', strtotime($booking['tanggal_booking'])) ?></td>
      <td><?= esc($booking['durasi']) ?></td>
      <td><?= ucfirst(esc($booking['status'])) ?></td>
      <td><?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
      <td>
        <!-- Contoh aksi: edit, hapus (bisa ditambah nanti) -->
        <a href="#">Edit</a> |
        <a href="#" onclick="confirmDelete(<?= $booking['id'] ?>)">Hapus</a>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
          function confirmDelete(id) {
            Swal.fire({
              title: 'Yakin ingin menghapus booking ini?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Ya, hapus!',
              cancelButtonText: 'Batal'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '<?= base_url('/dashboard/booking/hapus') ?>/' + id;
              }
            });
          }
        </script>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?= $this->endSection() ?>
