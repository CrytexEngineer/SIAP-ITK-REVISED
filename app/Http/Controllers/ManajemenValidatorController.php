<?php

namespace App\Http\Controllers;

use App\Validator;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ManajemenValidatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qrCode');

    }

    public function show($id)
    {

        $meetingID = $id;
        $token = $this->getQrToken();
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $expiredTime = date('Y-m-d H:i:s', strtotime(date("Y-m-d H:i:s") . " + 10 minute"));

        $validator = new Validator(['VD_PT_ID' => $meetingID,
            'VD_Token' => $token,
            'VD_Expired' => $expiredTime]);

        if (Validator::where("VD_PT_ID", "=", $meetingID)->first()) {

            $validator = Validator::where("VD_PT_ID", "=", $meetingID)->first();
            $validator->update([
                'VD_Token' => $token,
                'VD_Expired' => $expiredTime]);

        } else {
            $validator->save();
        }

        return $this->getQrCode((string)$validator);
    }


    public function getQrToken($length = 16)
    {
        if (!function_exists('openssl_random_pseudo_bytes')) {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false) {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);

    }

    public function getQrCode($token)
    {
        $data['qrCode'] = \QrCode::size(500)
            ->generate($token);
        return view('qr_code_container', $data);

    }

    public function validation(Request $request)
    {
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
                $response = ['msg' => 'Token Kadaluarsa, Silahkan Scan Ulang Kode QR'];
                return response()->json($response, Response::HTTP_FORBIDDEN);
            }

            $token = DB::table('meetings')
                ->join('validators', 'meetings.PT_ID', '=', 'validators.VD_PT_ID')
                ->join('classes', 'meetings.PT_KE_ID', '=', 'classes.id')
                ->where('validators.VD_PT_ID', '=', $request->input('VD_PT_ID'))
                ->get()->first();

            $response = ['msg' => 'Validasi berhasil', $token];
            return response()->json($response, Response::HTTP_ACCEPTED);
        }

        $response = ['msg' => 'Presensi Tidak Ditemukan, Silahkan Scan Ulang Kode QR'];
        return response()->json($response, Response::HTTP_NOT_FOUND);
    }
}
