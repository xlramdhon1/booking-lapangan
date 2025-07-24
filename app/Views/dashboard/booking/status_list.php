<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Kelola Status Booking</h2>

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

<div class="overflow-x-auto bg-white rounded-xl shadow">
  <table class="min-w-full text-sm text-left text-gray-700">
    <thead class="bg-blue-100 text-blue-800">
      <tr>
        <th class="px-4 py-3">No</th>
        <th class="px-4 py-3">Nama Pelanggan</th>
        <th class="px-4 py-3">Nama Lapangan</th>
        <th class="px-4 py-3">Tanggal & Jam</th>
        <th class="px-4 py-3">Durasi (Jam)</th>
        <th class="px-4 py-3">Status</th>
        <th class="px-4 py-3">Total Bayar</th>
        <th class="px-4 py-3">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach($bookings as $booking): ?>
      <tr class="border-t hover:bg-blue-50">
        <td class="px-4 py-3"><?= $no++ ?></td>
        <td class="px-4 py-3"><?= esc($booking['pelanggan_nama']) ?></td>
        <td class="px-4 py-3"><?= esc($booking['lapangan_nama']) ?></td>
        <td class="px-4 py-3">
          <?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?> pukul <?= esc(substr($booking['jam_mulai'], 0, 5)) ?>
        </td>
        <td class="px-4 py-3"><?= esc($booking['durasi']) ?></td>
        <td class="px-4 py-3">
          <?php
            $status = $booking['status'];
            $badgeClass = '';
            switch ($status) {
              case 'pending': $badgeClass = 'bg-yellow-100 text-yellow-800'; break;
              case 'confirmed': $badgeClass = 'bg-blue-100 text-blue-800'; break;
              case 'cancelled': $badgeClass = 'bg-red-100 text-red-800'; break;
              case 'completed': $badgeClass = 'bg-green-100 text-green-800'; break;
              default: $badgeClass = 'bg-gray-100 text-gray-800';
            }
          ?>
          <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>">
            <?= ucfirst($status) ?>
          </span>
        </td>
        <td class="px-4 py-3">Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
        <td class="px-4 py-3 space-x-2">
          <a href="<?= base_url('/booking/status/' . $booking['id']) ?>" class="text-indigo-600 hover:underline">Ubah Status</a> |
          <a href="<?= base_url('/booking/edit/' . $booking['id']) ?>" class="text-blue-600 hover:underline">Edit</a> |
          <button type="button" onclick="confirmDelete(<?= $booking['id'] ?>)" class="text-red-600 hover:underline">Hapus</button>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

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
