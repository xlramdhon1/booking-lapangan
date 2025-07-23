<?= $this->extend('dashboard/layout') ?>
<?= $this->section('content') ?>

<h2 class="text-2xl font-bold text-blue-700 mb-6">Edit Data Pelanggan</h2>

<div class="w-full bg-white rounded-xl shadow p-4 sm:p-8 mx-auto max-w-full">
  <form method="post" action="<?= base_url('/pelanggan/update/' . $pelanggan['id']) ?>" class="space-y-5 w-full">
    <div>
      <label class="block font-semibold mb-1">Nama</label>
      <input type="text" name="nama_pelanggan" value="<?= esc($pelanggan['nama_pelanggan']) ?>" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>
    <div>
      <label class="block font-semibold mb-1">No HP</label>
      <input type="text" name="no_hp" value="<?= esc($pelanggan['no_hp']) ?>" required
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>
    <div>
      <label class="block font-semibold mb-1">Email</label>
      <input type="email" name="email" value="<?= esc($pelanggan['email']) ?>"
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" />
    </div>
    <div>
      <label class="block font-semibold mb-1">Alamat</label>
      <textarea name="alamat" rows="3"
        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"><?= esc($pelanggan['alamat']) ?></textarea>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
      <button type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white font-semibold px-10 py-4 rounded-lg transition text-base w-full sm:w-auto">
        Update
      </button>
      <a href="<?= base_url('/pelanggan') ?>"
        class="sm:ml-4 text-blue-600 hover:underline font-semibold text-center py-4 sm:py-0">← Kembali</a>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
