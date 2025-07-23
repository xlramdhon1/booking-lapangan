<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<?php if(session()->getFlashdata('success')): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Sukses!',
    text: '<?= session()->getFlashdata('success') ?>',
    timer: 2000,
    showConfirmButton: false
  });
</script>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '<?= session()->getFlashdata('error') ?>',
    timer: 2000,
    showConfirmButton: false
  });
</script>
<?php endif; ?>

<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-blue-700">Data Pelanggan</h2>
    <a href="<?= base_url('/pelanggan/tambah') ?>">
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition font-semibold">
            Tambah Data Pelanggan
        </button>
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-blue-100 text-blue-800">
            <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">No HP</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Alamat</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($pelanggan as $row): ?>
            <tr class="border-t hover:bg-blue-50">
                <td class="px-4 py-3"><?= $no++ ?></td>
                <td class="px-4 py-3"><?= esc($row['nama_pelanggan']) ?></td>
                <td class="px-4 py-3"><?= esc($row['no_hp']) ?></td>
                <td class="px-4 py-3"><?= esc($row['email']) ?></td>
                <td class="px-4 py-3"><?= esc($row['alamat']) ?></td>
                <td class="px-4 py-3 space-x-2">
                    <a href="<?= base_url('/dashboard/pelanggan/edit/' . $row['id']) ?>"
                       class="text-blue-600 hover:underline">Edit</a>
                    <button type="button" onclick="confirmDelete(<?= $row['id'] ?>)"
                        class="text-red-600 hover:underline">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus data ini?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = '<?= base_url('/dashboard/pelanggan/hapus') ?>/' + id;
    }
  });
}
</script>

<?= $this->endSection() ?>
