<?php

namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Meeting;
use App\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function registerStudent(Request $request)
    {
        $properties = ['msg' => 'Register Presensi',
            'href' => "api/v1/mobile/validate/register_meeting",
            'method' => 'POST'
        ];



        $request->validate([
            'MA_Nrp' => 'required',
            'PT_Token' => 'required'
        ]);

        $meetings = Meeting::where('PT_Token', trim($request['PT_Token'], '"'))->get()->first();

        if ($meetings) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $createdTime = strtotime($meetings['created_at']);
            $blockTime = strtotime($meetings['PT_BlockTime']);
            $lateTime = strtotime($meetings['PT_LateTime']);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $isBlocked = ($blockTime - $currentTime);
            $isLate = ($lateTime - $currentTime);
            $maxBlockTime = strtotime($meetings['created_at'] . '+120 minutes');
            $maxLateTime = strtotime($meetings['created_at'] . '+15 minutes');


            if ($blockTime == $createdTime || $blockTime > $maxBlockTime) {
                $isBlocked = ($maxBlockTime - $currentTime);
            } else if ($blockTime < $maxBlockTime) {
                $isBlocked = ($blockTime - $currentTime);
            }

            $isLate = $maxLateTime - $currentTime;



            $khs = DB::select("select * from `meetings`
                inner join `classes` on `meetings`.`PT_KE_ID` = `classes`.`KE_ID`
                 inner join `class_student` on `classes`.`KE_KR_MK_ID` = `class_student`.`KU_KE_KR_MK_ID`
                  where `classes`.`KE_ID` =" . $meetings['PT_KE_ID'] .
                " and `classes`.`KE_Kelas` = class_student.KU_KE_Kelas
                 and `class_student`.`KU_MA_Nrp`=" . $request->input('MA_Nrp'));

            if ($khs) {
                date_default_timezone_set("Asia/Kuala_Lumpur");
                if ($isBlocked > 0) {
                    $isPresenced = Presence::whereDate('presences.created_at', Carbon::today())
                        ->join('meetings','presences.PR_PT_ID','meetings.PT_ID')
                        ->where('PR_KU_ID', '=', $khs[0]->KU_ID)
                        ->where('meetings.PT_Token','=',trim($request->PT_Token,'"'))->get()->first();

                    if (!$isPresenced) {
                        $keterangan = 'HADIR';
                        $type = 'QR';
                        $latemrker = 'LATE';
                        $properties = ['msg' => 'Kamu  telat, Lebih rajin ya!'];

                        if ($isLate > 0) {

                            $latemrker = 'NOT LATE';
                            $properties = ['msg' => 'Kamu Tepat Waktu, Luar Biasa!'];

                        }

                        $presence = new Presence(['PR_KU_ID' => $khs['0']->KU_ID,
                            'PR_PT_ID' => $meetings['PT_ID'],
                            'PR_KE_ID' => $meetings['PT_KE_ID'],
                            'PR_IsLAte' => $latemrker,
//                            'PR_KU_MA_Nrp' => $request->input('MA_Nrp'),
                            'PR_Keterangan' => $keterangan,
                            'PR_Type' => $type]);

                        $presence->save();
                        return response()->json(['properties' => [$properties], 'presences' => [$presence]], Response::HTTP_CREATED);

                    }

                    $properties = ['msg' => 'Kamu Telah Melakukan Presensi'];
                    return response()->json(['properties' => [$properties]], Response::HTTP_OK);

                }


                $properties = ['msg' => 'Kamu melewati batas waktu, Presensi diblokir'];
                return response()->json(['properties' => [$properties]], Response::HTTP_OK);


            }
            $properties = ['msg' => 'Kamu tidak terdaftar di kelas ini'];
            return response()->json(['properties' => [$properties]], Response::HTTP_OK);
        }
        $properties = ['msg' => 'Pertemuan tidak ditemukan'];
        return response()->json(['properties' => [$properties]], Response::HTTP_OK);
    }

}
