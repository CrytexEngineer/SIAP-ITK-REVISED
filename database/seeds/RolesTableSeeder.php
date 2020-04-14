<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Employee;

class RolesTableSeeder extends Seeder

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


        Role::truncate();

        Role::create(['role_name' => 'Super Admin']);
        Role::create(['role_name' => 'Admin']);
        Role::create(['role_name' => 'Observer']);
        Role::create(['role_name' => 'Wakil Rektor']);
        Role::create(['role_name' => 'Ketua Prodi']);
        Role::create(['role_name' => 'Ketua Jurusan']);
        Role::create(['role_name' => 'Tendik Jurusan']);
        Role::create(['role_name' => 'Tendik Pusat']);
        Role::create(['role_name' => 'Dosen Pengampu']);
        Role::create(['role_name' => 'Mahasiswa']);
    }
}
