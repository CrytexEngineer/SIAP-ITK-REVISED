<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $primaryKey='KE_ID';
    protected $table = "classes";
    protected $fillable= ['KE_ID','KE_KR_MK_ID','KE_Tahun','KE_Kelas','KE_PE_NIPPengajar','KE_IDSemester','KE_DayaTampung','KE_Terisi','KE_Jadwal_IDHari','KE_Jadwal_JamMulai','KE_Jadwal_JamUsai','KE_Jadwal_Ruangan','KE_KodeJurusan','KE_RencanaTatapMuka','KE_RealisasiTatapMuka'];
}
