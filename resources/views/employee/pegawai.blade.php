@extends('layouts.app')
@section('title', 'Manajemen Akun Pegawai')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('status_failed'))
                            <div class="alert alert-danger" role="alert">
                            {{ session('status_failed') }}
                            </div>
                        @endif

                        <a href="/akunpegawai/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        @include('employee.import')
                        <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
<<<<<<< HEAD
                                <th>Roles</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                @can('manage-users')
                                <th width="85">Action</th>
                                    @endcan
=======
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th width="85">Action</th>
>>>>>>> master
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/akunpegawai/json',
                columns: [
                    { data: 'PE_Nip', name: 'PE_Nip' },
<<<<<<< HEAD
                    { data: 'PE_NamaLengkap', name: 'PE_NamaLengkap' },
                    { data: 'PE_Email', name: 'PE_Email' },
                    { data: '', name: 'role_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                        @can('manage-users')
                    { data: 'action', name: 'action' }
                    @endcan
=======
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role_name', name: 'role_name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
>>>>>>> master
                ]
            });
        });
    </script>
@endpush
