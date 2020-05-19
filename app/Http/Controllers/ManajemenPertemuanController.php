<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Meeting;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ManajemenPertemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }


    function json($id)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'PT_KE_ID' => ['required', 'integer'],
            'PT_Name' => ['required', 'string', 'max:255'],
            'PT_Types' => ['required', 'string', 'max:255'],
            'PT_Notes' => ['required', 'string', 'max:255']
        ]);

        $kelas = Kelas::find($request->PT_KE_ID);
        $token = $this->getMeetingToken(16);
        $isLate = "NOT LATE";
        date_default_timezone_set("Asia/Kuala_Lumpur");

        $meeting = Meeting::where('PT_KE_ID', $request->PT_KE_ID)->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->get()->first();
        if ($meeting) {

            //redirect back sudah membuat pertemuan hari ini
        }

        if ($kelas) {

            $lateDay = $kelas['KE_Jadwal_IDHari'];
            $currentDay = $dayOfTheWeek = Carbon::now()->dayOfWeek;
            $lateTime = strtotime($kelas['KE_Jadwal_JamUsai']);
            $currentTime = strtotime(date('H:i:s'));

            if ($lateDay == $currentDay) {
                if ($currentTime > $lateTime) {
                    $isLate = "LATE";
                }
            } else {
                $isLate = "LATE";
            }

            $meeting = new Meeting([
                'PT_KE_ID' => $request->PT_KE_ID,
                'PT_Name' => $request->PT_Name,
                'PT_Token' => $token,
                'PT_isLate' => $isLate,
                'PT_Type' => $request->PT_Types,
                'PT_Notes' => $request->PT_Notes,
            ]);


            $meeting->save();


            return redirect()->back(201);

        } else {

//            return redirect()->back(404);
            dd("Eror");
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meeting = Meeting::where('PT_KE_ID', $id);
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
