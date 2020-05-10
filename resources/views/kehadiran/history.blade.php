@extends('layouts.dosen')
@section('title','Riwayat Pertemuan')
@section('content')

    @include('alert')
    @foreach($pertemuan  as $iterasiPertemuan)
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Riwayat Pertemuan ke-{{$loop->iteration }} Perkuliahan</div>

                    <div class="card-body">


                        {{ Form::open(['url'=>'kehadiran/'.Request::segment(2)])}}

                        <table class="table table-bordered">
                            <a href="/kehadiran/{{ Request::segment(2)}}" class="btn btn-danger"><i class="fas fa-backward"></i> Kembali</a>
                            <hr>
{{--                            <tr><td width="270">Kode Matakuliah</td><td>{{ $jadwal->MK_ID}}</td></tr>--}}
{{--                            <tr><td>Nama Matakuliah</td><td>{{ $jadwal->MK_Mata_Kuliah}}</td></tr>--}}
{{--                            <tr><td>Kelas</td><td>{{ $jadwal->KE_Kelas}}</td></tr>--}}
{{--                            <tr><td>Nama Dosen</td><td>{{ $jadwal->PE_NamaLengkap}}</td></tr>--}}
                            <tr><td>Pertemuan Ke</td>
                                <td>
                                    {{ $loop->iteration }} {{ Form::hidden('pertemuan_ke',$loop->iteration )}}
                                </td></tr>
                            <tr><td>Hari</td><td>{{ date_format($iterasiPertemuan->created_at,'D, d-m-yy ') }}</td></tr>
                            <tr><td>Waktu</td><td>{{ date_format($iterasiPertemuan->created_at,'H:i:s ') }}</td></tr>
                            <tr><td>Jenis Kelas</td><td>{{ $iterasiPertemuan->PT_Type }}</td></tr>
                            <tr><td>Topik</td><td>{{ $iterasiPertemuan->PT_Name}}</td></tr>
                            <tr><td>Catatan</td><td>{{ $iterasiPertemuan->PT_Notes }}</td></tr>
                            <tr><td></td>
                                <td>
                                    <a href='/validator/{{$iterasiPertemuan->PT_ID}}' class="btn btn-danger"><i class="fas fa-qrcode"></i> Show QR Code</a>
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
