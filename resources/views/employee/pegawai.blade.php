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
                                <th>Roles</th>
                                <th>Created At</th>
                                <th>Updated At</th>
{{--                                @can('manage-users')--}}
                                    <th width="50">Action</th>
{{--                                @endcan--}}
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
                    { data: 'PE_NamaLengkap', name: 'PE_NamaLengkap' },
                    { data: 'PE_Email', name: 'PE_Email' },
                    { data: 'roles', name: 'role_name',
                        render: "[, ].role_name"},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
{{--                        @can('manage-users')--}}
                    { data: 'action', name: 'action' }
{{--                    @endcan--}}
                ]
            });
        });
    </script>
@endpush
