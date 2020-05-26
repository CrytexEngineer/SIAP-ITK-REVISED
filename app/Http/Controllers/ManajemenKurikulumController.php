<?php

namespace App\Http\Controllers;

use App\Curiculum;
use App\Employee;
use App\Kelas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManajemenKurikulumController extends Controller
{

    function json()
    {
        return Datatables::of(Curiculum::all())
            ->addColumn('action', function ($row) {
                $action = '<a href="/kurikulum/' . $row->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $action .= \Form::open(['url' => 'kurikulum/' . $row->id, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;
            })
            ->make(true);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kurikulum.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('kurikulum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'KL_Tahun_Kurikulum' => 'required',
            'KL_Date_Start' => 'required',
            'KL_Date_End' => 'required'
        ]);



        $kurikulum = New Curiculum();
        $kurikulum->create($request->all());
        return redirect('/kurikulum');
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
    public function edit($id){

        $data['kurikulum'] = Curiculum::find($id);
        return view('kurikulum.edit',$data);
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
        $curiculum = Curiculum::find($id);
        $curiculum->update($request->all());
        return redirect('/kurikulum')->with('status_failed', 'Data Kelas Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curiculum = Curiculum::find($id);
        $curiculum->delete();
        return redirect('/kurikulum')->with('status_failed', 'Data Kelas Berhasil Dihapus');
    }
}
