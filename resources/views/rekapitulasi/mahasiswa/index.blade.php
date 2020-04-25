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
{{--                                <th>Mata Kuliah</th>--}}
{{--                                <th>SKS</th>--}}
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
                                    <th width="70">Action</th>
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
                ajax: '/rekapitulasi_mahasiswa/json',
                columns: [
                    //NO
                    {data: 'class_student.KU_ID', name: 'class_student.KU_ID'},
                    {data: 'class_student.KU_KE_KR_MK_ID', name: 'class_student.KU_KE_KR_MK_ID'},
                    //NAMA MATA KULIAH
                    //SKS
                    {data: 'class_student.KU_KE_Kelas', name: 'class_student.KU_KE_Kelas'},
                    {data: 'employees.PE_NamaLengkap', name: 'employees.PE_NamaLengkap'},
                    {data: 't3.KE_Terisi', name: 't3.KE_Terisi'},
                    //NO.
                    {data: 'students.MA_NRP_Baru', name: 'students.MA_NRP_Baru'},
                    {data: 'students.MA_NamaLengkap', name: 'students.MA_NamaLengkap'},
                    //PEKAN PERKULIAHAN
                    {data: 'Jumlah_Pertemuan', name: 'Jumlah_Pertemuan'},
                    {data: 'Khadiran Mahasiswa', name: 'Kehadiran'},
                    {data: 'Persentase', name: 'persentase'},
                    {{--                    @can('manage-users')--}}
                    {data: '#', name: '#'}
{{--                    @endcan--}}
                ]
            });
        });
    </script>
@endpush
