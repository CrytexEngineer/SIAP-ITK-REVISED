@extends('layouts.app')
@section('title', 'Manajemen Akun Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">

                        @include('alert')

                        <a href="/akunmahasiswa/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                            @include('mahasiswa.import')
                            <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>IMEI</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th width="50">Action</th>
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
                ajax: '/akunmahasiswa/json',
                columns: [
                    { data: 'MA_NRP_Baru', name: 'MA_NRP_Baru' },
                    { data: 'MA_NamaLengkap', name: 'MA_NamaLengkap' },
                    { data: 'email', name: 'email' },
                    { data: 'MA_IMEI', name: 'MA_IMEI' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endpush
