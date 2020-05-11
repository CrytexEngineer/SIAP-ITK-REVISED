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

Route::get('/home', 'HomeController@index')->name('home')->middleware('superadmin');

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
//Route::get('/dosen/json', 'DosenController@json')->name('dosen');


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
Route::get('/kelas/{id}/manage', 'ManajemenKelasController@manage');
Route::post('/kelas/{id}/manage/store', 'ManajemenKelasController@manage_store');
Route::post('/kelas/import','ManajemenKelasController@import')->name('import_kelas');
Route::post('/kelas/fetch', 'ManajemenKelasController@fetch')->name('kelas.fetch');
Route::post('/kelas/fetch_pengajar', 'ManajemenKelasController@fetch_pengajar')->name('kelas.fetch_pengajar');



//KHS
Route::get('/khs/json','ManajemenKHSController@json');
Route::resource('/khs','ManajemenKHSController');
Route::post('/khs/import','ManajemenKHSController@import')->name('import_khs');


//Pegawai
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json');
Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController')->name('*','admin.users.index');
Route::post('/akunpegawai/import','ManajemenAkunPegawaiController@import')->name('import_employee');

//Mahasiswa
Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json');
Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController');
Route::post('/akunmahasiswa/import', 'ManajemenAkunMahasiswaController@import')->name('import_mahasiswa');

//Dosen
Route::get('jadwal_mengajar','DosenController@jadwal_mengajar');
Route::get('jadwal_mengajar/json','DosenController@jadwal_mengajar_json');
Route::get('kehadiran/{id_jadwal}/create','KehadiranController@create');
Route::get('kehadiran/{id_jadwal}','KehadiranController@index');
Route::post('/kehadiran','KehadiranController@store');
Route::post('/kehadiran/update','KehadiranController@update');
Route::get('/kehadiran/{id_jadwal}/history/','KehadiranController@showHistory')->name('meeting.history');
Route::get('/kehadiran/presenceCount/{pt_id}',"KehadiranController@getKehadiranPertemuan");


//Operasi QR
Route::resource('/validator',"ManajemenValidatorController");
Route::get('/validator/generateQrCode/{pt_id}',"ManajemenValidatorController@generateQrCode");


//Rekapitulasi Mahasiswa
Route::get('/rekapitulasi/mahasiswa/json',"RekapitulasiMahasiswaController@json");
Route::resource('/rekapitulasi/mahasiswa',"RekapitulasiMahasiswaController");

//Rekapitulasi Dosen
Route::get('/rekapitulasi/dosen/json',"RekapitulasiDosenController@json");
Route::resource('/rekapitulasi/dosen',"RekapitulasiDosenController");

//Rekapitulasi Pertemuan
Route::get('/rekapitulasi/pertemuan/json',"RekapitulasiPegawaiController@json");
Route::resource('/rekapitulasi/pertemuan',"RekapitulasiPegawaiController");

//Multi-user Management
//Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function (){
//    Route::resource('/users', 'UsersController', ['except' => ['show','create', 'store']]);
//});

//reset password
Route::GET('password/form/{token}', 'Mobile\PasswordResetController@showForm')->name('Passeord.showForm');

//Kurikulum
Route::resource('/kurikulum',"KurikulumController");



