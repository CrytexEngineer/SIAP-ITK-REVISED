<script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-v8BU367qNbs/aIZIxuivaU55N5GPF89WBerHoGA4QTcbUjYiLQtKdrfXnqAcXyTv" crossorigin="anonymous">

@extends('layouts.app')
@section('title','Rekapitulasi Kehadiran Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-table"></i> Rekapitulasi Kehadiran Mahasiswa</div>

                    <div class="card-body">

                        @include('alert')



                        <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        @include('rekapitulasi.mahasiswa.import')
                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
{{--                                <th>No.</th>--}}
                                <th>Kode Mata Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Kelas</th>
                                <th>Dosen Pengampu</th>
                                <th>Jumlah Peserta</th>
{{--                                <th>No.</th>--}}
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
{{--                                <th>Pekan Perkuliahan</th>--}}
                                <th>Kehadiran Mengajar</th>
                                <th>Kehadiran Mahasiswa</th>
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
    <script>
        $(function () {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/rekapitulasi/mahasiswa/json',
                'rowsGroup': [0],
                columns: [
                    //NO
                    {data: 'KU_KE_KR_MK_ID', name: 'KU_KE_KR_MK_ID'},
                       {data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah'},
                        {data: 'MK_KreditKuliah', name: 'MK_KreditKuliah'},
                    {data: 'KU_KE_Kelas', name: 'KU_KE_Kelas'},
                    {data: 'PE_NamaLengkap', name: 'PE_NamaLengkap'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    //NO.
                    {data: 'MA_NRP_Baru', name: 'MA_NRP_Baru'},
                    {data: 'MA_NamaLengkap', name: 'MA_NamaLengkap'},
                    //PEKAN PERKULIAHAN
                    {data: 'Jumlah_Pertemuan', name: 'Jumlah_Pertemuan'},
                    {data: 'Kehadiran', name: 'Kehadiran'},
                    {data: 'persentase', name: 'persentase'},
                    {{--                    @can('manage-users')--}}
{{--                    {data: 'action', name: 'action'}--}}
{{--                    @endcan--}}
                ]
            });
        });
    </script>
@endpush
