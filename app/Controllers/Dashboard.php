<?php

namespace App\Controllers;
use App\Models\LapanganModel;
use App\Models\PelangganModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('dashboard/home');
    }

    public function lapangan()
    {
        $model = new LapanganModel();
        $data['lapangan'] = $model->findAll();

        return view('dashboard/lapangan/lapangan', $data);
    }

    public function tambahLapangan()
    {
        $model = new LapanganModel();

        $data = [
            'nama_lapangan' => $this->request->getPost('nama_lapangan'),
            'jenis_olahraga' => $this->request->getPost('jenis_olahraga'),
            'harga_per_jam' => $this->request->getPost('harga_per_jam'),
        ];

        $model->insert($data);
        return redirect()->to('/dashboard/lapangan')->with('success', 'Data Lapangan ditambahkan!');
    }

    public function hapusLapangan($id)
    {
        $model = new LapanganModel();
        $model->delete($id);
        return redirect()->to('/dashboard/lapangan')->with('success', 'Data lapangan dihapus!');
    }
    
    public function editLapangan($id)
    {
    $model = new \App\Models\LapanganModel();
    $data['lapangan'] = $model->find($id);
    
    if (!$data['lapangan']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Data lapangan tidak ditemukan');
    }

    return view('dashboard/lapangan/lapangan_edit', $data);
    }

    public function updateLapangan($id)
    {
    $model = new \App\Models\LapanganModel();

    $data = [
        'nama_lapangan' => $this->request->getPost('nama_lapangan'),
        'jenis_olahraga' => $this->request->getPost('jenis_olahraga'),
        'harga_per_jam' => $this->request->getPost('harga_per_jam'),
    ];

    $model->update($id, $data);
    return redirect()->to('/dashboard/lapangan')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function pelanggan()
    {
    $model = new PelangganModel();
    $data['pelanggan'] = $model->findAll();
    return view('dashboard/pelanggan/pelanggan', $data);
    }

    public function formPelanggan()
    {
    return view('dashboard/pelanggan/pelanggan_tambah');
    }

    public function tambahPelanggan()
    {
    $model = new PelangganModel();
    $data = [
        'nama' => $this->request->getPost('nama'),
        'no_hp' => $this->request->getPost('no_hp'),
        'email' => $this->request->getPost('email'),
        'alamat' => $this->request->getPost('alamat'),
    ];
    $model->insert($data);
    return redirect()->to('/dashboard/pelanggan')->with('success', 'Data pelanggan ditambahkan!');
    }

    public function hapusPelanggan($id)
    {
    $model = new PelangganModel();
    $model->delete($id);
    return redirect()->to('/dashboard/pelanggan/')->with('success', 'Data pelanggan dihapus!');
    }

    public function editPelanggan($id)
    {
    $model = new \App\Models\PelangganModel();
    $data['pelanggan'] = $model->find($id);

    if (!$data['pelanggan']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Pelanggan tidak ditemukan');
    }

    return view('dashboard/pelanggan/pelanggan_edit', $data);
    }

    public function updatePelanggan($id)
    {
    $model = new \App\Models\PelangganModel();
    $data = [
        'nama'    => $this->request->getPost('nama'),
        'no_hp'   => $this->request->getPost('no_hp'),
        'email'   => $this->request->getPost('email'),
        'alamat'  => $this->request->getPost('alamat'),
    ];

    $model->update($id, $data);
    return redirect()->to('/dashboard/pelanggan')->with('success', 'Data pelanggan berhasil diperbarui!');
    }



}
