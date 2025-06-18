<?php

namespace App\Models;

use CodeIgniter\Model;

class QurbanParticipantModel extends Model
{
    protected $table            = 'qurban_participants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // Or 'object'
    protected $useSoftDeletes   = false;
    // protected $allowedFields    = ['user_id', 'animal_type', 'share_number', 'payment_status', 'qurban_group', 'amount_paid', 'created_at', 'updated_at']; // Tambahkan qurban_group dan amount_paid
    protected $allowedFields    = ['user_id', 'animal_type', 'share_number', 'payment_status', 'qurban_group', 'amount_paid', 'amount_paid_admin', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = '';

    // Validation (tambahkan validasi jika diperlukan di sini)
    protected $validationRules = [
        'user_id'        => 'required|integer|is_not_unique[users.id]',
        'animal_type'    => 'required|in_list[kambing,sapi]',
        'share_number'   => 'permit_empty|integer|less_than_equal_to[7]|greater_than[0]',
        'payment_status' => 'required|in_list[paid,unpaid]',
        'amount_paid'    => 'permit_empty|numeric', // allow empty or numeric
    ];
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