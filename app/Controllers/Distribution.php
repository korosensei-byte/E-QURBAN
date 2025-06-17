<?php

namespace App\Controllers;

use App\Models\MeatDistributionModel;
use Myth\Auth\Models\UserModel;
use App\Models\QurbanParticipantModel; // Import QurbanParticipantModel
use chillerlan\QRCode\{QRCode, QROptions};
use CodeIgniter\I18n\Time;

class Distribution extends BaseController
{
    protected $meatDistributionModel;
    protected $userModel;
    protected $qurbanParticipantModel; // Tambahkan

    public function __construct()
    {
        $this->meatDistributionModel = new MeatDistributionModel();
        $this->userModel = new UserModel();
        $this->qurbanParticipantModel = new QurbanParticipantModel(); // Inisialisasi
    }

    public function index()
    {
        // Hanya admin yang bisa mengakses rekapan pembagian daging
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Rekapan Pembagian Daging';
        $data['distributions'] = $this->meatDistributionModel
                                    ->select('meat_distribution.*, users.username, users.email')
                                    ->join('users', 'users.id = meat_distribution.recipient_user_id')
                                    ->findAll();

        return view('distribution/index', $data);
    }

    public function add()
    {
        // Hanya admin yang bisa menambahkan catatan pembagian
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Tambah Catatan Pembagian Daging';
        $data['users'] = $this->userModel->findAll();
        return view('distribution/add', $data);
    }

