<?php

namespace App\Controllers;

use App\Models\MeatDistributionKambingModel;
use App\Models\MeatDistributionSapiModel;
use App\Models\QurbanParticipantModel;
use chillerlan\QRCode\{QRCode, QROptions};
use CodeIgniter\I18n\Time;
use Myth\Auth\Models\GroupModel;
use Myth\Auth\Models\UserModel;

class Distribution extends BaseController
{
    protected $kambingDistModel;
    protected $sapiDistModel;
    protected $userModel;
    protected
        $qurbanParticipantModel;
    protected $groupModel;
    protected $db;

    public function __construct()
    {
        $this->kambingDistModel = new MeatDistributionKambingModel();
        $this->sapiDistModel = new MeatDistributionSapiModel();
        $this->userModel = new UserModel();
        $this->qurbanParticipantModel = new QurbanParticipantModel();
        $this->groupModel = new GroupModel();
        $this->db = \Config\Database::connect();
    }

    // Menampilkan halaman utama dengan dua tombol
    public function index()
    {
        return view('distribution/index');
    }

    // Menampilkan halaman khusus untuk mengelola daging kambing
    // public function manageKambing()
    // {
    //     $data['title'] = "Manajemen Distribusi Daging Kambing";
    //     $data['distributions'] = $this->kambingDistModel
    //         ->select('meat_distribution_kambing.*, users.username')
    //         ->join('users', 'users.id = meat_distribution_kambing.recipient_user_id', 'left')
    //         ->orderBy('distribution_date', 'DESC')
    //         ->findAll();

    //     return view('distribution/kambing', $data);
    // }

    // // Menampilkan halaman khusus untuk mengelola daging sapi
    // public function manageSapi()
    // {
    //     $data['title'] = "Manajemen Distribusi Daging Sapi";
    //     $data['distributions'] = $this->sapiDistModel
    //         ->select('meat_distribution_sapi.*, users.username')
    //         ->join('users', 'users.id = meat_distribution_sapi.recipient_user_id', 'left')
    //         ->orderBy('distribution_date', 'DESC')
    //         ->findAll();

    //     return view('distribution/sapi', $data);
    // }

public function manageKambing()
{
    $data['title'] = "Manajemen Distribusi Daging Kambing";
    $distributions = $this->kambingDistModel
        ->select('meat_distribution_kambing.*, users.username')
        ->join('users', 'users.id = meat_distribution_kambing.recipient_user_id', 'left')
        ->orderBy('distribution_date', 'DESC')
        ->findAll();

    $todayPoolId = strtoupper('kambing') . '_POOL_' . date('Y-m-d');

    // Cek apakah ada data dengan status 'pending'
    $data['hasPending'] = !empty(array_filter($distributions, fn ($dist) => $dist['status'] === 'pending' && $dist['qurban_animal_id'] === $todayPoolId));
    // Cek apakah ada data 'distributed' untuk hari ini yang bisa di-reset
    $data['canReset'] = !empty(array_filter($distributions, fn ($dist) => $dist['status'] === 'distributed' && $dist['qurban_animal_id'] === $todayPoolId));

    $data['distributions'] = $distributions;

    return view('distribution/kambing', $data);
}

// Ganti fungsi manageSapi() yang ada
public function manageSapi()
{
    $data['title'] = "Manajemen Distribusi Daging Sapi";
    $distributions = $this->sapiDistModel
        ->select('meat_distribution_sapi.*, users.username')
        ->join('users', 'users.id = meat_distribution_sapi.recipient_user_id', 'left')
        ->orderBy('distribution_date', 'DESC')
        ->findAll();

    $todayPoolId = strtoupper('sapi') . '_POOL_' . date('Y-m-d');

    // Cek apakah ada data dengan status 'pending'
    $data['hasPending'] = !empty(array_filter($distributions, fn ($dist) => $dist['status'] === 'pending' && $dist['qurban_animal_id'] === $todayPoolId));
    // Cek apakah ada data 'distributed' untuk hari ini yang bisa di-reset
    $data['canReset'] = !empty(array_filter($distributions, fn ($dist) => $dist['status'] === 'distributed' && $dist['qurban_animal_id'] === $todayPoolId));

    $data['distributions'] = $distributions;

    return view('distribution/sapi', $data);
}

public function resetDistribution($animalType)
{
    // Keamanan: Pastikan hanya admin atau panitia yang bisa mengakses
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
    }

