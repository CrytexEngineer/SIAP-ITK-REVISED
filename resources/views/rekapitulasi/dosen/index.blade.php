@extends('layouts.app')
@section('title','Rekapitulasi Kehadiran Dosen')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-table"></i> Rekapitulasi Kehadiran Dosen</div>

                    <div class="card-body">
                        @include('alert')

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                {{--                                <th>No.</th>--}}
                                <th>Nama Dosen</th>
                                <th>Tim Pengajar</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Kelas</th>
                                <th>Jumlah Peserta</th>
                                <th>Jumlah Tatap Muka</th>
                                <th>Kehadiran</th>
                                <th>Diluar Jadwal</th>
                                <th>Persentase</th>
                                {{--                                @can('manage-users')--}}
                                {{--                                    <th width="70">Action</th>--}}
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
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/js/datatable-buttons.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script type="text/javascript"
            src=" https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
    <script>
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: false,
                ajax: '/rekapitulasi/dosen/json',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                'rowsGroup': [0,1,2,3,4,5,6,7,8,9,10],
                columns: [
                    {data: 'PE_NamaLengkap', name: 'PE_NamaLengkap'},
                    {data: 'tim_dosen', name: 'tim_dosen'},
                    {data: 'KE_KR_MK_ID', name: 'clasess.KE_KR_MK_ID'},
                    {data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah'},
                    {data: 'MK_KreditKuliah', name: 'MK_KreditKuliah'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    {data: 'KE_RencanaTatapMuka', name: 'KE_RencanaTatapMuka'},
                    {data: 'KE_RealisasiTatapMuka', name: 'KE_RealisasiTatapMuka'},
                    {data: 'KE_isLate', name: 'KE_isLate'},
                    {data: 'KE_Prosentase', name: 'KE_Prosentase',
                     render: function ( data, type, row ) {
                    return data+ '%';
    }},

        {{--                    @can('manage-users')--}}
        {{--                    // {data: 'action', name: 'action'}--}}
        {{--                    @endcan--}}
        ],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {


                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },

        ],

    });
});





    </script>
@endpush
