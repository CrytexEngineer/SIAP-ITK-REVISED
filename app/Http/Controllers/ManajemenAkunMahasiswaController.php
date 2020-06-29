<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Logbook;
use App\Major;
use App\Student;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenAkunMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function json()
    {
        $role = (Auth::user()->roles->pluck('id')[0]);
        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {
            return Datatables::of(Student::all())
                ->addColumn('action', function ($row) {
                    $action = '<a href="/akunmahasiswa/' . $row->MA_Nrp . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => 'akunmahasiswa/' . $row->MA_Nrp, 'method' => 'delete', 'style' => 'float:right']);
                    $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                    $action .= \Form::close();
                    return $action;

                })
                ->make(true);
        } else {
            $jurusan = Auth::user()->PE_KodeJurusan;
            $idJurusan = Major::all()->where('PS_Kode_Prodi',$jurusan)->pluck('PS_ID')->first();
            $mahasiswa = Student::all();
            return Datatables::of(DB::select("select * from students where SUBSTRING(students.MA_Nrp,5,3) = 110"))
                ->addColumn('action', function ($row) {
                    $action = '<a href="/akunmahasiswa/' . $row->MA_Nrp . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => 'akunmahasiswa/' . $row->MA_Nrp, 'method' => 'delete', 'style' => 'float:right']);
                    $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                    $action .= \Form::close();
                    return $action;
                })
                ->make(true);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mahasiswa.mahasiswa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create_mahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'MA_NamaLengkap.required' => 'Nama mahasiswa tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email yang Anda masukkan tidak sesuai.',
            'email.unique' => 'Email sudah terdaftar, harap masukan email yang baru.',
            'MA_NRP_Baru.required' => 'NIM tidak boleh kosong.',
            'MA_NRP_Baru.unique' => 'NIM sudah ada di database.',
            'MA_NRP_Baru.integer' => 'NIM tidak boleh selain angka.',
            'MA_PASSWORD.required' => 'Password tidak boleh kosong.',
            'MA_PASSWORD.min' => 'Password minimal 6 huruf/angka.'
        ];

        $request->validate([
            'MA_NamaLengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'MA_PASSWORD' => ['required', 'string', 'min:6'],
            'MA_NRP_Baru' => ['required', 'integer', 'unique:students'],
        ], $messages);

        $mahasiswa = Student::create([
            'email' => $request->email,
            'MA_Nrp' => $request->MA_NRP_Baru,
            'MA_NamaLengkap' => $request->MA_NamaLengkap,
            'MA_NRP_Baru' => $request->MA_NRP_Baru,
            'MA_PASSWORD' => Hash::make($request->MA_PASSWORD)
        ]);

//        $mahasiswa = New Student();
//        $mahasiswa->MA_PASSWORD = Hash::make($request->MA_PASSWORD);
//        $mahasiswa->create($request->all());

        Logbook::write(Auth::user()->PE_Nip, 'Menambah data mahasiswa ' . $mahasiswa->MA_NamaLengkap . ' dari tabel mahasiswa', Logbook::ACTION_CREATE, Logbook::TABLE_STUDENTS);
        return redirect('/akunmahasiswa')->with('success', 'Data mahasiswa berhasil disimpan!');

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['users'] = Student::where('MA_Nrp', $id)->first();
        return view('mahasiswa.edit_mahasiswa', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        $user = User::where('email', $id)->with('student')->get()->first();
//        if ($user != null) {
//
//            $user->update($request->except(['_token', '_method']));
//            $user->student->where('MA_Nrp', $user->student['MA_Nrp'])->update(
//                [
//                    'MA_NamaLengkap' => $user['name'],
//                    'email' => $user['email'],]
//            );
//
//        }
//        return redirect('/akunmahasiswa')->with('status', 'Data Berhasil Diubah');

        $mahasiswa = Student::where('MA_Nrp', '=', $id)->first();
        $mahasiswa->MA_NamaLengkap = $request->MA_NamaLengkap;
        $mahasiswa->email = $request->email;
        //SYNTAX KETIKA PASSWORD DIISI KOSONG MAKA DIISI PASSWORD LAMA
        if ($request->MA_PASSWORD != '') {
            $mahasiswa->MA_PASSWORD = Hash::make($request->MA_PASSWORD);
        }

        $mahasiswa->save();
        Logbook::write(Auth::user()->PE_Nip, 'Mengubah data mahasiswa ' . $mahasiswa->MA_NamaLengkap . ' dari tabel mahasiswa', Logbook::ACTION_EDIT, Logbook::TABLE_STUDENTS);
        //$mahasiswa->update($request->except('_method','_token'));
        return redirect('/akunmahasiswa')->with('success', 'Data mahasiswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $user = User::where('email', $id)->with('student');
//        if ($user != null) {
//
//            if ($user->delete()) {
//                $student = \App\Student::where('email', $id);
//                $student->delete();
//            }
//        }
//        return redirect('/akunmahasiswa')->with('status_failed', 'Data Berhasil Dihapus');

        $mahasiswa = Student::where('MA_Nrp', $id)->first();


        if ($mahasiswa->delete()) {
            Logbook::write(Auth::user()->PE_Nip, 'Menghapus data mahasiswa ' . $mahasiswa->MA_NamaLengkap . ' dari tabel mahasiswa', Logbook::ACTION_DELETE, Logbook::TABLE_STUDENTS);
        }
        return redirect('/akunmahasiswa')->with('toast_warning', 'Data Mahasiswa Berhasil Dihapus!');
    }

    public function import()
    {
        $data = Excel::import(new StudentsImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip, 'Mengimpor data mahasiswa  dari tabel mahasiswa', Logbook::ACTION_IMPORT, Logbook::TABLE_STUDENTS);

        }
        return back()->with('toast_success', 'Import data mahasiswa berhasil!');

    }
}
