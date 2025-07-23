<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Management Lapangan - Prikitiw</title>
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/booking-status.css') ?>">
  <link href="<?= base_url('css/tailwind.css') ?>" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Management<br>Lapangan</h2>
      <ul>
        <li><a href="<?= base_url('/tampilan/admin/dashboard') ?>">Dashboard</a></li>
        <li><a href="<?= base_url('/lapangan') ?>">Data Lapangan</a></li>
        <li><a href="<?= base_url('/pelanggan') ?>">Data Pelanggan</a></li>
        <li><a href="<?= base_url('/booking/tambah') ?>">Tambah Booking</a></li>
        <li><a href="<?= base_url('/booking') ?>">Lihat Booking</a></li>
        <li><a href="<?= base_url('/booking/status') ?>">Status Booking</a></li>
        <li><a href="<?= base_url('/auth/logout') ?>">Logout</a></li>
      </ul>
    </div>
    <div class="main-content">
      <?= $this->renderSection('content') ?>
    </div>
  </div>
</body>
</html>
