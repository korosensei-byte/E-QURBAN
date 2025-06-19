<?php

namespace App\Controllers;

use App\Models\MeatDistributionModel;
use App\Models\QurbanParticipantModel;
use App\Models\TransactionModel;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;
use chillerlan\QRCode\{QRCode, QROptions};

class User extends BaseController
{
    protected $meatDistributionModel;
    protected $kambingDistModel; // Tambahkan ini
protected $sapiDistModel;    // Tambahkan ini
    protected $qurbanParticipantModel;
    protected $transactionModel;
    protected $userModel;
    protected $groupModel;
    protected $db; // Tambahkan properti database connection

    

    public function __construct()
    {
        $this->meatDistributionModel = new MeatDistributionModel();
        $this->kambingDistModel = new \App\Models\MeatDistributionKambingModel(); // Tambahkan ini
    $this->sapiDistModel = new \App\Models\MeatDistributionSapiModel();       // Tambahkan ini
        $this->qurbanParticipantModel = new QurbanParticipantModel();
        $this->transactionModel = new TransactionModel();
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect(); // Inisialisasi koneksi database
    }

    // public function index(): string
    // {
    //     $data['title'] = "My Profile";
    //     $data['user_distributions'] = $this->meatDistributionModel->where('recipient_user_id', user()->id)->findAll();
    //     $data['user_qurbans'] = $this->qurbanParticipantModel->where('user_id', user()->id)->findAll();
    //     return view('user/index', $data);
    // }
    public function index(): string
{
    $data['title'] = "My Profile";
    $userId = user()->id;

    // 1. Ambil data jatah daging kambing untuk user ini
    $kambingDistributions = $this->kambingDistModel->where('recipient_user_id', $userId)->findAll();
    // Tambahkan penanda tipe hewan untuk setiap record
    foreach ($kambingDistributions as &$dist) {
        $dist['animal_type'] = 'kambing';
    }

    // 2. Ambil data jatah daging sapi untuk user ini
    $sapiDistributions = $this->sapiDistModel->where('recipient_user_id', $userId)->findAll();
    // Tambahkan penanda tipe hewan untuk setiap record
    foreach ($sapiDistributions as &$dist) {
        $dist['animal_type'] = 'sapi';
    }

    // 3. Gabungkan kedua hasil menjadi satu array
    $data['user_distributions'] = array_merge($kambingDistributions, $sapiDistributions);

    // Ambil data riwayat qurban user
    $data['user_qurbans'] = $this->qurbanParticipantModel->where('user_id', $userId)->findAll();

    return view('user/index', $data);
}

    public function myQrCard()
{
    $data['title'] = "Kartu Pengambilan Daging";
    $userId = user()->id;

    // 1. Ambil data jatah daging kambing untuk user ini
    $kambingDistributions = $this->kambingDistModel->where('recipient_user_id', $userId)->findAll();
    // Tambahkan penanda tipe hewan
    foreach ($kambingDistributions as &$dist) {
        $dist['animal_type'] = 'kambing';
    }

    // 2. Ambil data jatah daging sapi untuk user ini
    $sapiDistributions = $this->sapiDistModel->where('recipient_user_id', $userId)->findAll();
    // Tambahkan penanda tipe hewan
    foreach ($sapiDistributions as &$dist) {
        $dist['animal_type'] = 'sapi';
    }

    // 3. Gabungkan kedua hasil menjadi satu array
    $data['user_distributions'] = array_merge($kambingDistributions, $sapiDistributions);

    return view('user/my_qr_card', $data);
}

//    public function generateQrCodeForUser($qrCodeData)
// {
//     // Mulai output buffering untuk menangkap semua output
//     ob_start();

//     // Opsi untuk QR Code tetap sama
//     $options = new QROptions([
//         'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'         => QRCode::ECC_L,
//         'scale'            => 5,
//         'imageTransparent' => false,
//     ]);

//     // Proses render QR code, outputnya akan ditangkap oleh buffer
//     (new QRCode($options))->render($qrCodeData);

//     // Ambil data gambar dari buffer dan simpan ke variabel
//     $imageData = ob_get_contents();

//     // Hentikan dan bersihkan buffer (membuang semua output yang tidak diinginkan)
//     ob_end_clean();

//     // Setelah buffer bersih, sekarang kita bisa kirim header dengan aman
//     header('Content-Type: image/png');
//     header('Content-Length: ' . strlen($imageData)); // Header tambahan yang baik untuk performa
//     header('Cache-Control: no-cache');

//     // Tampilkan data gambar murni ke browser
//     echo $imageData;

//     exit; // Tetap gunakan exit untuk memastikan tidak ada output lain dari framework
// }

// app/Controllers/User.php

public function generateQrCodeForUser($qrCodeData)
{
    // BUG FIX: Tambahkan urldecode() untuk data dari URL
    $decodedQrData = urldecode($qrCodeData);

    $options = new QROptions([
        'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel'         => QRCode::ECC_L,
        'scale'            => 5,
        'imageTransparent' => false,
    ]);

    try {
        // Render data yang sudah di-decode
        $imageData = (new QRCode($options))->render($decodedQrData);

        // Gunakan Response object
        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader('Content-Length', (string) strlen($imageData))
            ->setHeader('Cache-Control', 'no-cache')
            ->setBody($imageData);

    } catch (\Exception $e) {
        log_message('error', 'User QR Code generation failed: ' . $e->getMessage());
        return $this->response->setStatusCode(500, 'Error generating user QR code image.');
    }
}

