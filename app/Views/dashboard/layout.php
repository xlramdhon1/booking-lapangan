<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Management Lapangan - Prikitiw</title>
  <link href="<?= base_url('css/tailwind.css') ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="min-h-screen flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:block">
      <div class="p-6 border-b border-gray-200">
        <h2 class="text-xl font-bold text-blue-600 leading-tight">Management<br>Lapangan</h2>
      </div>
      <nav class="p-4">
        <ul class="space-y-2">
          <li><a href="<?= base_url('/tampilan/admin/dashboard') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Dashboard</a></li>
          <li><a href="<?= base_url('/lapangan') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Data Lapangan</a></li>
          <li><a href="<?= base_url('/pelanggan') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Data Pelanggan</a></li>
          <li><a href="<?= base_url('/booking/tambah') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Tambah Booking</a></li>
          <li><a href="<?= base_url('/booking') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Lihat Booking</a></li>
          <li><a href="<?= base_url('/booking/status') ?>" class="block py-2 px-4 rounded hover:bg-blue-100">Status Booking</a></li>
          <li><a href="<?= base_url('/auth/logout') ?>" class="block py-2 px-4 text-red-600 rounded hover:bg-red-100">Logout</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
      <?= $this->renderSection('content') ?>
    </main>
  </div>
</body>
</html>
