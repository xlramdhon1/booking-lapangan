<?php

namespace App\Models;
use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'no_hp', 'email', 'alamat'];
}
