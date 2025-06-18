<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReworkTransactionsTable extends Migration
{
    public function up()
    {
        // Menghapus kolom 'transaction_type' dari tabel 'transactions'
        $this->forge->dropColumn('transactions', 'transaction_type');
    }

    public function down()
    {
        // Logika untuk mengembalikan kolom jika migrasi di-rollback
        $this->forge->addColumn('transactions', [
            'transaction_type' => [
                'type' => "ENUM('in','out')",
                'null' => false,
                'after' => 'id',
            ],
        ]);
    }
}