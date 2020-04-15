<?php

namespace App\Http\Controllers;

use App\Imports\KHSImport;
use App\Imports\StudentsImport;
use App\Role;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenAkunMahasiswaController extends Controller
{

    function json()
    {
        return Datatables::of(DB::table('users')
            ->join('students', 'users.email', '=', 'students.MA_Email')
            ->where('role','=','10')->get()->all())
            ->addColumn('action', function ($row) {
                $action = '<a href="/mahasiswa/mahasiswa/' . $row->email . '/edit" class="btn btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                $action .= \Form::open(['url' => 'akunmahasiswa/' . $row->email, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
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

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'MA_Nrp' => ['required', 'integer', 'unique:students'],
            'role' => ['required', 'integer'],]);

        $data = $request->all();
        $user = [
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
        ];

        $student = new \App\Student([
            'MA_Nrp' => $data['MA_Nrp'],
            'MA_NRP_Baru' => $data['MA_Nrp'],
            'MA_NamaLengkap' => $data['name'],
            'MA_Email' => $data['email']]);


        if ($student->save()) {
            User::create($user);
            $user = User::where('email', $data['email'])->first();
            $role = Role::where('id', $data['role'])->get()->first();
            $user->roles()->attach($role);
        }

        return redirect('/akunmahasiswa')->with('status','Data Mahasiswa Berhasil Disimpan');
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
        $data['users'] = User::where('email', $id)->first();
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

        $user = User::where('email', $id)->with('student')->get()->first();
        if ($user != null) {

            $user->update($request->except(['_token', '_method']));
            $user->student->where('MA_Nrp', $user->student['MA_Nrp'])->update(
                [
                    'MA_NamaLengkap' => $user['name'],
                    'MA_Email' => $user['email'],]
            );

        }
        return redirect('/akunmahasiswa')->with('status', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('email', $id)->with('student');
        if ($user != null) {

            if ($user->delete()) {
                $student = \App\Student::where('MA_Email', $id);
                $student->delete();
            }
        }
        return redirect('/akunmahasiswa')->with('status_failed', 'Data Berhasil Dihapus');
    }

    public function import(){
        $data = Excel::import(new StudentsImport(), request()->file('file'));
        return back();

    }
}
