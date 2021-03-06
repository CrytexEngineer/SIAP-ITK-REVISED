<?php

namespace App\Http\Controllers;

use App\Imports\MajorsImport;
use App\Logbook;
use App\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;


class ManajemenProgramStudiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function json(Request $request)
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
        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
        }

        return view('program_studi.index',$data);
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
        $messages = [
          'PS_Kode_Prodi.required' => 'Kode Program Studi tidak boleh kosong.',
          'PS_Kode_Prodi.unique' => 'Kode Program Studi sudah terdaftar.',
          'PS_Kode_Prodi.min' => 'Kode Program Studi minimal 1 angka/huruf.',
          'PS_Nama.min' => 'Nama Program Studi minimal 3 angka/huruf.',
          'PS_Nama.required' => 'Nama Program Studi tidak boleh kosong.',
        ];

        $request->validate([
            'PS_Kode_Prodi' => 'required|unique:majors|min:1',
            'PS_Nama' => 'required|min:3',
        ], $messages);

        $major = New Major();
        $major->create($request->all());
        Logbook::write(Auth::user()->PE_Nip,
            'Menambah data program studi ' . $major->PS_Nama . ' dari tabel program studi', Logbook::ACTION_CREATE,
            Logbook::TABLE_MAJORS);

        return redirect('/program_studi')->with('success', 'Data Program Studi berhasil ditambahkan!');
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

        $major = Major::where('PS_Kode_Prodi', '=', $id)->first();
        if (
        $major->update($request->except('_method', '_token'))) {

            Logbook::write(Auth::user()->PE_Nip,
                'Mengubah data program studi ' . $major->PS_Nama . ' dari tabel program studi', Logbook::ACTION_EDIT,
                Logbook::TABLE_MAJORS);
        }
        return redirect('/program_studi')->with('success', 'Data Program Studi berhasil diubah!');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $major = Major::where('PS_Kode_Prodi', $id)->first();
        if ($major->delete()) {
            Logbook::write(Auth::user()->PE_Nip,
                'Menghapus data program studi ' . $major->PS_Nama . ' dari tabel program studi', Logbook::ACTION_DELETE,
                Logbook::TABLE_MAJORS);
        };

        return redirect('/program_studi')->with('toast_warning', 'Data Program Studi berhasil dihapus!');;
    }


    public function import()
    {
        $data = Excel::import(new MajorsImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip,
                'Mengimpor data program studi  dari tabel program studi', Logbook::ACTION_IMPORT,
                Logbook::TABLE_MAJORS);
        }
        return back()->with('toast_success', 'Import data program studi berhasil!');
    }
}
