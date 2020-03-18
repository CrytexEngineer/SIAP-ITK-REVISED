<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Imports\ClasesImport;
use App\Imports\EmployeesImport;
use App\Role;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenAkunPegawaiController extends Controller
{

    function json()
    {
        return Datatables::of(DB::table('users')
            ->join('employees', 'users.email', '=', 'employees.PE_Email')
            ->join('roles', 'users.role', '=', 'roles.id')->where('role', '<', '10')->get()->all())
            ->addColumn('action', function ($row) {
                $action = '<a href="/manajemen_akun/pegawai/' . $row->email . '/edit" class="btn btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $action .= \Form::open(['url' => 'akunpegawai/' . $row->email, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                $action .= \Form::close();
                return $action;

            })
            ->make(true);
        //Khusus di pegawai harus query ke roles selain mahasiswa
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manajemen_akun.pegawai');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manajemen_akun.create_pegawai');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'PE_Nip' => ['required', 'integer', 'unique:employees'],
            'role' => ['required', 'integer']
        ]);
        $data = $request->all();
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ];

        $employee = [];
        if ($data['role'] != 10) {
            if ($data['role'] >= 1 && $data['role'] <= 6 || $data['role'] == 9) {

                $employee = New Employee([
                    'PE_Nip' => $data['PE_Nip'],
                    'PE_Nama' => $data['name'],
                    'PE_NamaLengkap' => $data['name'],
                    'PE_Email' => $data['email'],
                    'PE_TipePegawai' => 0
                ]);
            }

            if ($data['role'] == 7 || $data['role'] == 8) {
                $employee = New Employee([
                    'PE_Nip' => $data['PE_Nip'],
                    'PE_Nama' => $data['name'],
                    'PE_NamaLengkap' => $data['name'],
                    'PE_Email' => $data['email'],
                    'PE_TipePegawai' => 1
                ]);
            }


            if ($employee->save()) {

                User::create($user);
                $user = User::where('email', $data['email'])->first();
                $role = Role::where('id', $data['role'])->get()->first();
                $user->roles()->attach($role);
            }
            return redirect('/akunpegawai')->with('status', 'Data Pegawai Berhasil Disimpan');

        }
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
        $data['users'] = User::where('email', $id)->first();
        return view('manajemen_akun.edit_pegawai', $data);


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
        $user = User::where('email', $id)->with('roles')->with('employee')->get()->first();
        if ($user != null) {
            $user->update($request->except(['_token', '_method']));
            $user->roles()->sync($user['role']);

            $user->employee->where('PE_Nip', $user->employee['PE_Nip'])->update(
                [
                    'PE_Nama' => $user['name'],
                    'PE_NamaLengkap' => $user['name'],
                    'PE_Email' => $user['email']]
            );
        }
        return redirect('manajemen_akun/pegawai')->with('status', 'Data Berhasil Diubah');
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
        $user = User::where('email', $id)->with('employee');
        if ($user != null) {
            if ($user->delete()) {
                $employee = Employee::where('PE_Email', $id);
                $employee->delete();
            }
        }
        return redirect('/manajemen_akun/pegawai')->with('status_failed', 'Data Berhasil Dihapus');
    }

    function import()
    {

        $data = Excel::import(new EmployeesImport(), request()->file('file'));
        return back();
    }
}

