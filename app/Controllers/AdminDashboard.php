<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\LapanganModel;
use App\Models\BookingModel;

class AdminDashboard extends BaseController
{
    protected $pelangganModel;
    protected $lapanganModel;
    protected $bookingModel;

    public function __construct()
    {
        $this->pelangganModel = new PelangganModel();
        $this->lapanganModel = new LapanganModel();
        $this->bookingModel = new BookingModel();
    }

    public function index()
    {
        // Jumlah pelanggan
        $jumlahPelanggan = $this->pelangganModel->countAll();

        // Ambil semua lapangan
        $lapangan = $this->lapanganModel->findAll();

        // Hitung jumlah booking per lapangan
        $bookingPerLapangan = [];
        foreach ($lapangan as $l) {
            $bookingPerLapangan[] = [
                'nama_lapangan' => $l['nama_lapangan'],
                'jumlah_booking' => $this->bookingModel
                    ->where('lapangan_id', $l['id'])
                    ->countAllResults(),
            ];
        }

        // Tambahkan di dalam method index()

        $bookingStatusCount = [
            'pending' => $this->bookingModel->where('status', 'pending')->countAllResults(),
            'confirmed' => $this->bookingModel->where('status', 'confirmed')->countAllResults(),
            'completed' => $this->bookingModel->where('status', 'completed')->countAllResults(),
            'cancelled' => $this->bookingModel->where('status', 'cancelled')->countAllResults(),
        ];

        // Kirim ke view
        $data = [
            'jumlahPelanggan' => $jumlahPelanggan,
            'bookingPerLapangan' => $bookingPerLapangan,
            'bookingStatusCount' => $bookingStatusCount,
        ];

        return view('tampilan/admin/dashboard/admin_dashboard', $data);
    }

}
