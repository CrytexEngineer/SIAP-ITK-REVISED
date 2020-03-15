@extends('layouts.app')
@section('title','Modul Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('status_failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status_failed') }}
                            </div>
                        @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Program Studi</td>
                                            <td>{{Form::select('major',$major,null,['class'=>'form-control'])}}</td>
                                        </tr>
                                        <tr>
                                            <td>Semester</td>
                                            <td>{{Form::select('semester',['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3','4'=>'Semester 4','5'=>'Semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'],null,['class'=>'form-control'])}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="/kelas/create" class="btn btn-primary">Input Data</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-8" style="overflow-x:auto;">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40">Kode Kelas</th>
                                            <th>Nama Kelas</th>
                                            <th width="100">Kode Matakuliah</th>
                                            <th width="40">Tahun</th>
                                            <th width="40">Semester</th>
                                            <th>Daya Tampung</th>
                                            <th>Jumlah Terisi</th>
                                            <th>NIP Pengajar</th>
                                            <th>Hari</th>
                                            <th>Jam Mulai</th>
                                            <th>Jam Usai</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
