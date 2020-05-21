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

                        <table class="table table-bordered" id="users-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>E-mail</th>
                                <th>Jurusan</th>
                                <th>Roles</th>
                                <th>Created At</th>
                                <th>Updated At</th>
{{--                                @can('manage-users')--}}
                                    <th width="50">Action</th>
{{--                                @endcan--}}
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th width="50">E-mail</th>
                            </tr>
                            </tfoot>
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
                serverSide: false,
                ajax: '/akunpegawai/json',
                columns: [
                    { data: 'PE_Nip', name: 'PE_Nip' },
                    { data: 'PE_NamaLengkap', name: 'PE_NamaLengkap' },
                    { data: 'PE_Email', name: 'PE_Email' },
                    { data: 'PS_Nama', name: 'PS_Nama' },
                    { data: 'roles', name: 'role_name',
                        render: "[, ].role_name"},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
{{--                        @can('manage-users')--}}
                    { data: 'action', name: 'action' }
{{--                    @endcan--}}

                ],
                initComplete: function () {
                    this.api().columns().every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            });
        });
    </script>
@endpush
