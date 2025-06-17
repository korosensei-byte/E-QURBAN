<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQurbanParticipantsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'animal_type' => [
                'type' => 'ENUM',
                'constraint' => ['kambing', 'sapi'],
                'null' => false,
            ],
            'share_number' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true, // Null for kambing, 1-7 for sapi
            ],
            'payment_status' => [
                'type' => 'ENUM',
                'constraint' => ['paid', 'unpaid'],
                'default' => 'unpaid',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('qurban_participants');
    }

    public function down(): void
    {
        $this->forge->dropTable('qurban_participants');
    }
}