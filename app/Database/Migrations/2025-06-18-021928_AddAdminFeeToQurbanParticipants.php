<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminFeeToQurbanParticipants extends Migration
{
    public function up()
    {
        $this->forge->addColumn('qurban_participants', [
            'amount_paid_admin' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'after'      => 'amount_paid', // Letakkan kolom ini setelah 'amount_paid'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('qurban_participants', 'amount_paid_admin');
    }
}