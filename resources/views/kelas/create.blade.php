@extends('layouts.app')
@section('title','Input Data Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Kelas</div>

                    <div class="card-body">
                        @include('validation_error')

                        {{ Form::open(['url'=>'kelas'])}}

                        @include('kelas.form')

                        @csrf

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">
                                {{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                <a href="/kelas" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
