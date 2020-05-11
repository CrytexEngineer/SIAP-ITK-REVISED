@extends('layouts.app')
@section('title','Input Data Kurikulum')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Input Data Kurikulum</div>

                    <div class="card-body">

                        {{ Form::open(['url'=>'kurikulum'])}}

                        <table class="table table-bordered">
                            <tr>
                                <td width="300">Tahun Kurikulum</td><td></td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai & Selesai</td><td>
                                    <div class="form-group row">
                                    <div class="col-md-2">
                                        {{ Form::text('Tanggal_Mulai',null,['class'=>'form-control', 'id'=>'datetimepicker'])}}
                                    </div> -
                                    <div class="col-md-2">{{ Form::text('Tanggal_Selesai',null,['class'=>'form-control', 'id'=>'datetimepicker'])}}
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td><td>{{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                    <a href="/kurikulum" class="btn btn-primary">Kembali</a></td>
                            </tr>
                        @csrf
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



