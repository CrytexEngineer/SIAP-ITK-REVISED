@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Register Mahasiswa</div>

                    <div class="card-body">

                        @include('validation_error')

                        {{Form::open(['url'=>'akunmahasiswa/'])}}

                        @csrf

{{--                        <div class="form-group row">--}}
{{--                            <label class="col-md-3 col-form-label text-md-right">NIM Default Mahasiswa</label>--}}
{{--                            <div class="col-md-6">--}}
{{--                                {{ Form::text('MA_Nrp', null, ['class'=>'form-control', 'placeholder'=> 'NIM Dafault Mahasiswa contoh: 1116110022']) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">NIM Mahasiswa</label>
                            <div class="col-md-6">
                                {{ Form::text('MA_NRP_Baru', null, ['class'=>'form-control', 'placeholder'=> 'NIM Mahasiswa contoh: 10161022']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                {{ Form::text('MA_NamaLengkap', null, ['class'=>'form-control', 'placeholder'=> 'Nama Mahasiswa']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-4">
                                {{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'E-Mail Mahasiswa']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                {{ Form::password('MA_PASSWORD',['class'=>'form-control','placeholder'=>'Password'])}}
                            </div>
                        </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
                                    {{Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                    <a href="/akunmahasiswa" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