    public function registerQurban()
    {
        $data['title'] = "Daftar Qurban";
        $data['user_qurbans'] = $this->qurbanParticipantModel->where('user_id', user()->id)->findAll();

        // Cek apakah user sudah memiliki role 'berqurban' dengan query manual
        $berqurbanGroup = $this->groupModel->where('name', 'berqurban')->first();
        $isBerqurban = false;
        if ($berqurbanGroup) {
            $userInGroup = $this->db->table('auth_groups_users')
                                    ->where('user_id', user()->id)
                                    ->where('group_id', $berqurbanGroup->id)
                                    ->countAllResults();
            if ($userInGroup > 0) {
                $isBerqurban = true;
            }
        }
        $data['isBerqurban'] = $isBerqurban;

        return view('user/register_qurban', $data);
    }

public function saveRegisterQurban()
{
    // Pastikan user sudah login
    if (!logged_in()) {
        return redirect()->to('/login')->with('error', 'Anda harus login untuk mendaftar qurban.');
    }

    // Dapatkan ID user yang sedang login
    $userId = user()->id;

    $rules = [
        'animal_type'    => 'required|in_list[kambing,sapi]',
    ];

    if ($this->request->getPost('animal_type') === 'sapi') {
        $rules['share_number'] = 'required|integer|less_than_equal_to[7]|greater_than[0]';
    } else {
        $rules['share_number'] = 'permit_empty';
    }

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $animalType = $this->request->getPost('animal_type');
    $shareNumber = $this->request->getPost('share_number');
    
    // Inisialisasi variabel biaya
    $amountPaid = 0;
    $adminFee = 0; // Variabel baru untuk biaya admin
    $qurbanGroup = null;

    if ($animalType === 'kambing') {
        $existingKambing = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'kambing'])->first();
        if ($existingKambing) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban kambing.');
        }
        $amountPaid = 2700000;
        $adminFee = 50000; // Biaya admin untuk kambing

    } elseif ($animalType === 'sapi') {
        $existingCowParticipantsForUser = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'sapi'])->findAll();
        if (!empty($existingCowParticipantsForUser) && $shareNumber <= 0) {
             return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban sapi. Jika ingin menambah bagian, masukkan jumlah bagian yang valid.');
        }

        $lastCowGroup = $this->qurbanParticipantModel->where('animal_type', 'sapi')->orderBy('qurban_group', 'DESC')->first();
        $lastCowNumber = 0;
        if ($lastCowGroup) {
            preg_match('/Sapi ([A-Z])/', $lastCowGroup['qurban_group'], $matches);
            if (!empty($matches)) {
                $lastCowNumber = ord($matches[1]) - ord('A');
            }
        }

        $qurbanGroup = 'Sapi ' . chr(65 + $lastCowNumber);

        if ($lastCowGroup) {
            $currentGroupShares = $this->qurbanParticipantModel->where(['animal_type' => 'sapi', 'qurban_group' => $lastCowGroup['qurban_group']])->selectSum('share_number')->first()['share_number'];
            if (($currentGroupShares + $shareNumber) > 7) {
                $lastCowNumber++;
                $qurbanGroup = 'Sapi ' . chr(65 + $lastCowNumber);
            } else {
                $qurbanGroup = $lastCowGroup['qurban_group'];
            }
        } else {
            $qurbanGroup = 'Sapi A';
        }

        $existingShareInGroup = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'sapi', 'qurban_group' => $qurbanGroup, 'share_number' => $shareNumber])->first();
        if ($existingShareInGroup) {
            return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban sapi dengan bagian yang sama di grup ini. Jika ingin menambah bagian, pilih jumlah bagian yang berbeda atau hubungi admin.');
        }

        $amountPaid = 3000000 * $shareNumber;
        $adminFee = 100000; // Biaya admin untuk sapi
    }

    // Simpan data qurban, TERMASUK biaya admin
    $this->qurbanParticipantModel->save([
        'user_id'             => $userId,
        'animal_type'         => $animalType,
        'share_number'        => $shareNumber,
        'payment_status'      => 'unpaid',
        'qurban_group'        => $qurbanGroup,
        'amount_paid'         => $amountPaid,
        'amount_paid_admin'   => $adminFee, // Simpan biaya admin di sini
        'created_at'          => date('Y-m-d H:i:s'),
    ]);

    // Tambahkan user ke group 'berqurban'
    $berqurbanGroup = $this->groupModel->where('name', 'berqurban')->first();
    if ($berqurbanGroup) {
        $userInGroupCheck = $this->db->table('auth_groups_users')
                                    ->where('user_id', $userId)
                                    ->where('group_id', $berqurbanGroup->id)
                                    ->countAllResults();
        if ($userInGroupCheck === 0) {
            $this->groupModel->addUserToGroup($userId, $berqurbanGroup->id);
        }
    }

    return redirect()->to('/user')->with('message', 'Pendaftaran qurban Anda berhasil! Silakan lakukan pembayaran agar status menjadi lunas.');
}
}