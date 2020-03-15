@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register Mahasiswa</div>

                    <div class="card-body">
                        {{Form::open(['url'=>'manajemen_akun/mahasiswa'])}}
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">NIM</label>

                                <div class="col-md-6">
                                    {{ Form::text('MA_Nrp', null, ['class'=>'form-control', 'placeholder'=> 'NIM Mahasiswa']) }}
{{--                                    <input id="MA_Nrp" type="text" class="form-control @error('MA_Nrp') is-invalid @enderror" name="MA_Nrp" value="{{ old('MA_Nrp') }}" required autocomplete="MA_Nrp" autofocus>--}}

{{--                                    @error('MA_Nrp')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Nama Lengkap</label>

                                <div class="col-md-6">
                                    {{ Form::text('name', null, ['class'=>'form-control', 'placeholder'=> 'Nama Mahasiswa']) }}
{{--                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>--}}

{{--                                    @error('name')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alamat Email') }}</label>

                                <div class="col-md-6">
                                    {{ Form::text('email', null, ['class'=>'form-control', 'placeholder'=> 'Alamat Email Mahasiswa']) }}
{{--                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">--}}

{{--                                    @error('email')--}}
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

                            {{ Form::hidden('role', '10') }}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    {{Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
                                    <a href="/manajemen_akun/mahasiswa" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
