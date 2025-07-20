<?php

namespace App\Controllers;
use App\Models\LapanganModel;

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

        return view('dashboard/lapangan', $data);
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

    return view('dashboard/lapangan_edit', $data);
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

}
