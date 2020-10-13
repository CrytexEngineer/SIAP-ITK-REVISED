<?php

namespace App\Http\Controllers;

use App\Imports\KHSImport;
use App\Imports\KHSimportimplements;
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

class ManajemenKhsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function json(Request $request)
    {
        $role = (Auth::user()->roles->pluck('id')[0]);

        if ($role == 1 || $role == 2 || $role == 4 || $role == 8) {
            return Datatables::of(DB::table('class_student')
                ->where('class_student.KU_KE_KodeJurusan', '=', $request->input('PS_ID'))
                ->join('students', 'class_student.KU_MA_Nrp', '=', 'students.MA_Nrp')
                ->join('subjects', 'class_student.KU_KE_KR_MK_ID', '=', 'subjects.MK_ID')
                ->join('majors', 'class_student.KU_KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi'))
//                ->join('classes', 'class_student.KU_KE_Kelas', '=', 'classes.KE_Kelas'))
                ->addColumn('action', function ($row) {
                    $action = '<a href="/khs/' . $row->KU_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => 'khs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
                    $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                    $action .= \Form::close();
                    return $action;
                })
                ->make(true);
        } else {
            $jurusan = Auth::user()->PE_KodeJurusan;
            return Datatables::of(DB::table('class_student')
                ->where('class_student.KU_KE_KodeJurusan', '=', $jurusan)
                ->join('students', 'class_student.KU_MA_Nrp', '=', 'students.MA_Nrp')
                ->join('subjects', 'class_student.KU_KE_KR_MK_ID', '=', 'subjects.MK_ID')
                ->join('majors', 'class_student.KU_KE_KodeJurusan', '=', 'majors.PS_Kode_Prodi'))
//                ->join('classes', 'class_student.KU_KE_Kelas', '=', 'classes.KE_Kelas'))
                ->addColumn('action', function ($row) {
                    $action = '<a href="/khs/' . $row->KU_ID . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
                    $action .= \Form::open(['url' => '/khs/' . $row->KU_ID, 'method' => 'delete', 'style' => 'float:right']);
                    $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
                    $action .= \Form::close();
                    return $action;
                })
                ->make(true);
        }
    }


    public function index()
    {
        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        } else {
            $data['major'] = Major::where('PS_Kode_Prodi', '=', $user_major)->pluck('PS_Nama', 'PS_Kode_Prodi');
        }

        return view('khs.index', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['subjects'] = Subject::pluck('MK_Mata_Kuliah', 'MK_ID');
        $data['major'] = Major::pluck('PS_Nama', 'PS_Kode_Prodi');
        $data['students'] = Student::pluck('MA_NamaLengkap', 'MA_Nrp');
        $data['classes'] = Kelas::pluck('KE_Kelas', 'KE_Kelas');
        return view('khs.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        $Khs = New Khs();
        $Khs->create($request->all());
        Logbook::write(Auth::user()->PE_Nip,
            'Menambah data KHS ' . $Khs->MA_NamaLengkap . ' mata kuliah ' . $Khs->MK_Mata_Kuliah . ' kelas ' . $Khs->KU_KE_Kelas . ' ke tabel KHS', Logbook::ACTION_CREATE,
            Logbook::TABLE_CLASS_STUDENT);
        return redirect('khs')->with('success', 'Data KHS berhasil ditambahkan!');
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
        $data['khs'] = Khs::where('KU_ID', $id)->first();
        return view('khs.edit', $data);
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
        return redirect('/khs')->with('success', 'Data KHS berhasil diubah!');
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
        return redirect('/khs')->with('toast_warning', 'Data KHS berhasil dihapus!');;
    }

    public function import()
    {
        $data = Excel::import(new KHSImport(), request()->file('file'));
        if ($data) {
            Logbook::write(Auth::user()->PE_Nip,
                'Mengimpor data khs  ke  tabel KHS ', Logbook::ACTION_IMPORT,
                Logbook::TABLE_CLASS_STUDENT);
        }
        return back()->with('toast_success', 'Import data KHS berhasil!');
    }
}
