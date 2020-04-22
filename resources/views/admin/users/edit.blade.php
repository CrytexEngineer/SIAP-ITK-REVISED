@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit User {{ $employee->PE_Nip }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.users.update', $employee) }}" method="POST">

                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="PE_Email" type="email" class="form-control @error('PE_Email') is-invalid @enderror" name="PE_Email" value="{{ $employee->PE_Email }}" required autocomplete="PE_Email" autofocus>

                                    @error('PE_Email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="PE_NamaLengkap" type="text" class="form-control @error('PE_NamaLengkap') is-invalid @enderror" name="PE_NamaLengkap" value="{{ $employee->PE_NamaLengkap }}" required autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            @csrf
                            {{ method_field('PUT') }}
                            <div class="form-group row">
                                <label for="roles" class="col-md-2 col-form-label text-md-right">Roles</label>
                                @foreach($roles as $role)
                                    <div class="form-check" class="col-md-6">
                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                               @if($employee->roles()->pluck('roles.id')->contains($role->id)) checked @endif>
                                        <label>{{ $role->role_name }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-2 col-form-label text-md-right">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
