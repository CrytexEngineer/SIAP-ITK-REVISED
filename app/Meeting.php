<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Meeting extends Model
{
    protected $primaryKey = 'PT_ID';
    protected $fillable = ['PT_KE_ID', 'PT_Name', 'PT_Token', 'PT_isLate', 'PT_Type', 'PT_Notes'];


    static function count($params = array())
    {
        $defaultQuery = "SELECT  classes.KE_ID,employees.PE_NamaLengkap,t2.tim_dosen,classes.KE_KR_MK_ID,
        subjects.MK_Mata_Kuliah,subjects.MK_Mata_Kuliah,subjects.MK_KreditKuliah,classes.KE_Kelas,
        classes.KE_Terisi,classes.KE_RencanaTatapMuka,
              COUNT(*) as KE_RealisasiTatapMuka,
              COUNT(IF(PT_isLate='LATE',1, NULL)) as 'KE_isLate',
              FORMAT(COUNT(*)/classes.KE_RencanaTatapMuka*100,2)as KE_Prosentase FROM meetings
              RIGHT JOIN classes ON meetings.PT_KE_ID=classes.KE_ID
              JOIN subjects on subjects.MK_ID=classes.KE_KR_MK_ID
              JOIN employees on employees.PE_Nip=classes.KE_PE_NIPPengajar
              LEFT JOIN (SELECT classes.KE_ID , GROUP_CONCAT(t1.PE_NamaLengkap SEPARATOR ', ') as tim_dosen FROM classes
                JOIN (SELECT class_employee.classes_KE_ID , employees.PE_NamaLengkap FROM class_employee JOIN employees on employees.PE_Nip= class_employee.employee_PE_Nip )AS t1 ON classes.KE_ID= t1.classes_KE_ID
             GROUP BY t1.classes_KE_ID) as t2 on classes.KE_ID = t2.KE_ID
              ";

        $order = "ORDER BY employees.PE_Nip";

        $group = "GROUP BY classes.KE_ID";

        $filter = null;
        if (isset($params['KE_KodeJurusan'])) {
            $filter = "WHERE classes.KE_KodeJurusan=" . $params['KE_KodeJurusan'];
        }


        return DB::select($defaultQuery . " " . $filter . " " . $group . " " . $order);
    }


}
