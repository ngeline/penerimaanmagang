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

    $routes->group('', ['filter' => 'AdminFilter'], function ($routes) {
        $routes->get('users', 'UsersController::index');
        $routes->post('users/update', 'UsersController::update');
        $routes->get('users/delete/(:any)', 'UsersController::delete/$1');
    });

    $routes->group('', ['filter' => 'SiswaFilter'], function ($routes) {
        $routes->post('siswa/users/update', 'UsersController::updateSiswaUsers');
        $routes->post('siswa/profile/update', 'ProfileController::updateProfileSiswa');

        $routes->get('siswa/pengajuan', 'PengajuanController::index');
        $routes->get('siswa/magang', 'MagangController::index');
        $routes->get('siswa/absensi', 'AbsensiController::index');
        $routes->get('siswa/kegiatan', 'KegiatanController::index');
        $routes->get('siswa/penilaian', 'PenilaianController::index');
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
