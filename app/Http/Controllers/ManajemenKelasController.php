<?php

namespace App\Http\Controllers;
use DB;
use App\Employee;
use App\Imports\ClasesImport;
use App\Kelas;
use App\Major;
use App\Subject;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ManajemenKelasController extends Controller
{
    function json()
    {
        return Datatables::of(DB::table('classes')
            ->join('employees', 'classes.KE_PE_NIPPengajar', '=', 'employees.PE_Nip')
            ->join('subjects', 'classes.KE_KR_MK_ID', '=', 'subjects.MK_ID')
            ->join('majors', 'classes.KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi'))
            ->addColumn('action', function ($row) {
                $action = '<a href="/kelas/'.$row->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::open(['url' => 'kelas/' . $row->id, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;
            })
            ->make(true);
    }

//    UNTUK MENAMPILKAN AUTOCOMPLETE//
    function fetch(Request $request)
    {
        if($request->get('query'))
        {
            $query = $request->get('query');
            $data = DB::table('subjects')
                ->where('MK_Mata_Kuliah', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row)
            {
                $output .= '
       <li><a href="#">'.$row->MK_Mata_Kuliah.'</a></li>
       ';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['employees'] = Employee::pluck('PE_Nip');
        $data['subjects'] = Subject::pluck('MK_ID');
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        return view('kelas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees_nip'] = Employee::pluck('PE_Nip','PE_Nip');
        $data['employees_nama'] = Employee::pluck('PE_NamaLengkap','PE_NamaLengkap');
        $data['employees'] = Employee::pluck('PE_Nip', 'PE_NamaLengkap');
        $data['subjects'] = Subject::pluck('MK_ID');
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        return view('kelas.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $kelas = New Kelas();
        $kelas->create($request->all());
        return redirect('kelas')->with('status', 'Informasi Kelas Berhasil Ditambahkan');
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
        $data['kelas'] = Kelas::where('id', $id)->first();
        return view('kelas.edit', $data);
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
        $subject = Kelas::where('id','=',$id);
        $subject->update($request->except('_method','_token'));
        return redirect('/kelas')->with('status','Data Kelas Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    //pasing data kode mk dan mata kuliah kesini $kelas=['Kode MK','Nama_MK']
    public function destroy($id)
    {
        $subject = Kelas::where('id',$id);
        $subject->delete();
        return redirect('/kelas')->with('status','Data Kelas Berhasil Dihapus');;
    }

    public function import()
    {
        $data = Excel::import(new ClasesImport(), request()->file('file'));
        return back();
    }
}
