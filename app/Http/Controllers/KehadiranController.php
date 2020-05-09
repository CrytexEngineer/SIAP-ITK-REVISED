<?php

namespace App\Http\Controllers;
use App\Kehadiran;

use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    function index($id_jadwal){
        $jadwal = \DB::table('classes')
            ->join('employees','employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
            ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
            ->where('KE_ID',$id_jadwal)->first();


        $data['mahasiswa'] = \DB::table('class_student')
            ->join('students','students.MA_Nrp','=','class_student.KU_MA_Nrp')
            ->join('classes','classes.KE_KR_MK_ID','=','class_student.KU_KE_KR_MK_ID')
            ->where('class_student.KU_KE_Kelas',$jadwal->KE_Kelas)
            ->where('classes.KE_PE_NIPPengajar',$jadwal->PE_Nip)
            ->where('class_student.KU_KE_KR_MK_ID',$jadwal->MK_ID)
            ->where('classes.KE_Terisi',$jadwal->KE_Terisi)
            ->get();
        $data['jadwal']    = $jadwal;
        return view('kehadiran.index',$data);
    }

    function create($id_jadwal)
    {
        $jadwal = \DB::table('classes')
            ->join('employees','employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
            ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
            ->join('majors','majors.PS_Kode_Prodi','=','classes.KE_KodeJurusan')

            ->where('KE_ID',$id_jadwal)->first();

        $pertemuan = \DB::table('meetings')
            ->join('classes','classes.KE_ID','=','meetings.PT_KE_ID')
            ->join('employees','employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
            ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
            ->join('class_student','class_student.KU_KE_KR_MK_ID','=','classes.KE_KR_MK_ID')
            ->where('MK_ID',$jadwal->MK_ID)
            ->where('PE_Nip',$jadwal->PE_Nip)
            ->where('KU_KE_KodeJurusan',$jadwal->PS_Kode_Prodi)->count();


        $data['jadwal']    = $jadwal;
        $data['pertemuan_ke'] = $pertemuan+1;
        return view('kehadiran.create',$data);
    }

    function store(Request $request,$id_jadwal){

        $jadwal = \DB::table('jadwal_kuliah')->where('id',$id_jadwal)->first();

        $kehadiran = new Kehadiran;
        $kehadiran->kode_mk             = $jadwal->kode_mk;
        $kehadiran->kode_dosen          = $jadwal->kode_dosen;
        $kehadiran->kode_jurusan        = $jadwal->kode_jurusan;
        $kehadiran->kode_ruang          = $jadwal->kode_ruangan;
        $kehadiran->kode_tahun_akademik = $jadwal->kode_tahun_akademik;
        $kehadiran->topik_pembahasan    = $request->topik;
        $kehadiran->pertemuan_ke        = $request->pertemuan_ke;
        $kehadiran->save();

        $lastID = $kehadiran->id;

        return redirect('kehadiran/'.$lastID.'/absen/');

    }


    function show($id_kehadiran)
    {
        $kehadiran          = \DB::table('kehadiran')
            ->join('dosen','dosen.kode_dosen','=','kehadiran.kode_dosen')
            ->join('matakuliah','matakuliah.kode_mk','=','kehadiran.kode_mk')
            ->first();

        $data['mahasiswa'] = \DB::table('khs')
            ->join('mahasiswa','mahasiswa.nim','=','khs.nim')
            ->where('khs.kode_dosen',$kehadiran->kode_dosen)
            ->where('khs.kode_mk',$kehadiran->kode_mk)
            ->get();
        $data['kehadiran'] = $kehadiran;
        return view('kehadiran.show',$data);
    }

    function update(Request $request)
    {
        $chek = \DB::table('riwayat_kehadiran')
            ->where('nim',$request->nim)
            ->where('kehadiran_id',$request->id_kehadiran)
            ->count();
        if($chek>0)
        {
            // lakukan update

            \DB::table('riwayat_kehadiran')
                ->where('kehadiran_id',$request->id_kehadiran)
                ->update([
                    'status_kehadiran'=>$request->status_kehadiran
                ]);
        }else{
            // lakukan insert
            \DB::table('riwayat_kehadiran')
                ->insert([
                    'nim'=>$request->nim,
                    'kehadiran_id'=>$request->id_kehadiran,
                    'status_kehadiran'=>$request->status_kehadiran,
                    'pertemuan_ke' => $request->pertemuan_ke
                ]);
        }

    }
}
