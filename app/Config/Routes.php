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
$routes->get('/dashboard/booking/add', 'Dashboard::bookingAdd');
$routes->get('/dashboard/booking/list', 'Dashboard::bookingList');
$routes->get('/dashboard/booking/update', 'Dashboard::bookingUpdate');

$routes->get('/dashboard/lapangan', 'Dashboard::lapangan');
$routes->post('/dashboard/lapangan/tambah', 'Dashboard::tambahLapangan');
$routes->get('/dashboard/lapangan/hapus/(:num)', 'Dashboard::hapusLapangan/$1');
$routes->get('/dashboard/lapangan/edit/(:num)', 'Dashboard::editLapangan/$1');
$routes->post('/dashboard/lapangan/update/(:num)', 'Dashboard::updateLapangan/$1');

$routes->get('/dashboard/pelanggan', 'Dashboard::pelanggan');
$routes->post('/dashboard/pelanggan/tambah', 'Dashboard::tambahPelanggan');
$routes->get('/dashboard/pelanggan/tambah', 'Dashboard::formPelanggan');
$routes->get('/dashboard/pelanggan/hapus/(:num)', 'Dashboard::hapusPelanggan/$1');
$routes->get('/dashboard/pelanggan/edit/(:num)', 'Dashboard::editPelanggan/$1');
$routes->post('/dashboard/pelanggan/update/(:num)', 'Dashboard::updatePelanggan/$1');


