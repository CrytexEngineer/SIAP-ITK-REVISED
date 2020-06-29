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
            'PE_Email' => '',
            'PE_NamaLengkap' => 'Super Admin',
            'PE_Nama' => 'Super Admin',
            'password' => Hash::make('password')
        ]);

        $tendikPusatRole = Role::where('role_name', 'Tendik Pusat') -> first();
        $tendikPusat = Employee::create([
           'PE_Nip' => '222222',
            'PE_Email' => '',
            'PE_NamaLengkap' => 'Tendik Pusat',
            'PE_Nama' => 'Tendik Pusat',
            'password' => Hash::make('password'),
            'PE_KodeJurusan' => ''
        ]);

        $tendikJurusanSIRole = Role::where('role_name', 'Tendik Program Studi') -> first();
        $tendikJurusanSI = Employee::create([
            'PE_Nip' => '333333',
            'PE_Email' => '',
            'PE_NamaLengkap' => 'Tendik Program Studi',
            'PE_Nama' => 'Tendik Program Studi',
            'password' => Hash::make('password'),
            'PE_KodeJurusan' => '11110'
        ]);

        $dosenPengampuRole = Role::where('role_name', 'Dosen Pengampu') -> first();
        $dosenPengampu = Employee::create([
            'PE_Nip' => '100116057',
            'PE_Email' => '',
            'PE_NamaLengkap' => 'Sri Rahayu Natasia, S. Komp., M.Si',
            'PE_Nama' => 'Sri Rahayu Natasia, S. Komp., M.Si',
            'password' => Hash::make('password'),
            'PE_KodeJurusan' => ''
        ]);


        $superAdmin->roles()->attach($superAdminRole);
        $tendikPusat->roles()->attach($tendikPusatRole);
        $tendikJurusanSI->roles()->attach($tendikJurusanSIRole);
        $dosenPengampu->roles()->attach($dosenPengampuRole);
        DB::statement("SET foreign_key_checks=1");

    }
}
