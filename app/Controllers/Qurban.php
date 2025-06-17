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
        // Hanya admin yang bisa mengakses manajemen qurban
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Peserta Qurban';
        $data['participants'] = $this->qurbanParticipantModel
                                ->select('qurban_participants.*, users.username, users.email')
                                ->join('users', 'users.id = qurban_participants.user_id')
                                ->findAll();

        return view('qurban/index', $data);
    }

    public function add()
    {
        // Hanya admin yang bisa menambahkan qurban
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Qurban Baru';
        $data['users'] = $this->userModel->findAll();
        return view('qurban/add', $data);
    }

    public function save()
    {
        // Hanya admin yang bisa menyimpan data qurban
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $rules = [
            'user_id'        => 'required|integer|is_not_unique[users.id]',
            'animal_type'    => 'required|in_list[kambing,sapi]',
            'payment_status' => 'required|in_list[paid,unpaid]',
        ];

        if ($this->request->getPost('animal_type') === 'sapi') {
            $rules['share_number'] = 'required|integer|less_than_equal_to[7]|greater_than[0]';
        } else {
            $rules['share_number'] = 'permit_empty';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $animalType = $this->request->getPost('animal_type');
        $shareNumber = $this->request->getPost('share_number');
        $paymentStatus = $this->request->getPost('payment_status');
        $amountPaid = 0;
        $description = '';
        $qurbanGroup = null;

        // Logika Biaya dan Grouping
        if ($animalType === 'kambing') {
            // Cek apakah user sudah terdaftar qurban kambing
            $existingKambing = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'kambing'])->first();
            if ($existingKambing) {
                return redirect()->back()->withInput()->with('errors', ['user_id' => 'User ini sudah terdaftar qurban kambing.']);
            }
            $amountPaid = 2700000;
            $description = 'Iuran Qurban Kambing oleh ' . $this->userModel->find($userId)->username;

        } elseif ($animalType === 'sapi') {
            $existingCowParticipants = $this->qurbanParticipantModel->where('animal_type', 'sapi')->findAll();
            $totalSharesFilled = 0;
            foreach ($existingCowParticipants as $participant) {
                $totalSharesFilled += $participant['share_number'];
            }

            $nextCowGroupNumber = floor($totalSharesFilled / 7) + 1;
            $qurbanGroup = 'Sapi ' . chr(64 + $nextCowGroupNumber);

            $currentGroupShares = $this->qurbanParticipantModel->where(['animal_type' => 'sapi', 'qurban_group' => $qurbanGroup])->selectSum('share_number')->first()['share_number'];
            if (($currentGroupShares + $shareNumber) > 7) {
                $nextCowGroupNumber++;
                $qurbanGroup = 'Sapi ' . chr(64 + $nextCowGroupNumber);
            }

            $amountPaid = 3000000 * $shareNumber;
            $description = 'Iuran Qurban Sapi (' . $shareNumber . ' bagian) oleh ' . $this->userModel->find($userId)->username;
        }

        $this->qurbanParticipantModel->save([
            'user_id'        => $userId,
            'animal_type'    => $animalType,
            'share_number'   => $shareNumber,
            'payment_status' => $paymentStatus,
            'qurban_group'   => $qurbanGroup,
            'amount_paid'    => $amountPaid,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        // Tambahkan biaya administrasi ke transaksi keuangan jika status paid
        if ($paymentStatus === 'paid') {
            $this->transactionModel->save([
                'transaction_type' => 'in',
                'amount'           => $amountPaid,
                'description'      => $description,
                'related_user_id'  => $userId,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);

            // Biaya administrasi terpisah
            $adminFee = ($animalType === 'kambing') ? 50000 : 100000;
            $this->transactionModel->save([
                'transaction_type' => 'in',
                'amount'           => $adminFee,
                'description'      => 'Administrasi Qurban ' . ucfirst($animalType) . ' oleh ' . $this->userModel->find($userId)->username,
                'related_user_id'  => $userId,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/qurban')->with('message', 'Data peserta qurban berhasil ditambahkan!');
    }

    public function markAsPaid($id = null)
    {
        // Hanya admin yang bisa mengubah status pembayaran
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if ($id === null) {
            return redirect()->to('/qurban')->with('error', 'ID peserta qurban tidak ditemukan.');
        }

        $participant = $this->qurbanParticipantModel->find($id);

        if (!$participant) {
            return redirect()->to('/qurban')->with('error', 'Peserta qurban tidak ditemukan.');
        }

        if ($participant['payment_status'] === 'paid') {
            return redirect()->to('/qurban')->with('error', 'Pembayaran peserta ini sudah lunas.');
        }

        // Update status pembayaran
        $this->qurbanParticipantModel->update($id, [
            'payment_status' => 'paid',
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        // Catat transaksi keuangan untuk pembayaran ini
        $user = $this->userModel->find($participant['user_id']);
        $description = 'Iuran Qurban ' . ucfirst($participant['animal_type']);
        if ($participant['animal_type'] === 'sapi') {
            $description .= ' (' . $participant['share_number'] . ' bagian)';
        }
        $description .= ' oleh ' . $user->username . ' (Pembayaran dari Unpaid)';

        $this->transactionModel->save([
            'transaction_type' => 'in',
            'amount'           => $participant['amount_paid'],
            'description'      => $description,
            'related_user_id'  => $user->id,
            'created_at'       => date('Y-m-d H:i:s'), // Tanggal transaksi saat ini
        ]);

        // Tambahkan biaya administrasi jika belum tercatat (saat pertama kali paid)
        // Ini asumsi biaya administrasi hanya dicatat sekali per pendaftaran qurban
        // Jika Anda ingin memastikan biaya admin dicatat hanya sekali, Anda bisa menambahkan flag di qurban_participants
        // atau mencari transaksi adminfee yang terkait dengan user ini dan jenis hewan ini.
        // Untuk kesederhanaan, kita akan mencatatnya lagi jika payment_status sebelumnya unpaid.
        $adminFee = ($participant['animal_type'] === 'kambing') ? 50000 : 100000;
        $this->transactionModel->save([
            'transaction_type' => 'in',
            'amount'           => $adminFee,
            'description'      => 'Administrasi Qurban ' . ucfirst($participant['animal_type']) . ' oleh ' . $user->username . ' (Pembayaran dari Unpaid)',
            'related_user_id'  => $user->id,
            'created_at'       => date('Y-m-d H:i:s'),
        ]);


        return redirect()->to('/qurban')->with('message', 'Status pembayaran berhasil diubah menjadi LUNAS dan transaksi keuangan dicatat!');
    }
}