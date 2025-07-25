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
        // Jumlah pelanggan terdaftar
        $jumlahPelanggan = $this->pelangganModel->countAll();

        // Data lapangan dan jumlah booking
        $lapangan = $this->lapanganModel->findAll();
        $bookingPerLapangan = [];
        foreach ($lapangan as $l) {
            $jumlah = $this->bookingModel
                            ->where('lapangan_id', $l['id'])
                            ->countAllResults();
            $bookingPerLapangan[] = [
                'nama_lapangan' => $l['nama_lapangan'],
                'jumlah_booking' => $jumlah
            ];
        }

        // Status count
        $bookingStatusCount = [
            'pending' => $this->bookingModel->where('status', 'pending')->countAllResults(),
            'confirmed' => $this->bookingModel->where('status', 'confirmed')->countAllResults(),
            'completed' => $this->bookingModel->where('status', 'completed')->countAllResults(),
            'cancelled' => $this->bookingModel->where('status', 'cancelled')->countAllResults(),
        ];

        // Booking untuk kalender
        $bookings = $this->bookingModel
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->select('booking.*, lapangan.nama_lapangan, pelanggan.nama_pelanggan')
            ->whereIn('booking.status', ['confirmed', 'completed'])
            ->findAll();

        $calendarEvents = [];
        foreach ($bookings as $b) {
            if (!empty($b['tanggal_booking']) && !empty($b['jam_mulai'])) {
                $tanggal = date('Y-m-d', strtotime($b['tanggal_booking']));
                $start = strtotime("$tanggal {$b['jam_mulai']}");
                $end = strtotime("+{$b['durasi']} hour", $start);

                $calendarEvents[] = [
                    'title' => $b['nama_pelanggan'] . ' - ' . $b['nama_lapangan'],
                    'start' => date('Y-m-d\TH:i:s', $start),
                    'end'   => date('Y-m-d\TH:i:s', $end),
                    'color' => $this->getColorForStatus($b['status']),
                    'extendedProps' => [
                        'nama_pelanggan' => $b['nama_pelanggan'],
                        'nama_lapangan'  => $b['nama_lapangan'],
                        'tanggal'        => $tanggal,
                        'jam_mulai'      => $b['jam_mulai'],
                        'durasi'         => $b['durasi'],
                        'status'         => ucfirst($b['status']),
                        'total_bayar'    => number_format($b['total_bayar'], 0, ',', '.')
                    ]
                ];
            }
        }

        // Kirim ke view
        return view('tampilan/admin/dashboard/admin_dashboard', [
            'jumlahPelanggan'     => $jumlahPelanggan,
            'bookingPerLapangan'  => $bookingPerLapangan,
            'bookingStatusCount'  => $bookingStatusCount,
            'calendarEvents'      => $calendarEvents
        ]);
    }

    // ✅ Fungsi bantuan: Diletakkan di luar method index, tapi masih di dalam class
    protected function getColorForStatus($status)
    {
        switch ($status) {
            case 'pending': return '#facc15'; // kuning
            case 'confirmed': return '#3b82f6'; // biru
            case 'completed': return '#10b981'; // hijau
            case 'cancelled': return '#ef4444'; // merah
            default: return '#6b7280'; // abu
        }
    }
}
