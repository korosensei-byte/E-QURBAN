<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnimalTagToQurbanParticipants extends Migration
{
    public function up()
    {
        $this->forge->addColumn('qurban_participants', [
            'animal_tag' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true, // Bisa null karena sapi menggunakan qurban_group
                'unique'     => true, // Setiap tag harus unik
                'after'      => 'qurban_group',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('qurban_participants', 'animal_tag');
    }
}