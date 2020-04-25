<?php


namespace App\Http\Controllers\Mobile;


use App\Http\Controllers\Controller;
use App\Presence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PresenceController extends Controller
{


    function count(Request $request)
    {

        $request->validate([
            'MA_Nrp' => 'required',
            'MK_ID' => 'required'
        ]);


        $properties = ['msg' => 'Rekapitulasi Kehadiran',
            'href' => "api/v1/mobile/presence/count",
            'method' => 'GET'
        ];

        $presenceCount = Presence::count(['MA_Nrp' => trim($request['MA_Nrp'],'"'), 'MK_ID' => trim($request['MK_ID'],'"')]);

        if($presenceCount){
            $response = ['properties' => [$properties],
                'presenceCount' => $presenceCount];

        }
        else{
            $response = ['properties' => [$properties]];
            $properties = ['msg' => 'Kamu Telah Melakukan Presensi'];

        }


        return response()->json(['properties' => [$properties],$response], Response::HTTP_OK);
    }

    function index(Request $request)
    {
        $request->validate([
            'MA_Nrp' => 'required',
            'MK_ID' => 'required'
        ]);

       return $presences= Presence::index(['MA_Nrp'=>trim($request['MA_Nrp'],'"'),'MK_ID'=>trim($request['MK_ID'],'"'),]);
    }

}
