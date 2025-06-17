<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQurbanAnimalIdToMeatDistribution extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('meat_distribution', [
            'qurban_animal_id' => [ // This will link to a specific animal (e.g., Sapi A)
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Null for general public distribution
                'after'      => 'qr_code',
            ],
        ]);

        // Add foreign key constraint if you have a separate animals table
        // For now, let's assume 'qurban_animal_id' will simply be a reference without a direct FK for simplicity
        // If you later create an 'animals' table, you can add:
        // $this->forge->addForeignKey('qurban_animal_id', 'animals', 'id', 'SET NULL', 'CASCADE');
    }

    public function down(): void
    {
        $this->forge->dropColumn('meat_distribution', 'qurban_animal_id');
    }
}