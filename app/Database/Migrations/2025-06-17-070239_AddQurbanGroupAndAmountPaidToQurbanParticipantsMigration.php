<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddQurbanGroupAndAmountPaidToQurbanParticipants extends Migration
{
    public function up(): void
    {
        $this->forge->addColumn('qurban_participants', [
            'qurban_group' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true, // Can be null for 'kambing'
                'after'      => 'share_number',
            ],
            'amount_paid' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'after'      => 'payment_status',
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->dropColumn('qurban_participants', 'qurban_group');
        $this->forge->dropColumn('qurban_participants', 'amount_paid');
    }
}