<?php

namespace App\Controllers;

use App\Models\TransactionModel; // Import model transaksi
use CodeIgniter\Controller;

class Financial extends BaseController
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Rekapan Keuangan';
        $data['transactions'] = $this->transactionModel->findAll();

        // Hitung total pemasukan dan pengeluaran
        $totalIncome = 0;
        $totalExpense = 0;
        foreach ($data['transactions'] as $transaction) {
            if ($transaction['transaction_type'] === 'in') {
                $totalIncome += $transaction['amount'];
            } else {
                $totalExpense += $transaction['amount'];
            }
        }
        $data['totalIncome'] = $totalIncome;
        $data['totalExpense'] = $totalExpense;
        $data['balance'] = $totalIncome - $totalExpense;

        return view('financial/index', $data);
    }

    public function add()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Tambah Transaksi Keuangan';
        return view('financial/add', $data);
    }

    public function save()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (! $this->validate([
            'transaction_type' => 'required|in_list[in,out]',
            'amount'           => 'required|numeric|greater_than[0]',
            'description'      => 'required|max_length[255]',
            // 'related_user_id' => 'permit_empty|integer', // Optional, will be handled by form
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->transactionModel->save([
            'transaction_type' => $this->request->getPost('transaction_type'),
            'amount'           => $this->request->getPost('amount'),
            'description'      => $this->request->getPost('description'),
            'related_user_id'  => $this->request->getPost('related_user_id') ?: null,
            'created_at'       => date('Y-m-d H:i:s'), // Set current timestamp
        ]);

        return redirect()->to('/financial')->with('message', 'Transaksi berhasil ditambahkan!');
    }
}