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
        error_log($request->input('MK_ID'));
        $request->validate([
            'MA_Nrp' => 'required',
            'MK_ID' => 'required'
        ]);


        $properties = ['msg' => 'Rekapitulasi kehadiran',
            'href' => "api/v1/mobile/presence/count",
            'method' => 'GET'
        ];

        $presenceCount = Presence::countBySubject(['MA_Nrp' => trim($request['MA_Nrp'], '"'), 'MK_ID' => trim($request['MK_ID'], '"')]);

        if ($request['MK_ID'] == "all") {
            $presenceCount = Presence::countAll(['MA_Nrp' => trim($request['MA_Nrp'], '"')]);
            $presenceCount[0]->Jumlah_Pertemuan=Presence::countAllMeetings(['MA_Nrp' => trim($request['MA_Nrp'], '"')])[0]->Jumlah_Pertemuan;

        }

        if ($presenceCount) {
            $response = ['properties' => [$properties],
                'presenceCount' => $presenceCount];

        } else {
            $properties = ['msg' => "Kehadiran tidak ditemukan"];
            $response = ['properties' => [$properties]];

        }


        return response()->json($response, Response::HTTP_OK);
    }

    function index(Request $request)
    {
        error_log($request->input('MK_ID'));
        $request->validate([
            'MA_Nrp' => 'required',
            'MK_ID' => 'required'
        ]);

        $properties = ['msg' => 'Rekapitulasi kehadiran',
            'href' => "api/v1/mobile/presence/count",
            'method' => 'GET'
        ];

        $presences = Presence::index(['MA_Nrp' => trim($request['MA_Nrp'], '"'), 'MK_ID' => trim($request['MK_ID'], '"'),]);


        if ($presences) {
            $response = ['properties' => [$properties],
                'presences' => $presences];

        } else {
            $properties = ['msg' => "Kehadiran tidak ditemukan"];
            $response = ['properties' => [$properties]];

        }

        return response()->json($response, Response::HTTP_OK);

    }


}
