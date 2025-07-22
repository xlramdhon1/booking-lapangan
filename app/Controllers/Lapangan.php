<?php

namespace App\Controllers;
use App\Models\LapanganModel;
use CodeIgniter\Controller;

class Lapangan extends BaseController
{
    protected $lapanganModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
    }

    public function index()
    {
        $data['lapangan'] = $this->lapanganModel->findAll();
        return view('dashboard/lapangan/lapangan', $data);
    }

    public function tambah()
    {
        $data = [
            'nama_lapangan'   => $this->request->getPost('nama_lapangan'),
            'jenis_olahraga'  => $this->request->getPost('jenis_olahraga'),
            'harga_per_jam'   => $this->request->getPost('harga_per_jam'),
        ];

        $this->lapanganModel->insert($data);
        return redirect()->to('/lapangan')->with('success', 'Data lapangan ditambahkan!');
    }

    public function hapus($id)
    {
        $this->lapanganModel->delete($id);
        return redirect()->to('/lapangan')->with('success', 'Data lapangan dihapus!');
    }

    public function edit($id)
    {
        $data['lapangan'] = $this->lapanganModel->find($id);

        if (!$data['lapangan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Lapangan tidak ditemukan');
        }

        return view('dashboard/lapangan/lapangan_edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_lapangan'   => $this->request->getPost('nama_lapangan'),
            'jenis_olahraga'  => $this->request->getPost('jenis_olahraga'),
            'harga_per_jam'   => $this->request->getPost('harga_per_jam'),
        ];

        $this->lapanganModel->update($id, $data);
        return redirect()->to('/lapangan')->with('success', 'Data lapangan berhasil diperbarui!');
    }
}
