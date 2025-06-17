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
    protected $qurbanParticipantModel;
    protected $transactionModel;
    protected $userModel;
    protected $groupModel;
    protected $db; // Tambahkan properti database connection

    public function __construct()
    {
        $this->meatDistributionModel = new MeatDistributionModel();
        $this->qurbanParticipantModel = new QurbanParticipantModel();
        $this->transactionModel = new TransactionModel();
        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect(); // Inisialisasi koneksi database
    }

    public function index(): string
    {
        $data['title'] = "My Profile";
        $data['user_distributions'] = $this->meatDistributionModel->where('recipient_user_id', user()->id)->findAll();
        $data['user_qurbans'] = $this->qurbanParticipantModel->where('user_id', user()->id)->findAll();
        return view('user/index', $data);
    }

    public function myQrCard()
    {
        $data['title'] = "Kartu Pengambilan Daging";
        $data['user_distributions'] = $this->meatDistributionModel->where('recipient_user_id', user()->id)->findAll();

        return view('user/my_qr_card', $data);
    }

    public function generateQrCodeForUser($qrCodeData)
    {
        header('Content-Type: image/png');

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
            'imageTransparent' => false,
        ]);

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        echo (new QRCode($options))->render($qrCodeData);
        exit;
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
        if (! logged_in()) {
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

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $animalType = $this->request->getPost('animal_type');
        $shareNumber = $this->request->getPost('share_number');
        $amountPaid = 0;
        $description = '';
        $qurbanGroup = null;

        // Logika Biaya dan Grouping
        if ($animalType === 'kambing') {
            // Cek apakah user sudah terdaftar qurban kambing
            $existingKambing = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'kambing'])->first();
            if ($existingKambing) {
                return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban kambing.');
            }
            $amountPaid = 2700000;
            $description = 'Iuran Qurban Kambing oleh ' . user()->username;

        } elseif ($animalType === 'sapi') {
            // Cek apakah user sudah pernah mendaftar sapi
            $existingCowParticipantsForUser = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'sapi'])->findAll();
            if (!empty($existingCowParticipantsForUser) && $shareNumber <= 0) {
                 return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban sapi. Jika ingin menambah bagian, masukkan jumlah bagian yang valid.');
            }

            // Cek apakah ada slot kosong di sapi terakhir atau buat sapi baru
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

            // Pastikan user tidak mendaftar bagian yang sama untuk sapi yang sama
            $existingShareInGroup = $this->qurbanParticipantModel->where(['user_id' => $userId, 'animal_type' => 'sapi', 'qurban_group' => $qurbanGroup, 'share_number' => $shareNumber])->first();
            if ($existingShareInGroup) {
                return redirect()->back()->withInput()->with('error', 'Anda sudah terdaftar qurban sapi dengan bagian yang sama di grup ini. Jika ingin menambah bagian, pilih jumlah bagian yang berbeda atau hubungi admin.');
            }


            $amountPaid = 3000000 * $shareNumber;
            $description = 'Iuran Qurban Sapi (' . $shareNumber . ' bagian) oleh ' . user()->username;
        }

        // Simpan data qurban sebagai 'unpaid' dulu
        $this->qurbanParticipantModel->save([
            'user_id'        => $userId,
            'animal_type'    => $animalType,
            'share_number'   => $shareNumber,
            'payment_status' => 'unpaid',
            'qurban_group'   => $qurbanGroup,
            'amount_paid'    => $amountPaid,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        // Tambahkan user ke group 'berqurban'
        $berqurbanGroup = $this->groupModel->where('name', 'berqurban')->first();
        if ($berqurbanGroup) {
            // Cek manual apakah user sudah di grup 'berqurban'
            $userInGroupCheck = $this->db->table('auth_groups_users')
                                        ->where('user_id', $userId)
                                        ->where('group_id', $berqurbanGroup->id)
                                        ->countAllResults();
            if ($userInGroupCheck === 0) { // Jika user belum ada di grup ini
                $this->groupModel->addUserToGroup($userId, $berqurbanGroup->id);
            }
        }

        return redirect()->to('/user')->with('message', 'Pendaftaran qurban Anda berhasil! Silakan lakukan pembayaran agar status menjadi lunas.');
    }
}