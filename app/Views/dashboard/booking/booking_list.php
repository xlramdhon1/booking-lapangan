<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Daftar Booking</h2>

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

<form method="get" action="<?= base_url('/booking') ?>" class="flex flex-col md:flex-row md:items-end gap-4 mb-6 bg-white p-4 rounded-lg shadow">
  <div>
    <label for="lapangan_id" class="block font-semibold mb-1">Lapangan</label>
    <select name="lapangan_id" id="lapangan_id"
      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      <option value="">Semua Lapangan</option>
      <?php foreach ($lapanganList as $l): ?>
        <option value="<?= $l['id'] ?>" <?= $filter_lapangan_id == $l['id'] ? 'selected' : '' ?>>
          <?= esc($l['nama_lapangan']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div>
    <label for="status" class="block font-semibold mb-1">Status</label>
    <select name="status" id="status"
      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
      <option value="">Semua</option>
      <option value="pending" <?= $filter_status == 'pending' ? 'selected' : '' ?>>Pending</option>
      <option value="confirmed" <?= $filter_status == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
      <option value="completed" <?= $filter_status == 'completed' ? 'selected' : '' ?>>Completed</option>
      <option value="cancelled" <?= $filter_status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>
  </div>
  <div>
    <label for="tanggal" class="block font-semibold mb-1">Tanggal Booking</label>
    <input type="date" name="tanggal" id="tanggal" value="<?= esc($filter_tanggal) ?>"
      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
  </div>
  <div>
    <button type="submit"
      class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded transition mt-4 md:mt-0 w-full md:w-auto">
      Filter
    </button>
  </div>
</form>

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
<div class="overflow-x-auto bg-white rounded-lg shadow">
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
              case 'completed': $badgeClass = 'bg-green-100 text-green-800'; break;
              case 'cancelled': $badgeClass = 'bg-red-100 text-red-800'; break;
              default: $badgeClass = 'bg-gray-100 text-gray-800';
            }
            ?>
            <span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badgeClass ?>">
              <?= ucfirst($status) ?>
            </span>
          </td>
          <td class="px-4 py-3">Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
          <td class="px-4 py-3 space-x-2">
            <?php if ($booking['status'] === 'pending'): ?>
              <a href="<?= base_url('/payment/' . $booking['id']) ?>" class="text-green-600 hover:underline">Bayar</a> |
            <?php endif; ?>
            <a href="<?= base_url('/booking/edit/' . $booking['id']) ?>" class="text-blue-600 hover:underline">Edit</a> |
            <button type="button" onclick="confirmDelete(<?= $booking['id'] ?>)" class="text-red-600 hover:underline">Hapus</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
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
