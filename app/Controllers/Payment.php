<?php namespace App\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Config\Midtrans as MidtransConfig;

class Payment extends BaseController
{
    protected $db;

    public function __construct()
    {
        // Konfigurasi Midtrans
        $midtransConfig = new MidtransConfig();
        Config::$serverKey = $midtransConfig->serverKey;
        Config::$isProduction = $midtransConfig->isProduction;
        Config::$isSanitized = $midtransConfig->isSanitized;
        Config::$is3ds = $midtransConfig->is3ds;

        $this->db = \Config\Database::connect();
    }

    /**
     * Halaman tes pembayaran (opsional)
     */
    public function index()
    {
        return view('pay_view');
    }

    /**
     * Generate Snap Token saat tombol Bayar diklik
     * Route: POST /payment/tokenize
     */
    public function tokenize()
    {
        $json = $this->request->getJSON();
        $bookingId = $json->booking_id ?? null;

        if (!$bookingId) {
            return $this->response->setJSON(['error' => 'Booking ID tidak valid']);
        }

        $booking = $this->db->table('booking')
            ->select('booking.*, pelanggan.nama_pelanggan, pelanggan.email, pelanggan.no_hp, lapangan.nama_lapangan')
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.id', $bookingId)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return $this->response->setJSON(['error' => 'Data booking tidak ditemukan']);
        }

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking['id'] . '-' . time(),
                'gross_amount' => (int) $booking['total_bayar'],
            ],
            'customer_details' => [
                'first_name' => $booking['nama_pelanggan'],
                'email' => $booking['email'] ?? 'demo@example.com',
                'phone' => $booking['no_hp'] ?? '081122334455',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $this->response->setJSON(['token' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Gagal membuat token: ' . $e->getMessage()]);
        }
    }

    /**
     * Tampilkan halaman pembayaran
     * Route: GET /payment/bayar/{id}
     */
    public function bayar($id)
    {
        $booking = $this->db->table('booking')
            ->select('booking.*, pelanggan.nama_pelanggan, pelanggan.email, pelanggan.no_hp, lapangan.nama_lapangan, lapangan.harga_per_jam')
            ->join('pelanggan', 'pelanggan.id = booking.pelanggan_id')
            ->join('lapangan', 'lapangan.id = booking.lapangan_id')
            ->where('booking.id', $id)
            ->get()
            ->getRowArray();

        if (!$booking || $booking['status'] !== 'pending') {
            return redirect()->to('/booking')->with('error', 'Data booking tidak ditemukan atau tidak bisa dibayar.');
        }

        // Hitung jam selesai dari jam mulai + durasi
        $jamMulai = $booking['jam_mulai'];
        $durasi = (int) $booking['durasi'];
        $jamSelesai = date('H:i', strtotime("+{$durasi} hours", strtotime($jamMulai)));

        $booking['jam_selesai'] = $jamSelesai;

        return view('dashboard/payment/pay_view', ['booking' => $booking]);
    }

    public function notification()
{
    // Konfigurasi Midtrans
    $midtransConfig = new \Config\Midtrans();
    \Midtrans\Config::$serverKey = $midtransConfig->serverKey;
    \Midtrans\Config::$isProduction = $midtransConfig->isProduction;

    // Ambil payload dari Midtrans
    $notif = new \Midtrans\Notification();

    $transaction = $notif->transaction_status;
    $orderId = $notif->order_id;
    $paymentType = $notif->payment_type;
    $fraudStatus = $notif->fraud_status;

    log_message('info', "Midtrans Notif: $transaction for order $orderId");

    // Ambil ID booking dari order_id
    // Contoh format: BOOK-123-1721833293
    $bookingId = explode('-', $orderId)[1] ?? null;

    if (!$bookingId) {
        log_message('error', 'Invalid order_id format');
        return $this->response->setStatusCode(400)->setBody('Invalid format');
    }

    // Cek status transaksi dan update DB jika diperlukan
    if (in_array($transaction, ['capture', 'settlement'])) {
        $this->db->table('booking')
            ->where('id', $bookingId)
            ->update(['status' => 'confirmed', 'pembayaran' => 'midtrans']);
        return $this->response->setStatusCode(200)->setBody('OK');
    }

    // Tambahan: handle status lain jika perlu
    if ($transaction === 'cancel' || $transaction === 'expire') {
        $this->db->table('booking')
            ->where('id', $bookingId)
            ->update(['status' => 'cancelled']);
        return $this->response->setStatusCode(200)->setBody('Expired or Cancelled');
    }

    return $this->response->setStatusCode(200)->setBody('Ignored');
}

}
