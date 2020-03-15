<?php

use App\Subject;
use Illuminate\Database\Seeder;

class MataKuliahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        Subject::create(['MK_ID' => 'EL1003',
            'MK_Mata_Kuliah' => 'Algoritma dan Pemrograman',
            'MK_ThnKurikulum' => '2015',
            'MK_KreditKuliah' => '3'
        ]);

    }
}
