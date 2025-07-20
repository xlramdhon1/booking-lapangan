<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Ubah Status Booking</h2>

<p><strong>Pelanggan:</strong> <?= esc($booking['pelanggan_nama']) ?></p>
<p><strong>Lapangan:</strong> <?= esc($booking['nama_lapangan']) ?></p>
<p><strong>Tanggal Booking:</strong> <?= date('Y-m-d', strtotime($booking['tanggal_booking'])) ?> pukul <?= esc(substr($booking['jam_mulai'], 0, 5)) ?></p>

<form action="<?= base_url('/dashboard/booking/status/update/' . $booking['id']) ?>" method="post">
    <label for="status">Status:</label>
    <select name="status" id="status" required>
        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="completed" <?= $booking['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
        <option value="canceled" <?= $booking['status'] == 'canceled' ? 'selected' : '' ?>>Canceled</option>
    </select>

    <br><br>
    <button type="submit">Simpan</button>
</form>

<?= $this->endSection() ?>
