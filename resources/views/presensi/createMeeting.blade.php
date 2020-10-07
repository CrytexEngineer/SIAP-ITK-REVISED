@extends('layouts.dosen')
@section('title','Daftar Hadir Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Catatan Pertemuan Perkuliahan</div>

                    <div class="card-body">
                        @include('alert')

                        {{ Form::open(['url'=>'meeting'])}}

                        <table class="table table-bordered">
                            <a href="/kehadiran/{{ Request::segment(2)}}" class="btn btn-danger"><i
                                    class="fas fa-backward"></i> Kembali</a>
                            <hr>
                            <tr>
                                <td width="270">Kode Matakuliah</td>
                                <td>{{ $jadwal->MK_ID}}</td>
                            </tr>
                            <tr>
                                <td>Nama Matakuliah</td>
                                <td>{{ $jadwal->MK_Mata_Kuliah}}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>{{ $jadwal->KE_Kelas}}</td>
                            </tr>
                            <tr>
                                <td>Nama Dosen</td>
                                <td>{{ $jadwal->PE_NamaLengkap}}</td>
                            </tr>
                            <tr>
                                <td>Tim Pengajar</td>
                                <td>{{ implode(" ,",$timPegajar)}}</td>
                            </tr>
                            <tr>
                                <td>Pertemuan Ke</td>
                                <td>
                                    {{ $pertemuan_ke }} {{ Form::hidden('PT_Urutan',$pertemuan_ke )}}
                                    {{ Form::hidden('PT_KE_ID', Request::segment(2) )}}
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Kelas</td>
                                <td>{{ Form::select('PT_Types',['reguler'=>'Reguler','praktikum'=>'Praktikum','seminar'=>'Seminar'],'reguler')}}</td>
                            </tr>
                            <tr>
                                <td>Topik</td>
                                <td>{{ Form::text('PT_Name',null,['class'=>'form-control','placeholder'=>'Topik Pembahasan'])}}</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>{{ Form::textarea('PT_Notes',null,['class'=>'form-control','placeholder'=>'Catatan Kelas'])}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan
                                    </button>
                                </td>
                            </tr>
                        </table>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
