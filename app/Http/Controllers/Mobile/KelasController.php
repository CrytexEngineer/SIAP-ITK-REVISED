<?php


namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function show($nrp)
    {


        $kelas = DB::select("SELECT `class_student`.`KU_MA_Nrp`,
                         `class_student`.`KU_ID`,
                        `classes`.`KE_ID`,
                        `classes`.`KE_KR_MK_ID`,
                        `classes`.`KE_Kelas`,
                        `classes`.`KE_PE_NIPPengajar`,
                        `classes`.`KE_Jadwal_IDHari`,
                        `classes`.`KE_Jadwal_JamMulai`,
                        `classes`.`KE_Jadwal_JamUsai`,
                        `classes`.`KE_Jadwal_Ruangan`,
                        `employees`.`PE_NamaLengkap`,
                        `employees`.`PE_Nip`,
                        `subjects`.`MK_Mata_Kuliah`,
                        `students`.`MA_NamaLengkap`
                        FROM `class_student`
                            INNER JOIN `classes` ON `class_student`.`KU_KE_KodeJurusan` = `classes`.`KE_KodeJurusan`
                            INNER JOIN `employees` ON `classes`.`KE_PE_NIPPengajar` = `employees`.`PE_Nip`
                                INNER JOIN `subjects` ON `classes`.`KE_KR_MK_ID` = `subjects`.`MK_ID`
                                    INNER JOIN `students` ON `class_student`.`KU_MA_Nrp` = `students`.`MA_Nrp`

                        WHERE `class_student`.`KU_MA_Nrp` = $nrp
                        AND `classes`.`KE_KR_MK_ID` = `class_student`.`KU_KE_KR_MK_ID`
                        AND `classes`.`KE_Kelas` = `class_student`.`KU_KE_Kelas` ");

        $properties = ['msg' => 'List Kelas Mahasiswa',
            'href' => "api/v1/mobile/kelas",
            'method' => 'GET'
        ];

        $response = ['properties' => [$properties],
            'kelas' => $kelas];

        return response()->json($response, 200);

    }

    public function showPresenceRate($request)
    {
        $request->validate([
            'KU_ID' => 'required',
            'PT_KE_ID' => 'required'
        ]);


        DB::select("
        SELECT COUNT(*)*100  as persentase_kehadiran from presences
        INNER JOIN class_student ON presences.PR_KU_ID=class_student.KU_ID
        WHERE class_student.KU_ID=$request->input('KU_ID') / (SELECT COUNT(*) FROM meetings
         WHERE meetings.PT_KE_ID=$request->input('PT_KE_ID')) ");


    }
}
