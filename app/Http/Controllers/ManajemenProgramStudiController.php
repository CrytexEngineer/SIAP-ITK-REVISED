<?php

namespace App\Http\Controllers;

use App\Imports\MajorsImport;
use App\Imports\SubjectsImport;
use App\Major;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class ManajemenProgramStudiController extends Controller
{

    function json()
    {
        return DataTables::of(Major::all())
            ->addColumn('action', function ($row) {
                $action = '<a href="/program_studi/' . $row->PS_Kode_Prodi . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url' => 'program_studi/' . $row->PS_Kode_Prodi, 'method' => 'DELETE', 'style' => 'float:right']);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'PS_Kode_Prodi' =>'required|unique:majors|min:5',
            'PS_Nama' => 'required|min:6',

        ]);

        $major = New Major();
        $major->create($request->all());


        return redirect('/program_studi')->with('status', 'Data Program Studi Berhasil Disimpan');
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
        $data['major'] = Major::where('PS_Kode_Prodi', $id)->first();
       return view('program_studi.edit', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'PS_Nama' => 'required|min:6',

        ]);

        $major = Major::where('PS_Kode_Prodi', '=', $id);
        $major->update($request->except('_method', '_token'));
        return redirect('/program_studi')->with('status','Data Program Studi Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $major = Major::where('PS_Kode_Prodi', $id);
        $major->delete();
        return redirect('/program_studi')->with('status','Data Program Studi Berhasil Dihapus');;
    }


    public function import()
    {
        $data = Excel::import(new MajorsImport(),request()->file('file'));
        return back();
    }
}
