@extends('layouts.app')
@section('title','Input Data Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data KHS</div>

                    <div class="card-body">
                        @include('validation_error')
                        @include('alert')
                        {{ Form::open(['url'=>'frs'])}}

                        @include('frs.form')

                        @csrf


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
