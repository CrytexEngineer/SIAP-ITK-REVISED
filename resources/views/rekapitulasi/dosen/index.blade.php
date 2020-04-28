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
                                <th>No.</th>
                                <th>Nama Dosen</th>
                                <th>Kode Mata Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Kelas</th>
                                <th>Jumlah Peserta</th>
                                <th>Jumlah Tatap Muka</th>
                                <th>Kehadiran</th>
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
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <script>
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/rekapitulasi/mahasiswa/json',
                columns: [
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {data: '#', name: '#'},
                    {{--                    @can('manage-users')--}}
                    // {data: 'action', name: 'action'}
{{--                    @endcan--}}
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endpush
