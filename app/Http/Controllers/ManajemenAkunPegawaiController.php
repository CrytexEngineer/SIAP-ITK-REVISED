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
        return Datatables::of(Employee::with('roles')->get()->all())
            ->addColumn('action', function ($row) {
                $action  = '<a href="/akunpegawai/'.$row->PE_Nip.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url'=>'akunpegawai/'.$row->PE_Nip,'method'=>'delete','style'=>'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;
            })
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employee.pegawai')->with('employees',$employees);    }

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
//            return redirect('/akunpegawai')->with('status', 'Data Pegawai Berhasil Disimpan');
//
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
        $employee->save();
        return redirect('/akunpegawai')->with('status', 'Data Berhasil Diubah');
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
        $employee->delete();
        return redirect('/akunpegawai')->with('status_failed', 'Data Berhasil Dihapus');
    }

    function import()
    {

        $data = Excel::import(new EmployeesImport(), request()->file('file'));
        return back();
    }


}

