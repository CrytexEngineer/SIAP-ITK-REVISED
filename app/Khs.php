<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Khs extends Model
{
    protected $table='class_student';
    protected $fillable = ['KU_KE_Tahun', 'KU_MA_Nrp', 'KU_KE_KR_MK_ID', 'KU_KE_Kelas', 'KU_KE_KodeJurusan'];
}
