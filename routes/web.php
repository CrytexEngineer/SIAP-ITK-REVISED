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
    if (Auth::check()) {
        $role = (Auth::user()->roles->pluck('id')[0]);
        return view('welcome')->with([
            'role' => $role]);
    } else {
        return view('welcome');
    }
});




//Testing Routes
Auth::routes();

Route::get('/register/mahasiswa', 'RegisterMahasiswaController@showRegistrationForm')->name('register/mahasiswa');
Route::get('/register/pegawai', 'RegisterPegawaiController@showRegistrationForm');
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json')->middleware('can:admin');
Route::resource('/register/pegawai', 'RegisterPegawaiController');
Route::resource('/mahasiswa/mahasiswa', 'ManajemenAkunMahasiswaController')->middleware('can:admin');

//Program Studi
Route::get('/program_studi/json', 'ManajemenProgramStudiController@json')->middleware('can:admin');
Route::resource('/program_studi', 'ManajemenProgramStudiController')->middleware('can:admin');
Route::post('/program_studi/import', 'ManajemenProgramStudiController@import')->name('import_program_studi')->middleware('can:admin');

//Mata Kuliah
Route::get('matakuliah/json', 'ManajemenMataKuliahController@json')->middleware('can:admin');
Route::resource('/matakuliah', 'ManajemenMatakuliahController')->middleware('can:admin');
Route::post('/matakuliah/import', 'ManajemenMatakuliahController@import')->name('import_matakuliah')->middleware('can:admin');

//Kelas
Route::get('/kelas/json', 'ManajemenKelasController@json')->middleware('can:admin');
Route::resource('/kelas', 'ManajemenKelasController')->middleware('can:admin');
Route::post('/kelas/import', 'ManajemenKelasController@import')->name('import_kelas')->middleware('can:admin');
Route::post('/kelas/fetch', 'ManajemenKelasController@fetch')->name('kelas.fetch')->middleware('can:admin');
Route::post('/kelas/fetch_pengajar', 'ManajemenKelasController@fetch_pengajar')->name('kelas.fetch_pengajar')->middleware('can:admin');

//Manajemen Kelas
Route::get('/kelas/{id}/manage/json', 'ManajemenKelasController@manage_json')->middleware('can:admin');
Route::get('/kelas/{id}/manage', 'ManajemenKelasController@manage')->middleware('can:admin');
Route::post('/kelas/{id}/manage/store', 'ManajemenKelasController@manage_store')->middleware('can:admin');
Route::delete('/kelas/{id}/manage/delete', 'ManajemenKelasController@manage_delete')->middleware('can:admin');


//KHS
Route::get('/khs/json', 'ManajemenKHSController@json')->middleware('can:admin');
Route::resource('/khs', 'ManajemenKHSController')->middleware('can:admin');
Route::post('/khs/import', 'ManajemenKHSController@import')->name('import_khs')->middleware('can:admin');


//Pegawai
Route::get('/akunpegawai/json', 'ManajemenAkunPegawaiController@json')->middleware('can:admin');
Route::resource('/akunpegawai', 'ManajemenAkunPegawaiController')->name('*', 'admin.users.index')->middleware('can:admin');
Route::post('/akunpegawai/import', 'ManajemenAkunPegawaiController@import')->name('import_employee')->middleware('can:admin');

//Mahasiswa
Route::get('/akunmahasiswa/json', 'ManajemenAkunMahasiswaController@json')->middleware('can:admin');
Route::resource('/akunmahasiswa', 'ManajemenAkunMahasiswaController')->middleware('can:admin');
Route::post('/akunmahasiswa/import', 'ManajemenAkunMahasiswaController@import')->name('import_mahasiswa')->middleware('can:admin');

//Dosen
Route::middleware('can:dosen')->group(function () {
    Route::get('jadwal_mengajar', 'DosenController@jadwal_mengajar')->name('jadwal_mengajar');
    Route::get('jadwal_mengajar/json', 'DosenController@jadwal_mengajar_json');


});

//ManajemenPertemuanController
Route::get('pertemuan/index/json', 'ManajemenPertemuanController@index_json');
Route::get('pertemuan/', 'ManajemenPertemuanController@index');
Route::get('pertemuan/{id_jadwal}/dashboard', 'ManajemenPertemuanController@dashboard');
Route::post('/pertemuan', 'ManajemenPertemuanController@store');
Route::get('pertemuan/{id_jadwal}/create', 'ManajemenPertemuanController@create');
Route::get('/pertemuan/{id_jadwal}/history/', 'ManajemenPertemuanController@showHistory')->name('meeting.history');
Route::get('/pertemuan/{id}/delete', 'ManajemenPertemuanController@destroy');
Route::get('/kehadiran/presenceCount/{pt_id}', "ManajemenPertemuanController@getKehadiranPertemuan");


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

//test
Route::get('export', "ExportMajor@export");
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
Route::get('/riwayat_data/json', "ManajemenLogbookController@json")->middleware('can:admin');
Route::resource('/riwayat_data', "ManajemenLogbookController")->middleware('can:admin');
Route::get('/delete_all', 'DeleteAllController@destroy')->name('delete.all')->middleware('can:admin');

//Multi-user Management
//Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function (){
//    Route::resource('/users', 'UsersController', ['except' => ['show','create', 'store']]);
//});

//reset password
Route::get('password/form/{token}', 'Mobile\PasswordResetController@showForm')->name('Passeord.showForm');
Route::get('/password/success', 'Mobile\PasswordResetController@index');

//Kurikulum
Route::get('/kurikulum/json', "ManajemenKurikulumController@json")->middleware('can:admin');
Route::resource('/kurikulum', "ManajemenKurikulumController")->middleware('can:admin');

//Helper Query Matakuliah
Route::get('/subjectQuery', "FilterHelperController@subjectQuery")->name('subjectQuery');


