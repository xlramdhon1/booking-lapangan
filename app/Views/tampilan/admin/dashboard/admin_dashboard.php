<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<!-- Style dan FullCalendar CSS -->
<link href="<?= base_url('css/fullcalendar.css') ?>" rel="stylesheet" />
<style>
  #calendar {
    background-color: #fff;
    padding: 20px;
    border-radius: 0.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }
</style>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?= session()->getFlashdata('success') ?>',
      timer: 2000,
      showConfirmButton: false
    });
  </script>
<?php endif; ?>

<div class="p-6">
  <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Jumlah Pelanggan -->
    <div class="bg-white shadow-md rounded-lg p-6">
      <h2 class="text-lg font-semibold">Jumlah Pelanggan Terdaftar</h2>
      <p class="text-4xl text-blue-600 font-bold mt-2"><?= $jumlahPelanggan ?></p>
    </div>

    <!-- Jumlah Booking per Lapangan -->
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
  </div>

  <!-- Booking Status -->
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

  <!-- Kalender Booking -->
  <div class="mt-10">
    <h2 class="text-xl font-semibold mb-4">Jadwal Booking</h2>

    <!-- Legend Warna -->
    <div class="flex gap-4 mb-4">
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 bg-blue-500 rounded"></div>
        <span class="text-sm">Confirmed</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="w-4 h-4 bg-green-500 rounded"></div>
        <span class="text-sm">Completed</span>
      </div>
    </div>

    <!-- Kalender -->
    <div id="calendar"></div>
  </div>
</div>

<!-- FullCalendar Script -->
<script src="<?= base_url('js/fullcalendar.js') ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      events: <?= json_encode($calendarEvents) ?>,
      height: 'auto'
    });
    calendar.render();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      events: <?= json_encode($calendarEvents) ?>,
      eventClick: function(info) {
        const props = info.event.extendedProps;

        Swal.fire({
          title: props.nama_pelanggan + ' - ' + props.nama_lapangan,
          html: `
            <div class="text-left">
              <p><strong>Tanggal:</strong> ${props.tanggal}</p>
              <p><strong>Jam Mulai:</strong> ${props.jam_mulai}</p>
              <p><strong>Durasi:</strong> ${props.durasi} jam</p>
              <p><strong>Status:</strong> ${props.status}</p>
              <p><strong>Total Bayar:</strong> Rp ${props.total_bayar}</p>
            </div>
          `,
          icon: 'info',
          confirmButtonText: 'Tutup',
        });
      },
      height: 'auto'
    });

    calendar.render();
  });
</script>

<!-- Debug (Opsional, bisa dihapus) -->
<!-- <pre><?= json_encode($calendarEvents, JSON_PRETTY_PRINT) ?></pre> -->

<?= $this->endSection() ?>
