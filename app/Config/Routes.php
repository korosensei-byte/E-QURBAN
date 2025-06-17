<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Tahap Develop (Hapus jika sudah production)
// $routes->setAutoRoute(true); // Biarkan ini mati untuk keamanan di production
// $routes->get('home/(:any)', 'Home::$1');
// End Tahap Develop

$routes->get('/', 'User::index', ['filter' => 'login']); // Pastikan user harus login untuk ke halaman utama
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);


// Rute untuk Keuangan
$routes->group('financial', ['filter' => 'role:admin,panitia'], function($routes) {
    $routes->get('/', 'Financial::index');
    $routes->get('add', 'Financial::add');
    $routes->post('save', 'Financial::save');
});

// Rute untuk Pendataan Qurban
$routes->group('qurban', ['filter' => 'role:admin,panitia'], function($routes) {
    $routes->get('/', 'Qurban::index');
    $routes->get('add', 'Qurban::add');
    $routes->post('save', 'Qurban::save');
});

// Rute untuk Pembagian Daging
$routes->group('distribution', ['filter' => 'role:admin,panitia'], function($routes) {
    $routes->get('/', 'Distribution::index');
    $routes->get('add', 'Distribution::add');
    $routes->post('save', 'Distribution::save');
    $routes->get('generateqrcode/(:any)', 'Distribution::generateQrCode/$1'); // Untuk menampilkan QR code
    $routes->get('scan', 'Distribution::scanQrCode');
    $routes->post('verifyqrcode', 'Distribution::verifyQrCode');
});

// Rute untuk User (My Profile dan Kartu QR)
$routes->group('user', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('myqrcard', 'User::myQrCard');
    $routes->get('generateqrcard/(:any)', 'User::generateQrCodeForUser/$1'); // Untuk QR code di kartu user
});

// Rute default Myth:Auth
// $routes->addRedirect('login', 'login');
// $routes->addRedirect('register', 'register');