<?php

namespace App\Controllers;
use App\Models\BookingModel;
use App\Models\PelangganModel;
use App\Models\LapanganModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Booking extends BaseController
{
    protected $bookingModel;
    protected $pelangganModel;
    protected $lapanganModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->pelangganModel = new PelangganModel();
        $this->lapanganModel = new LapanganModel();
    }

    // Daftar booking dengan filter
    public function index()
    {
        $status = $this->request->getGet('status');
        $tanggal = $this->request->getGet('tanggal');
        $lapangan_id = $this->request->getGet('lapangan_id');

        $builder = $this->bookingModel
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama');

        if ($status) {
            $builder->where('booking.status', $status);
        }

        if ($tanggal) {
            $builder->where('DATE(booking.tanggal_booking)', $tanggal);
        }

        if ($lapangan_id) {
            $builder->where('booking.lapangan_id', $lapangan_id);
        }

        $data['bookings'] = $builder->findAll();

        // Untuk filter form
        $data['filter_status'] = $status;
        $data['filter_tanggal'] = $tanggal;
        $data['filter_lapangan_id'] = $lapangan_id;
        $data['lapanganList'] = $this->lapanganModel->findAll();

        // Cek hasil kosong
        $data['no_result'] = empty($data['bookings']);

        return view('dashboard/booking/booking_list', $data);
    }

    // Form tambah booking
    public function tambah()
    {
        $data['pelanggan'] = $this->pelangganModel->findAll();
        $data['lapangan'] = $this->lapanganModel->findAll();

        return view('dashboard/booking/booking_tambah', $data);
    }

    // Simpan booking baru
    public function simpan()
    {
        $data = [
            'pelanggan_id' => $this->request->getPost('pelanggan_id'),
            'lapangan_id' => $this->request->getPost('lapangan_id'),
            'tanggal_booking' => $this->request->getPost('tanggal_booking'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'durasi' => $this->request->getPost('durasi'),
            'status' => 'pending',
            'total_bayar' => $this->request->getPost('total_bayar'),
        ];

        $this->bookingModel->insert($data);

        return redirect()->to('/booking')->with('success', 'Booking berhasil ditambahkan!');
    }

    // Hapus booking
    public function hapus($id)
    {
        $this->bookingModel->delete($id);
        return redirect()->to('/booking')->with('success', 'Booking berhasil dihapus!');
    }

    // Form edit booking
    public function edit($id)
    {
        $data['booking'] = $this->bookingModel->find($id);
        $data['pelanggan'] = $this->pelangganModel->findAll();
        $data['lapangan'] = $this->lapanganModel->findAll();

        if (!$data['booking']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booking tidak ditemukan');
        }

        return view('dashboard/booking/booking_edit', $data);
    }

    // Update booking
    public function update($id)
    {
        $lapangan = $this->lapanganModel->find($this->request->getPost('lapangan_id'));
        $harga_per_jam = $lapangan['harga_per_jam'];
        $durasi = (int)$this->request->getPost('durasi');
        $total_bayar = $harga_per_jam * $durasi;

        $data = [
            'pelanggan_id'    => $this->request->getPost('pelanggan_id'),
            'lapangan_id'     => $this->request->getPost('lapangan_id'),
            'tanggal_booking' => $this->request->getPost('tanggal_booking'),
            'jam_mulai'       => $this->request->getPost('jam_mulai'),
            'durasi'          => $durasi,
            'status'          => $this->request->getPost('status'),
            'total_bayar'     => $total_bayar,
        ];

        $this->bookingModel->update($id, $data);

        return redirect()->to('/booking')->with('success', 'Booking berhasil diperbarui!');
    }

    // Halaman update status booking (list)
    public function statusList()
    {
        $data['bookings'] = $this->bookingModel
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama')
            ->findAll();

        return view('dashboard/booking/status_list', $data);
    }

    // Form update status booking
    public function statusForm($id)
    {
        $booking = $this->bookingModel
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama')
            ->find($id);

        if (!$booking) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Booking tidak ditemukan");
        }

        return view('dashboard/booking/status_form', ['booking' => $booking]);
    }

    // Proses update status booking
    public function statusUpdate($id)
    {
        $statusBaru = $this->request->getPost('status');
        $this->bookingModel->update($id, ['status' => $statusBaru]);

        return redirect()->to('/booking')->with('success', 'Status booking diperbarui!');
    }

    // dompdf
    public function exportPdf()
    {
    $lapanganModel = new \App\Models\LapanganModel();
    $bookingModel = new \App\Models\BookingModel();

    // Ambil filter
    $lapangan_id = $this->request->getGet('lapangan_id');
    $status      = $this->request->getGet('status');
    $tanggal     = $this->request->getGet('tanggal');

    $bookings = $bookingModel
        ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama')
        ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id');

    if (!empty($lapangan_id)) {
        $bookings->where('booking.lapangan_id', $lapangan_id);
    }

    if (!empty($status)) {
        $bookings->where('booking.status', $status);
    }

    if (!empty($tanggal)) {
        $bookings->where('DATE(booking.tanggal_booking)', $tanggal);
    }

    $data['bookings'] = $bookings->findAll();

    // View untuk PDF
    $html = view('tampilan/admin/dashboard/pdf_booking_list', $data);

    // Konfigurasi Dompdf
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $dompdf->stream('laporan-booking.pdf', ['Attachment' => false]);
    exit();
    }

    // excel
    // File: app/Controllers/Booking.php
    public function exportExcel()
    {
    $bookingModel = new \App\Models\BookingModel();

    $lapangan_id = $this->request->getGet('lapangan_id');
    $status      = $this->request->getGet('status');
    $tanggal     = $this->request->getGet('tanggal');

    $bookings = $bookingModel
        ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id')
        ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama');

    if (!empty($lapangan_id)) {
        $bookings->where('booking.lapangan_id', $lapangan_id);
    }
    if (!empty($status)) {
        $bookings->where('booking.status', $status);
    }
    if (!empty($tanggal)) {
        $bookings->where('DATE(booking.tanggal_booking)', $tanggal);
    }

    $bookings = $bookings->findAll();

    // Buat Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Nama Pelanggan');
    $sheet->setCellValue('C1', 'Nama Lapangan');
    $sheet->setCellValue('D1', 'Tanggal Booking');
    $sheet->setCellValue('E1', 'Jam Mulai');
    $sheet->setCellValue('F1', 'Durasi');
    $sheet->setCellValue('G1', 'Status');
    $sheet->setCellValue('H1', 'Total Bayar');

    // Isi Data
    $row = 2;
    $no = 1;
    foreach ($bookings as $b) {
        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $b['pelanggan_nama']);
        $sheet->setCellValue('C' . $row, $b['lapangan_nama']);
        $sheet->setCellValue('D' . $row, $b['tanggal_booking']);
        $sheet->setCellValue('E' . $row, $b['jam_mulai']);
        $sheet->setCellValue('F' . $row, $b['durasi']);
        $sheet->setCellValue('G' . $row, $b['status']);
        $sheet->setCellValue('H' . $row, $b['total_bayar']);
        $row++;
    }

    // Download Excel
    $filename = 'laporan-booking.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
    }
}
