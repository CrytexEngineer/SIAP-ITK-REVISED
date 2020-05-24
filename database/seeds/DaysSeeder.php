<?php

use Illuminate\Database\Seeder;
use App\Day;

class DaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Day::truncate();

        Day::unguard();
        Day::create(['nama_hari'=>'Senin']);
        Day::create(['nama_hari'=>'Selasa']);
        Day::create(['nama_hari'=>'Rabu']);
        Day::create(['nama_hari'=>'Kamis']);
        Day::create(['nama_hari'=>'Jumat']);
        Day::create(['nama_hari'=>'Sabtu']);
        Day::create(['nama_hari'=>'Minggu']);
    }
}
