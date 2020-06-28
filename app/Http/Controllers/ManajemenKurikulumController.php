<?php

namespace App\Http\Controllers;

use App\Curiculum;
use App\Employee;
use App\Kelas;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManajemenKurikulumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $messages = [
            'KL_Tahun_Kurikulum.required' => 'Tahun Kurikulum tidak boleh kosong.',
            'KL_Date_Start.required' => 'Tanggal Mulai tidak boleh kosong.',
            'KL_Date_End.required' => 'Tanggal Selesai tidak boleh kosong.',

        ];

        $request->validate([
            'KL_Tahun_Kurikulum' => 'required',
            'KL_Date_Start' => 'required',
            'KL_Date_End' => 'required'
        ], $messages);

        $kurikulum = New Curiculum();
        $kurikulum->create($request->all());
        return redirect('/kurikulum')->with('success', 'Data tahun kurikulum berhasil ditambahkan!');
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
        $messages = [
            'KL_Tahun_Kurikulum.required' => 'Tahun Kurikulum tidak boleh kosong.',
            'KL_Date_Start.required' => 'Tanggal Mulai tidak boleh kosong.',
            'KL_Date_End.required' => 'Tanggal Selesai tidak boleh kosong.',

        ];

        $request->validate([
            'KL_Tahun_Kurikulum' => 'required',
            'KL_Date_Start' => 'required',
            'KL_Date_End' => 'required'
        ], $messages);

        $curiculum = Curiculum::find($id);
        $curiculum->update($request->all());
        return redirect('/kurikulum')->with('success', 'Data tahun kurikulum berhasil diubah!');
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
        return redirect('/kurikulum')->with('toast_warning', 'Data tahun kurikulum berhasil dihapus!');
    }
}
