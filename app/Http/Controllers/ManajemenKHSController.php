<?php

namespace App\Http\Controllers;

use App\Imports\KHSImport;
use App\Imports\KHSimportimplements;
use App\Khs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ManajemenKhsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function json()
    {
        return Datatables::of(DB::table('class_student')
            ->join('students', 'class_student.KU_MA_Nrp', '=', 'students.MA_Nrp')
            ->join('subjects', 'class_student.KU_KE_KR_MK_ID', '=', 'subjects.MK_ID')
            ->join('majors', 'class_student.KU_KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi'))
            ->addColumn('action', function ($row) {
                $action = '<a href="/Khs/' . $row->KU_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url' => 'Khs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;
            })
            ->make(true);
    }


    public function index()
    {
        return view('khs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Khs = New Khs();
        $Khs->create($request->all());
        return redirect('Khs')->with('status', 'Informasi Khs Berhasil Ditambahkan');
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
        $Khs = Khs::where('KU_ID', '=', $id);
        $Khs->update($request->except('_method', '_token'));
        return redirect('/Khs')->with('status', 'Data Khs Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Khs = Khs::where('KU_ID', $id);
        $Khs->delete();
        return redirect('/Khs')->with('status', 'Data Khs Berhasil Dihapus');;
    }

    public function import()
    {
        $data = Excel::import(new KHSImport(), request()->file('file'));
        return back();
    }
}
