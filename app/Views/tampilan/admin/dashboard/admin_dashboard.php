<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Jumlah Pelanggan -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Jumlah Pelanggan Terdaftar</h2>
            <p class="text-4xl text-blue-600 font-bold mt-2"><?= $jumlahPelanggan ?></p>
        </div>

        <!-- Card Jumlah Booking per Lapangan -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Jumlah Booking per Lapangan</h2>
            <ul class="space-y-2">
                <?php foreach ($bookingPerLapangan as $item): ?>
                    <li class="flex justify-between border-b pb-1">
                        <span><?= esc($item['nama_lapangan']) ?></span>
                        <span class="font-semibold"><?= $item['jumlah_booking'] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
    <div class="bg-yellow-100 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-yellow-700">Pending</h3>
        <p class="text-2xl font-bold text-yellow-800"><?= $bookingStatusCount['pending'] ?></p>
    </div>
    <div class="bg-blue-100 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-blue-700">Confirmed</h3>
        <p class="text-2xl font-bold text-blue-800"><?= $bookingStatusCount['confirmed'] ?></p>
    </div>
    <div class="bg-green-100 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-green-700">Completed</h3>
        <p class="text-2xl font-bold text-green-800"><?= $bookingStatusCount['completed'] ?></p>
    </div>
    <div class="bg-red-100 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-red-700">Cancelled</h3>
        <p class="text-2xl font-bold text-red-800"><?= $bookingStatusCount['cancelled'] ?></p>
    </div>
</div>

    </div>
</div>

<?= $this->endSection() ?>
