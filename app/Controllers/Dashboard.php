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
        $this->lapanganModel = new \App\Models\LapanganModel();
        $this->pelangganModel = new \App\Models\PelangganModel();
        $this->bookingModel = new \App\Models\BookingModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('dashboard/home');
    }
}
