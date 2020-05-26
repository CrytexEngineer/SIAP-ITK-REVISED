<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MobileNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $request->validate([
            'MA_Nrp' => 'required'
        ]);

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dt = Carbon::now();
        $currentDate = $dt->format('Y-m-d');
        $currrentTime = $dt->format('H:i:s');

        $properties = ['msg' => 'Notifikasi',
            'href' => "api/v1/mobile/notification",
            'method' => 'GET'
        ];
        $presences = Presence::countBySubject(['MA_Nrp' => trim($request['MA_Nrp'], '"'), 'max_percentage' => 80]);
        $notification = new Notification(
            [
                'date' => $currentDate,
                'time' => $currrentTime,
                'msg' => "Kamu mahasiswa yang rajin, pertahankan yaa!",
                'count' => count($presences)]);


        if ($presences) {
            $notification['msg']= "Kamu punya " . count($presences) . " kehadiran matakuliah kurang dari 80%";
        }



        $response = ['properties' => [$properties],
            'notification' => [$notification]];

        return response()->json($response, Response::HTTP_OK);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
