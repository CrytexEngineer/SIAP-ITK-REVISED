<?php

namespace App\Http\Controllers;

use App\kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    function json(){
        return Datatables::of(kelas::all())
            ->addColumn('action', function ($row) {
                $action  = '<a href="/kelas/'.$row->kode_mk.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url'=>'kelas/'.$row->kode_mk,'method'=>'delete','style'=>'float:right']);
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
//        return view('kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kelas.create');
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
            'kode_mk' => 'required|unique:kelas|min:4',
            'nama_mk' => 'required|min:6',
            'sks'     =>'require'
        ]);


        $kelas = New kelas();
        $kelas->create($request->all());
        return redirect('/kelas')->with('status','Data kelas Berhasil Disimpan');
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
        $data['kelas'] = kelas::where('kode_mk',$id)->first();
        return view('kelas.edit',$data);
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


        $kelas = kelas::where('kode_mk','=',$kode_mk);
        $kelas->update($request->except('_method','_token'));
        return redirect('/kelas')->with('status','Data kelas Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_mk)
    {
        $kelas = kelas::where('kode_mk',$kode_mk);
        $kelas->delete();
        return redirect('/kelas')->with('status','Data kelas Berhasil Dihapus');;
    }
}
