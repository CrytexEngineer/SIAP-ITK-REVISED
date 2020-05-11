<?php

namespace App\Http\Controllers;

use App\Presence;
use App\Validator;
use http\Exception\RuntimeException;

class ManajemenValidatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    public function show($id)
    {
        $data['PT_ID'] = $id;
        return view('qrCode', $data);

    }


    public function generateQRcode($id)
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




}
