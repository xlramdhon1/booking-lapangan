<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <h2>Admin</h2>
      <ul>
        <li><a href="<?= base_url('/dashboard/lapangan') ?>">Data Lapangan</a></li>
        <li><a href="<?= base_url('/dashboard/pelanggan') ?>">Data Pelanggan</a></li>
        <li><a href="<?= base_url('/dashboard/booking/tambah') ?>">Tambah Booking</a></li>
        <li><a href="<?= base_url('/dashboard/booking') ?>">Lihat Booking</a></li>
        <li><a href="<?= base_url('/dashboard/booking/status') ?>">Status Booking</a></li>
        <li><a href="<?= base_url('/auth/logout') ?>">Logout</a></li>
      </ul>
    </div>
    
    <div class="main-content">
      <?= $this->renderSection('content') ?>
    </div>
  </div>
</body>
</html>
