<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Major;
use App\Employee;
use App\Subject;
use App\Kelas;
use PhpParser\Node\Expr\New_;

class ManajemenKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $kelas = \DB::table('classes')
//            ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
//            ->join('employees','employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
//            ->get();
//        return $kelas;

        $data['employees'] = Employee::pluck('PE_Nip');
        $data['subjects'] = Subject::pluck('MK_ID');
        $data['major'] = Major::pluck('PS_Nama_Baru','PS_Kode_Prodi');
        return view('kelas.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['employees'] = Employee::pluck('PE_Nip');
        $data['subjects'] = Subject::pluck('MK_ID');
        $data['major'] = Major::pluck('PS_Nama_Baru','PS_Kode_Prodi');
        return view('kelas.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $data ['kelas'] = \DB::table('classes')
//                ->join('subjects','subjects.MK_ID','=','classes.KE_KR_MK_ID')
//                ->join('employees','employees.PE_Nip','=','classes.KE_PE_NIPPengajar')
//                ->get();

        $kelas = New Kelas();
        $kelas->create($request->all());
        return redirect('kelas')->with('status','Informasi Kelas Berhasil Ditambahkan');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
