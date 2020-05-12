@extends('layouts.app')
@section('title','Riwayat Manajemen Data')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Riwayat Manajemen Data</div>

                    <div class="card-body">

                        @include('alert')


                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>NIP Pegawai</th>
                                <th>Departemen</th>
                                <th>Aksi</th>
                                <th>Waktu</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>NIP Pegawai</th>
                                <th>Departemen</th>
                                <th>Aksi</th>
                                <th>Waktu</th>

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
        $(function () {
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/riwayat_data/json',
                columns: [
                    {data: 'PE_NamaLengkap', name: 'PE_NamaLengkap'},
                    {data: 'PE_Nip', name: 'PE_Nip'},
                    {data: 'PS_Nama', name: 'PS_Nama'},
                    {data: 'LB_Notes', name: 'LB_Notes'},
                    {data: 'created_at', name: 'created_at'}

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
