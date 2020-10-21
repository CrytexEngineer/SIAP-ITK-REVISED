@extends('layouts.app')
@section('title','Edit Data KHS')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Data KHS</div>

                    <div class="card-body">
                        @include('validation_error')

                        {{ Form::model($khs,['url'=>'khs/'.$khs->KU_ID,'method'=>'PUT'])}}

                        @csrf

                        @include('frs.form')

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">

                                {{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                <a href="/khs" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
