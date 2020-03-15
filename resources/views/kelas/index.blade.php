@extends('layouts.app')
@section('title','kelas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('status_failed'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('status_failed') }}
                            </div>
                        @endif

                        <a href="/manajemen_akun/mahasiswa/create" class="btn btn-success">Input Data Baru</a>
                        <hr>

                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th width="70">Kode Kelas</th>
                                <th width="100">Mata Kuliah</th>
                                <th width="40">Tahun</th>
                                <th width="40">Semester</th>
                                <th>Nama Kelas</th>
                                <th>Daya Tampung</th>
                                <th>NIP Pengajar</th>
                                <th>Terisi</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Usai</th>
                                <th>Jadwal Ruangan</th>
                                <th>Kode Jurusan</th>
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
        $(function() {
            $('#users-table').DataTable({
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/kelas/json', //DIGANTI SESUAI CONTROLLER
                columns: [
                    { data: 'KE_ID', name: 'KE_ID' },
                    { data: 'KE_KR_MK_ID', name: 'KE_KR_MK_ID' },
                    { data: 'KE_Tahun', name: 'KE_Tahun' },
                    { data: 'KE_IDSemester', name: 'KE_IDSemester' },
                    { data: 'KE_Kelas', name: 'KE_Kelas' },
                    { data: 'KE_DayaTampung', name: 'KE_DayaTampung' },
                    { data: 'KE_PE_NIPPengajar', name: 'KE_PE_NIPPengajar' },
                    { data: 'KE_Terisi', name: 'KE_Terisi' },
                    { data: 'KE_Jadwal_IDHari', name: 'KE_Jadwal_IDHari' },
                    { data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai' },
                    { data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai' },
                    { data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan' },
                    { data: 'KE_KodeJurusan', name: 'KE_KodeJurusan' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endpush
