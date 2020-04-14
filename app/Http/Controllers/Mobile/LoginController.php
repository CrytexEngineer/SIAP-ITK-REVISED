<?php


namespace App\Http\Controllers\Mobile;


use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController
{
private $properties;
    public function login(Request $request)
    {
       $this->properties = ['msg' => 'Credentials Tidak Ditemukan',
            'href' => "api/v1/mobile/login",
            'method' => 'POST'
        ];

        $request->validate([
            'MA_Email' => 'required',
            'MA_PASSWORD' => 'required',
            'MA_IMEI' => 'required'
        ]);


        $credential = $request->all();
        $email = trim($credential['MA_Email'], '"');
        $user = Student::where('MA_Email', '=', $email)->get()->first();


        if ($this->validate($credential, $user)) {

            $this->properties['msg'] = "Selamat Datang " . $user['MA_NamaLengkap'];
            $response = ['properties' => [$this->properties],
                'user' => [$user]];


            return response()->json($response, 200);

        }

        $response = ['properties' => [$this->properties]];
        return response()->json($response, 200);

    }

    public function validate($credential, $user)
    {

        $imei = trim($credential['MA_IMEI'], '"');

        if ($imei) {
            if ($user['MA_IMEI'] == null) {
                if ($this->ValidatePassword($credential, $user)) {

                    $user['MA_IMEI'] = $imei;
                    $user->save();



                    return true;
                }
            }
            if ($user['MA_IMEI'] == $imei) {
                if ($this->ValidatePassword($credential, $user)) {
                    return true;
                }
            }
            $this->properties['msg'] = "Perangkat Tidak Sesuai";

            return false;
        }
        $this->properties['msg'] = "Ponsel Anda Ilegal";
        return false;
    }


    public function ValidatePassword($credential, $user)
    {
        $password = trim($credential['MA_PASSWORD'], '"');
        return (Hash::check($password, $user['MA_PASSWORD']));
    }

}
