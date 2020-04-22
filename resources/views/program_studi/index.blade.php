@extends('layouts.app')
@section('title','Modul Program Studi')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Program Studi</div>

                    <div class="card-body">

                        @include('alert')

                        <a href="/program_studi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        @include('program_studi.import')
                        <hr>
                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th width="100">Kode</th>
                                <th>Nama Program Studi</th>
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
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/program_studi/json', //DIGANTI SESUAI CONTROLLER
                columns: [
                    { data: 'PS_Kode_Prodi', name: 'PS_Kode_Prodi' }, //SESUAIKAN DB
                    { data: 'PS_Nama', name: 'PS_Nama' }, //SESUAIKAN DB
                        @can('manage-users')
                    { data: 'action', name: 'action' }
                    @endcan
                ]
            });
        });
    </script>
@endpush
