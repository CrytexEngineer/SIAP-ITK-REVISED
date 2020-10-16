@extends('layouts.app')
@section('title','Riwayat Manajemen Data')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Modul Riwayat Manajemen Data</div>

                    <div class="card-body">

                        @include('alert')



                        <table class="display compact"   id="users-table" style="overflow-x:auto;">
                            <thead>
                            <tr>
                                <th>Nama Pegawai</th>
                                <th>NIP Pegawai</th>
                                <th>Departemen</th>
                                <th>Aksi</th>
                                <th>Waktu</th>

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
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/riwayat_data/json',
                columns: [
                    {data: 'PE_NamaLengkap', name: 'PE_NamaLengkap'},
                    {data: 'PE_Nip', name: 'PE_Nip'},
                    {data: 'PS_Nama', name: 'PS_Nama'},
                    {data: 'LB_Notes', name: 'LB_Notes'},
                    {data: 'created_at', name: 'created_at'}

                ],

            });
        });




    </script>

@endpush
