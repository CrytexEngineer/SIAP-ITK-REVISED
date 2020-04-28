<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meeting extends Model
{
    protected $primaryKey = 'PT_ID';


    static function count($params = array())
    {
        $defaultQuery = "SELECT  classes.KE_ID,employees.PE_NamaLengkap,classes.KE_Tahun,
        subjects.MK_Mata_Kuliah,subjects.MK_Mata_Kuliah,classes.KE_Kelas,
        classes.KE_Terisi,classes.KE_RencanaTatapMuka,
              COUNT(*) as KE_RealisasiTatapMuka,
              (COUNT(*)/classes.KE_RencanaTatapMuka*100)as KE_Prosentase FROM meetings
              RIGHT JOIN classes ON meetings.PT_KE_ID=classes.KE_ID
              JOIN subjects on subjects.MK_ID=classes.KE_KR_MK_ID
              JOIN employees on employees.PE_Nip=classes.KE_PE_NIPPengajar";

        $order = "ORDER BY classes.KE_KR_MK_ID,employees.PE_Nip";

        $group = "GROUP BY classes.KE_ID";

        $filter = null;
        if (isset($params['KE_KodeJurusan'])) {
            $filter = "WHERE classes.KE_KodeJurusan=" . $params['KE_KodeJurusan'];
        }

        return DB::select($defaultQuery . " " . $filter . " " . $group . " " . $order);}


}
