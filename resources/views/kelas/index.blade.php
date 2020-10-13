@extends('layouts.app')
@section('title','Modul Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas

                        <div class="float-md-right"><a href="/kelas/create" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Input Data Baru</a>

                            @include('kelas.import')</div>
                        <div class="mt-4">
                            {{Form::select('PS_ID',$major,null,['class'=>'form-control','selected'=>''.$major->first().'','id' => 'PS_ID'])}}
                        </div>

                    </div>

                    <div class="card-body">
                        @include('alert')


                        <table class="display compact" id="users-table">
                            <thead>
                            <tr>
                                <th>Kode Mata Kuliah</th>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
                                <th>Program Studi</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Daya Tampung</th>
                                <th>Jumlah Kelas Terisi</th>
                                <th>NIP Pengajar</th>
                                <th>Nama Pengajar</th>
                                <th>Rencana Pertemuan</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                @can('change')
                                    <th width="160">Action</th>
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

      var table= $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                    'rowsGroup': [0,1,2,3,4,5,6,7,8,9,10],
                     ajax: {
                "url": '/kelas/json',
                "data": function ( d ) {
                    d.PS_ID = $('#PS_ID').val();
                }},
                             columns: [
                 {data: 'KE_KR_MK_ID', name: 'KE_KR_MK_ID'},
                    {data: 'MK_Mata_Kuliah', name: 'subjects.MK_Mata_Kuliah'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},
                    {data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan'},
                    {data: 'PS_Nama', name: 'majors.PS_Nama'},
                    {data: 'KE_Tahun', name: 'KE_Tahun'},
                    {data: 'KE_IDSemester', name: 'KE_IDSemester'},
                    {data: 'KE_DayaTampung', name: 'KE_DayaTampung'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    {data: 'KE_PE_NIPPengajar', name: 'KE_PE_NIPPengajar'},
                    {data: 'PE_Nama', name: 'employees.PE_Nama'},
                    {data: 'KE_RencanaTatapMuka', name: 'KE_RencanaTatapMuka'},
                    {data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari'},
                    {data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai'},
                    {data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai'},
                        @can('change')
            {data: 'action', name: 'action'}
@endcan
        ],

    });

         $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {
               table.ajax.reload();
                });
        });

    </script>
@endpush
