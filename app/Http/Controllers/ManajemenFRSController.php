<?php

namespace App\Http\Controllers;

use App\Imports\KHSImport;
use App\Kelas;
use App\Khs;
use App\Logbook;
use App\Major;
use App\Student;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ManajemenFRSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {

        $user_major = Auth::user()->PE_KodeJurusan;
        $role = (Auth::user()->roles->pluck('id')[0]);
        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('frs.index', $data);
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
            return view('frs.index', $data);

        }

    }

    function index_json(Request $request)
    {


        $jadwalPengampu = DB::table('classes')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->leftJoin('days', 'days.id', '=', 'classes.KE_Jadwal_IDHari')
            ->join('majors', 'majors.PS_Kode_Prodi', '=', 'classes.KE_KodeJurusan')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->where('majors.PS_Kode_Prodi', $request->input('PS_ID'))->get();


        return Datatables::of($jadwalPengampu)
            ->addColumn('action', function ($row) {
                $action = '<a href="/frs/' . $row->KE_ID . '/dashboard" class="btn btn-primary "> Mahasiswa</a>';
                return $action;
            })
            ->make(true);

    }


    function dashboard_json($id_jadwal)
    {
        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $mahasiswa = DB::table('class_student')
            ->join('students', 'students.MA_Nrp', '=', 'class_student.KU_MA_Nrp')
            ->join('classes', 'classes.KE_KR_MK_ID', '=', 'class_student.KU_KE_KR_MK_ID')
            ->where('classes.KE_Kelas', $jadwal->KE_Kelas) //sebelumnya class_student.KU_KE_Kelas
            ->where('class_student.KU_KE_Kelas', $jadwal->KE_Kelas)
            ->where('classes.KE_PE_NIPPengajar', $jadwal->PE_Nip)
            ->where('class_student.KU_KE_KR_MK_ID', $jadwal->MK_ID)
            ->where('classes.KE_Terisi', $jadwal->KE_Terisi)->get();


        return Datatables::of($mahasiswa)
            ->addColumn('action', function ($row) {

                $action = \Form::open(['url' => '/frs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
                $action .= "<button type='submit'class='btn btn-danger btn-sm center'><i class='fas fa-trash-alt'></i></button>";
                $action .= \Form::close();
                return $action;

            })
            ->make(true);
    }

    function dashboard($id_jadwal)
    {


        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id_jadwal)->pluck('PE_NamaLengkap')->all();

        $data['timPengajar'] = $timPengajar;

        $data['jadwal'] = $jadwal;
//        dd($data);
        return view('frs.dashboard', $data);
    }

    public function create(Request $request)
    {

        $kelas = Kelas::where('KE_ID', $request->input('ke_id'))->pluck('KE_ID')[0];
        $data['kelas'] = $kelas;
        return view('frs.create', $data);
    }


    function fetch_mahasiswa(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('students')
                ->where('MA_NamaLengkap', 'LIKE', "%{$query}%")
                ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($data as $row) {
                $output .= '
       <li><a href="#">' . $row->MA_Nrp . ' - ' . $row->MA_NamaLengkap . '   </a></li>
       ';
            }
            $output .= '</ul>';
            echo "$output";
        }
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

            'KU_MA_Nrp.required' => 'Nama Mahasiswa tidak boleh kosong.',

        ];

        $request->validate([
            'KU_MA_Nrp' => ['required'],
        ], $messages);

        $kelas = Kelas::where('KE_ID', $request->input('ke_id'))->get()->first();



        $mahasiswa = Student::where('MA_Nrp', substr($request->input('KU_MA_Nrp'), 0, strrpos($request->input('KU_MA_Nrp'), '-', 0)))->get()->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('status_failed', 'Data Mahasiswa Tidak Ditemukan!');
        }



        $Khs = New Khs(['KU_KE_Tahun' => $kelas->KE_Tahun,
            'KU_MA_Nrp' => $mahasiswa->MA_Nrp,
            'KU_KE_KR_MK_ID' => $kelas->KE_KR_MK_ID,
            'KU_KE_Kelas' => $kelas->KE_Kelas,
            'KU_KE_KodeJurusan' => $kelas->KE_KodeJurusan]);

        $Khs->save();
        Logbook::write(Auth::user()->PE_Nip,
            'Menambah data KHS ' . $Khs->MA_NamaLengkap . ' mata kuliah ' . $Khs->MK_Mata_Kuliah . ' kelas ' . $Khs->KU_KE_Kelas . ' ke tabel KHS', Logbook::ACTION_CREATE,
            Logbook::TABLE_CLASS_STUDENT);

        $id_jadwal=$kelas->KE_Kelas;

        $jadwal = DB::table('classes')
            ->join('employees', 'employees.PE_Nip', '=', 'classes.KE_PE_NIPPengajar')
            ->join('subjects', 'subjects.MK_ID', '=', 'classes.KE_KR_MK_ID')
            ->where('KE_ID', $id_jadwal)->first();


        $timPengajar = DB::table('class_employee')
            ->join('employees', 'employees.PE_Nip', '=', 'employee_PE_Nip')
            ->where('class_employee.classes_KE_ID', '=', $id_jadwal)->pluck('PE_NamaLengkap')->all();

        $data['timPengajar'] = $timPengajar;

        $data['jadwal'] = $jadwal;

        return redirect('frs/'.$kelas->KE_ID.'/dashboard')->with('success', 'Data KHS berhasil ditambahkan!');
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
        $data['subjects'] = Subject::pluck('MK_Mata_Kuliah', 'MK_ID');
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        $data['students'] = Student::pluck('MA_NamaLengkap', 'MA_Nrp');
        $data['classes'] = Kelas::pluck('KE_Kelas');
        $data['frs'] = Khs::where('KU_ID', $id)->first();
        return view('frs.edit', $data);
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
//        dd($request);
        $messages = [
            'KE_KR_MK_ID.required' => 'Mata Kuliah tidak boleh kosong.',
            'KE_KodeJurusan.required' => 'Program Studi tidak boleh kosong.',
            'KE_Kelas.required' => 'Kelas tidak boleh kosong.',
            'KE_Jadwal_Ruangan.required' => 'Nama Ruangan tidak boleh kosong.',
            'KE_Tahun.required' => 'Tahun Ajaran tidak boleh kosong.',
            'KE_Tahun.integer' => 'Tahun Ajaran harus diisi menggunakan angka.',
            'KE_IDSemester.required' => 'Semester tidak boleh kosong.',
            'KE_IDSemester.integer' => 'Semester harus diisi menggunakan angka.',
            'KE_DayaTampung.required' => 'Daya Tampung tidak boleh kosong.',
            'KE_DayaTampung.integer' => 'Daya Tampung harus diisi menggunakan angka.',

            'KU_KE_Tahun.required' => 'Tahun Akademik tidak boleh kosong.',
            'KU_KE_Tahun.integer' => 'Tahun Akademik harus diisi menggunakan angka.',
            'KU_MA_Nrp.required' => 'Nama Mahasiswa tidak boleh kosong.',
            'KU_MA_Nrp.integer' => 'Nama Mahasiswa harus diisi menggunakan angka.',
            'KU_KE_KR_MK_ID.required' => 'Mata Kuliah tidak boleh kosong.',
            'KU_KE_Kelas.required' => 'Kelas tidak boleh kosong.',
            'KU_KE_KodeJurusan.required' => 'Program Studi tidak boleh kosong.',
            'KU_KE_KodeJurusan.integer' => 'Jumlah Kelas harus diisi menggunakan angka.'
        ];

        $request->validate([
            'KU_KE_Tahun' => ['required', 'int'],
            'KU_MA_Nrp' => ['required', 'int'],
            'KU_KE_KR_MK_ID' => ['required'],
            'KU_KE_Kelas' => ['required'],
            'KU_KE_KodeJurusan' => ['required', 'int'],
        ], $messages);

        $Khs = Khs::where('KU_ID', '=', $id)->first();
        $Khs->update($request->except('_method', '_token'));


        Logbook::write(Auth::user()->PE_Nip,
            'Mengubah data KHS ' . $Khs->MA_NamaLengkap . ' mata kuliah ' . $Khs->MK_Mata_Kuliah . ' kelas ' . $Khs->KU_KE_Kelas . ' dari tabel KHS', Logbook::ACTION_EDIT,
            Logbook::TABLE_CLASS_STUDENT);
        return redirect('/frs')->with('success', 'Data KHS berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Khs = Khs::where('KU_ID', $id)->get()->first();
        $student = Student::where('MA_Nrp', '=', $Khs->KU_MA_Nrp)->get()->first;
        $Khs->delete();
        Logbook::write(Auth::user()->PE_Nip,
            'Menghapus data KHS ' . $student->MA_NamaLengkap . ' mata kuliah ' . $Khs->MK_Mata_Kuliah . ' kelas ' . $Khs->KU_KE_Kelas . ' dari  tabel KHS', Logbook::ACTION_DELETE,
            Logbook::TABLE_CLASS_STUDENT);
        return redirect()->back()->with('toast_warning', 'Data KHS berhasil dihapus!');
    }

    public function import()
    {
        $data = Excel::import(new KHSImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip,
                'Mengimpor data frs  ke  tabel KHS ', Logbook::ACTION_IMPORT,
                Logbook::TABLE_CLASS_STUDENT);
        }
        return back()->with('toast_success', 'Import data KHS berhasil!');
    }
}
