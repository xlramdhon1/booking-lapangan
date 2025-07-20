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

    public function hapusLapanganModel($id)
    {
        $model = new LapanganModel();
        $model->delete($id);
        return redirect()->to('/dashboard/lapangan')->with('success', 'Data lapangan dihapus!');
    }
}
