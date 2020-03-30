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



Route::get('/kelas', 'ManajemenKelasController@json');
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

Route::get('/dosen', 'DosenController@index')->name('dosen');
Route::get('/dosen/json', 'DosenController@json')->name('dosen');
//    ->middleware('dosen');


//Testing Routes
Auth::routes();

Route::get('/register/mahasiswa', 'RegisterMahasiswaController@showRegistrationForm')->name('register/mahasiswa');
Route::get('/register/pegawai', 'RegisterPegawaiController@showRegistrationForm');




Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json');





Route::resource('/register/pegawai', 'RegisterPegawaiController');

Route::resource('/mahasiswa/mahasiswa', 'ManajemenAkunMahasiswaController');



//Program Studi
Route::resource('/program_studi', 'ManajemenProgramStudiController');
Route::post('/program_studi/import', 'ManajemenProgramStudiController@import')->name('import_program_studi');

//Mata Kuliah
Route::get('matakuliah/json', 'ManajemenMataKuliahController@json');
Route::resource('/matakuliah', 'ManajemenMatakuliahController');
Route::post('/matakuliah/import', 'ManajemenMatakuliahController@import')->name('import_matakuliah');

//Kelas
Route::get('/kelas/json', 'ManajemenKelasController@json');
Route::resource('/kelas', 'ManajemenKelasController');
Route::post('/kelas/import','ManajemenKelasController@import')->name('import_kelas');
Route::post('/kelas/fetch', 'ManajemenKelasController@fetch')->name('kelas.fetch');


//KHS
Route::get('/khs/json','ManajemenKHSController@json');
Route::resource('/khs','ManajemenKHSController');
Route::post('/khs/import','ManajemenKHSController@import')->name('import_khs');


//Pegawai
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json');
Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController');
Route::post('/akunpegawai/import','ManajemenAkunPegawaiController@import')->name('import_employee');

//Mahasiswa
Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json');
Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController');
Route::post('/akunmahasiswa/import', 'ManajemenAkunMahasiswaController@import')->name('import_mahasiswa');


//Operasi QR
Route::resource('/validator',"ManajemenValidatorController");
