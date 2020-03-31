<?php

namespace App\Http\Controllers;

use App\meeting;
use App\presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function registerStudent(Request $request)
    {
        $request->validate([
            'MA_Nrp' => 'required',
            'PT_Token' => 'required'
        ]);

        $meetings = meeting::where('PT_Token', $request->input('PT_Token'))->get()->first();

        if ($meetings) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $blockTime = strtotime($meetings['PT_BlockTime']);
            $lateTime = strtotime($meetings['PT_LateTime']);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $isBlocked = ($blockTime - $currentTime);
            $isLate = ($lateTime - $currentTime);
            $defaultTime = strtotime(date('H:i:s', 1585497600));

            $khs = DB::select("select * from `meetings`
                inner join `classes` on `meetings`.`PT_KE_ID` = `classes`.`KE_ID`
                 inner join `class_student` on `classes`.`KE_KR_MK_ID` = `class_student`.`KU_KE_KR_MK_ID`
                  where `classes`.`KE_ID` =" . $meetings['PT_KE_ID'] .
                " and `classes`.`KE_Kelas` = class_student.KU_KE_Kelas
                 and `class_student`.`KU_MA_Nrp`=" . $request->input('MA_Nrp'));


            if ($khs) {

                if ($isBlocked > 0 || $blockTime == $defaultTime) {

                    $isPresenced = presence::whereDate('created_at', Carbon::today())
                        ->where('PR_KU_ID', '=', $khs[0]->KU_ID)->get()->first();

                    if (!$isPresenced) {

                        $latemrker = 'LATE';


                        if ($isLate > 0 || $lateTime == $defaultTime) {

                            $latemrker = 'NOT_LATE';
                            $keterangan = 'HADIR';
                            $type = 'QR';
                        }

                        $presence = new presence(['PR_KU_ID' => $khs['0']->KU_ID,
                            'PR_PT_ID' => $meetings['PT_ID'],
                            'PR_IsLAte' => $latemrker,
                            'PR_Keterangan' => $keterangan,
                            'PR_Type' => $type]);
                        $presence->save();
                    }

                    $response = ['msg' => 'Kamu tidak terdaftar di kelas ini'];
                    return response()->json($response, Response::HTTP_NOT_FOUND);

                }


                $response = ['msg' => 'Kamu telat, Dilarang Absen'];
                return response()->json($response, Response::HTTP_FORBIDDEN);


            }
            $response = ['msg' => 'Kamu tidak terdaftar di kelas ini'];
            return response()->json($response, Response::HTTP_NOT_FOUND);
        }
        $response = ['msg' => 'Pertemuan tidak ditemukan'];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
