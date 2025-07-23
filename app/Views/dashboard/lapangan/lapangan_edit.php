<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-semibold mb-6">Edit Data Lapangan</h2>

<div class="bg-white shadow rounded-lg p-6 max-w-xl">
    <form method="post" action="<?= base_url('/lapangan/update/' . $lapangan['id']) ?>" class="space-y-5">
        <div>
            <label class="block mb-1 font-medium">Nama Lapangan</label>
            <input type="text" name="nama_lapangan" value="<?= esc($lapangan['nama_lapangan']) ?>" required
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium">Jenis Olahraga</label>
            <input type="text" name="jenis_olahraga" value="<?= esc($lapangan['jenis_olahraga']) ?>" required
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium">Harga per Jam</label>
            <input type="number" name="harga_per_jam" value="<?= esc($lapangan['harga_per_jam']) ?>" required
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="<?= base_url('/lapangan') ?>" class="text-sm text-gray-600 hover:underline">← Kembali ke Daftar</a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                Update
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
