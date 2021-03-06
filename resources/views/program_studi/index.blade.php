@extends('layouts.app')
@section('title','Modul Program Studi')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Program Studi
                    <div class="float-md-right">
                        <a href="/program_studi/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>
                        @include('program_studi.import')
                    </div>

                    </div>

                    <div class="card-body">

                        @include('alert')
                        @include('validation_error')


                        <hr>
                        <table class="display compact"  id="users-table">
                            <thead>
                            <tr>
                                <th width="150">Kode Program Studi</th>
                                <th>Nama Program Studi</th>
                                @can('admin')
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
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/program_studi/json',
                columns: [
                    { data: 'PS_Kode_Prodi', name: 'PS_Kode_Prodi' },
                    { data: 'PS_Nama', name: 'PS_Nama' },
                        @can('admin')
                    { data: 'action', name: 'action' }
                    @endcan
                ]
            });
        });
    </script>
@endpush
