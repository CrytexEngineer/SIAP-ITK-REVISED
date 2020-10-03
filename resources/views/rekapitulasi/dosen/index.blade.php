@extends('layouts.app')
@section('title','Rekapitulasi Kehadiran Dosen')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fas fa-table"></i> Rekapitulasi Kehadiran Dosen</div>
                    <div class="card-body">

                        <a href='/rekapitulasi/dosen/export/major' class="btn btn-info"><i
                                class="fas fa-download"></i> Unduh Seluruh Data</a>

                        <a href='/rekapitulasi/dosen/showExportSubjectPage' class="btn btn-danger"><i
                                class='fas fa-download'></i> Unduh Berdasarkan Matakuliah</a></div>
                    <br>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right">Tampilkan Data Program Studi</label>
                        <div class="col-md-4">
                            {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('alert')

                        <table class=" compact cell-border" id="users-table" style="overflow-x:auto;">
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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
            src=" https://cdn.rawgit.com/ashl1/datatables-rowsgroup/fbd569b8768155c7a9a62568e66a64115887d7d0/dataTables.rowsGroup.js"></script>
    <script>



    var table= $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: false,
                ajax: {
                "url": "/rekapitulasi/dosen/json",
                "data": function ( d ) {
                    d.PS_ID = $('#PS_ID').val();
                },

                },
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

    });



                $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {
               table.ajax.reload();
                });

            });








    </script>
@endpush
