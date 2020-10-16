<?php

namespace App\Http\Controllers;

use App\Kehadiran;
use App\Kelas;
use App\Major;
use App\Meeting;
use App\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ManajemenPertemuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {

        $user_major = Auth::user()->PE_KodeJurusan;
        $role = (Auth::user()->roles->pluck('id')[0]);
        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('pertemuan.index', $data);
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('pertemuan.index', $data);

        }

    }

    function index_json(Request $request)
    {


        $user_major = Auth::user()->PE_KodeJurusan;
        $role = (Auth::user()->roles->pluck('id')[0]);
        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {


            $jadwalPengampu = DB::table('classes')
                ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
                ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
                ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
                ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
                ->where('majors.PS_Kode_Prodi', $request->input('PS_ID'))->get();


            return Datatables::of($jadwalPengampu)
                ->addColumn('action', function ($row) {
                    $action = '<a href="/pertemuan/' . $row->KE_ID . '/dashboard" class="btn btn-primary "> Dahsboard</a>';
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
                    $action = '<a href="/pertemuan/' . $row->KE_ID . '/dashboard" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Kehadiran</a>';
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
        return view('pertemuan.dashboard', $data);
    }




    function create($id_jadwal)
    {
        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
            ->where('KE_ID', $id_jadwal)->first();


        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id_jadwal)->pluck('PE_NamaLengkap')->all();


        $pertemuan = DB::table('meetings')
            ->where('meetings.PT_KE_ID', $jadwal->KE_ID)->count();


        $data['jadwal'] = $jadwal;
        $data['pertemuan_ke'] = $pertemuan + 1;
        $data['timPegajar'] = $timPengajar;
        return view('pertemuan.create', $data);}




    public function store(Request $request)
    {
        $messages = [
            'PT_Name.required' => 'Topik tidak boleh kosong.',
            'PT_Notes.required' => 'Catatan tidak boleh kosong.',

        ];


        $request->validate([
            'PT_Urutan' => ['required', 'integer'],
            'PT_KE_ID' => ['required', 'integer'],
            'PT_Name' => ['required', 'string', 'max:255'],
            'PT_Types' => ['required', 'string', 'max:255'],
            'PT_Notes' => ['required', 'string', 'max:255']
        ],$messages);

        $kelas = Kelas::find($request->PT_KE_ID);
        $token = $this->getMeetingToken(16);
        $isLate = "NOT LATE";
        date_default_timezone_set("Asia/Kuala_Lumpur");

        $meeting = Meeting::where('PT_KE_ID', $request->PT_KE_ID)->whereBetween('created_at', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])->get()->first();

        if (Auth::user()->roles()->pluck('role_id')[0]==9) {
            if ($meeting) {
                return redirect()->back()->with('status_failed', 'Pertemuan hari ini telah dibuat sebelumnya, silahkan cek riwayat pertemuan');
            }
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
                'PT_Urutan' => $request->PT_Urutan,
                'PT_Name' => $request->PT_Name,
                'PT_Token' => $token,
                'PT_isLate' => $isLate,
                'PT_Type' => $request->PT_Types,
                'PT_Notes' => $request->PT_Notes,
            ]);


            $meeting->save();


            return $this->showHistory($request->PT_KE_ID);

        } else {

            return redirect()->back()->with('status_failed', 'Jadwal tidak ditemukan');
        }


    }


    function showHistory($id_jadwal)
    {
        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id_jadwal)->pluck('PE_NamaLengkap')->all();

        $pertemuan = Meeting::where('PT_KE_ID', $id_jadwal)->orderBy('created_at', 'DESC')->get();


        $data['timPengajar'] = $timPengajar;
        $data['jadwal'] = $jadwal;
        $data['pertemuan'] = $pertemuan;


        if ($pertemuan->isEmpty()) {

            return redirect()->back()->with('status_failed', 'Belum ada pertemuan');
        }


        return view('pertemuan.history', $data);


    }

//    function update(Request $request)
//    {
//        $chek = DB::table('riwayat_kehadiran')
//            ->where('nim', $request->nim)
//            ->where('kehadiran_id', $request->id_kehadiran)
//            ->count();
//        if ($chek > 0) {
//            // lakukan update
//
//            \DB::table('riwayat_kehadiran')
//                ->where('kehadiran_id', $request->id_kehadiran)
//                ->update([
//                    'status_kehadiran' => $request->status_kehadiran
//                ]);
//        } else {
//            // lakukan insert
//            \DB::table('riwayat_kehadiran')
//                ->insert([
//                    'nim' => $request->nim,
//                    'kehadiran_id' => $request->id_kehadiran,
//                    'status_kehadiran' => $request->status_kehadiran,
//                    'pertemuan_ke' => $request->pertemuan_ke
//                ]);
//        }
//
//    }


    public function destroy($id)
    {
        $meeting = Meeting::find($id);
        ($meeting->delete());
        return redirect('pertemuan/' . $meeting->PT_KE_ID.'/dashboard')->with('status_failed', 'Data Berhasil dihapus');


    }


    public function getKehadiranPertemuan($PT_ID)
    {
        return Presence::where('PR_PT_ID', '=', $PT_ID)->count();


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