    // Tentukan model dan ID pool untuk hari ini
    $model = ($animalType === 'kambing') ? $this->kambingDistModel : $this->sapiDistModel;
    $todayPoolId = strtoupper($animalType) . '_POOL_' . date('Y-m-d');

    // Siapkan data untuk di-reset
    $resetData = [
        'status'                 => 'pending',
        'collected_at'           => null,
        'collected_by_user_id'   => null,
    ];

    // Lakukan update massal HANYA untuk pool distribusi hari ini
    // dan yang statusnya bukan 'pending' (opsional, untuk efisiensi)
    $model->where('qurban_animal_id', $todayPoolId)
          ->where('status', 'distributed')
          ->set($resetData)
          ->update();

    return redirect()->to('/distribution/' . $animalType)
        ->with('message', 'Semua status distribusi untuk hari ini berhasil di-reset menjadi "Pending".');
}

    // Memproses form distribusi daging kambing
    public function distributeKambing()
    {
        return $this->_distributeMeat('kambing', (float)$this->request->getPost('total_meat_weight_kambing'));
    }

    // Memproses form distribusi daging sapi
    public function distributeSapi()
    {
        return $this->_distributeMeat('sapi', (float)$this->request->getPost('total_meat_weight_sapi'));
    }

    public function deleteDistribution($animalType)
{
    // Keamanan: Pastikan hanya admin atau panitia
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
    }

    // Tentukan model dan ID pool untuk hari ini
    $model = ($animalType === 'kambing') ? $this->kambingDistModel : $this->sapiDistModel;
    $todayPoolId = strtoupper($animalType) . '_POOL_' . date('Y-m-d');

    // Hapus semua data distribusi yang cocok dengan ID pool hari ini
    $model->where('qurban_animal_id', $todayPoolId)->delete();

    // Arahkan kembali dengan pesan sukses
    return redirect()->to('/distribution/' . $animalType)
        ->with('message', 'Semua data alokasi daging ' . $animalType . ' untuk hari ini berhasil dihapus.');
}

    public function markAllAsDistributed($animalType)
{
    // Keamanan: Pastikan hanya admin atau panitia yang bisa mengakses
    if (!in_groups(['admin', 'panitia'])) {
        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
    }

    // Tentukan model mana yang akan digunakan berdasarkan tipe hewan
    $model = ($animalType === 'kambing') ? $this->kambingDistModel : $this->sapiDistModel;

    // Siapkan data untuk update
    $updateData = [
        'status'                 => 'distributed',
        'collected_at'           => date('Y-m-d H:i:s'), // Catat waktu pengambilan
        'collected_by_user_id'   => user()->id,          // Catat siapa yang mengubah status
    ];

    // Lakukan update massal untuk semua yang statusnya 'pending'
    $model->where('status', 'pending')->set($updateData)->update();

    // Arahkan kembali dengan pesan sukses
    return redirect()->to('/distribution/' . $animalType)
        ->with('message', 'Semua status "pending" untuk daging ' . $animalType . ' berhasil diubah menjadi "Distributed".');
}



    private function _distributeMeat(string $animalType, float $totalMeatWeight)
    {
        if (!in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }
        if ($totalMeatWeight <= 0) {
            return redirect()->back()->withInput()->with('error', 'Total berat daging harus lebih besar dari 0.');
        }

        $model = ($animalType === 'kambing') ? $this->kambingDistModel : $this->sapiDistModel;
        $animalPoolId = strtoupper($animalType) . '_POOL_' . date('Y-m-d');

        $this->db->transStart();

        $alreadyDistributed = $model->where('qurban_animal_id', $animalPoolId)->first();
        if ($alreadyDistributed) {
            $this->db->transComplete();
            return redirect()->back()->with('error', "Daging untuk pool '{$animalType}' hari ini sudah pernah didistribusikan.");
        }

        $allPequrban = $this->qurbanParticipantModel->where(['animal_type' => $animalType, 'payment_status' => 'paid'])->findAll();
        if (empty($allPequrban)) {
            $this->db->transComplete();
            return redirect()->back()->with('error', "Tidak ada peserta qurban '{$animalType}' yang lunas.");
        }

        $meatForPequrban = $totalMeatWeight * (1 / 3);
        $meatForOthers = $totalMeatWeight * (2 / 3);
        $meatPerPequrban = $meatForPequrban / count($allPequrban);
        $pequrbanUserIds = array_column($allPequrban, 'user_id');

        $dataToInsert = [];
        $distributionDate = Time::now()->toDateTimeString();

        foreach ($allPequrban as $user) {
            $dataToInsert[] = $this->_prepareDistributionData($user['user_id'], 'berqurban', round($meatPerPequrban, 2), $distributionDate, $animalPoolId);
        }

        $finalRecipientIds = $this->_getEligibleRecipients($pequrbanUserIds);
        if (!empty($finalRecipientIds)) {
            $meatPerRecipient = $meatForOthers / count($finalRecipientIds);
            $eligiblePanitiaIds = $this->_getEligiblePanitiaIds();

            foreach ($finalRecipientIds as $userId) {
                $type = in_array($userId, $eligiblePanitiaIds) ? 'panitia' : 'warga';
                $dataToInsert[] = $this->_prepareDistributionData($userId, $type, round($meatPerRecipient, 2), $distributionDate, $animalPoolId);
            }
        }

        if (!empty($dataToInsert)) {
            $model->insertBatch($dataToInsert);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan data distribusi.');
        }

        return redirect()->to('/distribution/' . $animalType)->with('message', "Pembagian daging dari pool '{$animalType}' berhasil dialokasikan!");
    }

    public function markAsDistributed($animalType, $id)
    {
        if (!in_groups(['admin', 'panitia'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
        }

        $model = ($animalType === 'kambing') ? $this->kambingDistModel : $this->sapiDistModel;

        $distribution = $model->find($id);

        if (!$distribution || $distribution['status'] === 'distributed') {
            return redirect()->to('/distribution/' . $animalType)->with('error', 'Data tidak ditemukan atau status sudah diambil.');
        }

        $model->update($id, [
            'status'                 => 'distributed',
            'collected_at'           => date('Y-m-d H:i:s'),
            'collected_by_user_id'   => user()->id,
        ]);

        $recipient = $this->userModel->find($distribution['recipient_user_id']);
        $recipientName = $recipient ? $recipient->username : 'Penerima';

        return redirect()->to('/distribution/' . $animalType)->with('message', 'Status untuk ' . $recipientName . ' berhasil diubah menjadi "Distributed".');
    }

    private function _prepareDistributionData(int $userId, string $distType, float $weight, string $date, string $poolId): array
    {
        return [
            'recipient_user_id' => $userId,
            'distribution_type' => $distType,
            'meat_weight'       => $weight,
            'distribution_date' => $date,
            'status'            => 'pending',
            'qr_code'           => 'DSTR' . $userId . '_' . strtoupper($poolId) . '_' . uniqid(),
            'qurban_animal_id'  => $poolId,
        ];
    }

    private function _getEligiblePanitiaIds(): array
    {
        $panitiaGroup = $this->groupModel->where('name', 'panitia')->first();
        if (!$panitiaGroup) {
            return [];
        }

        $allPanitiaResult = $this->userModel->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->where('auth_groups_users.group_id', $panitiaGroup->id)
            ->select('users.id')->findAll();
        $allPanitiaIds = array_column($allPanitiaResult, 'id');

        $receivedFromKambing = $this->kambingDistModel->where('distribution_type', 'panitia')->select('recipient_user_id')->distinct()->findAll();
        $receivedFromSapi = $this->sapiDistModel->where('distribution_type', 'panitia')->select('recipient_user_id')->distinct()->findAll();

        $receivedPanitiaIds = array_unique(array_merge(
            array_column($receivedFromKambing, 'recipient_user_id'),
            array_column($receivedFromSapi, 'recipient_user_id')
        ));

        return array_diff($allPanitiaIds, $receivedPanitiaIds);
    }

    private function _getEligibleRecipients(array $excludeUserIds = []): array
    {
        $eligiblePanitiaIds = $this->_getEligiblePanitiaIds();

        $wargaGroup = $this->groupModel->where('name', 'user')->first();
        $wargaUserIds = [];
        if ($wargaGroup) {
            $wargaUsers = $this->userModel->join('auth_groups_users', 'auth_groups_users.user_id = users.id')->where('auth_groups_users.group_id', $wargaGroup->id)->select('users.id')->findAll();
            $wargaUserIds = array_column($wargaUsers, 'id');
        }

        $allRecipientIds = array_unique(array_merge($wargaUserIds, $eligiblePanitiaIds));

        return array_diff($allRecipientIds, $excludeUserIds);
    }

    // public function generateQrImage($qrCodeData)
    // {
    //     ob_start();

    //     $options = new QROptions([
    //         'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
    //         'eccLevel'         => QRCode::ECC_L,
    //         'scale'            => 5,
    //         'imageTransparent' => false,
    //     ]);

    //     $decodedQrData = urldecode($qrCodeData);

    //     (new QRCode($options))->render($decodedQrData);

    //     $imageData = ob_get_contents();
    //     ob_end_clean();

    //     header('Content-Type: image/png');
    //     header('Content-Length: ' . strlen($imageData));
    //     header('Cache-Control: no-cache');
    //     echo $imageData;

    //     exit;
    // }

    // app/Controllers/Distribution.php

public function generateQrImage($qrCodeData)
{
    // 1. Dapatkan QR code yang sudah di-decode dari URL
    $decodedQrData = urldecode($qrCodeData);

    // 2. Siapkan opsi untuk library QR code
    $options = new QROptions([
        'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel'         => QRCode::ECC_L,
        'scale'            => 5,
        'imageTransparent' => false,
    ]);

    try {
        // 3. Render data QR menjadi data gambar PNG
        $imageData = (new QRCode($options))->render($decodedQrData);

        // 4. Gunakan Response object untuk mengirim gambar
        // Ini adalah cara yang paling andal di CodeIgniter
        return $this->response
            ->setHeader('Content-Type', 'image/png')
            ->setHeader('Content-Length', (string) strlen($imageData))
            ->setHeader('Cache-Control', 'no-cache')
            ->setBody($imageData);

    } catch (\Exception $e) {
        // Jika ada error saat membuat QR, catat dan kirim error 500
        log_message('error', 'QR Code generation failed: ' . $e->getMessage());
        return $this->response->setStatusCode(500, 'Error generating QR code image.');
    }
}

    public function scanQrCode()
    {
        if (!in_groups('admin', 'panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $data['title'] = 'Scan QR Code Pengambilan Daging';
        return view('distribution/scan', $data);
    }

    public function verifyQrCode()
    {
        if (!in_groups('admin', 'panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        $qrCodeInput = $this->request->getPost('qr_code_input');

        $distribution = $this->kambingDistModel->where('qr_code', $qrCodeInput)->first();
        $model = $this->kambingDistModel;
        $animalType = 'kambing';

        if (!$distribution) {
            $distribution = $this->sapiDistModel->where('qr_code', $qrCodeInput)->first();
            $model = $this->sapiDistModel;
            $animalType = 'sapi';
        }

        if ($distribution) {
            if ($distribution['status'] === 'distributed') {
                return redirect()->back()->with('error', 'Daging sudah diambil sebelumnya.');
            }
            $model->update($distribution['id'], [
                'status' => 'distributed',
                'collected_at' => date('Y-m-d H:i:s'),
                'collected_by_user_id' => user()->id,
            ]);
            $recipient = $this->userModel->find($distribution['recipient_user_id']);

            return redirect()->back()->with('message', 'QR Code valid! Daging (' . $animalType . ') berhasil diberikan kepada ' . $recipient->username . ' (' . $distribution['meat_weight'] . ' kg).');
        } else {
            return redirect()->back()->withInput()->with('error', 'QR Code tidak valid.');
        }
    }

}