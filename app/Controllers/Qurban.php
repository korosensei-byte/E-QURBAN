<?php

namespace App\Controllers;

use App\Models\QurbanParticipantModel;
use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;

class Qurban extends BaseController
{
    protected $qurbanParticipantModel;
    protected $transactionModel;
    protected $userModel;

    public function __construct()
    {
        $this->qurbanParticipantModel = new QurbanParticipantModel();
        $this->transactionModel = new TransactionModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Peserta Qurban';
        $data['participants'] = $this->qurbanParticipantModel
            ->select('qurban_participants.*, users.username, users.email')
            ->join('users', 'users.id = qurban_participants.user_id')
            ->findAll();

        // Menghitung total biaya administrasi (Lunas)
        // $totalAdminFeeResult = $this->qurbanParticipantModel
        //     ->where('payment_status', 'paid')
        //     ->selectSum('amount_paid_admin', 'total_admin')
        //     ->first();

        // $data['totalAdminFee'] = $totalAdminFeeResult['total_admin'] ?? 0;

        // --- LOGIKA BARU: Menghitung total biaya qurban (Lunas) ---
        $totalAmountPaidResult = $this->qurbanParticipantModel
            ->where('payment_status', 'paid')
            ->selectSum('amount_paid', 'total_qurban')
            ->first();

        $data['totalAmountPaid'] = $totalAmountPaidResult['total_qurban'] ?? 0;
        // --- AKHIR LOGIKA BARU ---

        return view('qurban/index', $data);
    }

    public function add()
    {
        if (!in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Qurban Baru';
        $data['users'] = $this->userModel->findAll();
        return view('qurban/add', $data);
    }

    public function save()
{
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    // Aturan validasi dasar
    $rules = [
        'user_id'        => 'required|integer|is_not_unique[users.id]',
        'animal_type'    => 'required|in_list[kambing,sapi]',
        'payment_status' => 'required|in_list[paid,unpaid]',
    ];

    $animalType = $this->request->getPost('animal_type');

    if ($animalType === 'sapi') {
        $rules['share_number'] = 'required|integer|less_than_equal_to[7]|greater_than[0]';
    } else {
        $rules['animal_tag'] = 'required|is_unique[qurban_participants.animal_tag]|regex_match[/^[a-zA-Z0-9\s-]+$/]';
    }

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $userId = $this->request->getPost('user_id');
    $shareNumber = $this->request->getPost('share_number');
    $paymentStatus = $this->request->getPost('payment_status');
    $animalTagInput = $this->request->getPost('animal_tag');

    $amountPaid = 0;
    $adminFee = 0;
    $qurbanGroup = null;
    $animalTag = null;

    if ($animalType === 'kambing') {
        $amountPaid = 2700000;
        $adminFee = 50000;
        $animalTag = $animalTagInput;
    } elseif ($animalType === 'sapi') {
        $existingCowParticipants = $this->qurbanParticipantModel->where('animal_type', 'sapi')->findAll();
        $totalSharesFilled = 0;
        foreach ($existingCowParticipants as $participant) {
            $totalSharesFilled += (int)$participant['share_number'];
        }

        $nextCowGroupNumber = floor($totalSharesFilled / 7) + 1;
        $qurbanGroup = 'Sapi ' . chr(64 + $nextCowGroupNumber);

        $currentGroupSharesResult = $this->qurbanParticipantModel->where(['animal_type' => 'sapi', 'qurban_group' => $qurbanGroup])->selectSum('share_number')->first();
        $currentGroupShares = $currentGroupSharesResult['share_number'] ?? 0;
        
        if (($currentGroupShares + $shareNumber) > 7) {
            $nextCowGroupNumber++;
            $qurbanGroup = 'Sapi ' . chr(64 + $nextCowGroupNumber);
        }
        
        $amountPaid = 3000000 * (int)$shareNumber;
        $adminFee = 100000;
    }

    $dataToSave = [
        'user_id'             => $userId,
        'animal_type'         => $animalType,
        'share_number'        => $animalType === 'sapi' ? $shareNumber : null,
        'payment_status'      => $paymentStatus,
        'qurban_group'        => $qurbanGroup,
        'animal_tag'          => $animalTag,
        'amount_paid'         => $amountPaid,
        'amount_paid_admin'   => $adminFee,
        'created_at'          => date('Y-m-d H:i:s'),
    ];

    $this->qurbanParticipantModel->save($dataToSave);

    // BLOK KODE YANG MENCATAT TRANSAKSI TELAH DIHAPUS DARI SINI
    
    return redirect()->to('/qurban')->with('message', 'Data peserta qurban berhasil ditambahkan!');
}
    public function markAsPaid($id = null)
{
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }

    $participant = $this->qurbanParticipantModel->find($id);

    if (!$participant) {
        return redirect()->to('/qurban')->with('error', 'Peserta qurban tidak ditemukan.');
    }

    if ($participant['payment_status'] === 'paid') {
        return redirect()->to('/qurban')->with('error', 'Pembayaran peserta ini sudah lunas.');
    }

    // HANYA UPDATE STATUS, TIDAK ADA LAGI LOGIKA INSERT KE TABEL TRANSACTIONS
    $this->qurbanParticipantModel->update($id, [
        'payment_status' => 'paid',
        'updated_at'     => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to('/qurban')->with('message', 'Status pembayaran berhasil diubah menjadi LUNAS!');
}
    public function delete($id = null)
    {
        // 1. Pastikan hanya admin yang bisa mengakses
        if (!in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
        }

        // 2. Gunakan model untuk menghapus data dari database berdasarkan ID
        $this->qurbanParticipantModel->delete($id);

        // 3. Buat pesan sukses untuk ditampilkan
        session()->setFlashdata('message', 'Data peserta qurban berhasil dihapus.');

        // 4. Arahkan kembali pengguna ke halaman daftar qurban
        return redirect()->to('/qurban');
    }
}
