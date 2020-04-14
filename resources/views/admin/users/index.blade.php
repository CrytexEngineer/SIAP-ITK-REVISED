@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Users</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Roles</th>
                                @can('manage-users')
                                    <th scope="col">Actions</th>
                                @endcan
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->PE_Nip }}</th>
                                    <td>{{ $user->PE_Nama }}</td>
                                    <td>{{ $user->PE_Email }}</td>
                                    <td>{{ implode(', ', $user->roles()->get()->pluck('role_name')->toArray()) }}</td>
                                    @can('manage-users')
                                        <td>
                                            <a href="{{ route('admin.users.edit', $user->PE_Nip) }}"><button type="button" class="btn btn-primary float-left">Edit</button></a>
                                            <form action="{{ route('admin.users.destroy', $user->PE_Nip) }}" method="POST" class="float-left">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-warning">Delete</button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
