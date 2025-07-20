<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2>Update Status dan Pembayaran Booking</h2>

<form action="<?= base_url('/dashboard/booking/status/update/' . $booking['id']) ?>" method="post">
    <p><strong>Pelanggan:</strong> <?= esc($pelanggan['nama']) ?></p>
    <p><strong>Lapangan:</strong> <?= esc($lapangan['nama_lapangan']) ?></p>
    <p><strong>Tanggal Booking:</strong> <?= esc($booking['tanggal_booking']) ?></p>
    <p><strong>Jam Mulai:</strong> <?= esc($booking['jam_mulai']) ?></p>
    <p><strong>Durasi:</strong> <?= esc($booking['durasi']) ?> jam</p>

    <label for="status">Status</label>
    <select name="status" id="status" required>
        <option value="pending" <?= $booking['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="confirmed" <?= $booking['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
        <option value="cancelled" <?= $booking['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        <option value="paid" <?= $booking['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
    </select>

    <label for="total_bayar">Total Bayar</label>
    <input type="number" name="total_bayar" id="total_bayar" value="<?= esc($booking['total_bayar']) ?>" required>

    <button type="submit">Update</button>
</form>

<?= $this->endSection() ?>
