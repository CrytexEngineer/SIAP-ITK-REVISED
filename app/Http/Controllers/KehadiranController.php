<?php

namespace App\Http\Controllers;

use App\Kehadiran;
use App\Kelas;
use App\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KehadiranController extends Controller
{
    function index($id_jadwal)
    {
        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('classes', 'classes.KE_KR_MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')
            ->where('class_student.KU_KE_Kelas', $jadwal->KE_Kelas)
            ->where('classes.KE_PE_NIPPengajar', $jadwal->PE_Nip)
            ->where('class_student.KU_KE_KR_MK_ID', $jadwal->MK_ID)
            ->where('classes.KE_Terisi', $jadwal->KE_Terisi)->get();
        $data['jadwal'] = $jadwal;
        return view('kehadiran.index', $data);
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
            ->join('classes', 'classes.KE_ID', '=', 'meetings.PT_KE_ID')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->join('class_student', 'class_student.KU_KE_KR_MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('MK_ID', $jadwal->MK_ID)
            ->where('PE_Nip', $jadwal->PE_Nip)
            ->where('KU_KE_KodeJurusan', $jadwal->PS_Kode_Prodi)->count();


        $data['jadwal'] = $jadwal;
        $data['pertemuan_ke'] = $pertemuan + 1;
        $data['timPegajar']=$timPengajar;
        return view('kehadiran.create', $data);
    }


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
            return redirect()->back()->with('status_failed', 'Pertemuan hari ini telah dibuat sebelumnya, silahkan cek riwayat pertemuan');
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
            dd($meeting);

            return redirect()->back(201);

        } else {

            return redirect()->back()->with('status_failed', 'Jadwal tidak ditemukan');
        }


    }


    function show($id)
    {
        $meeting = Meeting::where('PT_KE_ID', $id);
    }

    function update(Request $request)
    {
        $chek = DB::table('riwayat_kehadiran')
            ->where('nim', $request->nim)
            ->where('kehadiran_id', $request->id_kehadiran)
            ->count();
        if ($chek > 0) {
            // lakukan update

            \DB::table('riwayat_kehadiran')
                ->where('kehadiran_id', $request->id_kehadiran)
                ->update([
                    'status_kehadiran' => $request->status_kehadiran
                ]);
        } else {
            // lakukan insert
            \DB::table('riwayat_kehadiran')
                ->insert([
                    'nim' => $request->nim,
                    'kehadiran_id' => $request->id_kehadiran,
                    'status_kehadiran' => $request->status_kehadiran,
                    'pertemuan_ke' => $request->pertemuan_ke
                ]);
        }

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
