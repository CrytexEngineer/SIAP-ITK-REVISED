<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RekapitulasiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }


    public function json(){
        return Datatables::of($this->getRekapitulasiAll())

//            ->addColumn('action', function ($row) {
//                $action = '<a href="/Khs/' . $row->KU_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
//                $action .= \Form::open(['url' => 'Khs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
//                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
//                $action .= \Form::close();
//                return $action;
//            })
            ->make(true);



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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function  getRekapitulasiAll($MA_Nrp=0){
       return DB::select("
       SELECT class_student.KU_ID,
        class_student.KU_KE_KR_MK_ID,
        class_student.KU_KE_Kelas,
        employees.PE_NamaLengkap,
        t3.KE_Terisi,
        students.MA_NamaLengkap,
        students.MA_NRP_Baru,
        t3.total AS Jumlah_Pertemuan,
        COUNT(presences.PR_KU_ID)as Kehadiran,
        COUNT(presences.PR_KU_ID)/t3.total  as Persentase from class_student
        LEFT Outer  JOIN presences ON presences.PR_KU_ID=class_student.KU_ID
        JOIN (SELECT  meetings.PT_KE_ID,
              classes.*,
              COUNT(*) as total FROM meetings
              JOIN classes ON meetings.PT_KE_ID=classes.KE_ID
              GROUP BY meetings.PT_KE_ID
         ) as t3  on t3.KE_KR_MK_ID=class_student.KU_KE_KR_MK_ID
         JOIN(students) ON class_student.KU_MA_Nrp= students.MA_Nrp
          JOIN (employees)ON employees.PE_Nip=t3.KE_PE_NIPPengajar
         WHERE t3.KE_Kelas=class_student.KU_KE_Kelas
        group by class_student.KU_ID
        ORDER BY class_student.KU_KE_KR_MK_ID, class_student.KU_MA_Nrp
       ");

    }
}
