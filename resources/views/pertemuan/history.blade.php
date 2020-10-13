@extends('layouts.app')
@section('title','Riwayat Pertemuan')
@section('content')

    @include('alert')
    @foreach($pertemuan  as $iterasiPertemuan)
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Riwayat Pertemuan ke-{{($loop->iteration-count($pertemuan))*-1+1 }}
                            Perkuliahan
                        </div>

                        <div class="card-body">




                            <table class="table table-bordered">
                                <tr>
                                    <td>Pertemuan Ke</td>
                                    <td>
                                        {{ ($loop->iteration-count($pertemuan))*-1+1 }} {{ Form::hidden('pertemuan_ke',($loop->iteration-count($pertemuan))*-1+1 )}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hari</td>
                                    <td>{{ date_format($iterasiPertemuan->created_at,'D, d-m-yy ') }}</td>
                                </tr>
                                <tr>
                                    <td>Waktu</td>
                                    <td>{{ date_format($iterasiPertemuan->created_at,'H:i:s ') }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelas</td>
                                    <td>{{ $iterasiPertemuan->PT_Type }}</td>
                                </tr>
                                <tr>
                                    <td>Topik</td>
                                    <td>{{ $iterasiPertemuan->PT_Name}}</td>
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td>{{ $iterasiPertemuan->PT_Notes }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <a href='/validator/{{$iterasiPertemuan->PT_ID}}' class="btn btn-primary"><i
                                                class="fas fa-qrcode"></i> Tampilkan QR Code</a>

                                        <a   href='/pertemuan/{{$iterasiPertemuan->PT_ID}}/delete' data-method='delete' class="btn btn-danger"><i
                                                class='fas fa-trash-alt'></i> Hapus Pertemuan</a>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
