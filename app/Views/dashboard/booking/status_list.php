<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Kelola Status Booking</h2>
<!-- Tabel booking, kolom status, tombol "Ubah Status" di tiap baris -->

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

<table border="1" cellpadding="10" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Pelanggan</th>
      <th>Nama Lapangan</th>
      <th>Tanggal & Jam</th>
      <th>Durasi (Jam)</th>
      <th>Status</th>
      <th>Total Bayar</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; foreach($bookings as $booking): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= esc($booking['pelanggan_nama']) ?></td>
        <td><?= esc($booking['lapangan_nama']) ?></td>
        <td>
          <?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?> pukul <?= esc(substr($booking['jam_mulai'], 0, 5)) ?>
        </td>
        <td><?= esc($booking['durasi']) ?></td>
        <td>
            <?php
            $status = $booking['status'];
            $class = 'badge-';
            switch ($status) {
            case 'pending': $class .= 'pending'; break;
            case 'confirmed': $class .= 'confirmed'; break;
            case 'cancelled': $class .= 'cancelled'; break;
            case 'completed': $class .= 'completed'; break;
            default: $class = '';
            }
            ?>
            <span class="badge <?= $class ?>"><?= ucfirst($status) ?></span>
        </td>
        <td>Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
        <td>
          <a href="<?= base_url('/dashboard/booking/status/' . $booking['id']) ?>">Ubah Status</a> |
          <a href="<?= base_url('/dashboard/booking/edit/' . $booking['id']) ?>">Edit</a> |
          <a href="#" onclick="confirmDelete(<?= $booking['id'] ?>)">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

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

<?= $this->endSection() ?>
