<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeRole;
use App\Imports\EmployeesImport;
use App\Logbook;
use App\Major;
use App\Role;
use DataTables;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenAkunPegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function json()
    {
        $role = (Auth::user()->roles->pluck('id')->first());
        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {
            return Datatables::of(Employee::with('roles')->leftJoin('majors', 'employees.PE_KodeJurusan', '=', 'PS_Kode_Prodi')->get()->all())
                ->addColumn('action', function ($row) {
                    $action = '<a href="/akunpegawai/' . $row->PE_Nip . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => 'akunpegawai/' . $row->PE_Nip, 'method' => 'delete', 'style' => 'float:right']);
                    $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                    $action .= \Form::close();
                    return $action;
                })
                ->make(true);
        } else {
            $jurusan = Auth::user()->PE_KodeJurusan;
            return Datatables::of(Employee::with('roles')->leftJoin('majors', 'employees.PE_KodeJurusan', '=', 'PS_Kode_Prodi')
                ->where('employees.PE_KodeJurusan', '=', $jurusan)
                ->get()->all())
                ->addColumn('action', function ($row) {
                    $action = '<a href="/akunpegawai/' . $row->PE_Nip . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => 'akunpegawai/' . $row->PE_Nip, 'method' => 'delete', 'style' => 'float:right']);
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
        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('employee.pegawai', $data);
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('employee.pegawai', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        return view('employee.create_pegawai', $data)->with([
            'roles' => $roles
        ]);

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
            'PE_NamaLengkap.required' => 'Nama tidak boleh kosong.',
            'PE_NamaLengkap.string' => 'Nama tidak boleh memakai huruf.',
            'PE_Email.required' => 'Email tidak boleh kosong',
            'PE_Email.email' => 'Email yang Anda masukkan tidak sesuai.',
            'PE_Email.unique' => 'Email sudah terdaftar, harap masukan email yang baru.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'PE_Nip.required' => 'NIP tidak boleh kosong.',
            'PE_KodeJurusan.required' => 'Program Studi tidak boleh kosong.',
            'PE_Nip.integer' => 'NIP tidak boleh selain angka.',
            'PE_Nip.unique' => 'NIP yang Anda masukkan sudah terdaftar.',
            'roles.required' => 'Roles tidak boleh kosong.'
        ];

        $request->validate([
            'PE_NamaLengkap' => ['required', 'string', 'max:255'],
            'PE_Email' => ['required', 'email', 'max:255', 'unique:employees'],
            'password' => ['required', 'string', 'min:8'],
            'PE_Nip' => ['required', 'integer', 'unique:employees'],
            'PE_KodeJurusan' => ['required'],
            'roles' => ['required']
        ], $messages);

        $pegawai = New Employee();
        $pegawai->PE_Nip = $request->PE_Nip;
        $pegawai->PE_NamaLengkap = $request->PE_NamaLengkap;
        $pegawai->PE_Nama = $request->PE_NamaLengkap;
        $pegawai->PE_KodeJurusan = $request->PE_KodeJurusan;
        $pegawai->PE_Email = $request->PE_Email;
        $pegawai->password = Hash::make($request->password);
        $pegawai->save();
        $pegawai->roles()->attach($request->roles);

        return redirect('/akunpegawai')->with('success', 'Data pegawai berhasil ditambahkan!');
        Logbook::write(Auth::user()->PE_Nip,
            'Menambah data kelas ' . $kelas->KE_KR_MK_ID . ' kelas ' . $kelas->KE_Kelas . ' dari tabel kelas', Logbook::ACTION_CREATE,
            Logbook::TABLE_CLASSES);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $roles = Role::all();
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        $data['employee'] = Employee::where('PE_Nip', $id)->first();
        return view('employee.edit_pegawai', $data)->with([
            'id' => $id,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        $messages = [
            'PE_NamaLengkap.required' => 'Nama tidak boleh kosong.',
            'PE_NamaLengkap.string' => 'Nama tidak boleh memakai huruf.',
            'PE_Email.required' => 'Email tidak boleh kosong',
            'PE_KodeJurusan.required' => 'Program Studi tidak boleh kosong.',
            'PE_Nip.integer' => 'NIP tidak boleh selain angka.',
            'PE_Nip.unique' => 'NIP yang Anda masukkan sudah terdaftar.',
            'roles.required' => 'Roles tidak boleh kosong.'
        ];

        $request->validate([
            'PE_NamaLengkap' => ['required', 'string', 'max:255'],
            'PE_Nip' => ['required', 'integer'],
            'PE_KodeJurusan' => ['required'],
            'roles' => ['required']
        ], $messages);

        $employee = Employee::find($id);
        $employee->roles()->sync($request->roles);
        $employee->PE_Nip = $request->PE_Nip;
        $employee->PE_NamaLengkap = $request->PE_NamaLengkap;
        $employee->PE_Email = $request->PE_Email;
        $employee->PE_KodeJurusan = $request->PE_KodeJurusan;
        if ($request->password != '') {
            $employee->password = Hash::make($request->password);
        }

        if ($employee->save()) {
            Logbook::write(Auth::user()->PE_Nip, 'Mengubah data pegawai ' . $employee->PE_NamaLengkap . ' dari tabel pegawai', Logbook::ACTION_EDIT, Logbook::TABLE_EMPLOYEES);
        };
        return redirect('/akunpegawai')->with('success', 'Data pegawai berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->roles()->detach();
        if ($employee->delete()) {
            Logbook::write(Auth::user()->PE_Nip,
                'Menghapus data pegawai ' . $employee->PE_NamaLengkap . ' dari tabel pegawai', Logbook::ACTION_DELETE,
                Logbook::TABLE_EMPLOYEES);

        };
        return redirect('/akunpegawai')->with('toast_warning', 'Data berhasil dihapus');
    }

    function import()
    {

        $data = Excel::import(new EmployeesImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip, 'Mengimpor data pegawai  dari tabel pegawai', Logbook::ACTION_IMPORT, Logbook::TABLE_EMPLOYEES);
        }
        return back()->with('toast_success', 'Import data pegawai berhasil!');
    }


}

