<?php

namespace App\Http\Controllers;

use App\Employee;
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
            return Datatables::of(Employee::with('roles')->leftJoin('majors','employees.PE_KodeJurusan','=','PS_Kode_Prodi')->get()->all())
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
            return Datatables::of(Employee::with('roles')->leftJoin('majors','employees.PE_KodeJurusan','=','PS_Kode_Prodi')
                ->where('employees.PE_KodeJurusan','=',$jurusan)
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
        $employees = Employee::all();
        return view('employee.pegawai')->with('employees', $employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $data['employee'] = Employee::with(roles)->get()->all();
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
            'name.required' => 'Nama tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email yang Anda masukkan tidak sesuai.',
            'email.unique' => 'Email sudah terdaftar, harap masukan email yang baru.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 huruf/angka.',
            'PE_NIP.required' => 'NIP tidak boleh kosong.',
            'PE_NIP.integer' => 'NIP tidak boleh selain angka.',
            'PE_NIP.unique' => 'NIP yang Anda masukkan sudah terdaftar.'
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'PE_Nip' => ['required', 'integer', 'unique:employees'],
            'role' => ['required', 'integer']
        ], $messages);

        $data = $request->all();
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ];

//        $employee = [];
//        if ($data['role'] != 10) {
//            if ($data['role'] >= 1 && $data['role'] <= 6 || $data['role'] == 9) {
//
//                $employee = New Employee([
//                    'PE_Nip' => $data['PE_Nip'],
//                    'PE_Nama' => $data['name'],
//                    'PE_NamaLengkap' => $data['name'],
//                    'PE_Email' => $data['email'],
//                    'PE_TipePegawai' => 0
//                ]);
//            }
//
//            if ($data['role'] == 7 || $data['role'] == 8) {
//                $employee = New Employee([
//                    'PE_Nip' => $data['PE_Nip'],
//                    'PE_Nama' => $data['name'],
//                    'PE_NamaLengkap' => $data['name'],
//                    'PE_Email' => $data['email'],
//                    'PE_TipePegawai' => 1
//                ]);
//            }
//
//
//            if ($employee->save()) {
//
//                User::create($user);
//                $user = User::where('email', $data['email'])->first();
//                $role = Role::where('id', $data['role'])->get()->first();
//                $user->roles()->attach($role);
//            }
            return redirect('/akunpegawai')->with('status', 'Data pegawai berhasil disimpan');
//        Logbook::write(Auth::user()->PE_Nip, 'Menambah data pegawai ' . $employee->PE_NamaLengkap . ' dari tabel pegawai',Logbook::Create ,Logbook::TABLE_EMPLOYEES);
//        }
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
        $employee = Employee::find($id);
        $employee->roles()->sync($request->roles);
        $employee->PE_Nip = $request->PE_Nip;
        $employee->PE_NamaLengkap = $request->PE_NamaLengkap;
        $employee->PE_Email = $request->PE_Email;
        $employee->PE_KodeJurusan = $request->PE_KodeJurusan;
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

