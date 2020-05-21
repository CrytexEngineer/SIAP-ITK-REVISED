<?php

namespace App\Http\Controllers;

use App\Imports\SubjectsImport;
use App\Logbook;
use App\Subject;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenMataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    function json()
    {
        return Datatables::of(Subject::all())
            ->addColumn('action', function ($row) {
                $action = '<a href="/matakuliah/' . $row->MK_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url' => 'matakuliah/' . $row->MK_ID, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;

            })
            ->make(true);


    }


    public function index()
    {
        return view('matakuliah.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('matakuliah.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'MK_ID' => 'required|unique:subjects|min:6',
            'MK_Mata_Kuliah' => 'required|min:6',
            'MK_KreditKuliah' => 'required',
            'MK_ThnKurikulum' => 'required'
        ]);

        $subject = New Subject();
        $subject->create($request->all());
        Logbook::write(Auth::user()->PE_Nip, 'Menambah data matakuliah ' . $subject->MK_Mata_Kuliah . ' dari tabel matakuliah', Logbook::ACTION_CREATE, Logbook::TABLE_SUBJECTS);
        return redirect('/matakuliah')->with('status', 'Data Matakuliah Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data['subject'] = Subject::where('MK_ID', $id)->first();
        return view('matakuliah.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'MK_Mata_Kuliah' => 'required|min:6',
            'MK_KreditKuliah' => 'required',
            'MK_ThnKurikulum' => 'required'
        ]);


        $subject = Subject::where('MK_ID', '=', $id)->first();
        if (
        $subject->update($request->except('_method', '_token'))) {
            Logbook::write(Auth::user()->PE_Nip, 'Mengubah data matakuliah ' . $subject->MK_Mata_Kuliah . ' dari tabel matakuliah', Logbook::ACTION_EDIT, Logbook::TABLE_SUBJECTS);
        }

        return redirect('/matakuliah')->with('status', 'Data Matakuliah Berhasil Diubah!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $subject = Subject::where('MK_ID', $id)->first();
        if (
        $subject->delete()) {
            Logbook::write(Auth::user()->PE_Nip, 'Menghapus data matakuliah ' . $subject->MK_Mata_Kuliah . ' dari tabel matakuliah', Logbook::ACTION_DELETE, Logbook::TABLE_SUBJECTS);
        }
        return redirect('/matakuliah')->with('status_failed', 'Data Matakuliah Berhasil Dihapus!');;
    }


    public function importView()
    {

        return view('matakuliah.import');


    }

    public function import()
    {
        $data = Excel::import(new SubjectsImport(), request()->file('file'));
        if($data){
            Logbook::write(Auth::user()->PE_Nip, 'Mengimpor data matakuliah dari tabel matakuliah', Logbook::ACTION_IMPORT, Logbook::TABLE_SUBJECTS);
        }
        return back();
    }
}
