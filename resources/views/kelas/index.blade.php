@extends('layouts.app')
@section('title','Modul Kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        @include('alert')


                        <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        @include('kelas.import')
                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>Kode Matakuliah</th>
                                <th>Matakuliah</th>
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
                                <th>Realisasi Pertemuan</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                <th width="70">Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
                                <th>Program Studi</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Daya Tampung</th>
                                <th>Jumlah Kelas Terisi</th>
                                <th>NIP Pengajar</th>
                                <th>Nama Pengajar</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
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
                "scrollX": true,
                processing: true,
                serverSide: false,
                ajax: '/kelas/json',
                columns: [
                 {data: 'KE_KR_MK_ID', name: 'KE_KR_MK_ID'},
                    {data: 'MK_Mata_Kuliah', name: 'subjects.MK_Mata_Kuliah'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},
                    {data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan'},
                    {data: 'PS_Nama', name: 'majors.PS_Nama'},
                    {data: 'KE_Tahun', name: 'KE_Tahun'},
                    {data: 'KE_IDSemester', name: 'KE_IDSemester'},
                    {data: 'KE_DayaTampung', name: 'KE_IDSemester'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    {data: 'KE_PE_NIPPengajar', name: 'KE_PE_NIPPengajar'},
                    {data: 'PE_Nama', name: 'employees.PE_Nama'},
                    {data: 'KE_RencanaTatapMuka', name: 'KE_RencanaTatapMuka'},
                    {data: 'KE_RealisasiTatapMuka', name: 'KE_RealisasiTatapMuka'},
                    {data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari'},
                    {data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai'},
                    {data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai'},
                    {data: 'action', name: 'action'}
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
