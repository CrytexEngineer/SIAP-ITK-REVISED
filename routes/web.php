<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/manajemen_akun/mahasiswa/json', 'ManajemenAkunMahasiswaController@json');
Route::get('/manajemen_akun/pegawai/json', 'ManajemenAkunPegawaiController@json');
Route::get('/kelas', 'ManajemenKelasController@json');
Route::get('/matakuliah/json', 'MatakuliahController@json');
Route::get('/program_studi/json', 'ManajemenProgramStudiController@json');

Route::get('/home', 'HomeController@index')->name('home')->middleware('home');

Route::get('/superadmin', 'SuperAdminController@index')->name('superadmin')->middleware('superadmin');
Route::get('/superadmin/manajemen/akun_mahasiswa', 'DiksatController@index')->name('superadmin')->middleware('diksat');

Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/admin/manajemen/akun_mahasiswa', 'DiksatController@index')->name('admin')->middleware('diksat');

Route::get('/observer', 'ObserverController@index')->name('observer')->middleware('observer');

Route::get('/warek', 'WarekController@index')->name('warek')->middleware('warek');
Route::get('/admin/manajemen/akun_mahasiswa', 'DiksatController@index')->name('admin')->middleware('diksat');

Route::get('/kajur', 'KajurController@index')->name('kajur')->middleware('kajur');
Route::get('/kaprodi', 'KaprodiController@index')->name('kaprodi')->middleware('kaprodi');
Route::get('/dikjur', 'DikjurController@index')->name('dikjur')->middleware('dikjur');

Route::get('/diksat', 'DiksatController@index')->name('diksat')->middleware('diksat');
Route::get('/diksat/manajemen/akun_mahasiswa', 'DiksatController@index')->name('diksat')->middleware('diksat');

Route::get('/dosen', 'DosenController@index')->name('dosen')->middleware('dosen');


//Testing Routes
Auth::routes();

Route::get('/register/mahasiswa', 'RegisterMahasiswaController@showRegistrationForm')->name('register/mahasiswa');
Route::get('/register/pegawai', 'RegisterPegawaiController@showRegistrationForm');

Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController');
Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json');

Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController');
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json');

Route::resource('/matakuliah', 'ManajemenMataKuliahController');
Route::get('matakuliah/json', 'ManajemenMataKuliahController@json');


Route::resource('/register/pegawai', 'RegisterPegawaiController');

Route::resource('/manajemen_akun/mahasiswa', 'ManajemenAkunMahasiswaController');
Route::resource('/manajemen_akun/pegawai', 'ManajemenAkunPegawaiController');
Route::resource('/kelas', 'ManajemenKelasController');
Route::resource('/matakuliah', 'ManajemenMatakuliahController');
Route::resource('/program_studi', 'ManajemenProgramStudiController');

//import routes
route::get('/matakuliah/import', 'ManajemenMatakuliahController@importView')->name('import_matakuliah');
Route::post('/matakuliah/import', 'ManajemenMatakuliahController@import')->name('import_matakuliah');



