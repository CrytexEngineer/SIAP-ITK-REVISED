

@extends('layouts.app')
@section('title', 'Modul Tahun Kurikulum')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')
                    <div class="float-md-right">    <a href="/kurikulum/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a></div>
                    </div>

                    <div class="card-body">

                        @include('alert')

                        <table class="display compact"   id="users-table">
                            <thead>
                            <tr>
                                <th>Nama Kurikulum</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>

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
                serverSide: false,
                ajax: '/kurikulum/json',
                columns: [
                    { data: 'KL_Tahun_Kurikulum', name: 'KL_Tahun_Kurikulum' },
                    { data: 'KL_Date_Start', name: 'KL_Date_Start' },
                    { data: 'KL_Date_End', name: 'KL_Date_End' },

                        @can('admin')
            { data: 'action', name: 'action' }
@endcan
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
