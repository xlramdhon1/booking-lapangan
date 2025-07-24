<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Ubah Status Booking</h2>

<div class="w-full max-w-lg bg-white rounded-xl shadow p-8">
  <table class="w-full mb-6 text-sm">
    <tr>
      <td class="font-semibold py-2 w-1/3">Pelanggan</td>
      <td class="py-2"><?= esc($booking['pelanggan_nama']) ?></td>
    </tr>
    <tr>
      <td class="font-semibold py-2">Lapangan</td>
      <td class="py-2"><?= esc($booking['lapangan_nama']) ?></td>
    </tr>
    <tr>
      <td class="font-semibold py-2">Tanggal Booking</td>
      <td class="py-2"><?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?> pukul <?= esc(substr($booking['jam_mulai'], 0, 5)) ?></td>
    </tr>
  </table>

  <form action="<?= base_url('/booking/status/update/' . $booking['id']) ?>" method="post" class="space-y-5">
    <div>
      <label for="status" class="block font-semibold mb-1">Status</label>
      <select name="status" id="status" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
      </select>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-10 py-4 rounded-lg transition text-base w-full sm:w-auto">
        Simpan
      </button>
      <a href="<?= base_url('/booking/status') ?>"
        class="sm:ml-4 text-blue-600 hover:underline font-semibold text-center py-4 sm:py-0">Batal</a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
