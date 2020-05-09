<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Meeting;
use App\Presence;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManajemenPertemuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'PT_KE_ID' => ['required', 'integer'],
            'PT_Name' => ['required', 'string', 'max:255'],
            'PT_Types' => ['required', 'string', 'max:255'],
            'PT_Notes' => ['required', 'string', 'max:255']
        ]);

        $kelas = Kelas::find($request->PT_KE_ID);
        $token = $this->getMeetingToken(16);
        $isLate = "NOT LATE";

        if ($kelas) {

            date_default_timezone_set("Asia/Kuala_Lumpur");
            $lateDay = strtotime($kelas['KE_Jadwal_IDHari']);
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
                'PT_Types' => $request->PT_Types,
                'PT_Notes' => $request->PT_Notes,
            ]);
        } else {

            return redirect()->back(404);

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

    public function getMeetingToken($length = 16)
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
}
