<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeparateDistributionTables extends Migration
{
    public function up()
    {
        // Hapus tabel lama jika ada
        $this->forge->dropTable('meat_distribution', true);

        // 1. Buat tabel untuk distribusi KAMBING
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'recipient_user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'distribution_type' => ['type' => "ENUM('warga','berqurban','panitia')", 'null' => false],
            'meat_weight' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'distribution_date' => ['type' => 'DATETIME', 'null' => false],
            'status' => ['type' => "ENUM('distributed','pending')", 'default' => 'pending', 'null' => false],
            'qr_code' => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true, 'null' => true],
            'qurban_animal_id' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true], // Untuk menyimpan tag kambing
            'collected_at' => ['type' => 'DATETIME', 'null' => true],
            'collected_by_user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('recipient_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('meat_distribution_kambing');

        // 2. Buat tabel untuk distribusi SAPI
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'recipient_user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'distribution_type' => ['type' => "ENUM('warga','berqurban','panitia')", 'null' => false],
            'meat_weight' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => false],
            'distribution_date' => ['type' => 'DATETIME', 'null' => false],
            'status' => ['type' => "ENUM('distributed','pending')", 'default' => 'pending', 'null' => false],
            'qr_code' => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true, 'null' => true],
            'qurban_animal_id' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true], // Untuk menyimpan grup sapi
            'collected_at' => ['type' => 'DATETIME', 'null' => true],
            'collected_by_user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('recipient_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('meat_distribution_sapi');
    }

    public function down()
    {
        // Logika untuk mengembalikan perubahan jika diperlukan
        $this->forge->dropTable('meat_distribution_kambing', true);
        $this->forge->dropTable('meat_distribution_sapi', true);
        
        // (Optional) Buat kembali tabel meat_distribution yang lama jika di-rollback
        // ... kode untuk membuat ulang tabel lama bisa ditambahkan di sini
    }
}