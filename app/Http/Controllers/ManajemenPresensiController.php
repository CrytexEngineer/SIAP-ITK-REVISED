<?php

namespace App\Http\Controllers;


use App\Major;
use App\Meeting;
use App\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class  ManajemenPresensiController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }


    function index()
    {

        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('presensi.index', $data);
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('presensi.index', $data);

        }

    }

    function index_json(Request $request)
    {


        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {


            $jadwalPengampu = DB::table('classes')
                ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
                ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
                ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
                ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
                ->where('majors.PS_Kode_Prodi', $request->input('PS_ID'))->get();


            return Datatables::of($jadwalPengampu)
                ->addColumn('action', function ($row) {
                    $action = '<a href="/presensi/' . $row->KE_ID . '/dashboard" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Kehadiran</a>';
                    return $action;
                })
                ->make(true);

        } else {
            $jadwalPengampu = DB::table('classes')
                ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
                ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
                ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
                ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
                ->where('majors.PS_Kode_Prodi', $user_major)->get();

            return Datatables::of($jadwalPengampu)
                ->addColumn('action', function ($row) {
                    $action = '<a href="/presensi/' . $row->KE_ID . '/dashboard" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Kehadiran</a>';
                    return $action;
                })
                ->make(true);

        }

    }


    function dashboard($id_jadwal)
    {
        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('classes', 'classes.KE_KR_MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')
            ->where('classes.KE_Kelas', $jadwal->KE_Kelas) //sebelumnya class_student.KU_KE_Kelas
            ->where('class_student.KU_KE_Kelas', $jadwal->KE_Kelas)
            ->where('classes.KE_PE_NIPPengajar', $jadwal->PE_Nip)
            ->where('class_student.KU_KE_KR_MK_ID', $jadwal->MK_ID)
            ->where('classes.KE_Terisi', $jadwal->KE_Terisi)->get();


        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id_jadwal)->pluck('PE_NamaLengkap')->all();

        $data['timPengajar'] = $timPengajar;

        $data['jadwal'] = $jadwal;
//        dd($data);
        return view('presensi.dashboard', $data);
    }


    function manage($ku_id)
    {

        $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('subjects', 'subjects.MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')->
            where('class_student.KU_ID', '=', $ku_id);
        return view('presensi.manage', $data);

    }

    function manage_json($ku_id)
    {

        return Datatables::of(DB::table('presences')
            ->join('meetings', 'meetings.PT_ID', '=', 'presences.PR_PT_ID')
            ->where('presences.PR_KU_ID', '=', $ku_id)->get())
            ->addColumn('action', function ($row) {
                $action = \Form::open(['url' => 'presensi/' . $row->PR_ID, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
              return $action;
             })
            ->make(true);


    }


    public function create($ku_id)
    {
        $kelas = DB::table('class_student')
            ->join('classes', 'classes.KE_KR_MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')
            ->where('class_student.KU_ID', '=', $ku_id)->get()->pluck('KE_ID')[0];

        $data['kelas'] = $kelas;
        $data['meeting'] = Meeting::where('PT_KE_ID', '=', $kelas)->get()->pluck('PT_Urutan', 'PT_ID');
        $data['mahasiswa'] = $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('subjects', 'subjects.MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')->
            where('class_student.KU_ID', '=', $ku_id);

//dd($data['meeting']);
        return view('presensi.create', $data);

    }


    public function store(Request $request)
    {
        $presence = new Presence(['PR_KU_ID' => $request->input('PT_KU_ID'),
            'PR_PT_ID' => $request->input('PT_ID'),
            'PR_KE_ID' => $request->input('PT_KE_ID'),
            'PR_IsLAte' => "NOT LATE",
            'PR_Keterangan' => $request->input('PT_Keterangan'),
            'PR_Type' => "INPUT"]);

        if (
        $presence->save()){
            redirect()->back();
        };


    }


    public function destroy( $PR_ID)
    {

        DB::table('presences')->where('PR_ID', $PR_ID)->delete();

    }

}
