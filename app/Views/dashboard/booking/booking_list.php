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

<form method="get" action="<?= base_url('/booking') ?>">
  <label for="lapangan_id">Lapangan:</label>
  <select name="lapangan_id" id="lapangan_id">
    <option value="">Semua Lapangan</option>
    <?php foreach ($lapanganList as $l): ?>
      <option value="<?= $l['id'] ?>" <?= $filter_lapangan_id == $l['id'] ? 'selected' : '' ?>>
        <?= esc($l['nama_lapangan']) ?>
      </option>
    <?php endforeach; ?>
  </select>
  <label for="status">Status:</label>
  <select name="status" id="status">
    <option value="">Semua</option>
    <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
    <option value="confirmed" <?= $filter_status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
    <option value="completed" <?= $filter_status == 'completed' ? 'selected' : '' ?>>Completed</option>
    <option value="cancelled" <?= $filter_status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
  </select>

  <label for="tanggal">Tanggal Booking:</label>
  <input type="date" name="tanggal" id="tanggal" value="<?= esc($filter_tanggal) ?>">

  <button type="submit">Filter</button>
</form>

<br>

<?php if (!empty($no_result) && $no_result): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'info',
      title: 'Tidak ada data',
      text: 'Tidak ditemukan booking dengan filter tersebut.',
      timer: 2500,
      showConfirmButton: false
    });
  </script>
<?php endif; ?>

<?php if (!empty($bookings)): ?>
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
          <?php if ($booking['status'] === 'pending'): ?>
            <a href="<?= base_url('/payment/' . $booking['id']) ?>">Bayar</a> |
          <?php endif; ?>
          <a href="<?= base_url('/booking/edit/' . $booking['id']) ?>">Edit</a> |
          <a href="#" onclick="confirmDelete(<?= $booking['id'] ?>)">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
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
      window.location.href = '<?= base_url('/booking/hapus') ?>/' + id;
    }
  });
}
</script>

<?= $this->endSection() ?>
