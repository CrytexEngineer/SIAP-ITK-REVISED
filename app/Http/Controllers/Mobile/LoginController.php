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

        $request->validate([
            'MA_Email' => 'required',
            'MA_PASSWORD' => 'required',
            'MA_IMEI' => 'required'
        ]);

        $this->properties = ['msg' => 'Credentials Tidak Ditemukan',
            'href' => "api/v1/mobile/login",
            'method' => 'POST'
        ];


        $credential = $request->all();
        $email = trim($credential['MA_Email'], '"');
        $user = Student::where('email', '=', $email)->get()->first();

        if ($user) {
            if ($this->validate($credential, $user)) {

                $this->properties['msg'] = "Selamat Datang " . $user['MA_NamaLengkap'];
                $response = ['properties' => [$this->properties],
                    'user' => [$user]];


                return response()->json($response, 200);

            }

            $response = ['properties' => [$this->properties]];
            return response()->json($response, 200);

        }
        $this->properties['msg'] = "Username atau password salah";
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
                $this->properties['msg'] = "Username atau password salah";
                return false;
            }
            if ($user['MA_IMEI'] == $imei) {
                if ($this->ValidatePassword($credential, $user)) {
                    return true;
                }
                $this->properties['msg'] = "Username atau password salah";
                return false;
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
