<?php

use Illuminate\Database\Seeder;
use App\Role;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("SET foreign_key_checks=0");
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
        DB::statement("SET foreign_key_checks=1");
    }
}
