<?php
namespace App\Models;
use CodeIgniter\Model;

class MeatDistributionSapiModel extends Model
{
    protected $table            = 'meat_distribution_sapi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'recipient_user_id', 'distribution_type', 'meat_weight', 
        'distribution_date', 'status', 'qr_code', 'qurban_animal_id', 
        'collected_at', 'collected_by_user_id'
    ];
}