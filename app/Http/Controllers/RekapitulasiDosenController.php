<?php

namespace App\Http\Controllers;

use App\Exports\LectureByMajorExport;
use App\Exports\LectureBySubjectExport;
use App\Kelas;
use App\Major;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class RekapitulasiDosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {     $user_major=Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
           return view('rekapitulasi.dosen.index',$data);
    }
    else{
        $data['major'] = Major::where('PS_Kode_Prodi','=',$user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
        return view('rekapitulasi.dosen.index',$data);

    }

    }

    function json(Request $request)
    {

        $user_major=Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {

            return Datatables::of(Meeting::count(['KE_KodeJurusan'=>$request->input('PS_ID')]))->make(true);
        } else {
            return Datatables::of(Meeting::count(['KE_KodeJurusan'=>$user_major]))->make(true);
        }



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


    public function showExportSubjectPage()
    {   $user_major=Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        }
        else{
            $data['major'] = Major::where('PS_Kode_Prodi','=',$user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');

        }
        return view('rekapitulasi.dosen.export', $data);
    }

    public function saveSubject(Request $request){

        return Excel::download(new LectureBySubjectExport($request->input('KE_KR_MK_ID')), 'MONITORING DOSEN.xlsx');
    }


    public function saveMajor()

    {
        ini_set('max_execution_time', 600);
        return Excel::download(new LectureByMajorExport($jurusan = Auth::user()->PE_KodeJurusan), 'MONITORING DOSEN.xlsx');
    }


}

