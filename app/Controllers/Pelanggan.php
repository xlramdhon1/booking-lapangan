<?php

namespace App\Controllers;
use App\Models\PelangganModel;
use CodeIgniter\Controller;

class Pelanggan extends BaseController
{
    protected $pelangganModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
    }

    public function index()
    {
        $data['pelanggan'] = $this->pelangganModel->findAll();
        return view('dashboard/pelanggan/pelanggan', $data);
    }

    public function form()
    {
        return view('dashboard/pelanggan/pelanggan_tambah');
    }

    public function tambah()
    {
        $data = [
            'nama_pelanggan' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $this->pelangganModel->insert($data);
        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan ditambahkan!');
    }

    public function hapus($id)
    {
        $this->pelangganModel->delete($id);
        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan dihapus!');
    }

    public function edit($id)
    {
        $data['pelanggan'] = $this->pelangganModel->find($id);

        if (!$data['pelanggan']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelanggan tidak ditemukan');
        }

        return view('dashboard/pelanggan/pelanggan_edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_pelanggan'    => $this->request->getPost('nama_pelanggan'),
            'no_hp'   => $this->request->getPost('no_hp'),
            'email'   => $this->request->getPost('email'),
            'alamat'  => $this->request->getPost('alamat'),
        ];

        $this->pelangganModel->update($id, $data);
        return redirect()->to('/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui!');
    }
}
