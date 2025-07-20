<?php 

namespace App\Models;
use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pelanggan_id', 'lapangan_id', 'tanggal_booking', 'jam_mulai', 'durasi', 'status', 'total_bayar'];
    protected $useTimestamps = true; // supaya otomatis update created_at dan updated_at
}
