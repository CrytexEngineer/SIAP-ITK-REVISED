<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    function json(){
        return Datatables::of(jurusan::all())
            ->addColumn('action', function ($row) {
                $action  = '<a href="/program_studi/'.$row->kode_mk.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url'=>'program_studi/'.$row->kode_mk,'method'=>'delete','style'=>'float:right']);
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
        return view('program_studi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('program_studi.create');
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
            'kode_mk' => 'required|unique:program_studi|min:4',
            'nama_mk' => 'required|min:6',
            'sks'     =>'require'
        ]);


        $jurusan = New jurusan();
        $jurusan->create($request->all());
        return redirect('/program_studi')->with('status','Data program_studi Berhasil Disimpan');
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
        $data['program_studi'] = jurusan::where('kode_mk',$id)->first();
        return view('program_studi.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_mk)
    {
        $request->validate([
            'nama_mk' => 'required|min:6',
            'sks'     =>'require'
        ]);


        $jurusan = jurusan::where('kode_mk','=',$kode_mk);
        $jurusan->update($request->except('_method','_token'));
        return redirect('/program_studi')->with('status','Data program_studi Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_mk)
    {
        $jurusan = jurusan::where('kode_mk',$kode_mk);
        $jurusan->delete();
        return redirect('/program_studi')->with('status','Data program_studi Berhasil Dihapus');;
    }
}
