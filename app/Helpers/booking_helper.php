<?php

use App\Models\BookingModel;

function isConflictBooking($lapangan_id, $tanggal, $jam_mulai, $durasi, $booking_id = null)
{
    $bookingModel = new BookingModel();

    $startTime = strtotime("$tanggal $jam_mulai");
    $endTime = strtotime("+$durasi hour", $startTime);

    $builder = $bookingModel
        ->where('lapangan_id', $lapangan_id)
        ->where('tanggal_booking >=', $tanggal . ' 00:00:00')
        ->where('tanggal_booking <=', $tanggal . ' 23:59:59');

    if ($booking_id) {
        $builder->where('id !=', $booking_id);
    }

    $existingBookings = $builder->findAll();

    foreach ($existingBookings as $b) {
        $existingStart = strtotime($b['tanggal_booking'] . ' ' . $b['jam_mulai']);
        $existingEnd = strtotime("+{$b['durasi']} hour", $existingStart);

        if ($startTime < $existingEnd && $endTime > $existingStart) {
            return true; // Bentrok
        }
    }

    return false;
}


