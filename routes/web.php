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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $role = (Auth::user()->roles->pluck('id')[0]);
        return view('welcome')->with([
            'role' => $role]);
    } else {
        return view('welcome');
    }
});


//Sesion Management
Auth::routes();

//Kurikulum
Route::middleware('can:super-admin')->group(function () {
    Route::get('/kurikulum/json', "ManajemenKurikulumController@json");
    Route::resource('/kurikulum', "ManajemenKurikulumController");
});

//Program Studi
Route::middleware('can:admin')->group(function () {
    Route::get('/program_studi/json', 'ManajemenProgramStudiController@json');
    Route::resource('/program_studi', 'ManajemenProgramStudiController');
    Route::post('/program_studi/import', 'ManajemenProgramStudiController@import')->name('import_program_studi');
});

//Mata Kuliah
Route::middleware('can:admin')->group(function () {
    Route::get('matakuliah/json', 'ManajemenMataKuliahController@json');
    Route::resource('/matakuliah', 'ManajemenMatakuliahController');
    Route::post('/matakuliah/import', 'ManajemenMatakuliahController@import')->name('import_matakuliah');
});

//Kelas
Route::middleware('can:admin')->group(function () {
    Route::get('/kelas/json', 'ManajemenKelasController@json');
    Route::resource('/kelas', 'ManajemenKelasController');
    Route::post('/kelas/import', 'ManajemenKelasController@import')->name('import_kelas');
    Route::post('/kelas/fetch', 'ManajemenKelasController@fetch')->name('kelas.fetch');
    Route::post('/kelas/fetch_pengajar', 'ManajemenKelasController@fetch_pengajar')->name('kelas.fetch_pengajar');
});

//Manajemen Kelas
Route::middleware('can:admin')->group(function () {
    Route::get('/kelas/{id}/manage/json', 'ManajemenKelasController@manage_json');
    Route::get('/kelas/{id}/manage', 'ManajemenKelasController@manage');
    Route::post('/kelas/{id}/manage/store', 'ManajemenKelasController@manage_store');
    Route::delete('/kelas/{id}/manage/delete', 'ManajemenKelasController@manage_delete');
});

//KHS
Route::middleware('can:admin')->group(function () {
    Route::get('/khs/json', 'ManajemenKHSController@json');
    Route::resource('/khs', 'ManajemenKHSController');
    Route::post('/khs/import', 'ManajemenKHSController@import')->name('import_khs');
});

//Pegawai
Route::middleware('can:admin')->group(function () {
    Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json');
    Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController')->name('*', 'admin.users.index');
    Route::post('/akunpegawai/import', 'ManajemenAkunPegawaiController@import')->name('import_employee');
});

//Mahasiswa
Route::middleware('can:admin')->group(function () {
    Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json');
    Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController');
    Route::post('/akunmahasiswa/import', 'ManajemenAkunMahasiswaController@import')->name('import_mahasiswa');
});

//Dosen
Route::middleware('can:dosen')->group(function () {
    Route::get('jadwal_mengajar', 'DosenController@jadwal_mengajar')->name('jadwal_mengajar');
    Route::get('jadwal_mengajar/json', 'DosenController@jadwal_mengajar_json');
});

//ManajemenPertemuanController
Route::middleware('can:perkuliahan')->group(function () {
    Route::get('pertemuan/index/json', 'ManajemenPertemuanController@index_json');
    Route::get('pertemuan/', 'ManajemenPertemuanController@index');
    Route::get('pertemuan/{id_jadwal}/dashboard', 'ManajemenPertemuanController@dashboard');
    Route::post('/pertemuan', 'ManajemenPertemuanController@store');
    Route::get('pertemuan/{id_jadwal}/create', 'ManajemenPertemuanController@create');
    Route::get('/pertemuan/{id_jadwal}/history/', 'ManajemenPertemuanController@showHistory')->name('meeting.history');
    Route::get('/pertemuan/{id}/delete', 'ManajemenPertemuanController@destroy');
    Route::get('/kehadiran/presenceCount/{pt_id}', "ManajemenPertemuanController@getKehadiranPertemuan");
});

//Manajemen Presensi
Route::middleware('can:admin')->group(function () {
    Route::get('presensi/{ku_id}/manage', 'ManajemenPresensiController@manage');
    Route::get('presensi/{ku_id}/create', 'ManajemenPresensiController@create');
    Route::post('presensi/', 'ManajemenPresensiController@store');
    Route::delete('presensi/{PR_ID}', 'ManajemenPresensiController@destroy');
    Route::get('presensi/{ku_id}/manage/json', 'ManajemenPresensiController@manage_json');

});


//Operasi QR
Route::resource('/validator', "ManajemenValidatorController");
Route::get('/validator/generateQrCode/{pt_id}', "ManajemenValidatorController@generateQrCode");

//Rekapitulasi Mahasiswa

Route::get('rekapitulasi/mahasiswa/showExportSubjectPage', "RekapitulasiMahasiswaController@showExportSubjectPage");
Route::get('rekapitulasi/mahasiswa/export/major', "RekapitulasiMahasiswaController@saveMajor");
Route::post('rekapitulasi/mahasiswa/export/subject', "RekapitulasiMahasiswaController@saveSubject");
Route::get('/rekapitulasi/mahasiswa/json', "RekapitulasiMahasiswaController@json")->middleware('can:admin');
Route::resource('/rekapitulasi/mahasiswa', "RekapitulasiMahasiswaController")->name('*', 'rekapitulasi_mahasiswa')->middleware('can:admin');

//Rekapitulasi Dosen
Route::get('rekapitulasi/dosen/showExportSubjectPage', "RekapitulasiDosenController@showExportSubjectPage");
Route::get('rekapitulasi/dosen/export/major', "RekapitulasiDosenController@saveMajor");
Route::post('rekapitulasi/dosen/export/subject', "RekapitulasiDosenController@saveSubject");
Route::get('/rekapitulasi/dosen/json', "RekapitulasiDosenController@json")->middleware('can:admin');
Route::resource('/rekapitulasi/dosen', "RekapitulasiDosenController")->middleware('can:admin');


//ManajemenData
Route::middleware('can:admin')->group(function () {
    Route::get('/riwayat_data/json', "ManajemenLogbookController@json");
    Route::resource('/riwayat_data', "ManajemenLogbookController");
    Route::get('/delete_all', 'DeleteAllController@destroy')->name('delete.all');
});

//reset password
Route::get('password/form/{token}', 'Mobile\PasswordResetController@showForm')->name('Passeord.showForm');
Route::get('/password/success', 'Mobile\PasswordResetController@index');


//Helper Query Matakuliah
Route::get('/subjectQuery', "FilterHelperController@subjectQuery")->name('subjectQuery');


