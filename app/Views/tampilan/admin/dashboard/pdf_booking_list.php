<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Laporan Data Booking</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Durasi</th>
                <th>Status</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($bookings as $b): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($b['pelanggan_nama']) ?></td>
                <td><?= esc($b['lapangan_nama']) ?></td>
                <td><?= date('Y-m-d', strtotime($b['tanggal_booking'])) ?> <?= substr($b['jam_mulai'], 0, 5) ?></td>
                <td><?= $b['durasi'] ?> jam</td>
                <td><?= ucfirst($b['status']) ?></td>
                <td>Rp <?= number_format($b['total_bayar'], 0, ',', '.') ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
