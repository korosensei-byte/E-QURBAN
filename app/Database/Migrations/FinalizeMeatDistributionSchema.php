<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FinalizeMeatDistributionSchema extends Migration
{
    public function up()
    {
        // Menghapus kolom 'animal_type' karena informasinya
        // bisa didapatkan dari tabel qurban_participants
        if ($this->db->fieldExists('animal_type', 'meat_distribution')) {
            $this->forge->dropColumn('meat_distribution', 'animal_type');
        }
    }

    public function down()
    {
        // Logika untuk mengembalikan kolom jika migrasi di-rollback
        if (!$this->db->fieldExists('animal_type', 'meat_distribution')) {
             $this->forge->addColumn('meat_distribution', [
                'animal_type' => [
                    'type'       => "ENUM('kambing', 'sapi')",
                    'null'       => false,
                    'after'      => 'distribution_type',
                ],
            ]);
        }
    }
}
