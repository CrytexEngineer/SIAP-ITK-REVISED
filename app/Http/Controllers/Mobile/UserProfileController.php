<?php


namespace App\Http\Controllers\Mobile;


use App\Student;
use App\user;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserProfileController
{
    public function show($id)
    {
        $user = Student::findOrFail($id);


        $properties = ['msg' => 'Profil User ',
            'href' => "api/v1/mobile/user",
            'method' => 'GET'
        ];

        $response = ['propeties'=>[$properties],
            'user' => [$user]];

        return response()->json($response, 200);

    }
}
