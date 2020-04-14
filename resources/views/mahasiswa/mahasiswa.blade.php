@extends('layouts.app')
@section('title', 'Manajemen Akun Mahasiswa')
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

                        <a href="/akunmahasiswa/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                            @include('mahasiswa.import')
                            <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                @can('manage-users')
                                <th width="50">Action</th>
                                @endcan
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
                processing: true,
                serverSide: true,
                ajax: '/akunmahasiswa/json',
                columns: [
                    { data: 'MA_Nrp', name: 'MA_Nrp' },
                    { data: 'MA_NamaLengkap', name: 'MA_NamaLengkap' },
                    { data: 'MA_Email', name: 'MA_Email' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    @can('manage-users')
                    { data: 'action', name: 'action' }
                    @endcan
                ]
            });
        });
    </script>
@endpush
