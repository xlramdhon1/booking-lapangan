<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/lapangan', 'Dashboard::lapangan');
$routes->get('/dashboard/pelanggan', 'Dashboard::pelanggan');

$routes->get('/lapangan', 'Lapangan::lapangan');
$routes->post('/lapangan/tambah', 'Lapangan::tambahLapangan');
$routes->get('/lapangan/hapus/(:num)', 'Lapangan::hapusLapangan/$1');
$routes->get('/lapangan/edit/(:num)', 'Lapangan::editLapangan/$1');
$routes->post('/lapangan/update/(:num)', 'Lapangan::updateLapangan/$1');

$routes->get('/pelanggan', 'Pelanggan::pelanggan');
$routes->get('/pelanggan/tambah', 'Pelanggan::formpPelanggan');
$routes->post('/pelanggan/tambah', 'Pelanggan::tambahPelanggan');
$routes->get('/pelanggan/hapus/(:num)', 'Pelanggan::hapusPelanggan/$1');
$routes->get('/pelanggan/edit/(:num)', 'Pelanggan::editPelanggan/$1');
$routes->post('/pelanggan/update/(:num)', 'Pelanggan::updatePelanggan/$1');

$routes->get('/booking', 'Booking::booking');
$routes->get('/booking/tambah', 'Booking::BookingTambah');
$routes->post('/booking/simpan', 'Booking::bookingSimpan');
$routes->get('/booking/hapus/(:num)', 'Booking::hapusBooking/$1');
$routes->get('/booking/edit/(:num)', 'Booking::bookingEdit/$1');
$routes->post('/booking/update/(:num)', 'Booking::bookingUpdate/$1');

$routes->get('/booking/status', 'Booking::bookingStatusList');
$routes->get('/booking/status/edit/(:num)', 'Booking::bookingStatusForm/$1');
$routes->post('/booking/status/update/(:num)', 'Booking::bookingStatusUpdate/$1');

