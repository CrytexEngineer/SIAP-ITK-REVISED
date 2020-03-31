<?php

namespace App\Http\Controllers;

use App\meeting;
use App\presence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function registerStudent(Request $request)
    {
        $request->validate([
            'MA_Nrp' => 'required',
            'PT_Token' => 'required'
        ]);

        $meetings = meeting::where('PT_Token', $request->input('PT_Token'))->get()->first();
        if ($meetings) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $blockTime = strtotime($meetings['PT_BlockTime']);
            $lateTime = strtotime($meetings['PT_LateTime']);
            $currentTime = strtotime(date('Y-m-d H:i:s'));
            $isBlocked = ($blockTime - $currentTime);
            $isLate = ($lateTime - $currentTime);
            $defaultTime = 1585497600;


            $khs = DB::select("select * from `meetings`
                inner join `classes` on `meetings`.`PT_KE_ID` = `classes`.`KE_ID`
                 inner join `class_student` on `classes`.`KE_KR_MK_ID` = `class_student`.`KU_KE_KR_MK_ID`
                  where `classes`.`KE_ID` =" . $meetings['PT_KE_ID'] .
                " and `classes`.`KE_Kelas` = class_student.KU_KE_Kelas
                 and `class_student`.`KU_MA_Nrp`=" . $request->input('MA_Nrp'));

            if ($khs) {

                if ($isBlocked > 0 || $blockTime == $defaultTime) {


                    if ($isLate > 0 || $lateTime == $defaultTime) {

                        $isPresenced = presence::whereDate('created_at', Carbon::today())
                            ->where('PR_KU_ID', '=', $khs['class_student.KU_ID'])->get();


                        if (!$isPresenced){
                            $presence=new presence($khs['id'],$meetings['PT_ID']);
         }

                    }

                }
            }

        }
    }
}
