<?php

namespace App\Http\Controllers;

use App\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ValidatorController extends Controller
{


    public function validation(Request $request)
    {

        $properties = ['msg' => 'Validate QR',
            'href' => "api/v1/mobile/validate",
            'method' => 'POST'
        ];


        $this->validate($request, [
            'VD_PT_ID' => 'required|integer',
            'VD_Token' => 'required|string',
        ]);


        $validator = Validator::where("VD_PT_ID", "=", $request->input('VD_PT_ID'))
            ->where('VD_Token', '=', $request->input('VD_Token'))->get()->first();

        if ($validator) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $expiredTime = strtotime($validator['VD_Expired']);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $isExpired = ($expiredTime - $currentTime);

            if ($isExpired < 0) {
                $properties = ['msg' => 'Token Kadaluarsa, Silahkan Scan Ulang Kode QR'];
                return response()->json(['properties' => $properties], Response::HTTP_FORBIDDEN);
            }


            $token = DB::table('meetings')
                ->join('validators', 'meetings.PT_ID', '=', 'validators.VD_PT_ID')
                ->join('classes', 'meetings.PT_KE_ID', '=', 'classes.KE_ID')
                ->where('validators.VD_PT_ID', '=', $request->input('VD_PT_ID'))
                ->get()->first();

            $properties = ['msg' => 'Validasi berhasil'];
            $response = [['properties' => $properties, 'token' => $token]];
            return response()->json($response, Response::HTTP_ACCEPTED);
        }

        $properties = ['msg' => 'Kode QR Tidak Ditemukan, Silahkan Scan Ulang Kode QR'];
        return response()->json(['properties' => $properties], Response::HTTP_NOT_FOUND);
    }
}
