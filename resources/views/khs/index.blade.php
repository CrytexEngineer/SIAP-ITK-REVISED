@extends('layouts.app')
@section('title','Modul KHS')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul KHS

                        <div class="float-md-right"><a href="/khs/create" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Input Data Baru</a>

                            @include('khs.import')</div>
                        <div class="mt-4">
                            {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}
                        </div>
                    </div>

                    <div class="card-body">

                        @include('alert')


                        <table id="users-table"  class=" table-bordered dt-responsive nowrap" >
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Prodi/TPB</th>
                                <th>Tahun Akademik</th>
                                <th>Mata Kuliah Diambil</th>
                                <th>Kelas</th>
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src=" https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>


    <script>
      var table=
            $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                  ajax: {
                "url": '/khs/json',
                "data": function ( d ) {
                    d.PS_ID = $('#PS_ID').val();
                }},
                columns: [
                    {data: 'MA_NRP_Baru', name: 'students.MA_NRP_Baru'},
                    {data: 'MA_NamaLengkap', name: 'students.MA_NamaLengkap'},
                    {data: 'email', name: 'students.email'},
                    {data: 'PS_Nama', name: 'majors.PS_Nama'},
                    {data: 'KU_KE_Tahun', name: 'KU_KE_Tahun'},
                    {data: 'MK_Mata_Kuliah', name: 'subjects.MK_Mata_Kuliah'},
                            {data: 'KU_KE_Kelas', name: 'KU_KE_Kelas'},
                                     @can('admin')
            {data: 'action', name: 'action'}
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

       $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {
               table.ajax.reload();
                });
});





    </script>
@endpush
