<?php

namespace App\Models;

use CodeIgniter\Model;

class MeatDistributionModel extends Model
{
    protected $table            = 'meat_distribution';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    
    // Sesuaikan dengan struktur tabel baru Anda
    protected $allowedFields    = [
        'recipient_user_id', 
        'distribution_type', 
        'meat_weight_kambing',
        'meat_weight_sapi', 
        'distribution_date', 
        'status', 
        'qr_code', 
        'collected_at', 
        'collected_by_user_id', 
        'qurban_animal_id'
    ];

    // Kode di bawah ini tidak perlu diubah
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = ''; 
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $allowCallbacks = true;
}