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
    // Hanya admin yang bisa mengakses
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    $data['title'] = 'Rekapan Keuangan Administrasi';

    // Ambil SEMUA data pengeluaran dari tabel transactions
    $data['transactions'] = $this->transactionModel->findAll();

    // Hitung Total Dana Administrasi dari tabel qurban_participants (yang sudah lunas)
    $totalAdminFeeResult = $this->qurbanParticipantModel
        ->where('payment_status', 'paid')
        ->selectSum('amount_paid_admin', 'total_admin')
        ->first();
    $totalAdminFee = $totalAdminFeeResult['total_admin'] ?? 0;

    // Hitung Total Pengeluaran dari tabel transactions
    $totalExpenseResult = $this->transactionModel
        ->selectSum('amount', 'total_expense')
        ->first();
    $totalExpense = $totalExpenseResult['total_expense'] ?? 0;

    // Kirim data ke view
    $data['totalAdminFee'] = $totalAdminFee;
    $data['totalExpense'] = $totalExpense;
    $data['balance'] = $totalAdminFee - $totalExpense; // Saldo adalah Dana Admin - Pengeluaran

    return view('financial/index', $data);
}

    public function add()
    {
        // Hanya admin yang bisa menambahkan transaksi
        // if (! in_groups('admin')) {
        if (! in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Tambah Transaksi Keuangan';
        return view('financial/add', $data);
    }

    public function save()
{
    // Hanya admin yang bisa menyimpan transaksi
    // if (! in_groups('admin')) {
    if (! in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Validasi sekarang tidak memerlukan 'transaction_type'
    if (! $this->validate([
        'amount'           => 'required|numeric|greater_than[0]',
        'description'      => 'required|max_length[255]',
    ])) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // Menyimpan data pengeluaran. Tidak ada lagi 'transaction_type'.
    $this->transactionModel->save([
        'amount'           => $this->request->getPost('amount'),
        'description'      => $this->request->getPost('description'),
        'related_user_id'  => user()->id, // Mencatat siapa admin yg input
        'created_at'       => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/financial')->with('message', 'Data pengeluaran berhasil ditambahkan!');
}

    public function delete($id = null)
{
    // 1. Pastikan hanya admin yang bisa mengakses
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
    }

    // 2. Gunakan model transaksi untuk menghapus data berdasarkan ID
    $this->transactionModel->delete($id);

    // 3. Buat pesan sukses untuk ditampilkan
    session()->setFlashdata('message', 'Transaksi berhasil dihapus.');

    // 4. Arahkan kembali pengguna ke halaman rekapan keuangan
    return redirect()->to('/financial');
}
}