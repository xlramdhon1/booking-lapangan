<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/dashboard', 'AdminDashboard::index');
$routes->get('/dashboard/lapangan', 'Dashboard::lapangan');
$routes->get('/dashboard/pelanggan', 'Dashboard::pelanggan');

$routes->get('/lapangan', 'Lapangan::index');
$routes->post('/lapangan/tambah', 'Lapangan::tambah');
$routes->get('/lapangan/hapus/(:num)', 'Lapangan::hapus/$1');
$routes->get('/lapangan/edit/(:num)', 'Lapangan::edit/$1');
$routes->post('/lapangan/update/(:num)', 'Lapangan::update/$1');

$routes->get('/pelanggan', 'Pelanggan::index');
$routes->get('/pelanggan/tambah', 'Pelanggan::form');
$routes->post('/pelanggan/tambah', 'Pelanggan::tambah');
$routes->get('/pelanggan/hapus/(:num)', 'Pelanggan::hapus/$1');
$routes->get('/pelanggan/edit/(:num)', 'Pelanggan::edit/$1');
$routes->post('/pelanggan/update/(:num)', 'Pelanggan::update/$1');

$routes->get('/booking', 'Booking::index');
$routes->get('/booking/tambah', 'Booking::tambah');
$routes->post('/booking/simpan', 'Booking::simpan');
$routes->get('/booking/hapus/(:num)', 'Booking::hapus/$1');
$routes->get('/booking/edit/(:num)', 'Booking::edit/$1');
$routes->post('/booking/update/(:num)', 'Booking::update/$1');
$routes->get('/booking/export/pdf', 'Booking::exportPdf');
$routes->get('/booking/export/excel', 'Booking::exportExcel');
$routes->get('/booking/bukti/(:num)', 'Booking::buktiPembayaran/$1');


$routes->get('/booking/status/(:num)', 'Booking::statusForm/$1');
$routes->get('/booking/status/edit/(:num)', 'Booking::statusForm/$1');
$routes->post('/booking/status/update/(:num)', 'Booking::statusUpdate/$1');

$routes->get('/booking/status', 'Booking::statusList');

$routes->get('/admin/dashboard', 'AdminDashboard::index');

$routes->get('/tampilan/admin/dashboard', 'AdminDashboard::index');

$routes->get('/payment', 'Payment::index');
$routes->get('/payment/token', 'Payment::token');
$routes->post('/payment/finish', 'Payment::finish');

$routes->get('/payment/bayar/(:num)', 'Payment::bayar/$1');
$routes->post('/payment/tokenize', 'Payment::tokenize');
$routes->post('payment/notification', 'Payment::notification');
$routes->post('booking/update-status', 'Booking::updateStatus');


$routes->get('/tes-snap', 'TesSnap::index');
