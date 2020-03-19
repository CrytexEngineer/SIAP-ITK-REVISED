

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
                                <th width="40">Kode Kelas</th>
                                <th>Nama Kelas</th>
                                <th>Program Studi</th>
                                <th>Kode kelas</th>
                                <th>Tahun</th>
                                <th>Semester</th>
                                <th>Daya Tampung</th>
                                <th>Jumlah Kelas Terisi</th>
                                <th>NIP Pengajar</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                <th>Ruangan</th>
                                <th width="85">Action</th>
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
                ajax: '/kelas/json',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'KE_Kelas', name: 'KE_Kelas'},
                    {data: 'PS_Nama', name: 'majors.PS_Nama'},
                    {data: 'MK_Mata_Kuliah', name: 'subjects.MK_Mata_Kuliah'},
                    {data: 'KE_Tahun', name: 'KE_Tahun'},
                    {data: 'KE_IDSemester', name: 'KE_IDSemester'},
                    {data: 'KE_DayaTampung', name: 'KE_IDSemester'},
                    {data: 'KE_Terisi', name: 'KE_Terisi'},
                    {data: 'PE_Nama', name: 'employees.PE_Nama'},
                    {data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari'},
                    {data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai'},
                    {data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai'},
                    {data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush
