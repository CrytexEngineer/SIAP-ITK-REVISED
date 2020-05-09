@extends('layouts.dosen')
@section('title','Daftar Hadir Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Catatan Pertemuan Perkuliahan</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ Form::open(['url'=>'kehadiran/'.Request::segment(2)])}}

                        <table class="table table-bordered">
                            <a href="/kehadiran/{{ Request::segment(2)}}" class="btn btn-danger"><i class="fas fa-backward"></i> Kembali</a>
                            <hr>
                            <tr><td width="270">Kode Matakuliah</td><td>{{ $jadwal->MK_ID}}</td></tr>
                            <tr><td>Nama Matakuliah</td><td>{{ $jadwal->MK_Mata_Kuliah}}</td></tr>
                            <tr><td>Kelas</td><td>{{ $jadwal->KE_Kelas}}</td></tr>
                            <tr><td>Nama Dosen</td><td>{{ $jadwal->PE_NamaLengkap}}</td></tr>
                            <tr><td>Pertemuan Ke</td>
                                <td>
                                    {{ $pertemuan_ke }} {{ Form::hidden('pertemuan_ke',$pertemuan_ke )}}
                                </td></tr>
                            <tr><td>Jenis Kelas</td><td>{{ Form::select('kelas',['reguler'=>'Reguler','praktikum'=>'Praktikum','seminar'=>'Seminar'],'reguler')}}</td></tr>
                            <tr><td>Topik</td><td>{{ Form::text('topik',null,['class'=>'form-control','placeholder'=>'Topik Pembahasan'])}}</td></tr>
                            <tr><td>Catatan</td><td>{{ Form::textarea('catatan',null,['class'=>'form-control','placeholder'=>'Catatan Kelas'])}}</td></tr>
                            <tr><td></td>
                                <td>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-qrcode"></i> Show QR Code</button>
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
