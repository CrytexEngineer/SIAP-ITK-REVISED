@extends('layouts.dosen')
@section('title','Jadwal Mengajar')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Jadwal Mengajar</div>

                    <div class="card-body">
                        @include('alert')


                        <table class="table table-bordered" id="users-table">
                            <thead>
                            <tr>
                                <th width="100">Kode Matakuliah</th>
                                <th width="200">Matakuliah</th>
                                <th width="50">Kelas</th>
                                <th width="50">Hari</th>
                                <th width="50">Jam Mulai</th>
                                <th width="50">Jam Berakhir</th>
                                <th width="70">Ruang</th>
                                <th width="100">Jurusan</th>
                                <th width="100">Action</th>
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
                processing: true,
                serverSide: true,
                ajax: '/jadwal_mengajar/json',
                columns: [
                    { data: 'MK_ID', name: 'MK_ID' },
                    { data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah' },
                    { data: 'KE_Kelas', name: 'KE_Kelas' },
                    { data: 'nama_hari', name: 'nama_hari' },
                    { data: 'KE_Jadwal_JamMulai', name: 'KE_Jadwal_JamMulai' },
                    { data: 'KE_Jadwal_JamUsai', name: 'KE_Jadwal_JamUsai' },
                    { data: 'KE_Jadwal_Ruangan', name: 'KE_Jadwal_Ruangan' },
                    { data: 'PS_Nama', name: 'PS_Nama' },
                    { data: 'action', name: 'action' }
                ]
            });
        });
    </script>
@endpush
