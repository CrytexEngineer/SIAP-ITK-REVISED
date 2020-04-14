<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ManajemenAkunPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    function json()
    {
        return Datatables::of(User::all())->make(true);
    }

    public function index()
    {

    }

    public function indexUserPegawai()
    {
        User::where('role', '<', 10)->get()->all();
    }

    public function indexUserMahasiswa()
    {
        User::where('role', 10)->get()->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function editUserPegawai($id)
    {

    }

    public function editUserMahasiswa($id)
    {

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
        Validator::make($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'integer']
        ]);

        $user = User::find($id);
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['password'] = $request['password'];
        $user['role'] = $request['role'];
        $user->save();
        $user->roles()->sync($user['role']);

        if ($user['role'] != 10) {
            $user->employee['PE_Nama'] = $user['email'];
            $user->employee['PE_NamaLengkap'] = $user['email'];
            $user->employee['PE_Email'] = $user['email'];
            $user->employee->save();
        } else {
            $user->student['MA_NamaLengkap'] = $user['email'];
            $user->student['MA_Email'] = $user['email'];
            $user->student->save();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->delete()) {
            $user->employee()->delete();
            $user->student()->delete();
        }
    }
}
