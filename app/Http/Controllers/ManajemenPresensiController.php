<?php

namespace App\Http\Controllers;


use App\Meeting;
use App\Presence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class  ManajemenPresensiController extends Controller
{


    function manage($ku_id)
    {

        $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('subjects', 'subjects.MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')->
            where('class_student.KU_ID', '=', $ku_id);
        return view('kehadiran.manage', $data);

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
        return view('kehadiran.create', $data);

    }


    public function store(Request $request)
    {


        $messages = [
            'PT_ID.required' => 'Pertemuan Harus Diisi',
            'PT_Keterangan.required' => 'Keterangan Harus Diisi ',

        ];


        $request->validate([
            'PT_ID' => ['required', 'integer'],
            'PT_Keterangan' => ['required', 'string', 'max:255'],

        ], $messages);


        $presence = new Presence(['PR_KU_ID' => $request->input('PT_KU_ID'),
            'PR_PT_ID' => $request->input('PT_ID'),
            'PR_KE_ID' => $request->input('PT_KE_ID'),
            'PR_IsLAte' => "NOT LATE",
            'PR_Keterangan' => $request->input('PT_Keterangan'),
            'PR_Type' => "INPUT"]);

        $presenceBefore = Presence::where('presences.PR_PT_ID', '=', $request->input('PT_ID'))->get()->first();
        if ($presenceBefore) {
            return redirect()->back()->with('status_failed', 'Mahasiswa telah menghadiri pertemuan ini !');
        }

        if (


        $presence->save()) {
            return redirect('/presensi/' . $request->input('PT_KU_ID') . '/manage')->with('toast_success', 'Presensi berhasil ditambahkan');
        };


    }


    public function destroy($PR_ID)
    {

        DB::table('presences')->where('PR_ID', $PR_ID)->delete();
        return redirect()->back()->with('toast_success', 'Data kehadiran berhasil dihapus!');

    }

}
