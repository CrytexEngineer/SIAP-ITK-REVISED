<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class  DosenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function jadwal_mengajar()
    {
        return view('dosen.jadwal_mengajar');
    }

    function jadwal_mengajar_json()
    {
        $jadwalPengampu = DB::table('classes')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
            ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->where('classes.KE_PE_NIPPengajar', Auth::user()->PE_Nip)->get();


        $jadwalTimDosen = DB::table('class_employee')
            ->join('classes', 'classes.KE_ID', '=', 'class_employee.classes_KE_ID')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
            ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->where('class_employee.employee_PE_Nip', Auth::user()->PE_Nip)->get();

        $jadwal = $jadwalPengampu->merge($jadwalTimDosen);

        return Datatables::of($jadwal)
            ->addColumn('action', function ($row) {
                $action = '<a href="/pertemuan/' . $row->KE_ID . '/dashboard" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Dashboard</a>';
                return $action;
            })
            ->make(true);
    }
}
