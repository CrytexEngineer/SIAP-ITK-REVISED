<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DosenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\\Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function json()
    {

        $dosen = User::with('employee')->where('email', '=', Auth::user()->email)->get()->first();

        return Datatables::of(DB::table('classes')
            ->join('employees', 'classes.KE_PE_NIPPengajar', '=', 'employees.PE_Nip')
            ->join('subjects', 'classes.KE_KR_MK_ID', '=', 'subjects.MK_ID')
            ->join('majors', 'classes.KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi')
            ->where('classes.KE_PE_NIPPengajar', '=', $dosen->employee->PE_Nip))
            ->addColumn('action', function ($row) {
                $action = '<a href="/kelas/' . $row->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                $action .= \Form::close();
                return $action;
            })
            ->make(true);
    }

//    UNTUK MENAMPILKAN AUTOCOMPLETE//
    function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('subjects')
                ->where('MK_Mata_Kuliah', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
       <li><a href="#">' . $row->MK_ID . ' - ' . $row->MK_Mata_Kuliah . '   </a></li>
       ';
            }
            $output .= '</ul>';
            echo "$output";
        }
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
}
