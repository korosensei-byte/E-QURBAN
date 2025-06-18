<?php

namespace App\Controllers;

use App\Models\TransactionModel;
// Tambahkan QurbanParticipantModel untuk menghitung hewan
use App\Models\QurbanParticipantModel;
use CodeIgniter\Controller;

class Financial extends BaseController
{
    protected $transactionModel;
    // Definisikan properti untuk model baru
    protected $qurbanParticipantModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        // Inisialisasi model baru
        $this->qurbanParticipantModel = new QurbanParticipantModel();
    }

public function index()
{
    // Hanya admin yang bisa mengakses rekapan keuangan
    if (! in_groups('admin')) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    $data['title'] = 'Rekapan Keuangan';
    $data['transactions'] = $this->transactionModel->findAll();

    $totalIncome = 0;
    $totalExpense = 0;
    $totalAdminFee = 0; 

    foreach ($data['transactions'] as $transaction) {
        if ($transaction['transaction_type'] === 'in') {
            $totalIncome += $transaction['amount'];
            if (strpos($transaction['description'], 'Administrasi') !== false) {
                $totalAdminFee += $transaction['amount'];
            }
        } else {
            $totalExpense += $transaction['amount'];
        }
    }
    $data['totalIncome'] = $totalIncome;
    $data['totalExpense'] = $totalExpense;
    $data['balance'] = $totalIncome - $totalExpense;
    $data['totalAdminFee'] = $totalAdminFee;

    // Menghitung jumlah kambing yang statusnya sudah lunas
    $data['totalKambing'] = $this->qurbanParticipantModel->where(['animal_type' => 'kambing', 'payment_status' => 'paid'])->countAllResults();

    // Hitung jumlah sapi (berdasarkan grup unik yang sudah lunas)
    $data['totalSapi'] = $this->qurbanParticipantModel->where(['animal_type' => 'sapi', 'payment_status' => 'paid'])->groupBy('qurban_group')->countAllResults();
    
    // --- TAMBAHAN BARU: Definisikan Harga Hewan ---
    $data['hargaKambing'] = 2700000; // Harga sesuai controller Qurban
    $data['hargaSapi'] = 3000000;    // Harga iuran per orang sesuai controller Qurban
    // --- AKHIR TAMBAHAN BARU ---

    return view('financial/index', $data);
}

    public function add()
    {
        // Hanya admin yang bisa menambahkan transaksi
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Tambah Transaksi Keuangan';
        return view('financial/add', $data);
    }

    public function save()
    {
        // Hanya admin yang bisa menyimpan transaksi
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (! $this->validate([
            'transaction_type' => 'required|in_list[in,out]',
            'amount'           => 'required|numeric|greater_than[0]',
            'description'      => 'required|max_length[255]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->transactionModel->save([
            'transaction_type' => $this->request->getPost('transaction_type'),
            'amount'           => $this->request->getPost('amount'),
            'description'      => $this->request->getPost('description'),
            'related_user_id'  => $this->request->getPost('related_user_id') ?: null,
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/financial')->with('message', 'Transaksi berhasil ditambahkan!');
    }
}