<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\Employee;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Employee::all();
        return view('admin.users.index')->with('users', $users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {

        if(Gate::denies('manage-users')){
            return redirect(route('admin.users.index'));
        }

        $employee = Employee::find($id);
        $roles = Role::all();


        return view('admin.users.edit')->with([
            'employee' => $employee,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

//        $employee=Employee::where("PE_Nip",$id);
//        DB::select(" Select id from table employees where id=".$id);


        $employee->roles()->sync($request->roles);
        $employee->PE_NamaLengkap = $request->PE_NamaLengkap;
        $employee->PE_Email = $request->PE_Email;
        $employee->save();

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        if(Gate::denies('manage-users')){
            return redirect(route('admin.users.index'));
        }
        $employee = Employee::find($id);
        $employee->roles()->detach();
        $employee->delete();

        return redirect()->route('admin.users.index');
    }
}
