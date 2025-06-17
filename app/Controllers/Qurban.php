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
        if (! in_groups('admin') && ! in_groups('panitia')) {
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
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Daftar Qurban Baru';
        $data['users'] = $this->userModel->findAll(); // Untuk dropdown user
        return view('qurban/add', $data);
    }

    public function save()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (! $this->validate([
            'user_id' => 'required|integer|is_not_unique[users.id]',
            'animal_type' => 'required|in_list[kambing,sapi]',
            'share_number' => 'permit_empty|integer|less_than_equal_to[7]|greater_than[0]', // Only for sapi
            'payment_status' => 'required|in_list[paid,unpaid]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->request->getPost('user_id');
        $animalType = $this->request->getPost('animal_type');
        $shareNumber = $this->request->getPost('share_number');
        $paymentStatus = $this->request->getPost('payment_status');

        // Validasi tambahan untuk sapi
        if ($animalType === 'sapi') {
            if (empty($shareNumber)) {
                return redirect()->back()->withInput()->with('errors', ['share_number' => 'Jumlah bagian sapi wajib diisi.']);
            }
            // Cek apakah user sudah terdaftar qurban sapi dengan bagian yang sama
            $existingShare = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'sapi', 'share_number' => $shareNumber])->first();
            if ($existingShare) {
                return redirect()->back()->withInput()->with('errors', ['share_number' => 'User ini sudah terdaftar qurban sapi dengan bagian yang sama.']);
            }
        } else {
            $shareNumber = null; // Pastikan null jika kambing
            // Cek apakah user sudah terdaftar qurban kambing
            $existingKambing = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'kambing'])->first();
            if ($existingKambing) {
                return redirect()->back()->withInput()->with('errors', ['user_id' => 'User ini sudah terdaftar qurban kambing.']);
            }
        }


        $this->qurbanParticipantModel->save([
            'user_id' => $userId,
            'animal_type' => $animalType,
            'share_number' => $shareNumber,
            'payment_status' => $paymentStatus,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Tambahkan transaksi keuangan jika status paid
        if ($paymentStatus === 'paid') {
            $amount = 0;
            $description = '';
            if ($animalType === 'kambing') {
                $amount = 2700000;
                $description = 'Iuran Qurban Kambing oleh ' . $this->userModel->find($userId)->username;
                // Tambahkan biaya administrasi kambing
                $this->transactionModel->save([
                    'transaction_type' => 'in',
                    'amount'           => 50000,
                    'description'      => 'Administrasi Qurban Kambing oleh ' . $this->userModel->find($userId)->username,
                    'related_user_id'  => $userId,
                    'created_at'       => date('Y-m-d H:i:s'),
                ]);
            } elseif ($animalType === 'sapi') {
                $amount = 3000000 * $shareNumber; // assuming 3jt per share
                $description = 'Iuran Qurban Sapi (' . $shareNumber . ' bagian) oleh ' . $this->userModel->find($userId)->username;
                // Tambahkan biaya administrasi sapi (hanya sekali per sapi)
                // Logika ini perlu disesuaikan jika biaya admin sapi adalah per sapi bukan per bagian
                // Untuk saat ini, asumsikan biaya admin sapi adalah per sapi, dan dicatat saat sapi dibeli.
                // Jika mau perbagian, maka harus dihitung perbagiannya.
            }

            $this->transactionModel->save([
                'transaction_type' => 'in',
                'amount'           => $amount,
                'description'      => $description,
                'related_user_id'  => $userId,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/qurban')->with('message', 'Data peserta qurban berhasil ditambahkan!');
    }
}