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
        if (!in_groups('admin')) {
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
        if (!in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Qurban Baru';
        $data['users'] = $this->userModel->findAll();
        return view('qurban/add', $data);
    }

    public function save()
    {
        if (!in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $rules = [
            'user_id'        => 'required|integer|is_not_unique[users.id]',
            'animal_type'    => 'required|in_list[kambing,sapi]',
            'payment_status' => 'required|in_list[paid,unpaid]',
        ];

        $animalType = $this->request->getPost('animal_type');
        $qurbanGroupInput = $this->request->getPost('qurban_group');

        if ($animalType === 'sapi') {
            $rules['share_number'] = 'required|integer|less_than_equal_to[7]|greater_than[0]';
        } else { // Jika kambing
            // Grup/Tag untuk kambing wajib diisi, harus unik, dan sesuai format
            $rules['qurban_group'] = 'required|is_unique[qurban_participants.qurban_group]|regex_match[/^[a-zA-Z0-9\s-]+$/]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $shareNumber = $this->request->getPost('share_number');
        $paymentStatus = $this->request->getPost('payment_status');
        
        $amountPaid = 0;
        $description = '';
        $qurbanGroup = null;

        if ($animalType === 'kambing') {
            $amountPaid = 2700000;
            $qurbanGroup = $qurbanGroupInput;
            $description = 'Iuran Qurban Kambing (Grup/Tag: ' . $qurbanGroup . ') oleh ' . $this->userModel->find($userId)->username;
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
            $description = 'Iuran Qurban Sapi (' . $shareNumber . ' bagian) oleh ' . $this->userModel->find($userId)->username;
        }

        $dataToSave = [
            'user_id'        => $userId,
            'animal_type'    => $animalType,
            'share_number'   => $shareNumber,
            'payment_status' => $paymentStatus,
            'qurban_group'   => $qurbanGroup,
            'amount_paid'    => $amountPaid,
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $this->qurbanParticipantModel->save($dataToSave);

        if ($paymentStatus === 'paid') {
            $this->transactionModel->save([
                'transaction_type' => 'in',
                'amount'           => $amountPaid,
                'description'      => $description,
                'related_user_id'  => $userId,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);

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
        if (!in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $participant = $this->qurbanParticipantModel->find($id);

        if (!$participant) {
            return redirect()->to('/qurban')->with('error', 'Peserta qurban tidak ditemukan.');
        }

        if ($participant['payment_status'] === 'paid') {
            return redirect()->to('/qurban')->with('error', 'Pembayaran peserta ini sudah lunas.');
        }

        $this->qurbanParticipantModel->update($id, [
            'payment_status' => 'paid',
            'updated_at'     => date('Y-m-d H:i:s'),
        ]);

        $user = $this->userModel->find($participant['user_id']);
        $description = 'Iuran Qurban ' . ucfirst($participant['animal_type']);
        if ($participant['animal_type'] === 'sapi') {
            $description .= ' (' . $participant['share_number'] . ' bagian)';
        } else {
            $description .= ' (Grup/Tag: ' . $participant['qurban_group'] . ')';
        }
        $description .= ' oleh ' . $user->username . ' (Pembayaran dari Unpaid)';

        $this->transactionModel->save([
            'transaction_type' => 'in',
            'amount'           => $participant['amount_paid'],
            'description'      => $description,
            'related_user_id'  => $user->id,
            'created_at'       => date('Y-m-d H:i:s'),
        ]);

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
