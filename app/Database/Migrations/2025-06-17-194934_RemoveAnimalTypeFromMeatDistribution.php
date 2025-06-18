<?php

    namespace App\Database\Migrations;

    use CodeIgniter\Database\Migration;

    class RemoveAnimalTypeFromMeatDistribution extends Migration
    {
        public function up()
        {
            // Perintah untuk menghapus kolom 'animal_type'
            $this->forge->dropColumn('meat_distribution', 'animal_type');
        }

        public function down()
        {
            // Perintah untuk mengembalikan kolom 'animal_type' jika migrasi di-rollback
            $this->forge->addColumn('meat_distribution', [
                'animal_type' => [
                    'type'       => "ENUM('kambing', 'sapi')",
                    'null'       => false,
                    'after'      => 'distribution_type',
                ],
            ]);
        }
    }
    