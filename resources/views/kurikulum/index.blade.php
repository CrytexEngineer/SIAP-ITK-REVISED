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
                                <td width="300">Tahun Kurikulum</td>
                                <td>
                                    {{ Form::text('tahun_kurikulum',null,['class'=>'form-control','placeholder'=>'Tahun Ajaran (contoh: 2020 - Genap)'])}}
                                </td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai & Selesai</td>
                                <td>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input type="text"
                                                   class="datepicker-here form-control"
                                                   data-language='en'
                                                   name="tanggal_mulai"
                                                   data-multiple-dates="1"/>
                                        </div> -
                                        <div class="col-md-4">
                                            <input type="text"
                                                   class="datepicker-here form-control"
                                                   data-language='en'
                                                   name="tanggal_selesai"
                                                   data-multiple-dates="1"/>
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



