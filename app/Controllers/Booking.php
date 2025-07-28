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

    public function index()
{
    $status = $this->request->getGet('status');
    $tanggal = $this->request->getGet('tanggal');
    $lapangan_id = $this->request->getGet('lapangan_id');

    $builder = $this->bookingModel
        ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id')
        ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama');

    // Cek apakah ada filter yang aktif
    $hasFilter = false;

    if ($status !== null && $status !== '') {
        $builder->where('booking.status', $status);
        $hasFilter = true;
    }

    if ($tanggal !== null && $tanggal !== '') {
        $builder->where('DATE(booking.tanggal_booking)', $tanggal);
        $hasFilter = true;
    }

    if ($lapangan_id !== null && $lapangan_id !== '') {
        $builder->where('booking.lapangan_id', $lapangan_id);
        $hasFilter = true;
    }

    $bookings = $builder->findAll();

    $data = [
        'bookings' => $bookings,
        'filter_status' => $status,
        'filter_tanggal' => $tanggal,
        'filter_lapangan_id' => $lapangan_id,
        'lapanganList' => $this->lapanganModel->findAll(),
        'no_result' => $hasFilter && empty($bookings), // hanya tampilkan alert jika memang filter aktif
    ];

    return view('dashboard/booking/booking_list', $data);
}



    public function tambah()
    {
        $data['pelanggan'] = $this->pelangganModel->findAll();
        $data['lapangan'] = $this->lapanganModel->findAll();
        return view('dashboard/booking/booking_tambah', $data);
    }

    public function simpan()
    {
        helper('booking');

        $lapangan_id = $this->request->getPost('lapangan_id');
        $tanggal = $this->request->getPost('tanggal_booking');
        $jam_mulai = $this->request->getPost('jam_mulai');
        $durasi = (int)$this->request->getPost('durasi');

        if (isConflictBooking($lapangan_id, $tanggal, $jam_mulai, $durasi)) {
    return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan booking lain.');
    }

        $data = [
            'pelanggan_id'    => $this->request->getPost('pelanggan_id'),
            'lapangan_id'     => $lapangan_id,
            'tanggal_booking' => $tanggal,
            'jam_mulai'       => $jam_mulai,
            'durasi'          => $durasi,
            'status'          => 'pending',
            'total_bayar'     => $this->request->getPost('total_bayar'),
        ];
        

        $this->bookingModel->insert($data);
        return redirect()->to('/booking')->with('success', 'Booking berhasil ditambahkan!');
    }

    public function hapus($id)
    {
        $this->bookingModel->delete($id);
        return redirect()->to('/booking')->with('success', 'Booking berhasil dihapus!');
    }

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

    public function update($id)
    {
        helper('booking');
        $lapangan_id = $this->request->getPost('lapangan_id');
        $tanggal = $this->request->getPost('tanggal_booking');
        $jam_mulai = $this->request->getPost('jam_mulai');
        $durasi = (int)$this->request->getPost('durasi');

        if (isConflictBooking($lapangan_id, $tanggal, $jam_mulai, $durasi)) {
    return redirect()->back()->withInput()->with('error', 'Jadwal bentrok dengan booking lain.');
    }

        $lapangan = $this->lapanganModel->find($lapangan_id);
        $total_bayar = $lapangan['harga_per_jam'] * $durasi;

        $data = [
            'pelanggan_id'    => $this->request->getPost('pelanggan_id'),
            'lapangan_id'     => $lapangan_id,
            'tanggal_booking' => $tanggal,
            'jam_mulai'       => $jam_mulai,
            'durasi'          => $durasi,
            'status'          => $this->request->getPost('status'),
            'total_bayar'     => $total_bayar,
        ];

        $this->bookingModel->update($id, $data);
        return redirect()->to('/booking')->with('success', 'Booking berhasil diperbarui!');
    }

    public function statusList()
    {
        $data['bookings'] = $this->bookingModel
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->select('booking.*, pelanggan.nama_pelanggan as pelanggan_nama, lapangan.nama_lapangan as lapangan_nama')
            ->findAll();

        return view('dashboard/booking/status_list', $data);
    }

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

    public function statusUpdate($id)
    {
        $statusBaru = $this->request->getPost('status');
        $this->bookingModel->update($id, ['status' => $statusBaru]);
        return redirect()->to('/booking')->with('success', 'Status booking diperbarui!');
    }

    public function exportPdf()
    {
        $lapangan_id = $this->request->getGet('lapangan_id');
        $status      = $this->request->getGet('status');
        $tanggal     = $this->request->getGet('tanggal');

        $bookings = $this->bookingModel
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

        $html = view('tampilan/admin/dashboard/pdf_booking_list', $data);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan-booking.pdf', ['Attachment' => false]);
        exit();
    }

    public function exportExcel()
    {
        $lapangan_id = $this->request->getGet('lapangan_id');
        $status      = $this->request->getGet('status');
        $tanggal     = $this->request->getGet('tanggal');

        $bookings = $this->bookingModel
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

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Pelanggan');
        $sheet->setCellValue('C1', 'Nama Lapangan');
        $sheet->setCellValue('D1', 'Tanggal Booking');
        $sheet->setCellValue('E1', 'Jam Mulai');
        $sheet->setCellValue('F1', 'Durasi');
        $sheet->setCellValue('G1', 'Status');
        $sheet->setCellValue('H1', 'Total Bayar');

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

        $filename = 'laporan-booking.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    public function updateStatus()
{
    $json = $this->request->getJSON();
    $bookingId = $json->booking_id ?? null;

    if (!$bookingId) {
        return $this->response->setJSON(['status' => false, 'message' => 'Invalid booking ID']);
    }

    // Update status booking ke "confirmed"
    $updated = $this->bookingModel->update($bookingId, [
        'status' => 'confirmed',
        'pembayaran' => 'midtrans'
    ]);

    return $this->response->setJSON([
        'status' => $updated,
        'message' => $updated ? 'Status updated' : 'Failed to update'
    ]);
}
public function buktiPembayaran($id)
{
    $bookingModel = new BookingModel();

    $booking = $bookingModel
        ->select('booking.*, 
          pelanggan.nama_pelanggan as pelanggan_nama, 
          pelanggan.email as pelanggan_email, 
          lapangan.nama_lapangan as lapangan_nama')
        ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
        ->join('lapangan', 'lapangan.id = booking.lapangan_id')
        ->where('booking.id', $id)
        ->first();

    if (!$booking) {
        return redirect()->back()->with('error', 'Booking tidak ditemukan.');
    }

    if (!in_array($booking['status'], ['confirmed', 'completed'])) {
        return redirect()->back()->with('error', 'Bukti pembayaran hanya tersedia untuk booking yang sudah dibayar.');
    }

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml(view('dashboard/booking/bukti_pdf', ['booking' => $booking]));
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("Bukti_Pembayaran_Booking_{$booking['id']}.pdf", ['Attachment' => false]);
}

}
