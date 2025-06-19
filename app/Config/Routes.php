<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Tahap Develop (Hapus jika sudah production)
// $routes->setAutoRoute(true); // Biarkan ini mati untuk keamanan di production
// $routes->get('home/(:any)', 'Home::$1');
// End Tahap Develop
$routes->get('/test-qr', 'TestController::generate');

$routes->get('/', 'User::index', ['filter' => 'login']); // Pastikan user harus login untuk ke halaman utama
$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/index', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->post('/admin/updateUserRoles/(:num)', 'Admin::updateUserRoles/$1', ['filter' => 'role:admin']);


// Rute untuk Keuangan
// $routes->group('financial', ['filter' => 'role:admin'], function($routes) {
$routes->group('financial', ['filter' => 'role:admin,panitia'], function($routes) {
    $routes->get('/', 'Financial::index');
    $routes->get('add', 'Financial::add');
    $routes->post('save', 'Financial::save');
    $routes->get('delete/(:num)', 'Financial::delete/$1');
});

// Rute untuk Pendataan Qurban
// $routes->group('qurban', ['filter' => 'role:admin,panitia'], function($routes) {
//     $routes->get('/', 'Qurban::index');
//     $routes->get('add', 'Qurban::add');
//     $routes->post('save', 'Qurban::save');
// });

// $routes->group('qurban', ['filter' => 'role:admin'], function($routes) {
// $routes->group('qurban', ['filter' => 'role:admin,panitia'], function($routes) {
$routes->group('distribution', ['filter' => 'role:admin,panitia'], function($routes) {
    // $routes->get('/', 'Qurban::index');
    $routes->get('/', 'Distribution::index');
    $routes->get('add', 'Qurban::add');
    $routes->post('save', 'Qurban::save');
    $routes->get('markaspaid/(:num)', 'Qurban::markAsPaid/$1'); // Tambahkan rute ini
    $routes->get('delete/(:num)', 'Qurban::delete/$1');
});

// Rute untuk Pembagian Daging
$routes->group('distribution', ['filter' => 'role:admin,panitia'], function($routes) {
    $routes->get('/', 'Distribution::index');
    $routes->get('add', 'Distribution::add');
    $routes->post('save', 'Distribution::save');
    $routes->get('kambing', 'Distribution::manageKambing');
    $routes->post('kambing/distribute', 'Distribution::distributeKambing');
    $routes->get('sapi', 'Distribution::manageSapi');
    $routes->post('sapi/distribute', 'Distribution::distributeSapi');
    $routes->get('scan', 'Distribution::scanQrCode');
    $routes->post('verifyqrcode', 'Distribution::verifyQrCode');
    $routes->get('kambing/markasdistributed/(:num)', 'Distribution::markAsDistributed/kambing/$1');
    $routes->get('sapi/markasdistributed/(:num)', 'Distribution::markAsDistributed/sapi/$1');

    $routes->post('kambing/markall', 'Distribution::markAllAsDistributed/kambing');
    $routes->post('sapi/markall', 'Distribution::markAllAsDistributed/sapi');

    $routes->post('kambing/reset', 'Distribution::resetDistribution/kambing');
    $routes->post('sapi/reset', 'Distribution::resetDistribution/sapi');

    $routes->post('kambing/deleteall', 'Distribution::deleteDistribution/kambing');
    $routes->post('sapi/deleteall', 'Distribution::deleteDistribution/sapi');
});
// Rute untuk generate gambar QR (TIDAK PERLU FILTER, JADIKAN PUBLIK)
$routes->get('distribution/qrimage/(:any)', 'Distribution::generateQrImage/$1');
// $routes->get('qrimage/(:any)', 'Distribution::generateQrImage/$1');

// Rute untuk User (My Profile dan Kartu QR)
// $routes->group('user', ['filter' => 'login'], function($routes) {
//     $routes->get('/', 'User::index');
//     $routes->get('myqrcard', 'User::myQrCard');
//     $routes->get('generateqrcard/(:any)', 'User::generateQrCodeForUser/$1');
// });

$routes->group('user', ['filter' => 'login'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('myqrcard', 'User::myQrCard');
    $routes->get('generateqrcard/(:any)', 'User::generateQrCodeForUser/$1');
    $routes->get('registerqurban', 'User::registerQurban'); // Tambahkan rute ini
    $routes->post('saveregisterqurban', 'User::saveRegisterQurban'); // Tambahkan rute ini
});

$routes->get('/panitia', 'Panitia::index', ['filter' => 'role:admin,panitia']);

// Rute default Myth:Auth
// $routes->addRedirect('login', 'login');
// // $routes->addRedirect('register', 'register'); // Komentari jika ingin mematikan pendaftaran dari luar