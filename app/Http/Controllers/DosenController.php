<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class  DosenController extends Controller
{
    function jadwal_mengajar(){
        return view('dosen.jadwal_mengajar');
    }

    function jadwal_mengajar_json(){
//        dd('classes.KE_PE_NIPPengajarIndeks');
        $jadwal = \DB::table('classes')
            ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
            ->join('days','days.id','=','classes.KE_Jadwal_IDHari')
            ->join('majors','majors.PS_Kode_Prodi','=','classes.KE_KodeJurusan')
            ->join('employees', 'employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
//            ->where('jadwal_kuliah.kode_tahun_akademik','=',get_tahun_akademik('kode_tahun_akademik'))
            ->where('classes.KE_PE_NIPPengajar',Auth::user()->PE_Nip);
//
        return Datatables::of($jadwal)
            ->addColumn('action', function ($row) {
                $action = '<a href="/kehadiran/'.$row->KE_ID.'" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Kehadiran</a>';
                $action .= \Form::open(['url'=>'dosen/'.$row->PE_Nip,'method'=>'delete','style'=>'float:right']);
                return $action;
            })
            ->make(true);
    }
}
