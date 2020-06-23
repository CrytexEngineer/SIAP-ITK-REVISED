@extends('layouts.app')
@section('title','Input Data Mata Kuliah')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Mata Kuliah</div>

                    <div class="card-body">

                        @include('validation_error')

                        {{ Form::open(['url'=>'matakuliah'])}}

                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Kode Mata Kuliah</label>
                            <div class="col-md-6">
                                {{ Form::text('MK_ID',null,['class'=>'form-control','placeholder'=>'Kode Mata Kuliah'])}}
                            </div>
                        </div>

                        @include('matakuliah.form')

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-3">

                                {{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                <a href="/matakuliah" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
