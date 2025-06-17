<?php

namespace App\Controllers;

use App\Models\MeatDistributionModel;
use Myth\Auth\Models\UserModel;
use chillerlan\QRCode\{QRCode, QROptions};

class Distribution extends BaseController
{
    protected $meatDistributionModel;
    protected $userModel;

    public function __construct()
    {
        $this->meatDistributionModel = new MeatDistributionModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
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
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Tambah Catatan Pembagian Daging';
        $data['users'] = $this->userModel->findAll();
        return view('distribution/add', $data);
    }

    public function save()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (! $this->validate([
            'recipient_user_id' => 'required|integer|is_not_unique[users.id]',
            'distribution_type' => 'required|in_list[warga,berqurban,panitia]',
            'meat_weight_kg'    => 'required|numeric|greater_than[0]',
            'distribution_date' => 'required|valid_date[Y-m-d H:i:s]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recipientUserId = $this->request->getPost('recipient_user_id');
        $distributionType = $this->request->getPost('distribution_type');
        $meatWeightKg = $this->request->getPost('meat_weight_kg');
        $distributionDate = $this->request->getPost('distribution_date');

        // Generate a unique QR Code string
        $qrCodeString = $recipientUserId . '_' . $distributionType . '_' . uniqid();

        $this->meatDistributionModel->save([
            'recipient_user_id' => $recipientUserId,
            'distribution_type' => $distributionType,
            'meat_weight_kg'    => $meatWeightKg,
            'distribution_date' => $distributionDate,
            'status'            => 'pending', // Default status when recorded
            'qr_code'           => $qrCodeString,
        ]);

        return redirect()->to('/distribution')->with('message', 'Catatan pembagian daging berhasil ditambahkan!');
    }

    public function generateQrCode($qrCodeData)
    {
        // Ensure the output is an image
        header('Content-Type: image/png');

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 5,
            'imageTransparent' => false,
        ]);

        // Also need to set some required headers for caching.
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // The text for the QR code will be the unique string stored in the database
        echo (new QRCode($options))->render($qrCodeData);
        exit; // Terminate script after sending image
    }

    public function scanQrCode()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $data['title'] = 'Scan QR Code Pengambilan Daging';
        return view('distribution/scan', $data);
    }

    public function verifyQrCode()
    {
        if (! in_groups('admin') && ! in_groups('panitia')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $qrCodeInput = $this->request->getPost('qr_code_input');

        $distribution = $this->meatDistributionModel->where('qr_code', $qrCodeInput)->first();

        if ($distribution) {
            if ($distribution['status'] === 'distributed') {
                return redirect()->back()->with('error', 'Daging sudah diambil sebelumnya.');
            }

            // Update status to distributed
            $this->meatDistributionModel->update($distribution['id'], [
                'status' => 'distributed',
                'collected_at' => date('Y-m-d H:i:s'),
                'collected_by_user_id' => user()->id, // Assuming current logged-in user is the one scanning
            ]);

            $recipient = $this->userModel->find($distribution['recipient_user_id']);

            return redirect()->back()->with('message', 'QR Code valid! Daging berhasil diberikan kepada ' . $recipient->username . ' (' . $distribution['meat_weight_kg'] . ' kg).');
        } else {
            return redirect()->back()->withInput()->with('error', 'QR Code tidak valid.');
        }
    }
}