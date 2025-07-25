<?php

require_once dirname(__FILE__) . '/vendor/autoload.php'; // sesuaikan path jika di luar folder utama

// Inisialisasi Midtrans
\Midtrans\Config::$serverKey = 'Mid-server-2MHjLLN-N5JdZ8NnrAAo6zGR';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Data order uji coba
$params = [
    'transaction_details' => [
        'order_id' => 'TEST-' . time(),
        'gross_amount' => 10000,
    ],
    'item_details' => [
        [
            'id' => 'ITEM1',
            'price' => 10000,
            'quantity' => 1,
            'name' => 'Test Produk'
        ]
    ],
    'customer_details' => [
        'first_name' => 'Rizky',
        'last_name' => 'Nugraha',
        'email' => 'rizky@example.com',
        'phone' => '081234567890'
    ]
];

// Coba ambil Snap Token
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo "Snap Token berhasil: <br><b>$snapToken</b>";
} catch (Exception $e) {
    echo "Gagal ambil Snap Token:<br><pre>" . print_r($e->getMessage(), true) . "</pre>";
}