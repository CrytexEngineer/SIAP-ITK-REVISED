

@extends('layouts.app')
@section('title','Modul KHS')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Kelas</div>

                    <div class="card-body">

                        @include('alert')

                        <a href="/kelas/create" class="btn btn-primary"><i class="fas fa-plus"></i> Input Data Baru</a>

                        @include('khs.import')
                        <hr>

                        <table class="table table-bordered" id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Prodi/TPB</th>
                                <th>Tahun Akademik</th>
                                <th>Mata Kuliah Diambil</th>
                                <th width="50">Action</th>
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
                ajax: '/khs/json',
                columns: [
                    {data: 'MA_NRP_Baru', name: 'MA_NRP_Baru'},
                    {data: 'MA_NamaLengkap', name: 'MA_NamaLengkap'},
                    {data: 'email', name: 'email'},
                    {data: 'PS_Nama', name: 'PS_Nama'},
                    {data: 'KU_KE_Tahun', name: 'KU_KE_Tahun'},
                    {data: 'MK_Mata_Kuliah', name: 'MK_Mata_Kuliah'},
                    {data: 'action', name: 'action'}
                ]
            });
        });
    </script>
@endpush
