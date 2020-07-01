@extends('layouts.app')
@section('title', 'Input Data Pegawai')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        @include('validation_error')

                        {{Form::open(['url'=>'akunpegawai'])}}

                        @csrf

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">NIP Pegawai</label>
                            <div class="col-md-4">
                                {{ Form::text('PE_Nip', null, ['class'=>'form-control', 'placeholder'=> 'NIP Pegawai']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                {{ Form::text('PE_NamaLengkap', null, ['class'=>'form-control', 'placeholder'=> 'Nama Pegawai']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-4">
                                {{ Form::text('PE_Email', null, ['class'=>'form-control', 'placeholder'=> 'E-Mail Pegawai']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Program Studi</label>
                            <div class="col-md-4">
                                {{Form::select('PE_KodeJurusan',$major ?? '',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                {{ Form::password('password',['class'=>'form-control','placeholder'=>'Password'])}}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Konfirmasi Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-3 col-form-label text-md-right">Roles</label>
                            <div class="col-md-6">
                                @foreach($roles as $role)
                                    <div class="form-check">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
{{--                                               @if($employee->roles->pluck('id')->contains($role->id)) checked @endif>--}}
                                        <label> {{ $role->role_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-3">
                                    {{Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                    <a href="/manajemen_akun/pegawai" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
