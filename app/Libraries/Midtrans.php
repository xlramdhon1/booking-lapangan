<?php

namespace App\Libraries;

use Midtrans\Config;

class MidtransConfig
{
    public static function init()
    {
        Config::$serverKey = 'Mid-server-2MHjLLN-N5JdZ8NnrAAo6zGR'; 

        // Menggunakan Sanbox jadi
        Config::$isProduction = false;

        // Optional
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}