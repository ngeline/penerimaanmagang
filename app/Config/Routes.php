<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::postlogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('register', 'RegisterController::index');
$routes->post('register', 'RegisterController::register');
$routes->get('koderhs', 'RegisterController::kode');

$routes->get('errors', 'AuthController::errors');

$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('dashboard', 'AuthController::dashboard');
    $routes->get('profile', 'ProfileController::index');

    $routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
        $routes->get('users', 'UsersController::index');
        $routes->post('users/update', 'UsersController::update');
        $routes->get('users/delete/(:any)', 'UsersController::delete/$1');

        $routes->get('siswa', 'SiswaController::index');
        $routes->post('siswa/update', 'SiswaController::update');
        $routes->get('siswa/delete/(:any)/(:any)', 'SiswaController::delete/$1/$2');

        $routes->get('pembimbing', 'PembimbingController::index');
        $routes->post('pembimbing/store', 'PembimbingController::store');
        $routes->post('pembimbing/update', 'PembimbingController::update');
        $routes->get('pembimbing/delete/(:any)', 'PembimbingController::delete/$1');

        $routes->get('pengajuan', 'PengajuanController::indexAdmin');
        $routes->get('pengajuan/detail', 'PengajuanController::detail');
        $routes->post('pengajuan/validasi', 'PengajuanController::validasiAdmin');

        $routes->get('magang', 'MagangController::indexAdmin');
        $routes->post('magang/store', 'MagangController::storeAdmin');
        $routes->post('magang/update', 'MagangController::updateAdmin');
        $routes->get('magang/delete/(:any)', 'MagangController::deleteAdmin/$1');
        $routes->get('magang/list-siswa', 'MagangController::listSiswa');
    });

    $routes->group('siswa', ['filter' => 'SiswaFilter'], function ($routes) {
        $routes->post('users/update', 'UsersController::updateSiswaUsers');
        $routes->post('profile/update', 'ProfileController::updateProfileSiswa');

        $routes->get('pengajuan', 'PengajuanController::index');
        $routes->post('pengajuan/store', 'PengajuanController::store');
        $routes->get('pengajuan/detail', 'PengajuanController::detail');

        $routes->get('magang', 'MagangController::index');
        $routes->get('absensi', 'AbsensiController::index');
        $routes->get('kegiatan', 'KegiatanController::index');
        $routes->get('penilaian', 'PenilaianController::index');
    });

    $routes->group('pembimbing', ['filter' => 'PembimbingFilter'], function ($routes) {
        $routes->post('users/update', 'UsersController::updatePembimbingUsers');
        $routes->post('profile/update', 'ProfileController::updateProfilePembimbing');

        $routes->get('siswa', 'SiswaController::indexPembimbing');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
