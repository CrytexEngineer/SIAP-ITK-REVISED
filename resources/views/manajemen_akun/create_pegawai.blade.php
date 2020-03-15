@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        {{Form::open(['url'=>'manajemen_akun/pegawai'])}}
                         @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">NIP</label>

                                <div class="col-md-6">
                                    {{ Form::text('PE_Nip', null, ['class'=>'form-control', 'placeholder'=> 'NIM Pegawai']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alamat Email') }}</label>

                                <div class="col-md-6">
                                    {{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'Alamat Email Pegawai']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label>

                                <div class="col-md-6">
                                    {{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=> 'Nama Pegawai']) }}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Tipe Pegawai</label>

                                <div class="col-md-6">
                                    <select id="role" name="role" class="form-control">
                                        <option value="1">Super Admin</option>
                                        <option value="2">Admin</option>
                                        <option value="3">Observer</option>
                                        <option value="4">Wakil Rektor</option>
                                        <option value="5">Tendik Jurusan</option>
                                        <option value="6">Tendik Pusat</option>
                                        <option value="7">Ketua Prodi</option>
                                        <option value="8">Kepala Jurusan</option>
                                        <option value="9">Dosen Pengampu</option>
                                    </select>
                                    {{--                                <input id="PE_NamaLengkap" type="text" class="form-control @error('PE_NamaLengkap') is-invalid @enderror" name="PE_NamaLengkap" value="{{ old('PE_NamaLengkap') }}" required autocomplete="PE_NamaLengkap" autofocus>--}}

                                    {{--                                    @error('PE_NamaLengkap')--}}
                                    {{--                                    <span class="invalid-feedback" role="alert">--}}
                                    {{--                                        <strong>{{ $message }}</strong>--}}
                                    {{--                                    </span>--}}
                                    {{--                                    @enderror--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror " name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
