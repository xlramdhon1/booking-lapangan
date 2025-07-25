<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<!-- SweetAlert untuk flashdata -->
<?php if (session()->getFlashdata('success')): ?>
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

<?php if (session()->getFlashdata('error')): ?>
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

<!-- Judul -->
<h2 class="text-2xl font-semibold mb-4">Data Lapangan</h2>

<!-- Form Tambah Lapangan -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="post" action="<?= base_url('/lapangan/tambah') ?>" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="nama_lapangan" placeholder="Nama Lapangan" required
               class="border p-2 rounded w-full">
        <input type="text" name="jenis_olahraga" placeholder="Jenis Olahraga" required
               class="border p-2 rounded w-full">
        <input type="number" name="harga_per_jam" placeholder="Harga per Jam" required
               class="border p-2 rounded w-full">
        <div class="md:col-span-3">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded w-full">
                <i class="fa-solid fa-plus"></i> Tambah
            </button>
        </div>
    </form>
</div>

<!-- Tabel Data Lapangan -->
<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-200 text-gray-800">
            <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Nama Lapangan</th>
                <th class="px-4 py-3">Jenis Olahraga</th>
                <th class="px-4 py-3">Harga / Jam</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($lapangan as $row): ?>
            <tr class="border-t">
                <td class="px-4 py-3"><?= $no++ ?></td>
                <td class="px-4 py-3"><?= esc($row['nama_lapangan']) ?></td>
                <td class="px-4 py-3"><?= esc($row['jenis_olahraga']) ?></td>
                <td class="px-4 py-3">Rp<?= number_format($row['harga_per_jam'], 0, ',', '.') ?></td>
                <td class="px-4 py-3 space-x-2">
                    <a href="<?= base_url('lapangan/edit/' . $row['id']) ?>"
                       class="text-blue-600 hover:underline">Edit</a>
                    <button onclick="confirmDelete(<?= $row['id'] ?>)"
                            class="text-red-600 hover:underline">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Script SweetAlert untuk Hapus -->
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
            window.location.href = '<?= base_url('lapangan/hapus') ?>/' + id;
        }
    });
}
</script>

<?= $this->endSection() ?>
