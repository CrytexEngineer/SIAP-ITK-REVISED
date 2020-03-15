<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    function json(){
        return Datatables::of(matakuliah::all())
            ->addColumn('action', function ($row) {
                $action  = '<a href="/matakuliah/'.$row->kode_mk.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url'=>'matakuliah/'.$row->kode_mk,'method'=>'delete','style'=>'float:right']);
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
        return view('matakuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matakuliah.create');
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
            'kode_mk' => 'required|unique:matakuliah|min:4',
            'nama_mk' => 'required|min:6',
            'sks'     =>'require'
        ]);


        $matakuliah = New matakuliah();
        $matakuliah->create($request->all());
        return redirect('/matakuliah')->with('status','Data matakuliah Berhasil Disimpan');
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
        $data['matakuliah'] = matakuliah::where('kode_mk',$id)->first();
        return view('matakuliah.edit',$data);
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


        $matakuliah = matakuliah::where('kode_mk','=',$kode_mk);
        $matakuliah->update($request->except('_method','_token'));
        return redirect('/matakuliah')->with('status','Data matakuliah Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_mk)
    {
        $matakuliah = matakuliah::where('kode_mk',$kode_mk);
        $matakuliah->delete();
        return redirect('/matakuliah')->with('status','Data matakuliah Berhasil Dihapus');;
    }
}
