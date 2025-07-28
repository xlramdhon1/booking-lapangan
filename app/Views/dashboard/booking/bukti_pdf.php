<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 14px;
            color: #333;
            padding: 40px;
            background-color: #fff;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: #1d4ed8;
        }

        .info-box {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .info-box h3 {
            margin-top: 0;
            color: #111827;
            font-size: 16px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .label {
            font-weight: 600;
            width: 35%;
        }

        .footer {
            margin-top: 50px;
            font-style: italic;
            color: #555;
            text-align: center;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
            font-size: 14px;
        }

        .signature span {
            display: inline-block;
            margin-top: 50px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="title">Bukti Pembayaran Booking</div>

    <div class="info-box">
        <h3>Detail Booking</h3>
        <table>
            <tr>
                <td class="label">Nama Pelanggan</td>
                <td>: <?= esc($booking['pelanggan_nama']) ?></td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>: <?= esc($booking['pelanggan_email'])?></td>
            </tr>
            <tr>
                <td class="label">Lapangan</td>
                <td>: <?= esc($booking['lapangan_nama']) ?></td>
            </tr>
            <tr>
                <td class="label">Tanggal Booking</td>
                <td>: <?= date('d M Y', strtotime($booking['tanggal_booking'])) ?></td>
            </tr>
            <tr>
                <td class="label">Jam Mulai</td>
                <td>: <?= esc($booking['jam_mulai']) ?></td>
            </tr>
            <tr>
                <td class="label">Durasi</td>
                <td>: <?= esc($booking['durasi']) ?> jam</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>: <?= ucfirst($booking['status']) ?></td>
            </tr>
            <tr>
                <td class="label">Total Bayar</td>
                <td>: Rp <?= number_format($booking['total_bayar'], 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Terima kasih telah melakukan booking. <br>
        Bukti ini sah walau tanpa tanda tangan dan cap resmi.
    </div>

    <div class="signature">
        <p>Admin</p>
        <span><?= date('d M Y') ?></span>
    </div>

</body>
</html>
