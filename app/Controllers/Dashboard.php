<?php

namespace App\Controllers;
use App\Models\LapanganModel;
use App\Models\PelangganModel;
use App\Models\BookingModel;

class Dashboard extends BaseController
{
    protected $lapanganModel;
    protected $pelangganModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->lapanganModel = new LapanganModel();
        $this->pelangganModel = new PelangganModel();
        $this->bookingModel = new BookingModel();
    }

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

// Tampilkan daftar booking
    public function booking()
    {
    // ambil data booking dengan join pelanggan dan lapangan
    $data['bookings'] = $this->bookingModel
        ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id')
        ->select('booking.*, pelanggan.nama as pelanggan_nama, lapangan.nama as lapangan_nama')
        ->findAll();

    return view('dashboard/booking/index', $data);
    }

// Form tambah booking
    public function bookingTambah()
    {
    $data['pelanggan'] = $this->pelangganModel->findAll();
    $data['lapangan'] = $this->lapanganModel->findAll();

    return view('dashboard/booking/booking_tambah', $data);
    }

// Proses simpan booking
    public function bookingSimpan()
    {
    $data = [
        'pelanggan_id' => $this->request->getPost('pelanggan_id'),
        'lapangan_id' => $this->request->getPost('lapangan_id'),
        'tanggal_booking' => $this->request->getPost('tanggal_booking'),
        'durasi' => $this->request->getPost('durasi'),
        'status' => 'pending',
        'total_bayar' => $this->request->getPost('total_bayar'),
    ];

    $this->bookingModel->insert($data);

    return redirect()->to('/dashboard/booking')->with('success', 'Booking berhasil ditambahkan!');
    }


}
