@extends('layouts.app')
@section('title', 'Edit Data Pegawai')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        {{Form::model($employee, ['url'=>'akunpegawai/'.$employee->PE_Nip, 'method'=>'PUT'])}}
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">NIP Pegawai</label>
                            <div class="col-md-4">
                                {{ Form::text('PE_Nip', null, ['class'=>'form-control', 'placeholder'=> 'NIP Pegawai'], ['readonly']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">Nama Lengkap</label>
                            <div class="col-md-6">
                                {{ Form::text('PE_NamaLengkap', null, ['class'=>'form-control', 'placeholder'=> 'Nama Pegawai']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-2 col-form-label text-md-right">E-mail</label>
                            <div class="col-md-4">
                                {{ Form::text('PE_Email', null, ['class'=>'form-control', 'placeholder'=> 'E-Mail Pegawai']) }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="roles" class="col-md-2 col-form-label text-md-right">Roles</label>
                            <div class="col-md-6">
                            @foreach($roles as $role)
                                <div class="form-check" class="col-md-6">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                           @if($employee->roles()->pluck('roles.id')->contains($role->id)) checked @endif>
                                    <label>{{ $role->role_name }}</label>
                                </div>
                            @endforeach
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-2">
                                {{Form::submit('Simpan Data', ['class'=>'btn btn-primary'])}}
                                <a href="/akunpegawai" class="btn btn-primary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
