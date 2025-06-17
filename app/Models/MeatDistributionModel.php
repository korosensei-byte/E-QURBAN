<?php

namespace App\Models;

use CodeIgniter\Model;

class MeatDistributionModel extends Model
{
    protected $table            = 'meat_distribution';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Or 'object'
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['recipient_user_id', 'distribution_type', 'meat_weight_kg', 'distribution_date', 'status', 'qr_code', 'collected_at', 'collected_by_user_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = ''; // No created_at for this table
    protected $updatedField  = ''; // No updated_at for this table
    protected $deletedField  = '';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}