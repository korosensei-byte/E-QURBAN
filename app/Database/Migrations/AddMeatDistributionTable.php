<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMeatDistributionTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'recipient_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'distribution_type' => [
                'type' => 'ENUM',
                'constraint' => ['warga', 'berqurban', 'panitia'],
                'null' => false,
            ],
            'meat_weight_kg' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => false,
            ],
            'distribution_date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['distributed', 'pending'],
                'default' => 'pending',
                'null' => false,
            ],
            'qr_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'unique' => true,
                'null' => true,
            ],
            'collected_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'collected_by_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('recipient_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('collected_by_user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('meat_distribution');
    }

    public function down(): void
    {
        $this->forge->dropTable('meat_distribution');
    }
}