<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Imports\ClassesImport;
use App\Kelas;
use App\Logbook;
use App\Major;
use App\Subject;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ManajemenKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function json()
    {
        return Datatables::of(DB::table('classes')
            ->join('employees', 'classes.KE_PE_NIPPengajar', '=', 'employees.PE_Nip')
            ->join('subjects', 'classes.KE_KR_MK_ID', '=', 'subjects.MK_ID')
            ->join('majors', 'classes.KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi'))
            ->addColumn('action', function ($row) {
                $action = '<a href="/kelas/' . $row->KE_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a> ';
                $action .= '<a href="/kelas/' . $row->KE_ID . '/manage" class="btn btn-primary btn-sm"><i class="fas fa-tasks"></i></a> ';
                $action .= \Form::open(['url' => 'kelas/' . $row->KE_ID, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
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

    function fetch_pengajar(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('employees')
                ->where('PE_Nama', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
       <li><a href="#">' . $row->PE_Nip . ' - ' . $row->PE_Nama . '   </a></li>
       ';
            }
            $output .= '</ul>';
            echo "$output";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $timPengajar = \Illuminate\Support\Facades\DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip');
        $data['timPengajar'] = $timPengajar;

        return view('kelas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::pluck('PE_NamaLengkap', 'PE_Nip');
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
        $messages = [
            'MK_Mata_Kuliah.required' => 'Mata Kuliah tidak boleh kosong.',
            'KE_Kelas.required' => 'Kelas tidak boleh kosong.',
            'KE_Jadwal_Ruangan.required' => 'Nama Ruangan tidak boleh kosong.',
            'PS_Kode_Prodi.required' => 'Kode Program Studi tidak boleh kosong.',
            'KE_Tahun.required' => 'Tahun Ajaran tidak boleh kosong.',
            'KE_IDSemester.required' => 'Semester tidak boleh kosong.',
            'KE_DayaTampung.required' => 'Daya Tampung tidak boleh kosong.',
            'KE_Terisi.required' => 'Jumlah Kelas tidak boleh kosong.',
            'KE_PE_NIPPengajar.required' => 'NIP Pengajar tidak boleh kosong.',
            'KE_Jadwal_IDHari.required' => 'Hari tidak boleh kosong.',
            'KE_Jadwal_JamMulai.required' => 'Jam Mulai tidak boleh kosong.',
            'KE_Jadwal_JamUsai.required' => 'Jam Usai tidak boleh kosong.',
        ];

        $request->validate([
            'MK_Mata_Kuliah' => ['required'],
            'KE_Kelas' => ['required'],
            'KE_Jadwal_Ruangan' => ['required'],
            'PS_Kode_Prodi' => ['required'],
            'KE_Tahun' => ['required'],
            'KE_IDSemester' => ['required'],
            'KE_DayaTampung' => ['required'],
            'KE_Terisi' => ['required'],
            'KE_PE_NIPPengajar' => ['required'],
            'KE_Jadwal_IDHari' => ['required'],
            'KE_Jadwal_JamMulai' => ['required'],
            'KE_Jadwal_JamUsai' => ['required']
        ], $messages);

        $kelas = New Kelas();
        $kelas->create($request->all());
        Logbook::write(Auth::user()->PE_Nip,
            'Menambah data kelas ' . $kelas->KE_KR_MK_ID . ' kelas ' . $kelas->KE_Kelas . ' dari tabel kelas', Logbook::ACTION_CREATE,
            Logbook::TABLE_CLASSES);
        return redirect('kelas')->with('success', 'Informasi kelas berhasil ditambahkan!');
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
        $data['employees'] = Employee::pluck('PE_NamaLengkap', 'PE_Nip');
        $data['subjects'] = Subject::pluck('MK_ID');
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        $data['kelas'] = Kelas::where('KE_ID', $id)->first();
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
        $kelas = Kelas::where('KE_ID', '=', $id)->first();
        if (
        $kelas->update($request->except('_method', '_token'))) {
            Logbook::write(Auth::user()->PE_Nip,
                'Mengubah data kelas ' . $kelas->KE_KR_MK_ID . ' kelas ' . $kelas->KE_Kelas . ' dari tabel kelas', Logbook::ACTION_EDIT,
                Logbook::TABLE_CLASSES);
        }
        return redirect('/kelas')->with('success', 'Data kelas berhasil diubah!');;
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

        $kelas = Kelas::where('KE_ID', $id)->first();
        if (
        $kelas->delete()) {

            Logbook::write(Auth::user()->PE_Nip,
                'Menghapus data kelas ' . $kelas->KE_KR_MK_ID . ' kelas ' . $kelas->KE_Kelas . ' dari tabel kelas', Logbook::ACTION_DELETE,
                Logbook::TABLE_CLASSES);
        }
        return redirect('/kelas')->with('toast_warning', 'Data Kelas Berhasil Dihapus');;

    }

    public function import()
    {
        $data = Excel::import(new ClassesImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip,
                'Mengimpor data kelas  dari tabel kelas ', Logbook::ACTION_IMPORT,
                Logbook::TABLE_CLASSES);
        }
        return back()->with('toast_success', 'Import data kelas berhasil!');
    }

    public function manage($id)
    {
        $jadwal = \Illuminate\Support\Facades\DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id)->first();

        $data['employees'] = Employee::pluck('PE_NamaLengkap', 'PE_Nip');

        $data['mahasiswa'] = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('classes', 'classes.KE_KR_MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')
            ->where('class_student.KU_KE_Kelas', $jadwal->KE_Kelas)
            ->where('classes.KE_PE_NIPPengajar', $jadwal->PE_Nip)
            ->where('class_student.KU_KE_KR_MK_ID', $jadwal->MK_ID)
            ->where('classes.KE_Terisi', $jadwal->KE_Terisi)->get();

        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id)->pluck('PE_NamaLengkap')->all();

        $data['timPengajar'] = $timPengajar;

        $data['jadwal'] = $jadwal;
        return view('kelas.manage', $data);
    }

    public function manage_json($id)
    {


        return Datatables::of(DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id))
            ->addColumn('action', function ($row) {

                $action = \Form::open(['url' => 'kelas/' . $row->id . '/manage/delete', 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;
            })
            ->make(true);


    }

    public function manage_store(Request $request)
    {

        DB::table('class_employee')->insert([

            'employee_PE_Nip' => substr($request->PE_Nama, 0, strrpos($request->PE_Nama, '-', 0)),
            'classes_KE_ID' => $request->KE_ID
        ]);
        return back();
    }

    public function manage_delete($id)
    {

        DB::table('class_employee')->where('id', $id)->delete();


        return back();
    }
}