    public function save()
    {
        // Hanya admin yang bisa menyimpan catatan pembagian
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (! $this->validate([
            'recipient_user_id' => 'required|integer|is_not_unique[users.id]',
            'distribution_type' => 'required|in_list[warga,berqurban,panitia]', // Tetap 'panitia' di sini jika Anda ingin merekam pembagian untuk panitia (namun tidak ada role panitia yang bisa login)
            'meat_weight_kg'    => 'required|numeric|greater_than[0]',
            'distribution_date' => 'required|valid_date[Y-m-d H:i:s]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recipientUserId = $this->request->getPost('recipient_user_id');
        $distributionType = $this->request->getPost('distribution_type');
        $meatWeightKg = $this->request->getPost('meat_weight_kg');
        $distributionDate = $this->request->getPost('distribution_date');

        $qrCodeString = $recipientUserId . '_' . $distributionType . '_' . uniqid();

        $this->meatDistributionModel->save([
            'recipient_user_id' => $recipientUserId,
            'distribution_type' => $distributionType,
            'meat_weight_kg'    => $meatWeightKg,
            'distribution_date' => $distributionDate,
            'status'            => 'pending',
            'qr_code'           => $qrCodeString,
        ]);

        return redirect()->to('/distribution')->with('message', 'Catatan pembagian daging berhasil ditambahkan!');
    }

    public function autoDistributeMeat()
    {
        // Hanya admin yang bisa melakukan otomatisasi pembagian
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $totalMeatWeight = $this->request->getPost('total_meat_weight');
        $qurbanAnimalId = $this->request->getPost('qurban_animal_id');

        if (!$totalMeatWeight || $totalMeatWeight <= 0) {
            return redirect()->back()->with('error', 'Total berat daging harus diisi dan lebih dari 0.');
        }

        // Proporsi pembagian (dapat disesuaikan)
        // Asumsi role 'warga' = warga umum, 'admin' = panitia, 'berqurban' = shohibul qurban
        $wargaPercentage = 0.33;
        $adminPercentage = 0.33;
        $berqurbanPercentage = 0.34;

        $wargaMeatWeight = $totalMeatWeight * $wargaPercentage;
        $adminMeatWeight = $totalMeatWeight * $adminPercentage;
        $berqurbanMeatWeight = $totalMeatWeight * $berqurbanPercentage;

        $wargaUsers = $this->userModel->getUsersInGroup('user'); // Asumsi 'user' adalah warga umum
        $adminUsers = $this->userModel->getUsersInGroup('admin'); // Asumsi 'admin' adalah panitia
        $berqurbanUsers = $this->userModel->getUsersInGroup('berqurban'); // Asumsi 'berqurban' adalah shohibul qurban

        // Fetch actual user objects for getting IDs
        $wargaUserObjects = $this->userModel->whereIn('id', $wargaUsers)->findAll();
        $adminUserObjects = $this->userModel->whereIn('id', $adminUsers)->findAll();
        $berqurbanUserObjects = $this->userModel->whereIn('id', $berqurbanUsers)->findAll();

        $numWarga = count($wargaUserObjects);
        $numAdmin = count($adminUserObjects);
        $numBerqurban = count($berqurbanUserObjects);

        $meatPerWarga = ($numWarga > 0) ? $wargaMeatWeight / $numWarga : 0;
        $meatPerAdmin = ($numAdmin > 0) ? $adminMeatWeight / $numAdmin : 0;
        $meatPerBerqurban = ($numBerqurban > 0) ? $berqurbanMeatWeight / $numBerqurban : 0;

        $dataToInsert = [];
        $distributionDate = Time::now()->toDateTimeString();

        foreach ($wargaUserObjects as $user) {
            $qrCodeString = $user->id . '_warga_' . uniqid();
            $dataToInsert[] = [
                'recipient_user_id' => $user->id,
                'distribution_type' => 'warga',
                'meat_weight_kg'    => round($meatPerWarga, 2),
                'distribution_date' => $distributionDate,
                'status'            => 'pending',
                'qr_code'           => $qrCodeString,
                'qurban_animal_id'  => $qurbanAnimalId,
            ];
        }

        foreach ($adminUserObjects as $user) {
            $qrCodeString = $user->id . '_admin_panitia_' . uniqid(); // Label ini hanya untuk internal QR
            $dataToInsert[] = [
                'recipient_user_id' => $user->id,
                'distribution_type' => 'panitia', // Di database, masih pakai enum 'panitia' untuk admin
                'meat_weight_kg'    => round($meatPerAdmin, 2),
                'distribution_date' => $distributionDate,
                'status'            => 'pending',
                'qr_code'           => $qrCodeString,
                'qurban_animal_id'  => $qurbanAnimalId,
            ];
        }

        foreach ($berqurbanUserObjects as $user) {
            $qrCodeString = $user->id . '_berqurban_' . uniqid();
            $dataToInsert[] = [
                'recipient_user_id' => $user->id,
                'distribution_type' => 'berqurban',
                'meat_weight_kg'    => round($meatPerBerqurban, 2),
                'distribution_date' => $distributionDate,
                'status'            => 'pending',
                'qr_code'           => $qrCodeString,
                'qurban_animal_id'  => $qurbanAnimalId,
            ];
        }

        if (! empty($dataToInsert)) {
            $this->meatDistributionModel->insertBatch($dataToInsert);
            return redirect()->to('/distribution')->with('message', 'Pembagian daging otomatis berhasil dilakukan!');
        } else {
            return redirect()->back()->with('error', 'Tidak ada user yang terdaftar untuk pembagian daging.');
        }
    }

    public function scanQrCode()
    {
        // Hanya admin yang bisa melakukan scan QR
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Scan QR Code Pengambilan Daging';
        return view('distribution/scan', $data);
    }

    public function verifyQrCode()
    {
        // Hanya admin yang bisa memverifikasi QR
        if (! in_groups('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $qrCodeInput = $this->request->getPost('qr_code_input');

        $distribution = $this->meatDistributionModel->where('qr_code', $qrCodeInput)->first();

        if ($distribution) {
            if ($distribution['status'] === 'distributed') {
                return redirect()->back()->with('error', 'Daging sudah diambil sebelumnya.');
            }

            $this->meatDistributionModel->update($distribution['id'], [
                'status' => 'distributed',
                'collected_at' => date('Y-m-d H:i:s'),
                'collected_by_user_id' => user()->id,
            ]);

            $recipient = $this->userModel->find($distribution['recipient_user_id']);

            return redirect()->back()->with('message', 'QR Code valid! Daging berhasil diberikan kepada ' . $recipient->username . ' (' . $distribution['meat_weight_kg'] . ' kg).');
        } else {
            return redirect()->back()->withInput()->with('error', 'QR Code tidak valid.');
        }
    }
}