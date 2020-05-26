<?php


namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Presence;
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


        foreach ($kelas as $class) {

            ($class->KE_KR_MK_ID);
            $count = Presence::countBySubject(['MA_Nrp' => trim($nrp, '"'),
                'MK_ID' => trim($class->KE_KR_MK_ID, '"')]);


            $persentase = 0;
            $jumlahPertemuan=0;
            if ($count) {
                $persentase = ($count[0]->persentase);
                $jumlahPertemuan=($count[0]->Jumlah_Pertemuan);
            }
            $class->KE_Count = $persentase;
            $class->Jumlah_Pertemuan = $jumlahPertemuan;
        }


        $properties = ['msg' => 'List Kelas Mahasiswa',
            'href' => "api/v1/mobile/kelas",
            'method' => 'GET'
        ];

        if ($kelas) {
            $response = ['properties' => [$properties],
                'kelas' => $kelas];

        } else {
            $properties = ['msg' => 'Kelas Tidak Ditemukan'];
            $response = ['properties' => [$properties]];
        }


        return response()->json($response, 200);
    }

}
