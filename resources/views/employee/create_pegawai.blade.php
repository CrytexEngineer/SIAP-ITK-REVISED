@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        {{Form::open(['url'=>'mahasiswa/pegawai'])}}
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
                                    <div class="form-check">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                               @if($employee->roles->pluck('id')->contains($role->id)) checked @endif>
                                        <label>{{ $role->role_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    {{Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                    <a href="/manajemen_akun/pegawai" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
