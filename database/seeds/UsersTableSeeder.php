<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\Employee;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        DB::table('employees')->truncate();
        $superAdminRole = Role::where('role_name', 'Super Admin') -> first();
        $superAdmin = Employee::create([
            'PE_Nip' => '111111',
            'PE_Email' => 'super_admin@itk.ac.id',
            'PE_NamaLengkap' => 'Super Admin',
            'PE_Nama' => 'Super Admin',
            'password' => Hash::make('password')
        ]);


        $superAdmin->roles()->attach($superAdminRole);
        DB::statement("SET foreign_key_checks=1");

    }
}
