@extends('layouts.app')
@section('title', 'Edit Data Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        {{Form::model($users, ['url'=>'akunmahasiswa/'.$users->MA_Nrp, 'method'=>'PUT'])}}
                            @csrf


                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">NIM Mahasiswa</label>
                            <div class="col-md-6">
                                {{ Form::text('MA_NRP_Baru', null, ['class'=>'form-control', 'placeholder'=> 'NIM Mahasiswa','readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                {{ Form::text('MA_NamaLengkap', null, ['class'=>'form-control', 'placeholder'=> 'Nama Mahasiswa']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-6">
                                {{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'E-Mail Mahasiswa']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">ID Perangkat</label>
                            <div class="col-md-6">
                                {{ Form::text('MA_IMEI',null,['class'=>'form-control','placeholder'=>'Tidak Perlu Diisi','readonly'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                {{ Form::password('MA_PASSWORD',['class'=>'form-control','placeholder'=>'Password'])}}
                            </div>
                        </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-2">
                                    {{Form::submit('Simpan Data', ['class'=>'btn btn-primary'])}}
                                    <a href="/akunmahasiswa" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
