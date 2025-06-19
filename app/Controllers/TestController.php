<?php

namespace App\Controllers;

// PENTING: Gunakan Controller dasar dari framework, BUKAN BaseController Anda
use CodeIgniter\Controller;
// use chillerlan\QRCode\QRCode;
// use chillerlan\QRCode\QROptions;

use chillerlan\QRCode\QRCode as QRGen;
use chillerlan\QRCode\QROptions as QROpts;

class TestController extends Controller
{
    /**
     * Method ini dirancang untuk tidak memiliki dependensi lain
     * selain library QR code itu sendiri.
     */
    // public function generate()
    // {
    //     // Kita tidak mengambil data dari database atau URL,
    //     // kita gunakan teks statis untuk tes.
    //     $textToEncode = 'Jika Anda bisa melihat QR code ini, maka environment Anda berfungsi.';

    //     $options = new QROptions([
    //         'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
    //         'eccLevel'         => QRCode::ECC_L,
    //         'scale'            => 5,
    //         'imageTransparent' => false,
    //     ]);

    //     try {
    //         $imageData = (new QRCode($options))->render($textToEncode);

    //         // Gunakan Response object dari controller dasar untuk mengirim gambar.
    //         // Ini adalah metode paling bersih dan aman.
    //         return $this->response
    //             ->setHeader('Content-Type', 'image/png')
    //             ->setBody($imageData);

    //     } catch (\Exception $e) {
    //         log_message('error', 'Test QR Code generation failed: ' . $e->getMessage());
    //         return $this->response->setStatusCode(500, 'Error generating test QR code.');
    //     }
    // }

//     public function generate()
// {
//     $textToEncode = 'QR code test to file';

//     $options = new \chillerlan\QRCode\QROptions([
//         'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//         'scale'      => 5,
//     ]);

//     try {
//         $imageData = (new \chillerlan\QRCode\QRCode($options))->render($textToEncode);

//         // Simpan gambar QR ke file
//         file_put_contents(WRITEPATH . 'qr_test.png', $imageData);

//         // Tampilkan pesan sukses
//         echo 'QR code berhasil disimpan ke: ' . WRITEPATH . 'qr_test.png';

//     } catch (\Exception $e) {
//         echo 'Gagal membuat QR code: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     // Tes QR code debug
//     $textToEncode = 'QR code test debug';

//     try {
//         // Tambahkan ini untuk cek class tersedia
//         if (!class_exists(\chillerlan\QRCode\QRCode::class)) {
//             echo 'Class QRCode tidak ditemukan! Autoload mungkin belum aktif.';
//             return;
//         }

//         $options = new \chillerlan\QRCode\QROptions([
//             'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//             'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//             'scale'      => 5,
//         ]);

//         $qrCode = new \chillerlan\QRCode\QRCode($options);
//         $imageData = $qrCode->render($textToEncode);

//         // Simpan ke file
//         file_put_contents(WRITEPATH . 'qr_test.png', $imageData);
//         echo 'QR berhasil dibuat dan disimpan di writable/qr_test.png';

//     } catch (\Throwable $e) {
//         // Tangkap error dan tampilkan
//         echo 'Gagal membuat QR code: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     $textToEncode = 'QR code test to file';

//     $options = new \chillerlan\QRCode\QROptions([
//         'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//         'scale'      => 5,
//     ]);

//     try {
//         $qrcode = new \chillerlan\QRCode\QRCode($options);
//         $imageData = $qrcode->render($textToEncode);

//         if (!$imageData) {
//             echo "Render gagal: kosong atau null";
//             return;
//         }

//         file_put_contents(WRITEPATH . 'qr_test.png', $imageData);
//         echo 'Sukses. Panjang imageData: ' . strlen($imageData);

//     } catch (\Throwable $e) {
//         echo 'Gagal membuat QR code: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     $textToEncode = 'Jika Anda bisa melihat QR code ini, maka environment Anda berfungsi.';

//     $options = new \chillerlan\QRCode\QROptions([
//         'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//         'scale'      => 5,
//     ]);

//     try {
//         $imageData = (new \chillerlan\QRCode\QRCode($options))->render($textToEncode);

//         // Kirim sebagai gambar PNG langsung
//         header('Content-Type: image/png');
//         echo $imageData;
//         exit;

//     } catch (\Throwable $e) {
//         echo 'Gagal membuat QR code: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     $textToEncode = 'Test QR to browser (PNG)';

//     $options = new \chillerlan\QRCode\QROptions([
//         'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//         'scale'      => 5,
//     ]);

//     try {
//         $imageData = (new \chillerlan\QRCode\QRCode($options))->render($textToEncode);

//         // Output langsung sebagai PNG
//         header('Content-Type: image/png');
//         header('Content-Length: ' . strlen($imageData));
//         echo $imageData;
//         exit;

//     } catch (\Throwable $e) {
//         echo 'Gagal membuat QR code: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     $textToEncode = 'Test QR PNG final check';

//     $options = new \chillerlan\QRCode\QROptions([
//         'outputType' => \chillerlan\QRCode\QRCode::OUTPUT_IMAGE_PNG,
//         'eccLevel'   => \chillerlan\QRCode\QRCode::ECC_L,
//         'scale'      => 5,
//     ]);

//     try {
//         $qrcode = new \chillerlan\QRCode\QRCode($options);
//         $imageData = $qrcode->render($textToEncode);

//         // Output PNG as binary
//         header('Content-Type: image/png');
//         header('Content-Length: ' . strlen($imageData));
//         echo $imageData;
//         exit;

//     } catch (\Throwable $e) {
//         echo 'Gagal: ' . $e->getMessage();
//     }
// }

// public function generate()
// {
//     $textToEncode = 'QR Code TEST PNG Rendered';

//     $options = new QROptions();
//     $options->outputType = QRCode::OUTPUT_IMAGE_PNG;
//     $options->eccLevel   = QRCode::ECC_L;
//     $options->scale      = 5;

//     try {
//         $qrcode = new QRCode($options);
//         $imageData = $qrcode->render($textToEncode);

//         // INI PENTING: image/png hanya bisa terima biner, bukan data:image/*
//         if (str_starts_with($imageData, 'data:image')) {
//             echo '❌ MASIH BASE64! QRCode salah konfigurasi.';
//             return;
//         }

//         header('Content-Type: image/png');
//         header('Content-Length: ' . strlen($imageData));
//         echo $imageData;
//         exit;

//     } catch (\Throwable $e) {
//         echo '❌ ERROR: ' . $e->getMessage();
//     }
// }

public function generate()
    {
        $options = new QROpts();
        $options->outputType = QRGen::OUTPUT_IMAGE_PNG;
        $options->eccLevel   = QRGen::ECC_L;
        $options->scale      = 5;

        $qr = new QRGen($options);
        $imageData = $qr->render('QR code dari CodeIgniter, asli dari vendor');

        // Tes: jika base64, kita tahu masih salah
        if (str_starts_with($imageData, 'data:image')) {
            echo '❌ MASIH SALAH: hasil base64, bukan PNG';
            echo 'QRCode class: ' . get_class($qr);
            return;
        }

        // Kirim QR PNG
        header('Content-Type: image/png');
        header('Content-Length: ' . strlen($imageData));
        echo $imageData;
        
        exit;
    }





}