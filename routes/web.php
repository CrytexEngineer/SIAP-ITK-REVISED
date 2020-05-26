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



Route::get('/kelas', 'ManajemenKelasController@json')->middleware('can:admin');
Route::get('/program_studi/json', 'ManajemenProgramStudiController@json')->middleware('can:admin');

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

Route::get('/dosen', 'DosenController@jadwal_mengajar')->name('dosen')->middleware('dosen');;

//Testing Routes
Auth::routes();

Route::get('/register/mahasiswa', 'RegisterMahasiswaController@showRegistrationForm')->name('register/mahasiswa');
Route::get('/register/pegawai', 'RegisterPegawaiController@showRegistrationForm');
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json')->middleware('can:admin');
Route::resource('/register/pegawai', 'RegisterPegawaiController');
Route::resource('/mahasiswa/mahasiswa', 'ManajemenAkunMahasiswaController')->middleware('can:admin');

//Program Studi
Route::resource('/program_studi', 'ManajemenProgramStudiController')->middleware('can:admin');
Route::post('/program_studi/import', 'ManajemenProgramStudiController@import')->name('import_program_studi')->middleware('can:admin');

//Mata Kuliah
Route::get('matakuliah/json', 'ManajemenMataKuliahController@json')->middleware('can:admin');
Route::resource('/matakuliah', 'ManajemenMatakuliahController')->middleware('can:admin');
Route::post('/matakuliah/import', 'ManajemenMatakuliahController@import')->name('import_matakuliah')->middleware('can:admin');

//Kelas
Route::get('/kelas/json', 'ManajemenKelasController@json')->middleware('can:admin');
Route::resource('/kelas', 'ManajemenKelasController')->middleware('can:admin');
Route::get('/kelas/{id}/manage', 'ManajemenKelasController@manage')->middleware('can:admin');
Route::post('/kelas/{id}/manage/store', 'ManajemenKelasController@manage_store')->middleware('can:admin');
Route::post('/kelas/import','ManajemenKelasController@import')->name('import_kelas')->middleware('can:admin');
Route::post('/kelas/fetch', 'ManajemenKelasController@fetch')->name('kelas.fetch')->middleware('can:admin');
Route::post('/kelas/fetch_pengajar', 'ManajemenKelasController@fetch_pengajar')->name('kelas.fetch_pengajar')->middleware('can:admin');



//KHS
Route::get('/khs/json','ManajemenKHSController@json')->middleware('can:admin');
Route::resource('/khs','ManajemenKHSController')->middleware('can:admin');
Route::post('/khs/import','ManajemenKHSController@import')->name('import_khs')->middleware('can:admin');


//Pegawai
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json')->middleware('can:admin');
Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController')->name('*','admin.users.index')->middleware('can:admin');
Route::post('/akunpegawai/import','ManajemenAkunPegawaiController@import')->name('import_employee')->middleware('can:admin');

//Mahasiswa
Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json')->middleware('can:admin');
Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController')->middleware('can:admin');
Route::post('/akunmahasiswa/import', 'ManajemenAkunMahasiswaController@import')->name('import_mahasiswa')->middleware('can:admin');

//Dosen
Route::middleware('can:dosen')->group(function (){
    Route::get('jadwal_mengajar','DosenController@jadwal_mengajar')->name('jadwal_mengajar');
    Route::get('jadwal_mengajar/json','DosenController@jadwal_mengajar_json');
    Route::get('kehadiran/{id_jadwal}/create','KehadiranController@create');
    Route::get('kehadiran/{id_jadwal}','KehadiranController@index');
    Route::post('/kehadiran','KehadiranController@store');
    Route::post('/kehadiran/update','KehadiranController@update');
    Route::get('/kehadiran/{id_jadwal}/history/','KehadiranController@showHistory')->name('meeting.history');
    Route::get('/kehadiran/presenceCount/{pt_id}',"KehadiranController@getKehadiranPertemuan");
});

//Operasi QR
Route::resource('/validator',"ManajemenValidatorController");
Route::get('/validator/generateQrCode/{pt_id}',"ManajemenValidatorController@generateQrCode");


//Rekapitulasi Mahasiswa
Route::get('/rekapitulasi/mahasiswa/json',"RekapitulasiMahasiswaController@json")->middleware('can:admin');
Route::resource('/rekapitulasi/mahasiswa',"RekapitulasiMahasiswaController")->middleware('can:admin');

//Rekapitulasi Dosen
Route::get('/rekapitulasi/dosen/json',"RekapitulasiDosenController@json")->middleware('can:admin');
Route::resource('/rekapitulasi/dosen',"RekapitulasiDosenController")->middleware('can:admin');

//Rekapitulasi Pertemuan
Route::get('/rekapitulasi/pertemuan/json',"RekapitulasiPegawaiController@json")->middleware('can:admin');
Route::resource('/rekapitulasi/pertemuan',"RekapitulasiPegawaiController")->middleware('can:admin');

//ManajemenData
Route::get('/riwayat_data/json',"ManajemenLogbookController@json")->middleware('can:admin');
Route::resource('/riwayat_data',"ManajemenLogbookController")->middleware('can:admin');

//Multi-user Management
//Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function (){
//    Route::resource('/users', 'UsersController', ['except' => ['show','create', 'store']]);
//});

//reset password
Route::GET('password/form/{token}', 'Mobile\PasswordResetController@showForm')->name('Passeord.showForm');

//Kurikulum
Route::resource('/kurikulum',"KurikulumController")->middleware('can:admin');

Route::get('/delete_all', 'DeleteAllController@destroy')->name('delete.all')->middleware('can:admin');




