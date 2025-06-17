<?php

namespace App\Controllers;

use App\Models\MeatDistributionModel; // Import model
use chillerlan\QRCode\{QRCode, QROptions};

class User extends BaseController
{
    protected $meatDistributionModel;

    public function __construct()
    {
        $this->meatDistributionModel = new MeatDistributionModel();
    }

    public function index(): string
    {
        $data['title'] = "My Profile";
        $data['user_distributions'] = $this->meatDistributionModel->where('recipient_user_id', user()->id)->findAll();
        return view('user/index', $data);
    }

    public function myQrCard()
    {
        $data['title'] = "Kartu Pengambilan Daging";
        $data['user_distributions'] = $this->meatDistributionModel->where('recipient_user_id', user()->id)->findAll();

        // You can pass the distributions data to the view to generate multiple QR codes if needed
        // Or just show one QR code if there's only one.
        // For simplicity, let's assume we want to show all QR codes for the user.

        return view('user/my_qr_card', $data);
    }

    // This function is similar to Distribution::generateQrCode, but specifically for user's card
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
}