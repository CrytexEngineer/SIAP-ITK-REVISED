<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Presence extends Model
{

    protected $primaryKey = 'PR_ID';
    protected $fillable = ['PR_KU_ID', 'PR_KE_ID', 'PR_PT_ID', 'PR_IsLAte', 'PR_KU_MA_Nrp', 'PR_Keterangan', 'PR_Type'];


    static function countAll($params = array())
    {
        $defaultQuery = "SELECT count(*) as Kehadiran,
        COUNT(IF(PR_Keterangan='SAKIT',1, NULL)) as 'Sakit',
        COUNT(IF(PR_Keterangan='IZIN',1, NULL)) as 'Izin',
        ( count(*)-COUNT(PR_KU_ID)) as 'Alpha',
        COUNT(IF(PR_isLate='LATE',1, NULL)) as 'Telat'
        from presences
        join class_student on class_student.KU_ID= presences.PR_KU_ID";

        if (isset($params['MA_Nrp'])) {
            $filter = "WHERE class_student.KU_MA_Nrp=" . " '" . $params['MA_Nrp'] . "'";
        }

        return DB::select($defaultQuery . " " . $filter);
    }


    static function countBySubject($params = array())
    {
        $dateCuriculum=Curiculum::all()->sortByDesc('KL_Date_Start')->first()->KL_Date_Start;

        $defaultQuery = "SELECT class_student.KU_ID,
            class_student.KU_KE_KR_MK_ID,
            subjects.MK_Mata_Kuliah,
            subjects.MK_KreditKuliah,
            class_student.KU_KE_Kelas,
            employees.PE_NamaLengkap,
            t3.KE_Terisi,
            students.MA_NamaLengkap,
            ROUND(DATEDIFF(current_date(),'"."$dateCuriculum"."')/7, 0)  AS pekan_perkuliahan,
            students.MA_NRP_Baru,
            students.MA_Nrp,
            t3.total AS Jumlah_Pertemuan,
            COUNT(presences.PR_KU_ID)as Kehadiran,
            COUNT(IF(PR_Keterangan='SAKIT',1, NULL)) as 'Sakit',
             COUNT(IF(PR_Keterangan='IZIN',1, NULL)) as 'Izin',
          (t3.total-COUNT(presences.PR_KU_ID)) as 'Alpha',
            FORMAT(COUNT(presences.PR_KU_ID)/t3.total*100,0)  as persentase from class_student
            LEFT Outer  JOIN presences ON presences.PR_KU_ID=class_student.KU_ID
            JOIN (SELECT  meetings.PT_KE_ID,
                  classes.*,
                  COUNT(*) as total FROM meetings
                  JOIN classes ON meetings.PT_KE_ID=classes.KE_ID
                  GROUP BY meetings.PT_KE_ID
             ) as t3  on t3.KE_KR_MK_ID=class_student.KU_KE_KR_MK_ID
             JOIN(students) ON class_student.KU_MA_Nrp= students.MA_Nrp
              JOIN (employees)ON employees.PE_Nip=t3.KE_PE_NIPPengajar
                JOIN (subjects)ON subjects.MK_ID=t3.KE_KR_MK_ID
               ";

        $order = "ORDER BY class_student.KU_KE_KR_MK_ID, class_student.KU_MA_Nrp";

        $group = "group by class_student.KU_ID";

        $filter = "WHERE t3.KE_Kelas=class_student.KU_KE_Kelas";



        if (isset($params['KE_ID'])) {
            $filter = $filter . " " . " AND  t3.KE_ID=" . " '" . $params['KE_ID'] . "'";
        }

        if (isset($params['KE_Kelas'])) {
            $filter = $filter . " " . " AND  t3.KE_Kelas=" . " '" . $params['KE_Kelas'] . "'";
        }
        if (isset($params['MA_Nrp'])) {
            $filter = $filter . " " . "AND  students.MA_Nrp=" . " '" . $params['MA_Nrp'] . "'";
        }
        if (isset($params['MK_ID'])) {
            $filter = $filter . " " . "AND  class_student.KU_KE_KR_MK_ID=" . " '" . $params['MK_ID'] . "'";
        }
        if (isset($params['min_percentage'])) {
            $group = $group . " " . "having   persentase >=" . $params['min_percentage'];
        }
        if (isset($params['max_percentage'])) {
            $group = $group . " " . "having  persentase <=" . $params['max_percentage'];
        }

        if (isset($params['equals'])) {
            $group = $group . " " . "having  persentase =" . " '" . $params['equals'] . "'";
        }


        return DB::select($defaultQuery . " " . $filter . " " . $group . " " . $order);

    }

    static function index($params = array())
    {

        $defaultQuery="SELECT presences.*, meetings.PT_Name,meetings.PT_Type,students.* from presences
         JOIN class_student on class_student.KU_ID=presences.PR_KU_ID
         JOIN students on  class_student.KU_MA_Nrp=students.MA_Nrp
         JOIN meetings on meetings.PT_ID = presences.PR_PT_ID
         JOIN classes on presences.PR_KE_ID=classes.KE_ID";

        $filter=" WHERE classes.KE_KR_MK_ID= " . "'" . $params['MK_ID'] . "'";

        if (isset($params['MA_Nrp'])) {
            $filter = $filter . " " . " AND   class_student.KU_MA_Nrp=" . " '" . $params['MA_Nrp'] . "'";
        }

        if (isset($params['KE_ID'])) {
            $filter = $filter . " " . " AND   classes.KE_ID=" . " '" . $params['KE_ID'] . "'";
        }


        return DB::select($defaultQuery." ".$filter);
    }
}
