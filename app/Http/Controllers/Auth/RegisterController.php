<?php

namespace App\Http\Controllers\Auth;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use App\Student;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'PE_Nip' => ['required', 'integer', 'unique:employees'],
            'role' => ['required', 'integer']
        ]);
        if ($validator->fails()) {
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'MA_Nrp' => ['required', 'integer', 'unique:students'],
                'role' => ['required', 'integer']
            ]);
        }


        return $validator;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
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

            return $user;
        }
        $student = new Student([
            'MA_Nrp' => $data['MA_Nrp'],
            'MA_NRP_Baru' => $data['MA_Nrp'],
            'MA_NamaLengkap' => $data['name'],
            'MA_Email' => $data['email']
        ]);
        if ($student->save()) {
            User::create($user);
            $user = User::where('email', $data['email'])->first();
            $role = Role::where('id', $data['role'])->get()->first();
            $user->roles()->attach($role);
        }
        return $user;
    }


}
