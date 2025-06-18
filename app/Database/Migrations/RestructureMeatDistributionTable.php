<?php

    namespace App\Database\Migrations;

    use CodeIgniter\Database\Migration;

    class RestructureMeatDistributionTable extends Migration
    {
        public function up()
        {
            // Hapus kolom meat_weight_kg yang lama
            $this->forge->dropColumn('meat_distribution', 'meat_weight_kg');

            // Tambahkan kolom-kolom baru
            $this->forge->addColumn('meat_distribution', [
                'animal_type' => [
                    'type'       => "ENUM('kambing', 'sapi')",
                    'null'       => false,
                    'after'      => 'distribution_type',
                ],
                'meat_weight_kambing' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,2',
                    'null'       => true, // Bisa null jika yang didistribusi adalah sapi
                    'after'      => 'animal_type',
                ],
                'meat_weight_sapi' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,2',
                    'null'       => true, // Bisa null jika yang didistribusi adalah kambing
                    'after'      => 'meat_weight_kambing',
                ],
            ]);
        }

        public function down()
        {
            // Logika untuk mengembalikan perubahan jika diperlukan
            $this->forge->dropColumn('meat_distribution', ['animal_type', 'meat_weight_kambing', 'meat_weight_sapi']);

            $this->forge->addColumn('meat_distribution', [
                 'meat_weight_kg' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,2',
                    'null' => false,
                ],
            ]);
        }
    }
    