<?php

namespace App\Controllers;

use Midtrans\Config;
use Midtrans\Snap;

class TesSnap extends BaseController
{
    public function index()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = 'Mid-server-2MHjLLN-N5JdZ8NnrAAo6zGR';
        Config::$isProduction = false; // Sandbox mode
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi dummy
        $params = [
            'transaction_details' => [
                'order_id' => uniqid('test-'),
                'gross_amount' => 10000, // nominal total
            ],
            'customer_details' => [
                'first_name' => 'Rizky',
                'email' => 'rizky@example.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $this->response->setJSON(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal mendapatkan Snap Token.',
                'error_detail' => $e->getMessage(),
            ]);
        }
    }
}