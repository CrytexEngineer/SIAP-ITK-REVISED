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
//        $superadmin = Role::create(['role_name' => 'Super Admin']);
//        $admin = Role::create(['role_name' => 'Admin']);
//        $observer = Role::create(['role_name' => 'Observer']);
//        $warek = Role::create(['role_name' => 'Wakil Rektor']);
//        $kaprodi = Role::create(['role_name' => 'Ketua Prodi']);
//        $kajur = Role::create(['role_name' => 'Kepala Jurusan']);
//        $dikjur = Role::create(['role_name' => 'Tendik Jurusan']);
//        $diksat = App\Role::create(['role_name' => 'Tendik Pusat']);
//        $dosen = Role::create(['role_name' => 'Dosen Pengampu']);
//        $mahasiswa=Role::create(['role_name'=>'Mahasiswa']);


//        Employee::truncate();
        DB::table('employees')->delete();
//        DB::table('role_user')->truncate();

        $superAdminRole = Role::where('role_name', 'Super Admin') -> first();
//        $adminRole = Role::where('role_name', 'Admin') -> first();
//        $observerRole = Role::where('role_name', 'Observer') -> first();
//        $warekRole = Role::where('role_name', 'Wakil Rektor') -> first();
//        $kaprodiRole = Role::where('role_name', 'Ketua Prodi')->first();
//        $kajurRole = Role::where('role_name', 'Ketua Jurusan') -> first();
//        $dikjurRole = Role::where('role_name', 'Tendik Jurusan') -> first();
//        $diksatRole = Role::where('role_name', 'Tendik Pusat') -> first();
//        $dosenRole = Role::where('role_name', 'Dosen Pengampu') -> first();
//        $mahasiswaRole = Role::where('role_name', 'Mahasiswa') -> first();

        $superAdmin = Employee::create([
            'PE_Nip' => '111111',
            'PE_Email' => 'super_admin@itk.ac.id',
            'PE_NamaLengkap' => 'Super Admin',
            'PE_Nama' => 'Super Admin',
            'password' => Hash::make('password')
        ]);

//        $admin = Employee::create([
//            'PE_Nip' => '2222222',
//            'PE_Email' => 'admin@itk.ac.id',
//            'PE_NamaLengkap' => 'Admin',
//            'PE_Nama' => 'Admin',
//            'password' => Hash::make('password')
//        ]);
//
//        $observer = Employee::create([
//            'PE_Nip' => '3333333',
//            'PE_Email' => 'observer@itk.ac.id',
//            'PE_NamaLengkap' => 'Observer',
//            'PE_Nama' => 'Observer',
//            'password' => Hash::make('password')
//
//        ]);
//
//        $warek = Employee::create([
//            'PE_Nip' => '4444444',
//            'PE_Email' => 'warek@itk.ac.id',
//            'PE_NamaLengkap' => 'Wakil Rektor',
//            'PE_Nama' => 'Wakil Rektor',
//            'password' => Hash::make('password')
//        ]);
//
//        $kaprodi = Employee::create([
//            'PE_Nip' => '55555555',
//            'PE_Email' => 'kaprodi@itk.ac.id',
//            'PE_NamaLengkap' => 'Ketua Prodi',
//            'PE_Nama' => 'Ketua Prodi',
//            'password' => Hash::make('password')
//        ]);
//
//        $kajur = Employee::create([
//            'PE_Nip' => '6666666666',
//            'PE_Email' => 'kajur@itk.ac.id',
//            'PE_NamaLengkap' => 'Ketua Jurusan',
//            'PE_Nama' => 'Ketua Jurusan',
//            'password' => Hash::make('password')
//        ]);
//
//        $dikjur = Employee::create([
//            'PE_Nip' => '777777777',
//            'PE_Email' => 'dikjur@itk.ac.id',
//            'PE_NamaLengkap' => 'Tendik Jurusan',
//            'PE_Nama' => 'Tendik Jurusan',
//            'password' => Hash::make('password')
//        ]);
//
//        $diksat = Employee::create([
//            'PE_Nip' => '88888888888',
//            'PE_Email' => 'diksat@itk.ac.id',
//            'PE_NamaLengkap' => 'Tendik Pusat',
//            'PE_Nama' => 'Tendik Pusat',
//            'password' => Hash::make('password')
//        ]);
//
//        $dosen = Employee::create([
//            'PE_Nip' => '9999999999',
//            'PE_Email' => 'dosen@itk.ac.id',
//            'PE_NamaLengkap' => 'Dosen',
//            'PE_Nama' => 'Dosen',
//            'password' => Hash::make('password')
//        ]);

//        $mahasiswa = Employee::create([
//            'name' => 'Mahasiswa',
//            'email' => 'mahasiswa@itk.ac.id',
//            'password' => Hash::make('password')
//        ]);

        $superAdmin->roles()->attach($superAdminRole);
//        $admin->roles()->attach($adminRole);
//        $observer->roles()->attach($observerRole);
//        $warek->roles()->attach($warekRole);
//        $kaprodi->roles()->attach($kaprodiRole);
//        $kajur->roles()->attach($kajurRole);
//        $dikjur->roles()->attach($dikjurRole);
//        $diksat->roles()->attach($diksatRole);
//        $dosen->roles()->attach($dosenRole);

//        $superAdminRole->users()->attach($superAdmin);
//        $mahasiswa->roles()->attach($mahasiswaRole);
    }
}
