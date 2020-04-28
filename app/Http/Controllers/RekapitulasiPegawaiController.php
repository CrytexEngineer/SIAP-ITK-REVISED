<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Meeting;

class RekapitulasiPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function json(){
        return Datatables::of(Meeting::count(array('KE_KodeJurusan'=>11110)))

//            ->addColumn('action', function ($row) {
//                $action = '<a href="/Khs/' . $row->KU_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
//                $action .= \Form::open(['url' => 'Khs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
//                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
//                $action .= \Form::close();
//                return $action;
//            })
            ->make(true);





    }

    public function index()
    {

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
}
