@extends('layouts.dosen')
@section('title','Riwayat Pertemuan')
@section('content')
    @foreach($pertemuan as $row)
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Riwayat Pertemuan ke-{{$row->pertemuan_ke}} Perkuliahan</div>

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
                            <tr><td>Jenis Kelas</td><td>{{ $pertemuan->PT_Type }}</td></tr>
                            <tr><td>Topik</td><td>{{ $pertemuan->PT_Name}}</td></tr>
                            <tr><td>Catatan</td><td>{{ $pertemuan->PT_Notes }}</td></tr>
                            <tr><td></td>
                                <td>
                                    <a href="#" class="btn btn-danger"><i class="fas fa-qrcode"></i> Show QR Code</a>
                                </td>
                            </tr>
                        </table>
                        {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
