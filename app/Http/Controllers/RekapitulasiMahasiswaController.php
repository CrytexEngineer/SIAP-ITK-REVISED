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


    public function json()
    {
        return Datatables::of($this->getRekapitulasiAll(array('max_percentage' => '0.5',)))

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

    function getRekapitulasiAll($filters = array())
    {
        $defaultQuery = "SELECT class_student.KU_ID,
            class_student.KU_KE_KR_MK_ID,
            class_student.KU_KE_Kelas,
            employees.PE_NamaLengkap,
            t3.KE_Terisi,
            students.MA_NamaLengkap,
            students.MA_NRP_Baru,
            students.MA_Nrp,
            t3.total AS Jumlah_Pertemuan,
            COUNT(presences.PR_KU_ID)as Kehadiran,
            COUNT(presences.PR_KU_ID)/t3.total  as persentase from class_student
            LEFT Outer  JOIN presences ON presences.PR_KU_ID=class_student.KU_ID
            JOIN (SELECT  meetings.PT_KE_ID,
                  classes.*,
                  COUNT(*) as total FROM meetings
                  JOIN classes ON meetings.PT_KE_ID=classes.KE_ID
                  GROUP BY meetings.PT_KE_ID
             ) as t3  on t3.KE_KR_MK_ID=class_student.KU_KE_KR_MK_ID
             JOIN(students) ON class_student.KU_MA_Nrp= students.MA_Nrp
              JOIN (employees)ON employees.PE_Nip=t3.KE_PE_NIPPengajar";

        $order = "ORDER BY class_student.KU_KE_KR_MK_ID, class_student.KU_MA_Nrp";

        $group = "group by class_student.KU_ID";

        $filter = "WHERE t3.KE_Kelas=class_student.KU_KE_Kelas";

        if (isset($filters['KE_Kelas'])) {
            $filter = $filter . " " . " AND  t3.KE_Kelas=" . " '" . $filters['KE_Kelas'] . "'";
        }
        if (isset($filters['MA_Nrp'])) {
            $filter = $filter . " " . "AND  students.MA_Nrp=" . " '" . $filters['MA_Nrp'] . "'";
        }
        if (isset($filters['MK_ID'])) {
            $filter = $filter . " " . "AND  class_student.KU_KE_KR_MK_ID=" . " '" . $filters['MK_ID'] . "'";
        }
        if (isset($filters['min_percentage'])) {
            $group = $group . " " . "having   persentase >=" . " '" . $filters['min_percentage'] . "'";
        }
        if (isset($filters['max_percentage'])) {
            $group = $group . " " . "having  persentase <=" . " '" . $filters['max_percentage'] . "'";
        }

        if (isset($filters['equals'])) {
            $group = $group . " " . "having  persentase =" . " '" . $filters['max_percentage'] . "'";
        }


        return DB::select($defaultQuery . " " . $filter . " " . $group." ".$order);

    }
}
